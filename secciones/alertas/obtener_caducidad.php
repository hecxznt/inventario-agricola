<?php
require_once '../../php/config.php';

try {
    // Obtener productos que caducan en los próximos 10 días
    $sql = "SELECT id_producto, nombre, fecha_caducidad 
            FROM productos 
            WHERE fecha_caducidad IS NOT NULL 
            AND fecha_caducidad BETWEEN CURDATE() AND DATE_ADD(CURDATE(), INTERVAL 10 DAY)
            ORDER BY fecha_caducidad ASC";
    
    $stmt = $conn->query($sql);
    
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $fecha_caducidad = new DateTime($row['fecha_caducidad']);
            $hoy = new DateTime();
            $dias_restantes = $hoy->diff($fecha_caducidad)->days;
            
            echo '<tr>';
            echo '<td>' . htmlspecialchars($row['nombre']) . '</td>';
            echo '<td>' . date('d/m/Y', strtotime($row['fecha_caducidad'])) . '</td>';
            echo '<td>' . $dias_restantes . ' días</td>';
            echo '<td><span class="badge bg-danger">Crítico</span></td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="4" class="text-center">No hay productos próximos a caducar</td></tr>';
    }
} catch(PDOException $e) {
    echo '<tr><td colspan="4" class="text-center text-danger">Error al cargar los datos: ' . $e->getMessage() . '</td></tr>';
}
?> 