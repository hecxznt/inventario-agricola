<?php
require_once '../../php/config.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sistema de Inventario</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/inventario/css/styles.css?v=1.0">
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include '../includes/sidebar.php'; ?>

            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">Dashboard</h1>
                </div>

                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Búsqueda de Productos</h5>
                                <div class="d-flex gap-2 align-items-center">
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#nuevoProductoModal">
                                        <i class="bi bi-plus-circle"></i> Producto
                                    </button>
                                    <div class="input-group" style="max-width: 200px;">
                                        <input type="text" class="form-control" placeholder="Nombre" id="buscarNombre">
                                    </div>
                                    <select class="form-select" style="max-width: 200px;" id="buscarCategoria">
                                        <option value="">Categoría</option>
                                        <option value="herramientas">Herramientas</option>
                                        <option value="insumos">Insumos</option>
                                        <option value="implemento">Implemento</option>
                                    </select>
                                    <select class="form-select" style="max-width: 200px;" id="buscarLugar">
                                        <option value="">Lugar</option>
                                        <option value="bodega1">Bodega 1</option>
                                        <option value="bodega2">Bodega 2</option>
                                        <option value="bodega3">Bodega 3</option>
                                    </select>
                                    <button type="button" class="btn btn-secondary" id="btnBuscar">
                                        <i class="bi bi-search"></i> Buscar
                                    </button>
                                    <button type="button" class="btn btn-outline-secondary" id="btnLimpiar">
                                        <i class="bi bi-x-circle"></i> Limpiar
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de exportar en el dashboard de productos -->
                <div class="mb-3">
                    <button id="btnExportarExcelProductos" class="btn btn-success">
                        <i class="bi bi-file-earmark-excel"></i> Excel
                    </button>
                    <button id="btnExportarPDFProductos" class="btn btn-danger">
                        <i class="bi bi-file-earmark-pdf"></i> PDF
                    </button>
                </div>

                <div class="content">
                    <div class="table-responsive">
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
                            <tbody>
                                <?php
                                try {
                                    $stmt = $conn->query("SELECT id_producto, nombre, categoria, presentacion, cantidad as stock_actual, stock_minimo, fecha_caducidad, ubicacion, proveedor, precio, activo FROM productos ORDER BY nombre");
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
                                        ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($row['nombre']); ?></td>
                                            <td><?php echo htmlspecialchars($row['categoria']); ?></td>
                                            <td><?php echo htmlspecialchars($presentacion); ?></td>
                                            <td><?php echo !empty($row['stock_actual']) ? number_format(floatval($row['stock_actual']), 2) : '0.00'; ?></td>
                                            <td><?php echo intval($row['stock_minimo']); ?></td>
                                            <td><?php echo $fechaCaducidad; ?></td>
                                            <td><?php echo htmlspecialchars($row['ubicacion']); ?></td>
                                            <td><?php echo htmlspecialchars($row['proveedor']); ?></td>
                                            <td><?php
                                                $categoria = strtolower(trim($row['categoria']));
                                                echo (($categoria === 'insumo' || $categoria === 'insumos') && !empty($row['precio']))
                                                    ? '$' . number_format($row['precio'], 2)
                                                    : '-';
                                            ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo $row['activo'] ? 'success' : 'danger'; ?>">
                                                    <?php echo $row['activo'] ? 'Activo' : 'Deshabilitado'; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-sm btn-primary" title="Editar" 
                                                            onclick="editarProducto(<?php echo $row['id_producto']; ?>)">
                                                        <i class="bi bi-pencil"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-sm <?php echo $row['activo'] ? 'btn-success' : 'btn-secondary'; ?>" 
                                                            title="<?php echo $row['activo'] ? 'Deshabilitar' : 'Activar'; ?>"
                                                            onclick="cambiarEstado(<?php echo $row['id_producto']; ?>)">
                                                        <i class="bi bi-eye<?php echo $row['activo'] ? '' : '-slash'; ?>"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                    }
                                } catch(PDOException $e) {
                                    echo '<tr><td colspan="11" class="text-center text-danger">Error al cargar los productos: ' . $e->getMessage() . '</td></tr>';
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Nuevo Producto -->
    <div class="modal fade" id="nuevoProductoModal" tabindex="-1" aria-labelledby="nuevoProductoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="nuevoProductoModalLabel">Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="formNuevoProducto">
                        <input type="hidden" id="productoId">
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="nombre" class="form-label">Nombre</label>
                                <input type="text" class="form-control" id="nombre" required>
                            </div>
                            <div class="col-md-6">
                                <label for="categoria" class="form-label">Tipo de Producto</label>
                                <select class="form-select" id="categoria" required>
                                    <option value="">Seleccione un tipo</option>
                                    <option value="insumos">Insumos</option>
                                    <option value="herramientas">Herramientas</option>
                                    <option value="implemento">Implemento</option>
                                </select>
                            </div>
                        </div>
                        <!-- Campo de precio solo para insumo -->
                        <div class="row mb-3" id="campoPrecio" style="display:none;">
                            <div class="col-md-6">
                                <label for="precio" class="form-label">Precio</label>
                                <input type="number" class="form-control" id="precio" min="0" step="0.01" placeholder="Ej: 123.45">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="presentacion" class="form-label">Presentación</label>
                                <select class="form-select" id="presentacion" required>
                                    <option value="">Seleccione una presentación</option>
                                    <option value="Kg">Kilogramos</option>
                                    <option value="Cajas">Cajas</option>
                                    <option value="Bultos">Bultos</option>
                                    <option value="Piezas">Piezas</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="cantidad" class="form-label">Cantidad</label>
                                <input type="number" class="form-control" id="cantidad" required min="10" value="10" placeholder="Ej: 5 cajas, 10 kg, etc.">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="stockMinimo" class="form-label">Stock Mínimo</label>
                                <input type="number" class="form-control" id="stockMinimo" required min="10" value="10">
                            </div>
                            <div class="col-md-6">
                                <label for="fechaCaducidad" class="form-label">Fecha Caducidad</label>
                                <input type="date" class="form-control" id="fechaCaducidad" min="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="ubicacion" class="form-label">Ubicación</label>
                                <select class="form-select" id="ubicacion">
                                    <option value="">Seleccione una ubicación</option>
                                    <option value="bodega1">Bodega 1</option>
                                    <option value="bodega2">Bodega 2</option>
                                    <option value="bodega3">Bodega 3</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="proveedor" class="form-label">Proveedor</label>
                                <select class="form-select" id="proveedor">
                                    <option value="">Seleccione un proveedor</option>
                                    <option value="proveedor1">Proveedor 1</option>
                                    <option value="proveedor2">Proveedor 2</option>
                                    <option value="proveedor3">Proveedor 3</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" id="btnGuardarProducto">Guardar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Error -->
    <div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="errorModalLabel">Error</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p id="errorMessage"></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.7.0/jspdf.plugin.autotable.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../../js/productos.js"></script>
    <script src="/inventario/js/menu_alertas.js"></script>
</body>
</html> 