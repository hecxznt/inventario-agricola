<?php
require_once '../../php/config.php';

try {
    // Obtener productos donde el stock actual está cerca o por debajo del stock mínimo
    $sql = "SELECT id_producto, nombre, cantidad as stock_actual, stock_minimo 
            FROM productos 
            WHERE cantidad <= (stock_minimo + 6) 
            ORDER BY (cantidad / stock_minimo) ASC";
    
    $stmt = $conn->query($sql);
    
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Convertir a números para asegurar operaciones matemáticas correctas
            $stock_actual = floatval($row['stock_actual']);
            $stock_minimo = floatval($row['stock_minimo']);
            
            $diferencia = $stock_minimo - $stock_actual;
            $porcentaje = ($stock_actual / $stock_minimo) * 100;
            $limite_critico = $stock_minimo + 3; // 3 unidades por encima del mínimo
            $limite_bajo = $stock_minimo + 6; // 6 unidades por encima del mínimo
            
            // Determinar el estado y la clase CSS
            if ($stock_actual <= $limite_critico) {
                $estado = 'Crítico';
                $clase = 'danger';
            } else if ($stock_actual <= $limite_bajo) {
                $estado = 'Bajo';
                $clase = 'warning';
            }
            
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['nombre']) . '</td>';
            echo '<td>' . number_format($stock_actual, 2) . '</td>';
            echo '<td>' . number_format($stock_minimo, 2) . '</td>';
            echo '<td>' . number_format($diferencia, 2) . '</td>';
            echo '<td><span class="badge bg-' . $clase . '">' . $estado . '</span></td>';
            echo '<td>Límite crítico: ' . number_format($limite_critico, 2) . '<br>Límite bajo: ' . number_format($limite_bajo, 2) . '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="6" class="text-center">No hay productos con stock bajo</td></tr>';
    }
} catch(PDOException $e) {
    echo '<tr><td colspan="6" class="text-center text-danger">Error al cargar los datos: ' . $e->getMessage() . '</td></tr>';
}
?> 