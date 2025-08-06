<?php
require_once '../../php/config.php';
header('Content-Type: application/json');

if (!isset($_POST['id_trabajador'], $_POST['semana_inicio'], $_POST['semana_fin'], $_POST['montos'])) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

$id_trabajador = intval($_POST['id_trabajador']);
$semana_inicio = $_POST['semana_inicio'];
$semana_fin = $_POST['semana_fin'];
$montos = json_decode($_POST['montos'], true); // array de 6 montos

if (!is_array($montos) || count($montos) !== 6) {
    echo json_encode(['success' => false, 'message' => 'Montos inválidos']);
    exit;
}

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos']);
    exit;
}

// Calcular fechas de lunes a sábado
date_default_timezone_set('America/Mexico_City');
$fechas = [];
$fecha = new DateTime($semana_inicio);
for ($i = 0; $i < 6; $i++) {
    $fechas[] = $fecha->format('Y-m-d');
    $fecha->modify('+1 day');
}

// Primero eliminar registros existentes para este trabajador en esta semana
$stmt_delete = $conn->prepare("DELETE FROM nomina_trabajador WHERE id_trabajador = ? AND semana_inicio = ? AND semana_fin = ?");
if (!$stmt_delete) {
    echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta de eliminación']);
    $conn->close();
    exit;
}
$stmt_delete->bind_param('iss', $id_trabajador, $semana_inicio, $semana_fin);
$stmt_delete->execute();
$stmt_delete->close();

$stmt = $conn->prepare("INSERT INTO nomina_trabajador (id_trabajador, fecha, monto, semana_inicio, semana_fin) VALUES (?, ?, ?, ?, ?)");
if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta']);
    $conn->close();
    exit;
}

$insertados = 0;
for ($i = 0; $i < 6; $i++) {
    $monto = floatval($montos[$i]);
    if ($monto > 0) {
        $stmt->bind_param('isdss', $id_trabajador, $fechas[$i], $monto, $semana_inicio, $semana_fin);
        if ($stmt->execute()) {
            $insertados++;
        }
    }
}
$stmt->close();
$conn->close();

if ($insertados > 0) {
    echo json_encode(['success' => true, 'message' => 'Nómina guardada correctamente']);
} else {
    echo json_encode(['success' => false, 'message' => 'No se guardó ningún día (¿todos los montos son 0?)']);
} 