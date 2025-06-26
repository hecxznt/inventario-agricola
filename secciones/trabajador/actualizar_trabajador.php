<?php
require_once '../../php/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

try {
    $id_trabajador = sanitizar($_POST['id_trabajador'] ?? '');
    $nombre = sanitizar($_POST['nombre'] ?? '');
    $apellido_paterno = sanitizar($_POST['apellido_paterno'] ?? '');
    $apellido_materno = sanitizar($_POST['apellido_materno'] ?? '');
    $cargo = sanitizar($_POST['cargo'] ?? '');
    $salario_diario = sanitizar($_POST['salario_diario'] ?? '');
    // Puedes agregar más campos aquí si quieres permitir su edición

    $sql = "UPDATE trabajador SET nombre=?, apellido_paterno=?, apellido_materno=?, cargo=?, salario_diario=? WHERE id_trabajador=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$nombre, $apellido_paterno, $apellido_materno, $cargo, $salario_diario, $id_trabajador]);

    echo json_encode(['success' => true, 'message' => 'Trabajador actualizado correctamente']);
} catch(Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error al actualizar trabajador: ' . $e->getMessage()]);
} 