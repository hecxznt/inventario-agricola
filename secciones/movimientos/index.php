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
                                <h5 class="card-title mb-3">Registrar Movimiento</h5>
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
                                    <button type="button" class="btn btn-secondary" id="btnBuscarFechas">
                                        <i class="bi bi-search"></i> Buscar
                                    </button>
                                    <button type="button" class="btn btn-info" id="btnRegresar" style="display: none;">
                                        <i class="bi bi-arrow-counterclockwise"></i> Regresar
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
                                    <th>Tipo</th>
                                    <th>Cantidad Anterior</th>
                                    <th>Cantidad Movimiento</th>
                                    <th>Stock Actual</th>
                                    <th>Motivo</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Aquí se cargarán los movimientos -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Nuevo Movimiento -->
    <div class="modal fade" id="nuevoMovimientoModal" tabindex="-1" aria-labelledby="nuevoMovimientoModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoMovimientoModalLabel">Nuevo Movimiento</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formNuevoMovimiento">
                        <div class="mb-3">
                            <label for="producto" class="form-label">Producto</label>
                            <select class="form-select" id="producto" required>
                                <option value="">Seleccione un producto</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tipo_movimiento" class="form-label">Tipo de Movimiento</label>
                            <select class="form-select" id="tipo_movimiento" required onchange="mostrarCamposAdicionales()">
                                <option value="">Seleccione un tipo</option>
                                <option value="entrada">Entrada</option>
                                <option value="salida">Salida</option>
                            </select>
                        </div>

                        <!-- Campos para Entrada -->
                        <div id="camposEntrada" style="display: none;">
                            <div class="mb-3">
                                <label for="proveedor" class="form-label">Proveedor</label>
                                <select class="form-select" id="proveedor">
                                    <option value="">Seleccione un proveedor</option>
                                    <option value="proveedor1">Proveedor 1</option>
                                    <option value="proveedor2">Proveedor 2</option>
                                    <option value="proveedor3">Proveedor 3</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="monto" class="form-label">Monto</label>
                                <div class="input-group">
                                    <span class="input-group-text">$</span>
                                    <input type="number" class="form-control" id="monto" min="0" step="0.01" placeholder="0.00">
                                </div>
                            </div>
                        </div>

                        <!-- Campos para Salida -->
                        <div id="camposSalida" style="display: none;">
                            <div class="mb-3">
                                <label for="parcela" class="form-label">Parcela</label>
                                <select class="form-select" id="parcela">
                                    <option value="">Seleccione una parcela</option>
                                    <option value="parcela1">Parcela 1</option>
                                    <option value="parcela2">Parcela 2</option>
                                    <option value="parcela3">Parcela 3</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="trabajador" class="form-label">Trabajador</label>
                                <select class="form-select" id="trabajador" name="trabajador" required>
                                    <option value="">Seleccione un trabajador</option>
                                    <option value="1">Trabajador 1</option>
                                    <option value="2">Trabajador 2</option>
                                    <option value="3">Trabajador 3</option>
                                </select>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="cantidad" class="form-label">Cantidad</label>
                            <input type="number" class="form-control" id="cantidad" required min="0.01" step="0.01">
                        </div>

                        <div class="mb-3">
                            <label for="motivo" class="form-label">Motivo</label>
                            <textarea class="form-control" id="motivo" rows="3" required></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnGuardarMovimiento">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="/inventario/js/movimientos.js"></script>
</body>
</html> 