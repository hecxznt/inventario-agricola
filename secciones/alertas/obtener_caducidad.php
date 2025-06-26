<?php
require_once '../../php/config.php';
require_once '../../secciones/alertas/enviar_alerta.php';

try {
    // Obtener productos próximos a caducar
    $sql = "SELECT id_producto, nombre, cantidad, fecha_caducidad 
            FROM productos 
            WHERE fecha_caducidad IS NOT NULL 
            AND fecha_caducidad <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)
            AND fecha_caducidad > CURDATE()
            ORDER BY fecha_caducidad ASC";
    
    $stmt = $conn->query($sql);
    
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $fechaCaducidad = new DateTime($row['fecha_caducidad']);
            $hoy = new DateTime();
            $diferencia = $hoy->diff($fechaCaducidad);
            
            // Determinar el estado y la clase CSS
            if ($diferencia->days <= 7) {
                $estado = 'Crítico';
                $clase = 'danger';
            } else if ($diferencia->days <= 7) {
                $estado = 'Próximo';
                $clase = 'warning';
            }
            
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['nombre']) . '</td>';
            echo '<td>' . number_format($row['cantidad'], 2) . '</td>';
            echo '<td>' . date('d/m/Y', strtotime($row['fecha_caducidad'])) . '</td>';
            echo '<td>' . ($diferencia->days == 0 ? $diferencia->h . " horas" : $diferencia->days . " días") . '</td>';
            echo '<td><span class="badge bg-' . $clase . '">' . $estado . '</span></td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="5" class="text-center">No hay productos próximos a caducar</td></tr>';
    }
} catch(PDOException $e) {
    echo '<tr><td colspan="5" class="text-center text-danger">Error al cargar los datos: ' . $e->getMessage() . '</td></tr>';
}
?> 