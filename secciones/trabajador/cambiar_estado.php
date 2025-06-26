<?php
require_once '../../php/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

$id_trabajador = $_POST['id_trabajador'] ?? null;
$estado = isset($_POST['estado']) ? (int)$_POST['estado'] : null;

if (!$id_trabajador || ($estado !== 0 && $estado !== 1)) {
    echo json_encode(['success' => false, 'message' => 'Datos incompletos']);
    exit;
}

try {
    $sql = "UPDATE trabajador SET activo = ? WHERE id_trabajador = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$estado, $id_trabajador]);
    echo json_encode(['success' => true, 'message' => 'Estado actualizado correctamente']);
} catch(Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar estado: ' . $e->getMessage()]);
} 