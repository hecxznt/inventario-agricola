<?php
require_once '../../php/config.php';

if (!isset($_POST['id_producto'])) {
    echo '<div class="alert alert-danger">ID de producto no especificado</div>';
    exit;
}

$id_producto = $_POST['id_producto'];

try {
    // Obtener información del producto
    $stmt = $conn->prepare("SELECT nombre, stock_actual FROM productos WHERE id_producto = ?");
    $stmt->execute([$id_producto]);
    $producto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$producto) {
        echo '<div class="alert alert-danger">Producto no encontrado</div>';
        exit;
    }

    // Obtener historial de movimientos
    $stmt = $conn->prepare("SELECT m.*, p.nombre as producto_nombre 
                           FROM movimientos m 
                           LEFT JOIN productos p ON m.id_producto = p.id_producto 
                           WHERE m.id_producto = ? 
                           ORDER BY m.fecha DESC");
    $stmt->execute([$id_producto]);
    $movimientos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Mostrar información del producto
    echo '<div class="mb-4">';
    echo '<h4>' . htmlspecialchars($producto['nombre']) . '</h4>';
    echo '<p>Stock Actual: <strong>' . number_format($producto['stock_actual'], 2) . '</strong></p>';
    echo '</div>';

    // Mostrar tabla de movimientos
    echo '<div class="table-responsive">';
    echo '<table class="table table-sm table-striped">';
    echo '<thead><tr>';
    echo '<th>Fecha</th>';
    echo '<th>Tipo</th>';
    echo '<th>Cantidad</th>';
    echo '<th>Motivo</th>';
    echo '</tr></thead><tbody>';

    foreach ($movimientos as $mov) {
        $tipoClass = '';
        switch(strtolower($mov['tipo_movimiento'])) {
            case 'entrada':
                $tipoClass = 'text-success';
                break;
            case 'salida':
                $tipoClass = 'text-danger';
                break;
            case 'transferencia':
                $tipoClass = 'text-warning';
                break;
        }

        echo '<tr>';
        echo '<td>' . date('d/m/Y H:i', strtotime($mov['fecha'])) . '</td>';
        echo '<td><span class="' . $tipoClass . '">' . ucfirst($mov['tipo_movimiento']) . '</span></td>';
        echo '<td>' . number_format($mov['cantidad'], 2) . '</td>';
        echo '<td>' . htmlspecialchars($mov['motivo']) . '</td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
    echo '</div>';

} catch(PDOException $e) {
    echo '<div class="alert alert-danger">Error al cargar el historial: ' . $e->getMessage() . '</div>';
}
?> 