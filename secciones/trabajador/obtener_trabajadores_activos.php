<?php
require_once '../../php/config.php';
header('Content-Type: application/json');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'message' => 'Error de conexión a la base de datos']);
    exit;
}

$sql = "SELECT id_trabajador, CONCAT(nombre, ' ', apellido_paterno, ' ', apellido_materno) AS nombre_completo FROM trabajador WHERE activo = 1 ORDER BY nombre ASC";
$result = $conn->query($sql);

$trabajadores = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $trabajadores[] = [
            'id_trabajador' => $row['id_trabajador'],
            'nombre_completo' => trim($row['nombre_completo'])
        ];
    }
}

echo json_encode(['success' => true, 'trabajadores' => $trabajadores]);
$conn->close(); 