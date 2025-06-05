<?php
require_once '../../php/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

try {
    // Validar datos recibidos
    if (!isset($_POST['id_producto']) || !isset($_POST['tipo_movimiento']) || 
        !isset($_POST['cantidad']) || !isset($_POST['motivo'])) {
        echo json_encode(['success' => false, 'message' => 'Faltan datos requeridos']);
        exit;
    }

    $id_producto = $_POST['id_producto'];
    $tipo_movimiento = $_POST['tipo_movimiento'];
    $cantidad = floatval($_POST['cantidad']);
    $motivo = $_POST['motivo'];

    // Validar tipo de movimiento
    if (!in_array($tipo_movimiento, ['entrada', 'salida'])) {
        echo json_encode(['success' => false, 'message' => 'Tipo de movimiento inválido']);
        exit;
    }

    // Validar cantidad
    if ($cantidad <= 0) {
        echo json_encode(['success' => false, 'message' => 'La cantidad debe ser mayor a 0']);
        exit;
    }

    // Obtener stock actual del producto
    $stmt = $conn->prepare("SELECT cantidad, stock_minimo FROM productos WHERE id_producto = ?");
    $stmt->execute([$id_producto]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$producto) {
        echo json_encode(['success' => false, 'message' => 'Producto no encontrado']);
        exit;
    }
    
    $stock_anterior = floatval($producto['cantidad']);
    $stock_posterior = $stock_anterior;

    // Verificar stock actual si es una salida
    if ($tipo_movimiento === 'salida') {
        // Verificar si el stock mínimo es menor a 10
        if ($producto['stock_minimo'] < 10) {
            echo json_encode(['success' => false, 'message' => 'El stock mínimo del producto debe ser de 10 unidades o más']);
            exit;
        }
        
        // Verificar si hay suficiente stock
        if ($stock_anterior < $cantidad) {
            echo json_encode(['success' => false, 'message' => 'No hay suficiente stock. Stock actual: ' . $stock_anterior]);
            exit;
        }
        
        // Verificar si después de la salida quedaría menos del stock mínimo
        if (($stock_anterior - $cantidad) < $producto['stock_minimo']) {
            echo json_encode(['success' => false, 'message' => 'No se puede realizar la salida. Después de esta operación quedaría menos del stock mínimo permitido']);
            exit;
        }
        
        $stock_posterior = $stock_anterior - $cantidad;
    } else {
        $stock_posterior = $stock_anterior + $cantidad;
    }

    // Validar campos adicionales según el tipo de movimiento
    if ($tipo_movimiento === 'entrada') {
        if (!isset($_POST['proveedor']) || empty($_POST['proveedor'])) {
            echo json_encode(['success' => false, 'message' => 'Debe seleccionar un proveedor']);
            exit;
        }
        if (!isset($_POST['monto']) || !is_numeric($_POST['monto']) || floatval($_POST['monto']) < 0) {
            echo json_encode(['success' => false, 'message' => 'El monto debe ser un número válido']);
            exit;
        }
    } else if ($tipo_movimiento === 'salida') {
        if (!isset($_POST['parcela']) || empty($_POST['parcela'])) {
            echo json_encode(['success' => false, 'message' => 'Debe seleccionar una parcela']);
            exit;
        }
        if (!isset($_POST['trabajador']) || empty($_POST['trabajador'])) {
            echo json_encode(['success' => false, 'message' => 'Debe seleccionar un trabajador']);
            exit;
        }
    }

    // Iniciar transacción
    $conn->beginTransaction();

    // Insertar movimiento con stock anterior y posterior
    $stmt = $conn->prepare("INSERT INTO movimientos (id_producto, tipo_movimiento, cantidad, motivo, fecha, proveedor, monto, parcela, trabajador, stock_anterior, stock_posterior) 
                           VALUES (?, ?, ?, ?, NOW(), ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $id_producto, 
        $tipo_movimiento, 
        $cantidad, 
        $motivo,
        $_POST['proveedor'] ?? null,
        $_POST['monto'] ?? null,
        $_POST['parcela'] ?? null,
        $_POST['trabajador'] ?? null,
        $stock_anterior,
        $stock_posterior
    ]);

    // Actualizar stock del producto
    $stmt = $conn->prepare("UPDATE productos SET cantidad = ? WHERE id_producto = ?");
    $stmt->execute([$stock_posterior, $id_producto]);

    // Confirmar transacción
    $conn->commit();

    echo json_encode(['success' => true, 'message' => 'Movimiento guardado correctamente']);

} catch(PDOException $e) {
    // Revertir transacción en caso de error
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    echo json_encode(['success' => false, 'message' => 'Error al guardar el movimiento: ' . $e->getMessage()]);
}
?> 