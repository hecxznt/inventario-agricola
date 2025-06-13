<?php
require_once '../../php/config.php';

try {
    // Obtener el número de página actual
    $pagina = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $registros_por_pagina = 20;
    $offset = ($pagina - 1) * $registros_por_pagina;

    // Construir la consulta base
    $sql_base = "SELECT m.*, p.nombre as producto_nombre
                 FROM movimientos m 
                 LEFT JOIN productos p ON m.id_producto = p.id_producto";
    
    $params = [];
    $where = [];

    // Filtrar por producto
    if (isset($_GET['id_producto']) && !empty($_GET['id_producto'])) {
        $where[] = "m.id_producto = ?";
        $params[] = $_GET['id_producto'];
    }

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
        $sql_base .= " WHERE " . implode(" AND ", $where);
    }

    // Consulta para obtener el total de registros
    $sql_count = "SELECT COUNT(*) as total FROM (" . $sql_base . ") as subquery";
    $stmt_count = $conn->prepare($sql_count);
    $stmt_count->execute($params);
    $total_registros = $stmt_count->fetch(PDO::FETCH_ASSOC)['total'];
    $total_paginas = ceil($total_registros / $registros_por_pagina);

    // Consulta principal con paginación
    $sql = $sql_base . " ORDER BY m.fecha DESC LIMIT " . $registros_por_pagina . " OFFSET " . $offset;

    $stmt = $conn->prepare($sql);
    $stmt->execute($params);
    
    // Generar la tabla de movimientos
    if ($stmt->rowCount() > 0) {
        $contador = $offset + 1; // Iniciar contador desde el offset actual
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
            
            echo '<tr>';
            echo '<td>' . $contador . '</td>'; // Agregar número de registro
            echo '<td>' . $fecha . '</td>';
            echo '<td>' . htmlspecialchars($row['producto_nombre']) . '</td>';
            echo '<td><span class="' . $tipoClass . '">' . ucfirst($row['tipo_movimiento']) . '</span></td>';
            echo '<td>' . number_format($row['stock_anterior'], 2) . '</td>';
            echo '<td>' . number_format($row['cantidad'], 2) . '</td>';
            echo '<td>' . number_format($row['stock_posterior'], 2) . '</td>';
            echo '<td>' . htmlspecialchars($row['motivo']) . '</td>';
            echo '<td>';
            echo '<button type="button" class="btn btn-sm btn-danger" onclick="eliminarMovimiento(' . $row['id_movimiento'] . ')">';
            echo '<i class="bi bi-trash"></i>';
            echo '</button>';
            echo '</td>';
            echo '</tr>';
            $contador++;
        }

        // Generar la paginación
        echo '<tr><td colspan="9"><div class="d-flex justify-content-center mt-3">'; // Ajustado colspan a 9
        echo '<nav aria-label="Navegación de páginas"><ul class="pagination">';
        
        // Botón Anterior
        if ($pagina > 1) {
            echo '<li class="page-item"><a class="page-link" href="#" onclick="cambiarPagina(' . ($pagina - 1) . ')">Anterior</a></li>';
        } else {
            echo '<li class="page-item disabled"><a class="page-link" href="#">Anterior</a></li>';
        }

        // Números de página
        $inicio = max(1, $pagina - 2);
        $fin = min($total_paginas, $pagina + 2);

        if ($inicio > 1) {
            echo '<li class="page-item"><a class="page-link" href="#" onclick="cambiarPagina(1)">1</a></li>';
            if ($inicio > 2) {
                echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
            }
        }

        for ($i = $inicio; $i <= $fin; $i++) {
            if ($i == $pagina) {
                echo '<li class="page-item active"><a class="page-link" href="#">' . $i . '</a></li>';
            } else {
                echo '<li class="page-item"><a class="page-link" href="#" onclick="cambiarPagina(' . $i . ')">' . $i . '</a></li>';
            }
        }

        if ($fin < $total_paginas) {
            if ($fin < $total_paginas - 1) {
                echo '<li class="page-item disabled"><a class="page-link" href="#">...</a></li>';
            }
            echo '<li class="page-item"><a class="page-link" href="#" onclick="cambiarPagina(' . $total_paginas . ')">' . $total_paginas . '</a></li>';
        }

        // Botón Siguiente
        if ($pagina < $total_paginas) {
            echo '<li class="page-item"><a class="page-link" href="#" onclick="cambiarPagina(' . ($pagina + 1) . ')">Siguiente</a></li>';
        } else {
            echo '<li class="page-item disabled"><a class="page-link" href="#">Siguiente</a></li>';
        }

        echo '</ul></nav></div></td></tr>';
    } else {
        echo '<tr><td colspan="9" class="text-center">No hay movimientos registrados</td></tr>'; // Ajustado colspan a 9
    }
} catch(PDOException $e) {
    echo '<tr><td colspan="9" class="text-center text-danger">Error al cargar los movimientos: ' . $e->getMessage() . '</td></tr>'; // Ajustado colspan a 9
}
?> 