<?php
require_once '../../php/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Inventario - Movimientos</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/inventario/css/styles.css?v=1.0">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <nav class="col-md-3 col-lg-2 d-md-block bg-light sidebar">
                <div class="position-sticky pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link" href="../productos/index.php">
                                <i class="bi bi-box-seam"></i> Productos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="../movimientos/index.php">
                                <i class="bi bi-arrow-left-right"></i> Movimientos
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Movimientos de Inventario</h1>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex gap-2 align-items-center">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoMovimientoModal">
                                        <i class="bi bi-plus-circle"></i> Nuevo Movimiento
                                    </button>
                                    <div class="input-group" style="max-width: 200px;">
                                        <span class="input-group-text">Desde</span>
                                        <input type="date" class="form-control" id="fechaDesde">
                                    </div>
                                    <div class="input-group" style="max-width: 200px;">
                                        <span class="input-group-text">Hasta</span>
                                        <input type="date" class="form-control" id="fechaHasta">
                                    </div>
                                    <button type="button" class="btn btn-secondary" id="btnBuscar">
                                        <i class="bi bi-search"></i> Buscar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="content">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Producto</th>
                                    <th>Stock Actual</th>
                                    <th>Tipo</th>
                                    <th>Cantidad</th>
                                    <th>Motivo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                try {
                                    $stmt = $conn->query("SELECT m.*, p.nombre as producto_nombre, p.stock_actual 
                                                        FROM movimientos m 
                                                        LEFT JOIN productos p ON m.id_producto = p.id_producto 
                                                        ORDER BY m.fecha DESC");
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        // Formatear la fecha
                                        $fecha = date('d/m/Y H:i', strtotime($row['fecha']));
                                        
                                        // Determinar el color del tipo de movimiento
                                        $tipoClass = '';
                                        switch(strtolower($row['tipo_movimiento'])) {
                                            case 'entrada':
                                                $tipoClass = 'text-success';
                                                break;
                                            case 'salida':
                                                $tipoClass = 'text-danger';
                                                break;
                                            case 'transferencia':
                                                $tipoClass = 'text-warning';
                                                break;
                                        }

                                        // Determinar el color del stock
                                        $stockClass = '';
                                        if ($row['stock_actual'] <= 0) {
                                            $stockClass = 'text-danger';
                                        } elseif ($row['stock_actual'] < 10) {
                                            $stockClass = 'text-warning';
                                        } else {
                                            $stockClass = 'text-success';
                                        }
                                        ?>
                                        <tr>
                                            <td><?php echo $fecha; ?></td>
                                            <td><?php echo htmlspecialchars($row['producto_nombre']); ?></td>
                                            <td><span class="<?php echo $stockClass; ?>"><?php echo number_format($row['stock_actual'], 2); ?></span></td>
                                            <td><span class="<?php echo $tipoClass; ?>"><?php echo ucfirst($row['tipo_movimiento']); ?></span></td>
                                            <td><?php echo number_format($row['cantidad'], 2); ?></td>
                                            <td><?php echo htmlspecialchars($row['motivo']); ?></td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info btn-historial" data-id="<?php echo $row['id_producto']; ?>">
                                                    <i class="bi bi-clock-history"></i> Historial
                                                </button>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } catch(PDOException $e) {
                                    echo '<tr><td colspan="7" class="text-center text-danger">Error al cargar los movimientos: ' . $e->getMessage() . '</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal para Historial de Producto -->
    <div class="modal fade" id="historialModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Historial de Movimientos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="historialContenido"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal para Nuevo Movimiento -->
    <div class="modal fade" id="nuevoMovimientoModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Movimiento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formMovimiento">
                        <!-- Campo oculto para el ID del producto -->
                        <input type="hidden" name="id_producto" id="id_producto">
                        
                        <!-- Selector de Producto -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Producto</label>
                            <select class="form-select" id="selectProducto" name="select_producto" required>
                                <option value="">Seleccione un producto</option>
                                <?php
                                try {
                                    $stmt = $conn->query("SELECT id_producto, nombre, stock_actual 
                                                        FROM productos 
                                                        ORDER BY nombre");
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo sprintf(
                                            '<option value="%d" data-stock="%f">%s (Stock: %s)</option>',
                                            $row['id_producto'],
                                            $row['stock_actual'],
                                            htmlspecialchars($row['nombre']),
                                            number_format($row['stock_actual'], 2)
                                        );
                                    }
                                } catch(PDOException $e) {
                                    echo '<option value="">Error al cargar productos</option>';
                                }
                                ?>
                            </select>
                        </div>

                        <!-- Tipo de Movimiento -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Tipo de Movimiento</label>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="tipo_movimiento" id="tipoEntrada" value="entrada" autocomplete="off">
                                <label class="btn btn-outline-success" for="tipoEntrada">Entrada</label>

                                <input type="radio" class="btn-check" name="tipo_movimiento" id="tipoSalida" value="salida" autocomplete="off">
                                <label class="btn btn-outline-danger" for="tipoSalida">Salida</label>

                                <input type="radio" class="btn-check" name="tipo_movimiento" id="tipoTransferencia" value="transferencia" autocomplete="off">
                                <label class="btn btn-outline-warning" for="tipoTransferencia">Transferencia</label>
                            </div>
                        </div>

                        <!-- Campos para Entrada -->
                        <div id="camposEntrada" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label">Proveedor</label>
                                <select class="form-select" name="proveedor">
                                    <option value="">Seleccione un proveedor</option>
                                    <option value="1">Proveedor 1</option>
                                    <option value="2">Proveedor 2</option>
                                    <option value="3">Proveedor 3</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Monto</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="text" class="form-control" name="monto" placeholder="0.00">
                                </div>
                            </div>
                        </div>

                        <!-- Campos para Salida -->
                        <div id="camposSalida" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label">Parcela</label>
                                <select class="form-select" name="parcela">
                                    <option value="">Seleccione una parcela</option>
                                    <option value="1">Parcela 1</option>
                                    <option value="2">Parcela 2</option>
                                    <option value="3">Parcela 3</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Trabajador</label>
                                <select class="form-select" name="trabajador">
                                    <option value="">Seleccione un trabajador</option>
                                    <option value="1">Trabajador 1</option>
                                    <option value="2">Trabajador 2</option>
                                    <option value="3">Trabajador 3</option>
                                </select>
                            </div>
                        </div>

                        <!-- Campos para Transferencia -->
                        <div id="camposTransferencia" style="display: none;">
                            <div class="mb-3">
                                <label class="form-label">Destino</label>
                                <select class="form-select" name="destino">
                                    <option value="">Seleccione un destino</option>
                                    <option value="1">Almacén Principal</option>
                                    <option value="2">Almacén Secundario</option>
                                    <option value="3">Bodega</option>
                                </select>
                            </div>
                        </div>

                        <!-- Campos Comunes -->
                        <div class="mb-3">
                            <label class="form-label">Cantidad</label>
                            <input type="number" class="form-control" name="cantidad" step="0.01" min="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Motivo</label>
                            <textarea class="form-control" name="motivo" rows="3" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="guardarMovimiento()">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Definir la ruta base para las llamadas AJAX
        const BASE_URL = window.location.pathname.substring(0, window.location.pathname.indexOf('/secciones/movimientos/'));
        
        // Verificar que jQuery está cargado
        console.log('jQuery version:', $.fn.jquery);
        
        // Verificar que Bootstrap está cargado
        console.log('Bootstrap Modal:', typeof bootstrap.Modal);
    </script>
    <script src="../../js/movimientos.js?v=<?php echo time(); ?>"></script>
    <script>
        // Verificar que las funciones están disponibles
        console.log('verHistorial disponible:', typeof verHistorial);
        console.log('guardarMovimiento disponible:', typeof guardarMovimiento);
        
        // Agregar evento al botón de nuevo movimiento
        document.addEventListener('DOMContentLoaded', function() {
            const btnNuevoMovimiento = document.querySelector('[data-bs-target="#nuevoMovimientoModal"]');
            if (btnNuevoMovimiento) {
                btnNuevoMovimiento.addEventListener('click', function() {
                    console.log('Botón de nuevo movimiento clickeado');
                    const modal = new bootstrap.Modal(document.getElementById('nuevoMovimientoModal'));
                    modal.show();
                });
            }
        });

        // Agregar evento a los botones de historial
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-historial').forEach(btn => {
                btn.addEventListener('click', function() {
                    const idProducto = this.getAttribute('data-id');
                    console.log('Ver historial para producto:', idProducto);
                    verHistorial(idProducto);
                });
            });
        });
    </script>
</body>
</html> 