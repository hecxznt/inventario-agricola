<?php
require_once '../../php/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['q'])) {
    try {
        $termino = '%' . $_GET['q'] . '%';
        $sql = "SELECT id_producto, nombre FROM productos WHERE activo = 1 AND nombre LIKE ? ORDER BY nombre LIMIT 10";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$termino]);
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode([
            'success' => true,
            'productos' => $productos
        ]);
    } catch(PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error al buscar productos: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Parámetros inválidos'
    ]);
}
?> 