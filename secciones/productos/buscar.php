<?php
require_once '../../php/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $nombre = isset($_POST['nombre']) ? $_POST['nombre'] : '';
        $categoria = isset($_POST['categoria']) ? $_POST['categoria'] : '';
        $lugar = isset($_POST['lugar']) ? $_POST['lugar'] : '';

        // Construir la consulta base
        $sql = "SELECT * FROM productos WHERE 1=1";
        $params = array();

        // Agregar condiciones según los criterios de búsqueda
        if (!empty($nombre)) {
            $sql .= " AND nombre LIKE :nombre";
            $params[':nombre'] = "%$nombre%";
        }
        if (!empty($categoria)) {
            $sql .= " AND categoria = :categoria";
            $params[':categoria'] = $categoria;
        }
        if (!empty($lugar)) {
            $sql .= " AND ubicacion = :ubicacion";
            $params[':ubicacion'] = $lugar;
        }

        $sql .= " ORDER BY nombre";

        // Preparar y ejecutar la consulta
        $stmt = $conn->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value);
        }
        $stmt->execute();
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Generar la tabla HTML
        if (count($productos) > 0) {
            echo '<div class="mb-3">
                    <a href="index.php" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left"></i> Regresar
                    </a>
                  </div>';
            echo '<table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Presentación</th>
                            <th>Stock Mínimo</th>
                            <th>Fecha Caducidad</th>
                            <th>Ubicación</th>
                            <th>Proveedor</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>';
            
            foreach ($productos as $producto) {
                // Formatear la fecha de caducidad
                $fechaCaducidad = !empty($producto['fecha_caducidad']) ? date('d/m/Y', strtotime($producto['fecha_caducidad'])) : '-';
                
                // Formatear la presentación
                $presentacion = '';
                switch($producto['presentacion']) {
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
                        $presentacion = $producto['presentacion'];
                }
                
                echo '<tr>
                        <td>' . htmlspecialchars($producto['nombre']) . '</td>
                        <td>' . htmlspecialchars($producto['categoria']) . '</td>
                        <td>' . htmlspecialchars($presentacion) . '</td>
                        <td>' . intval($producto['stock_minimo']) . '</td>
                        <td>' . $fechaCaducidad . '</td>
                        <td>' . htmlspecialchars($producto['ubicacion']) . '</td>
                        <td>' . htmlspecialchars($producto['proveedor']) . '</td>
                        <td>
                            <span class="badge bg-' . ($producto['activo'] ? 'success' : 'danger') . '">
                                ' . ($producto['activo'] ? 'Activo' : 'Deshabilitado') . '
                            </span>
                        </td>
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
            echo '<div class="alert alert-info">No se encontraron productos que coincidan con los criterios de búsqueda.</div>';
        }
    } catch(PDOException $e) {
        echo '<div class="alert alert-danger">Error al realizar la búsqueda: ' . $e->getMessage() . '</div>';
    }
} else {
    http_response_code(405);
    echo '<div class="alert alert-danger">Método no permitido</div>';
} 