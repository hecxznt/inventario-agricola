<?php
require_once '../../php/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Inventario - Alertas</title>
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
                            <a class="nav-link" href="../movimientos/index.php">
                                <i class="bi bi-arrow-left-right"></i> Movimientos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="../alertas/index.php">
                                <i class="bi bi-bell"></i> Alertas
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Alertas del Sistema</h1>
                    <button type="button" class="btn btn-primary" onclick="actualizarAlertas()">
                        <i class="bi bi-arrow-clockwise"></i> Actualizar
                    </button>
                </div>

                <!-- Alertas de Stock Bajo -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-warning text-dark">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-exclamation-triangle"></i> Productos con Stock Bajo
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Stock Actual</th>
                                                <th>Stock Mínimo</th>
                                                <th>Diferencia</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablaStockBajo">
                                            <!-- Se llenará con JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Alertas de Caducidad -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-danger text-white">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-clock"></i> Productos Próximos a Caducar
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Producto</th>
                                                <th>Fecha de Caducidad</th>
                                                <th>Días Restantes</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablaCaducidad">
                                            <!-- Se llenará con JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Movimientos Recientes -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h5 class="card-title mb-0">
                                    <i class="bi bi-activity"></i> Movimientos Recientes
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Producto</th>
                                                <th>Tipo</th>
                                                <th>Cantidad</th>
                                                <th>Stock Actual</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tablaMovimientos">
                                            <!-- Se llenará con JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="/inventario/js/alertas.js"></script>
</body>
</html>
