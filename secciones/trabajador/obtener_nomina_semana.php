<?php
require_once '../../php/config.php';
header('Content-Type: application/json');

if (!isset($_GET['semana_inicio']) || !isset($_GET['semana_fin'])) {
    echo json_encode(['success' => false, 'message' => 'Fechas de semana requeridas']);
    exit;
}

$semana_inicio = $_GET['semana_inicio'];
$semana_fin = $_GET['semana_fin'];

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos']);
    exit;
}

// Obtener todos los pagos de la semana especificada
$stmt = $conn->prepare("
    SELECT nt.id_trabajador, nt.fecha, nt.monto, nt.semana_inicio, nt.semana_fin
    FROM nomina_trabajador nt
    WHERE nt.semana_inicio = ? AND nt.semana_fin = ?
    ORDER BY nt.id_trabajador, nt.fecha
");

if (!$stmt) {
    echo json_encode(['success' => false, 'message' => 'Error en la preparación de la consulta']);
    $conn->close();
    exit;
}

$stmt->bind_param('ss', $semana_inicio, $semana_fin);
$stmt->execute();
$result = $stmt->get_result();

$pagos = [];
while ($row = $result->fetch_assoc()) {
    $id_trabajador = $row['id_trabajador'];
    if (!isset($pagos[$id_trabajador])) {
        $pagos[$id_trabajador] = [
            'lunes' => 0,
            'martes' => 0,
            'miercoles' => 0,
            'jueves' => 0,
            'viernes' => 0,
            'sabado' => 0
        ];
    }
    
    // Determinar qué día de la semana es basado en la fecha
    $fecha = new DateTime($row['fecha']);
    $dia_semana = $fecha->format('N'); // 1=lunes, 2=martes, ..., 6=sábado
    
    switch ($dia_semana) {
        case 1: $pagos[$id_trabajador]['lunes'] = floatval($row['monto']); break;
        case 2: $pagos[$id_trabajador]['martes'] = floatval($row['monto']); break;
        case 3: $pagos[$id_trabajador]['miercoles'] = floatval($row['monto']); break;
        case 4: $pagos[$id_trabajador]['jueves'] = floatval($row['monto']); break;
        case 5: $pagos[$id_trabajador]['viernes'] = floatval($row['monto']); break;
        case 6: $pagos[$id_trabajador]['sabado'] = floatval($row['monto']); break;
    }
}

$stmt->close();
$conn->close();

echo json_encode(['success' => true, 'pagos' => $pagos]);
?> 