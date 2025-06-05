<?php
require_once '../../php/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    try {
        // Obtener el estado actual
        $sql = "SELECT activo FROM productos WHERE id_producto = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$_POST['id']]);
        $producto = $stmt->fetch(PDO::FETCH_ASSOC);
        
        if ($producto) {
            // Cambiar el estado
            $nuevo_estado = $producto['activo'] ? 0 : 1;
            
            $sql = "UPDATE productos SET activo = ? WHERE id_producto = ?";
            $stmt = $conn->prepare($sql);
            $stmt->execute([$nuevo_estado, $_POST['id']]);
            
            echo json_encode([
                'success' => true,
                'message' => 'Estado actualizado correctamente',
                'nuevo_estado' => $nuevo_estado
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Producto no encontrado'
            ]);
        }
    } catch(PDOException $e) {
        echo json_encode([
            'success' => false,
            'message' => 'Error al actualizar el estado: ' . $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Solicitud inválida'
    ]);
}
?> 