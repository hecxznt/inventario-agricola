<?php
require_once '../../php/config.php';

// Verificar si es una petición POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Obtener los datos del formulario
        $id = isset($_POST['id']) ? $_POST['id'] : null;
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $presentacion = $_POST['presentacion'];
        $cantidad = $_POST['cantidad'];
        $stockMinimo = $_POST['stockMinimo'];
        $fechaCaducidad = $_POST['fechaCaducidad'];
        $ubicacion = $_POST['ubicacion'];
        $proveedor = $_POST['proveedor'];

        if ($id) {
            // Actualizar producto existente
            $sql = "UPDATE productos SET 
                    nombre = :nombre,
                    categoria = :categoria,
                    presentacion = :presentacion,
                    cantidad = :cantidad,
                    stock_minimo = :stockMinimo,
                    fecha_caducidad = :fechaCaducidad,
                    ubicacion = :ubicacion,
                    proveedor = :proveedor
                    WHERE id_producto = :id";
            
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $id);
        } else {
            // Insertar nuevo producto
            $sql = "INSERT INTO productos (
                    nombre, categoria, presentacion, cantidad, stock_minimo,
                    fecha_caducidad, ubicacion, proveedor, activo
                ) VALUES (
                    :nombre, :categoria, :presentacion, :cantidad, :stockMinimo,
                    :fechaCaducidad, :ubicacion, :proveedor, 1
                )";
            
            $stmt = $conn->prepare($sql);
        }

        // Vincular parámetros
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':presentacion', $presentacion);
        $stmt->bindParam(':cantidad', $cantidad);
        $stmt->bindParam(':stockMinimo', $stockMinimo);
        $stmt->bindParam(':fechaCaducidad', $fechaCaducidad);
        $stmt->bindParam(':ubicacion', $ubicacion);
        $stmt->bindParam(':proveedor', $proveedor);

        // Ejecutar la consulta
        $stmt->execute();

        echo json_encode(['success' => true, 'message' => 'Producto guardado exitosamente']);
    } catch(PDOException $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error al guardar el producto: ' . $e->getMessage()]);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
} 