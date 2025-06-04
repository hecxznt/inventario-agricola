<?php
require_once '../../php/config.php';

try {
    // Obtener productos donde el stock actual está cerca o por debajo del stock mínimo
    $sql = "SELECT id_producto, nombre, stock_actual, stock_minimo 
            FROM productos 
            WHERE stock_actual <= (stock_minimo * 1.2) 
            ORDER BY (stock_actual / stock_minimo) ASC";
    
    $stmt = $conn->query($sql);
    
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $diferencia = $row['stock_minimo'] - $row['stock_actual'];
            $porcentaje = ($row['stock_actual'] / $row['stock_minimo']) * 100;
            
            // Determinar el estado y la clase CSS
            if ($row['stock_actual'] <= $row['stock_minimo']) {
                $estado = 'Crítico';
                $clase = 'danger';
            } else {
                $estado = 'Bajo';
                $clase = 'warning';
            }
            
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['nombre']) . '</td>';
            echo '<td>' . number_format($row['stock_actual'], 2) . '</td>';
            echo '<td>' . number_format($row['stock_minimo'], 2) . '</td>';
            echo '<td>' . number_format($diferencia, 2) . '</td>';
            echo '<td><span class="badge bg-' . $clase . '">' . $estado . '</span></td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="5" class="text-center">No hay productos con stock bajo</td></tr>';
    }
} catch(PDOException $e) {
    echo '<tr><td colspan="5" class="text-center text-danger">Error al cargar los datos: ' . $e->getMessage() . '</td></tr>';
}
?> 