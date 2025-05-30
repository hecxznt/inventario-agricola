<?php
require_once '../../php/config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
    exit;
}

if (!isset($_POST['id_movimiento'])) {
    echo json_encode(['success' => false, 'message' => 'ID de movimiento no proporcionado']);
    exit;
}

try {
    $id_movimiento = intval($_POST['id_movimiento']);

    // Iniciar transacción
    $conn->beginTransaction();

    // Obtener información del movimiento
    $stmt = $conn->prepare("SELECT * FROM movimientos WHERE id_movimiento = ?");
    $stmt->execute([$id_movimiento]);
    $movimiento = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$movimiento) {
        throw new Exception('Movimiento no encontrado');
    }

    // Eliminar el movimiento
    $stmt = $conn->prepare("DELETE FROM movimientos WHERE id_movimiento = ?");
    $stmt->execute([$id_movimiento]);

    // Revertir el stock del producto
    if ($movimiento['tipo_movimiento'] === 'entrada') {
        $stmt = $conn->prepare("UPDATE productos SET stock_actual = stock_actual - ? WHERE id_producto = ?");
    } else if ($movimiento['tipo_movimiento'] === 'salida') {
        $stmt = $conn->prepare("UPDATE productos SET stock_actual = stock_actual + ? WHERE id_producto = ?");
    }

    if ($movimiento['tipo_movimiento'] !== 'transferencia') {
        $stmt->execute([$movimiento['cantidad'], $movimiento['id_producto']]);
    }

    // Confirmar transacción
    $conn->commit();

    echo json_encode(['success' => true, 'message' => 'Movimiento eliminado correctamente']);

} catch(Exception $e) {
    // Revertir transacción en caso de error
    if ($conn->inTransaction()) {
        $conn->rollBack();
    }
    echo json_encode(['success' => false, 'message' => 'Error al eliminar el movimiento: ' . $e->getMessage()]);
}
?> 