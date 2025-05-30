<?php
require_once 'config.php';

header('Content-Type: application/json');

try {
    $stmt = $conn->query("SELECT id_producto, nombre FROM productos WHERE activo = 1 ORDER BY nombre");
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode([
        'success' => true,
        'productos' => $productos
    ]);
} catch(PDOException $e) {
    echo json_encode([
        'success' => false,
        'message' => 'Error al obtener productos: ' . $e->getMessage()
    ]);
}
?> 