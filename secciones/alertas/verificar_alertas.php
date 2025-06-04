<?php
require_once '../../php/config.php';

try {
    $alertas = [
        'stock_bajo' => false,
        'caducidad' => false,
        'total' => 0
    ];

    // Verificar stock bajo (hasta 6 unidades por encima del mínimo)
    $sql_stock = "SELECT COUNT(*) as total FROM productos WHERE cantidad <= (stock_minimo + 6)";
    $stmt = $conn->query($sql_stock);
    $stock_bajo = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    if ($stock_bajo > 0) {
        $alertas['stock_bajo'] = true;
        $alertas['total'] += $stock_bajo;
    }

    // Verificar caducidad (solo próximos 10 días)
    $sql_caducidad = "SELECT COUNT(*) as total FROM productos 
                      WHERE fecha_caducidad IS NOT NULL 
                      AND fecha_caducidad BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 10 DAY)";
    $stmt = $conn->query($sql_caducidad);
    $caducidad = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    if ($caducidad > 0) {
        $alertas['caducidad'] = true;
        $alertas['total'] += $caducidad;
    }

    echo json_encode($alertas);

} catch(PDOException $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
?> 