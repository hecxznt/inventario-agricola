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
                                                <button type="button" class="btn btn-sm btn-info" onclick="verHistorial(<?php echo $row['id_producto']; ?>)">
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
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Nuevo Movimiento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formMovimiento">
                        <div class="mb-3">
                            <label class="form-label">Producto</label>
                            <select class="form-select" name="id_producto" required>
                                <option value="">Seleccione un producto</option>
                                <?php
                                try {
                                    $stmt = $conn->query("SELECT id_producto, nombre, stock_actual FROM productos ORDER BY nombre");
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                        echo '<option value="' . $row['id_producto'] . '">' . 
                                             htmlspecialchars($row['nombre']) . 
                                             ' (Stock: ' . number_format($row['stock_actual'], 2) . ')</option>';
                                    }
                                } catch(PDOException $e) {
                                    echo '<option value="">Error al cargar productos</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tipo de Movimiento</label>
                            <select class="form-select" name="tipo_movimiento" required>
                                <option value="">Seleccione un tipo</option>
                                <option value="entrada">Entrada</option>
                                <option value="salida">Salida</option>
                                <option value="transferencia">Transferencia</option>
                            </select>
                        </div>
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function verHistorial(idProducto) {
        // Mostrar el modal
        const modal = new bootstrap.Modal(document.getElementById('historialModal'));
        modal.show();
        
        // Cargar el historial
        $.ajax({
            url: 'obtener_historial.php',
            type: 'POST',
            data: { id_producto: idProducto },
            success: function(response) {
                $('#historialContenido').html(response);
            },
            error: function() {
                $('#historialContenido').html('<div class="alert alert-danger">Error al cargar el historial</div>');
            }
        });
    }

    function guardarMovimiento() {
        const form = document.getElementById('formMovimiento');
        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        const formData = new FormData(form);
        formData.append('id_trabajador', 1); // Por ahora usamos un ID fijo

        $.ajax({
            url: 'guardar.php',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    location.reload();
                } else {
                    alert(response.message);
                }
            },
            error: function() {
                alert('Error al guardar el movimiento');
            }
        });
    }
    </script>
</body>
</html> 