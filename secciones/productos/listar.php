<?php
require_once '../../php/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $sql = "SELECT * FROM productos ORDER BY nombre";
        $stmt = $conn->query($sql);
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($productos) > 0) {
            echo '<table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Presentación</th>
                            <th>Cantidad</th>
                            <th>Stock Mínimo</th>
                            <th>Fecha de Caducidad</th>
                            <th>Ubicación</th>
                            <th>Proveedor</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>';
            
            foreach ($productos as $producto) {
                $estadoClase = $producto['activo'] ? 'success' : 'danger';
                $estadoTexto = $producto['activo'] ? 'Activo' : 'Deshabilitado';
                
                // Formatear la fecha de caducidad
                $fechaCaducidad = !empty($producto['fecha_caducidad']) ? date('d/m/Y', strtotime($producto['fecha_caducidad'])) : '-';
                
                // Obtener la presentación del producto
                $presentacion = isset($producto['presentacion']) ? $producto['presentacion'] : '';
                $presentacionTexto = '';
                
                if ($presentacion) {
                    switch($presentacion) {
                        case 'Kg':
                            $presentacionTexto = 'Kilogramos';
                            break;
                        case 'Cajas':
                            $presentacionTexto = 'Cajas';
                            break;
                        case 'Bultos':
                            $presentacionTexto = 'Bultos';
                            break;
                        case 'Piezas':
                            $presentacionTexto = 'Piezas';
                            break;
                        default:
                            $presentacionTexto = $presentacion;
                    }
                }
                
                echo '<tr>
                        <td>' . htmlspecialchars($producto['nombre']) . '</td>
                        <td>' . htmlspecialchars($producto['categoria']) . '</td>
                        <td>' . intval($producto['cantidad']) . ' ' . htmlspecialchars($presentacionTexto) . '</td>
                        <td>' . intval($producto['stock_minimo']) . '</td>
                        <td>' . $fechaCaducidad . '</td>
                        <td>' . htmlspecialchars($producto['ubicacion']) . '</td>
                        <td>' . htmlspecialchars($producto['proveedor']) . '</td>
                        <td><span class="badge bg-' . $estadoClase . '">' . $estadoTexto . '</span></td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-primary" title="Editar" 
                                        onclick="editarProducto(' . $producto['id_producto'] . ')">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button type="button" class="btn btn-sm ' . ($producto['activo'] ? 'btn-success' : 'btn-secondary') . '" 
                                        title="' . ($producto['activo'] ? 'Deshabilitar' : 'Activar') . '"
                                        onclick="cambiarEstado(' . $producto['id_producto'] . ')">
                                    <i class="bi bi-eye' . ($producto['activo'] ? '' : '-slash') . '"></i>
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
        echo '<div class="alert alert-danger">Error al cargar los productos: ' . $e->getMessage() . '</div>';
    }
} else {
    http_response_code(405);
    echo '<div class="alert alert-danger">Método no permitido</div>';
} 