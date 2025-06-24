<?php
require_once '../../php/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $nombre = isset($_POST['nombre']) ? trim($_POST['nombre']) : '';
        $categoria = isset($_POST['categoria']) ? trim($_POST['categoria']) : '';
        $lugar = isset($_POST['lugar']) ? trim($_POST['lugar']) : '';

        // Construir la consulta base
        $sql = "SELECT id_producto, nombre, categoria, presentacion, cantidad, stock_minimo, fecha_caducidad, ubicacion, proveedor, precio FROM productos WHERE 1=1";
        $params = array();

        // Agregar condiciones según los criterios de búsqueda
        if (!empty($nombre)) {
            $sql .= " AND LOWER(nombre) LIKE :nombre";
            $params[':nombre'] = '%' . strtolower($nombre) . '%';
        }
        if (!empty($categoria)) {
            $sql .= " AND LOWER(categoria) = :categoria";
            $params[':categoria'] = strtolower($categoria);
        }
        if (!empty($lugar)) {
            $sql .= " AND LOWER(ubicacion) = :ubicacion";
            $params[':ubicacion'] = strtolower($lugar);
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
            echo '<div class="table-responsive">
                    <table class="table table-striped table-hover">
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
                                <th>Precio</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>';
            
            foreach ($productos as $row) {
                $fechaCaducidad = !empty($row['fecha_caducidad']) ? date('d/m/Y', strtotime($row['fecha_caducidad'])) : '-';
                $presentacion = '';
                switch($row['presentacion']) {
                    case 'Kg': $presentacion = 'Kilogramos'; break;
                    case 'Cajas': $presentacion = 'Cajas'; break;
                    case 'Bultos': $presentacion = 'Bultos'; break;
                    case 'Piezas': $presentacion = 'Piezas'; break;
                    default: $presentacion = $row['presentacion'];
                }
                echo '<tr>
                        <td>' . htmlspecialchars($row['nombre']) . '</td>
                        <td>' . htmlspecialchars($row['categoria']) . '</td>
                        <td>' . htmlspecialchars($presentacion) . '</td>
                        <td>' . (!empty($row['cantidad']) ? number_format(floatval($row['cantidad']), 2) : '0.00') . '</td>
                        <td>' . intval($row['stock_minimo']) . '</td>
                        <td>' . $fechaCaducidad . '</td>
                        <td>' . htmlspecialchars($row['ubicacion']) . '</td>
                        <td>' . htmlspecialchars($row['proveedor']) . '</td>
                        <td>' . ($row['categoria'] === 'insumo' && !empty($row['precio']) ? '$' . number_format($row['precio'], 2) : '-') . '</td>
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
            
            echo '</tbody></table></div>';
        } else {
            echo '<div class="alert alert-info">
                    <h5>No se encontraron productos</h5>
                    <p>No se encontraron productos que coincidan con los criterios de búsqueda.</p>
                    <a href="index.php" class="btn btn-primary">Ver todos los productos</a>
                  </div>';
        }
    } catch(PDOException $e) {
        echo '<div class="alert alert-danger">
                <h5>Error en la búsqueda</h5>
                <p>Error al realizar la búsqueda: ' . $e->getMessage() . '</p>
                <a href="index.php" class="btn btn-primary">Regresar</a>
              </div>';
    }
} else {
    http_response_code(405);
    echo '<div class="alert alert-danger">Método no permitido</div>';
} 