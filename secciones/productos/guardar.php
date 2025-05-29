<?php
require_once '../../php/config.php';

// Asegurarnos de que no haya salida antes de los headers
ob_start();

// Configurar headers
header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $id_producto = !empty($_POST['id']) ? $_POST['id'] : null;
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $presentacion = $_POST['presentacion'];
        $cantidad = intval($_POST['cantidad']);
        $stock_minimo = intval($_POST['stockMinimo']);
        $fecha_caducidad = !empty($_POST['fechaCaducidad']) ? $_POST['fechaCaducidad'] : null;
        $ubicacion = $_POST['ubicacion'];
        $proveedor = $_POST['proveedor'];

        // Validar datos
        if (empty($nombre) || empty($categoria) || empty($presentacion) || empty($cantidad) || empty($stock_minimo) || empty($ubicacion) || empty($proveedor)) {
            throw new Exception('Todos los campos son obligatorios');
        }

        if ($cantidad < 0 || $stock_minimo < 0) {
            throw new Exception('Las cantidades no pueden ser negativas');
        }

        // Verificar si ya existe un producto con el mismo nombre
        $stmt = $conn->prepare("SELECT id_producto FROM productos WHERE nombre = ? AND id_producto != ?");
        $stmt->execute([$nombre, $id_producto ?? 0]);
        if ($stmt->rowCount() > 0) {
            throw new Exception('No se puede guardar el producto. Ya existe un producto con el nombre "' . $nombre . '" en el sistema.');
        }

        // Iniciar transacción
        $conn->beginTransaction();

        if ($id_producto) {
            // Actualizar producto existente
            $stmt = $conn->prepare("
                UPDATE productos 
                SET nombre = ?, categoria = ?, presentacion = ?, cantidad = ?, 
                    stock_minimo = ?, fecha_caducidad = ?, ubicacion = ?, proveedor = ?
                WHERE id_producto = ?
            ");
            $stmt->execute([$nombre, $categoria, $presentacion, $cantidad, $stock_minimo, $fecha_caducidad, $ubicacion, $proveedor, $id_producto]);
            $mensaje = 'Producto actualizado correctamente';
        } else {
            // Insertar nuevo producto
            $stmt = $conn->prepare("
                INSERT INTO productos (nombre, categoria, presentacion, cantidad, stock_minimo, fecha_caducidad, ubicacion, proveedor)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([$nombre, $categoria, $presentacion, $cantidad, $stock_minimo, $fecha_caducidad, $ubicacion, $proveedor]);
            $mensaje = 'Producto guardado correctamente';
        }

        $conn->commit();
        echo json_encode(['success' => true, 'message' => $mensaje]);
    } catch (Exception $e) {
        if ($conn->inTransaction()) {
            $conn->rollBack();
        }
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}

// Limpiar cualquier salida en el buffer
ob_end_flush(); 