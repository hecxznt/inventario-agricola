<?php
require_once '../../php/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        // Consulta para obtener solo productos deshabilitados
        $sql = "SELECT * FROM productos WHERE activo = 0 ORDER BY nombre";
        $stmt = $conn->query($sql);
        $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        if (count($productos) > 0) {
            echo '<div class="d-flex justify-content-between align-items-center mb-3">
                    <h4>Productos Deshabilitados</h4>
                    <a href="index.php" class="btn btn-primary">
                        <i class="bi bi-arrow-left"></i> Volver a Productos Activos
                    </a>
                  </div>';
            
            echo '<table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Unidad de Medida</th>
                            <th>Stock Mínimo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>';
            
            foreach ($productos as $producto) {
                echo '<tr>
                        <td>' . htmlspecialchars($producto['nombre']) . '</td>
                        <td>' . htmlspecialchars($producto['unidad_medida']) . '</td>
                        <td>' . htmlspecialchars($producto['stock_minimo']) . '</td>
                        <td>
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-sm btn-success" 
                                        title="Activar Producto"
                                        onclick="cambiarEstado(' . $producto['id_producto'] . ')">
                                    <i class="bi bi-eye"></i> Activar
                                </button>
                            </div>
                        </td>
                    </tr>';
            }
            
            echo '</tbody></table>';
        } else {
            echo '<div class="alert alert-info">
                    No hay productos deshabilitados.
                    <a href="index.php" class="alert-link">Volver a Productos Activos</a>
                  </div>';
        }
    } catch(PDOException $e) {
        echo '<div class="alert alert-danger">Error al cargar los productos: ' . $e->getMessage() . '</div>';
    }
} else {
    http_response_code(405);
    echo '<div class="alert alert-danger">Método no permitido</div>';
} 