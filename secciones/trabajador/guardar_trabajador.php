<?php
require_once '../../php/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

try {
    // Recoger y sanitizar datos
    $id_trabajador = sanitizar($_POST['id_trabajador'] ?? '');
    $nombre = sanitizar($_POST['nombre'] ?? '');
    $apellido_paterno = sanitizar($_POST['apellido_paterno'] ?? '');
    $apellido_materno = sanitizar($_POST['apellido_materno'] ?? '');
    $genero = sanitizar($_POST['genero'] ?? '');
    $fecha_nacimiento = sanitizar($_POST['fecha_nacimiento'] ?? '');
    $nss = sanitizar($_POST['nss'] ?? '');
    $curp = sanitizar($_POST['curp'] ?? '');
    $calleynum = sanitizar($_POST['calleynum'] ?? '');
    $colonia = sanitizar($_POST['colonia'] ?? '');
    $municipio = sanitizar($_POST['municipio'] ?? '');
    $estado = sanitizar($_POST['estado'] ?? '');
    $cp = sanitizar($_POST['cp'] ?? '');
    $tel = sanitizar($_POST['tel'] ?? '');
    $email = sanitizar($_POST['email'] ?? '');
    $cargo = sanitizar($_POST['cargo'] ?? '');
    $fecha_ingreso = sanitizar($_POST['fecha_ingreso'] ?? '');
    $fecha_registro = sanitizar($_POST['fecha_registro'] ?? '');
    $salario_diario = sanitizar($_POST['salario_diario'] ?? '');

    // Manejo de la foto (opcional)
    $foto_nombre = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $foto_nombre = uniqid('trabajador_') . '.' . $ext;
        $ruta_destino = __DIR__ . '/../uploads/trabajadores/' . $foto_nombre;
        if (!is_dir(__DIR__ . '/../uploads/trabajadores/')) {
            mkdir(__DIR__ . '/../uploads/trabajadores/', 0777, true);
        }
        move_uploaded_file($_FILES['foto']['tmp_name'], $ruta_destino);
    }

    $sql = "INSERT INTO trabajador (
        nombre, apellido_paterno, apellido_materno, genero, fecha_nacimiento, foto, nss, curp, calleynum, colonia, municipio, estado, cp, tel, email, cargo, fecha_ingreso, fecha_registro, salario_diario
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([
        $nombre, $apellido_paterno, $apellido_materno, $genero, $fecha_nacimiento, $foto_nombre, $nss, $curp, $calleynum, $colonia, $municipio, $estado, $cp, $tel, $email, $cargo, $fecha_ingreso, $fecha_registro, $salario_diario
    ]);

    echo json_encode(['success' => true, 'message' => 'Trabajador guardado correctamente']);
} catch(Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Error al guardar trabajador: ' . $e->getMessage()]);
} 