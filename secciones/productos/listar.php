<?php
require_once '../../php/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Si es una solicitud AJAX para el selector de productos
        if (isset($_GET['selector']) && $_GET['selector'] === 'true') {
            $sql = "SELECT id_producto, nombre FROM productos WHERE activo = 1 ORDER BY nombre";
            $stmt = $conn->query($sql);
            $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            header('Content-Type: application/json');
            echo json_encode([
                'success' => true,
                'productos' => $productos
            ]);
            exit;
        }

        // Si no, mostrar la tabla completa
        $sql = "SELECT id_producto, nombre, categoria, presentacion, cantidad as stock_actual, stock_minimo, fecha_caducidad, ubicacion, proveedor, 1 as activo FROM productos ORDER BY nombre";
        $stmt = $conn->query($sql);
        
        if ($stmt->rowCount() > 0) {
            echo '<table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Presentación</th>
                            <th>Stock Actual</th>
                            <th>Stock Mínimo</th>
                            <th>Fecha Caducidad</th>
                            <th>Ubicación</th>
                            <th>Proveedor</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>';
            
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                // Formatear la fecha de caducidad
                $fechaCaducidad = !empty($row['fecha_caducidad']) ? date('d/m/Y', strtotime($row['fecha_caducidad'])) : '-';
                
                // Formatear la presentación
                $presentacion = '';
                switch($row['presentacion']) {
                    case 'Kg':
                        $presentacion = 'Kilogramos';
                        break;
                    case 'Cajas':
                        $presentacion = 'Cajas';
                        break;
                    case 'Bultos':
                        $presentacion = 'Bultos';
                        break;
                    case 'Piezas':
                        $presentacion = 'Piezas';
                        break;
                    default:
                        $presentacion = $row['presentacion'];
                }
                
                echo '<tr>
                        <td>' . htmlspecialchars($row['nombre']) . '</td>
                        <td>' . htmlspecialchars($row['categoria']) . '</td>
                        <td>' . htmlspecialchars($presentacion) . '</td>
                        <td>' . number_format(floatval($row['stock_actual']), 2) . '</td>
                        <td>' . intval($row['stock_minimo']) . '</td>
                        <td>' . $fechaCaducidad . '</td>
                        <td>' . htmlspecialchars($row['ubicacion']) . '</td>
                        <td>' . htmlspecialchars($row['proveedor']) . '</td>
                        <td>
                            <span class="badge bg-success">Activo</span>
                        </td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-primary" title="Editar" 
                                        onclick="editarProducto(' . $row['id_producto'] . ')">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm btn-success" 
                                        title="Deshabilitar"
                                        onclick="cambiarEstado(' . $row['id_producto'] . ')">
                                    <i class="bi bi-eye"></i>
                                </button>
                            </div>
                        </td>
                    </tr>';
            }
            
            echo '</tbody></table>';
        } else {
            echo '<div class="alert alert-info">No hay productos registrados.</div>';
        }
    } catch(PDOException $e) {
        if (isset($_GET['selector']) && $_GET['selector'] === 'true') {
            header('Content-Type: application/json');
            echo json_encode([
                'success' => false,
                'message' => 'Error al cargar los productos: ' . $e->getMessage()
            ]);
        } else {
            echo '<div class="alert alert-danger">Error al cargar los productos: ' . $e->getMessage() . '</div>';
        }
    }
} else {
    if (isset($_GET['selector']) && $_GET['selector'] === 'true') {
        header('Content-Type: application/json');
        echo json_encode([
            'success' => false,
            'message' => 'Método no permitido'
        ]);
    } else {
        http_response_code(405);
        echo '<div class="alert alert-danger">Método no permitido</div>';
    }
} 