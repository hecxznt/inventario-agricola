<?php
require_once '../../php/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    try {
        $id = $_GET['id'];
        
        $sql = "SELECT * FROM productos WHERE id_producto = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($producto) {
            header('Content-Type: application/json');
            echo json_encode($producto);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Producto no encontrado']);
        }
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['error' => 'Error al obtener el producto: ' . $e->getMessage()]);
    }
} else {
    http_response_code(400);
    echo json_encode(['error' => 'Solicitud inválida']);
} 