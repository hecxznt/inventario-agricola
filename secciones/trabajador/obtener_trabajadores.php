<?php
require_once '../../php/config.php';

header('Content-Type: application/json');

// Parámetros de paginación
$pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$limite = isset($_GET['limite']) ? (int)$_GET['limite'] : 10;
$offset = ($pagina - 1) * $limite;

try {
    // Total de registros
    $sql_total = "SELECT COUNT(*) as total FROM trabajador";
    $stmt_total = $conn->query($sql_total);
    $total_registros = $stmt_total->fetch(PDO::FETCH_ASSOC)['total'];
    $total_paginas = ceil($total_registros / $limite);

    // Obtener solo los de la página actual
    $sql = "SELECT id_trabajador, nombre, apellido_paterno, apellido_materno, genero, fecha_nacimiento, foto, nss, curp, calleynum, colonia, municipio, estado, cp, tel, email, cargo, fecha_ingreso, fecha_registro, salario_diario, activo FROM trabajador ORDER BY nombre, apellido_paterno, apellido_materno LIMIT $limite OFFSET $offset";
    $stmt = $conn->query($sql);
    $trabajadores = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode([
        'success' => true,
        'trabajadores' => $trabajadores,
        'total_paginas' => $total_paginas,
        'pagina_actual' => $pagina
    ]);
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al obtener trabajadores: ' . $e->getMessage()
    ]);
} 