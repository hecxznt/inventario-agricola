<?php
require_once '../../php/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    try {
        $id = $_POST['id'];
        
        // Log para depuración
        error_log("ID recibido: " . $id);
        
        // Obtener el estado actual del producto
        $check = $conn->prepare("SELECT id_producto, activo FROM productos WHERE id_producto = ?");
        $check->execute([$id]);
        $producto = $check->fetch(PDO::FETCH_ASSOC);
        
        if ($producto) {
            // Invertir el estado actual
            $nuevoEstado = $producto['activo'] ? 0 : 1;
            
            // Actualizar el estado
            $sql = "UPDATE productos SET activo = :estado WHERE id_producto = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':estado', $nuevoEstado);
            
            // Log para depuración
            error_log("SQL: " . $sql);
            error_log("Parámetros - ID: " . $id . ", Estado actual: " . $producto['activo'] . ", Nuevo estado: " . $nuevoEstado);
            
            $stmt->execute();
            
            // Log para depuración
            error_log("Filas afectadas: " . $stmt->rowCount());
            
            if ($stmt->rowCount() > 0) {
                echo json_encode([
                    'success' => true, 
                    'message' => 'Estado actualizado exitosamente',
                    'nuevoEstado' => $nuevoEstado
                ]);
            } else {
                echo json_encode(['success' => false, 'message' => 'No se pudo actualizar el estado']);
            }
        } else {
            http_response_code(404);
            echo json_encode(['success' => false, 'message' => 'Producto no encontrado (ID: ' . $id . ')']);
        }
    } catch(PDOException $e) {
        error_log("Error en cambiar_estado.php: " . $e->getMessage());
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error al actualizar el estado: ' . $e->getMessage()]);
    }
} else {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Datos incompletos. ID: ' . (isset($_POST['id']) ? $_POST['id'] : 'no definido')]);
} 