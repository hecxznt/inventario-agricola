<?php
require_once '../../php/config.php';

try {
    $sql = "SELECT m.*, p.nombre as producto_nombre, p.stock_actual
            FROM movimientos m 
            LEFT JOIN productos p ON m.id_producto = p.id_producto";
    
    $params = [];
    $where = [];

    // Filtrar por fecha desde
    if (isset($_GET['fecha_desde']) && !empty($_GET['fecha_desde'])) {
        $where[] = "DATE(m.fecha) >= ?";
        $params[] = $_GET['fecha_desde'];
    }

    // Filtrar por fecha hasta
    if (isset($_GET['fecha_hasta']) && !empty($_GET['fecha_hasta'])) {
        $where[] = "DATE(m.fecha) <= ?";
        $params[] = $_GET['fecha_hasta'];
    }

    // Agregar condiciones WHERE si existen
    if (!empty($where)) {
        $sql .= " WHERE " . implode(" AND ", $where);
    }

    // Ordenar por fecha descendente
    $sql .= " ORDER BY m.fecha DESC";

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    
    if ($stmt->rowCount() > 0) {
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $fecha = date('d/m/Y H:i', strtotime($row['fecha']));
            $tipoClass = '';
            switch(strtolower($row['tipo_movimiento'])) {
                case 'entrada':
                    $tipoClass = 'text-success';
                    break;
                case 'salida':
                    $tipoClass = 'text-danger';
                    break;
            }
            
            // Calcular la cantidad anterior correctamente
            $cantidad_anterior = $row['tipo_movimiento'] === 'entrada' 
                ? $row['stock_actual'] - $row['cantidad']  // Si es entrada, restamos la cantidad que entró
                : $row['stock_actual'] + $row['cantidad']; // Si es salida, sumamos la cantidad que salió
            
            echo '<tr>';
            echo '<td>' . $fecha . '</td>';
            echo '<td>' . htmlspecialchars($row['producto_nombre']) . '</td>';
            echo '<td><span class="' . $tipoClass . '">' . ucfirst($row['tipo_movimiento']) . '</span></td>';
            echo '<td>' . number_format($cantidad_anterior, 2) . '</td>';
            echo '<td>' . number_format($row['cantidad'], 2) . '</td>';
            echo '<td>' . number_format($row['stock_actual'], 2) . '</td>';
            echo '<td>' . htmlspecialchars($row['motivo']) . '</td>';
            echo '<td>';
            echo '<button type="button" class="btn btn-sm btn-danger" onclick="eliminarMovimiento(' . $row['id_movimiento'] . ')">';
            echo '<i class="bi bi-trash"></i>';
            echo '</button>';
            echo '</td>';
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="8" class="text-center">No hay movimientos registrados</td></tr>';
    }
} catch(PDOException $e) {
    echo '<tr><td colspan="8" class="text-center text-danger">Error al cargar los movimientos: ' . $e->getMessage() . '</td></tr>';
}
?> 