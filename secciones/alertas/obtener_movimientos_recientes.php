<?php
require_once '../../php/config.php';

try {
    // Obtener los últimos 10 movimientos
    $sql = "SELECT m.*, p.nombre as producto_nombre
            FROM movimientos m 
            LEFT JOIN productos p ON m.id_producto = p.id_producto
            ORDER BY m.fecha DESC 
            LIMIT 10";
    
    $stmt = $conn->query($sql);
    
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $fecha = date('d/m/Y H:i', strtotime($row['fecha']));
            $tipoClass = $row['tipo_movimiento'] === 'entrada' ? 'success' : 'danger';
            
            echo '<tr>';
            echo '<td>' . $fecha . '</td>';
            echo '<td>' . htmlspecialchars($row['producto_nombre']) . '</td>';
            echo '<td><span class="badge bg-' . $tipoClass . '">' . ucfirst($row['tipo_movimiento']) . '</span></td>';
            echo '<td>' . number_format($row['cantidad'], 2) . '</td>';
            echo '<td>' . number_format($row['stock_posterior'], 2) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="5" class="text-center">No hay movimientos recientes</td></tr>';
    }
} catch(PDOException $e) {
    echo '<tr><td colspan="5" class="text-center text-danger">Error al cargar los datos: ' . $e->getMessage() . '</td></tr>';
}
?> 