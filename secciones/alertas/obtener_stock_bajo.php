<?php
require_once '../../php/config.php';
require_once '../../secciones/alertas/enviar_alerta.php';

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
                
                // Verificar si ya se envió una alerta para este producto
                $stmt_check = $conn->prepare("SELECT COUNT(*) as total FROM alertas_enviadas WHERE id_producto = ? AND tipo_alerta = 'stock' AND fecha_alerta >= DATE_SUB(NOW(), INTERVAL 1 DAY)");
                $stmt_check->execute([$row['id_producto']]);
                $alerta_enviada = $stmt_check->fetch(PDO::FETCH_ASSOC)['total'];
                
                if ($alerta_enviada == 0) {
                    // Enviar correo de alerta crítica
                    $asunto = "¡Alerta Crítica! Stock Mínimo Alcanzado";
                    $mensaje = "
                        <h2>Alerta de Stock Mínimo</h2>
                        <p>El siguiente producto ha alcanzado su stock mínimo:</p>
                        <ul>
                            <li><strong>Producto:</strong> {$row['nombre']}</li>
                            <li><strong>Stock Actual:</strong> {$stock_actual}</li>
                            <li><strong>Stock Mínimo:</strong> {$stock_minimo}</li>
                        </ul>
                        <p>Por favor, realice un nuevo pedido para reponer el inventario.</p>
                    ";
                    enviarCorreoAlerta($asunto, $mensaje, 'industriaagro25@gmail.com');
                    
                    // Registrar que se envió la alerta
                    $stmt_insert = $conn->prepare("INSERT INTO alertas_enviadas (id_producto, tipo_alerta, fecha_alerta) VALUES (?, 'stock', NOW())");
                    $stmt_insert->execute([$row['id_producto']]);
                }
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