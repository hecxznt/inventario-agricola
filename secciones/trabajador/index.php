<?php
// Página de inicio para la sección Trabajador
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trabajador - Sistema de Inventario</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/inventario/css/styles.css?v=1.0">
</head>
<body>
    <?php include '../../php/navbar.php'; ?>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include '../includes/sidebar.php'; ?>
            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h2">Sección Trabajador</h1>
                </div>
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <p>Bienvenido a la sección de gestión de trabajadores.</p>
                                <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#modalNuevoTrabajador">
                                    <i class="bi bi-person-plus"></i> Añadir Trabajador
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Botones de exportar en el dashboard de trabajadores -->
                <div class="mb-3">
                    <button id="btnExportarExcelTrabajadores" class="btn btn-success">
                        <i class="bi bi-file-earmark-excel"></i> Excel
                    </button>
                    <button id="btnExportarPDFTrabajadores" class="btn btn-danger">
                        <i class="bi bi-file-earmark-pdf"></i> PDF
                    </button>
                </div>
                <!-- Controles de paginación -->
                <div class="d-flex justify-content-center my-3">
                    <nav>
                        <ul class="pagination" id="paginacionTrabajadores"></ul>
                    </nav>
                </div>
                <!-- Tabla de trabajadores -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Nombre Completo</th>
                                                <th>Cargo</th>
                                                <th>Salario por Día</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tbodyTrabajadores">
                                            <!-- Aquí se cargarán los trabajadores desde la base de datos -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Modal Nuevo Trabajador -->
                <div class="modal fade" id="modalNuevoTrabajador" tabindex="-1" aria-labelledby="modalNuevoTrabajadorLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalNuevoTrabajadorLabel">Nuevo Trabajador</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                            </div>
                            <div class="modal-body">
                                <form id="formNuevoTrabajador" enctype="multipart/form-data">
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="id_trabajador" class="form-label">ID Trabajador</label>
                                            <input type="text" class="form-control" id="id_trabajador" name="id_trabajador" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="nombre" class="form-label">Nombre</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="apellido_paterno" class="form-label">Apellido Paterno</label>
                                            <input type="text" class="form-control" id="apellido_paterno" name="apellido_paterno" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="apellido_materno" class="form-label">Apellido Materno</label>
                                            <input type="text" class="form-control" id="apellido_materno" name="apellido_materno">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="genero" class="form-label">Género</label>
                                            <select class="form-select" id="genero" name="genero" required>
                                                <option value="">Selecciona</option>
                                                <option value="Masculino">Masculino</option>
                                                <option value="Femenino">Femenino</option>
                                                <option value="Otro">Otro</option>
                                            </select>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="foto" class="form-label">Foto</label>
                                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="nss" class="form-label">NSS</label>
                                            <input type="text" class="form-control" id="nss" name="nss">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="curp" class="form-label">CURP</label>
                                            <input type="text" class="form-control" id="curp" name="curp">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="calleynum" class="form-label">Calle y Número</label>
                                            <input type="text" class="form-control" id="calleynum" name="calleynum">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="colonia" class="form-label">Colonia</label>
                                            <input type="text" class="form-control" id="colonia" name="colonia">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="municipio" class="form-label">Municipio</label>
                                            <input type="text" class="form-control" id="municipio" name="municipio">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="estado" class="form-label">Estado</label>
                                            <input type="text" class="form-control" id="estado" name="estado">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="cp" class="form-label">Código Postal</label>
                                            <input type="text" class="form-control" id="cp" name="cp">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-4">
                                            <label for="tel" class="form-label">Teléfono</label>
                                            <input type="number" class="form-control" id="tel" name="tel" min="0" pattern="[0-9]+" oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email" name="email">
                                        </div>
                                        <div class="col-md-4">
                                            <label for="cargo" class="form-label">Cargo</label>
                                            <select class="form-select" id="cargo" name="cargo" required>
                                                <option value="">Selecciona un cargo</option>
                                                <option value="jornalero">Jornalero</option>
                                                <option value="capataz">Capataz</option>
                                                <option value="vigilante">Vigilante</option>
                                                <option value="supervisor">Supervisor</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
                                            <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="fecha_registro" class="form-label">Fecha de Registro</label>
                                            <input type="date" class="form-control" id="fecha_registro" name="fecha_registro">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="salario_diario" class="form-label">Salario por Día</label>
                                            <input type="number" class="form-control" id="salario_diario" name="salario_diario" min="0" step="0.01">
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-primary">Guardar</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/xlsx@0.18.5/dist/xlsx.full.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.7.0/jspdf.plugin.autotable.min.js"></script>
    <script>
    let modoEdicion = false;
    let idTrabajadorEditando = null;
    let paginaActual = 1;
    let totalPaginas = 1;
    const LIMITE_POR_PAGINA = 10;

    document.addEventListener('DOMContentLoaded', function() {
        cargarTrabajadores();

        // Envío del formulario de nuevo trabajador o edición
        document.getElementById('formNuevoTrabajador').addEventListener('submit', function(e) {
            e.preventDefault();
            const form = e.target;
            const formData = new FormData(form);
            let url = '../../secciones/trabajador/guardar_trabajador.php';
            if (modoEdicion && idTrabajadorEditando) {
                formData.append('id_trabajador', idTrabajadorEditando);
                url = '../../secciones/trabajador/actualizar_trabajador.php';
            }
            fetch(url, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Cerrar modal y recargar tabla
                    const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalNuevoTrabajador'));
                    modal.hide();
                    form.reset();
                    cargarTrabajadores();
                    modoEdicion = false;
                    idTrabajadorEditando = null;
                    document.getElementById('id_trabajador').removeAttribute('readonly');
                    document.getElementById('modalNuevoTrabajadorLabel').textContent = 'Nuevo Trabajador';
                } else {
                    alert(data.message || 'Error al guardar trabajador');
                }
            })
            .catch(() => {
                alert('Error al guardar trabajador');
            });
        });

        // Delegación para el botón de editar
        document.getElementById('tbodyTrabajadores').addEventListener('click', function(e) {
            if (e.target.closest('.btn-editar')) {
                const btn = e.target.closest('.btn-editar');
                const trabajador = JSON.parse(btn.dataset.trabajador);
                llenarFormularioEdicion(trabajador);
            } else if (e.target.closest('.btn-estado')) {
                const btn = e.target.closest('.btn-estado');
                const id = btn.dataset.id;
                const estadoActual = btn.dataset.estado;
                cambiarEstadoTrabajador(id, estadoActual);
            }
        });

        function cargarTrabajadores(pagina = 1) {
            fetch(`../../secciones/trabajador/obtener_trabajadores.php?pagina=${pagina}&limite=${LIMITE_POR_PAGINA}`)
                .then(response => response.json())
                .then(data => {
                    const tbody = document.getElementById('tbodyTrabajadores');
                    tbody.innerHTML = '';
                    if (data.success && data.trabajadores.length > 0) {
                        data.trabajadores.forEach(trabajador => {
                            const fila = document.createElement('tr');
                            fila.innerHTML = `
                                <td>${trabajador.nombre} ${trabajador.apellido_paterno} ${trabajador.apellido_materno}</td>
                                <td>${trabajador.cargo}</td>
                                <td>$${parseFloat(trabajador.salario_diario).toFixed(2)}</td>
                                <td><span class="badge bg-${trabajador.activo == 1 ? 'success' : 'danger'}">${trabajador.activo == 1 ? 'Activo' : 'Deshabilitado'}</span></td>
                                <td>
                                    <button class="btn btn-sm btn-primary btn-editar" title="Editar" data-trabajador='${JSON.stringify(trabajador)}'>
                                        <i class="bi bi-pencil"></i>
                                    </button>
                                    <button class="btn btn-sm ${trabajador.activo == 1 ? 'btn-success' : 'btn-secondary'} btn-estado" title="${trabajador.activo == 1 ? 'Deshabilitar' : 'Habilitar'}" data-id="${trabajador.id_trabajador}" data-estado="${trabajador.activo}">
                                        <i class="bi ${trabajador.activo == 1 ? 'bi-eye' : 'bi-eye-slash'}"></i>
                                    </button>
                                </td>
                            `;
                            tbody.appendChild(fila);
                        });
                    } else {
                        tbody.innerHTML = '<tr><td colspan="4" class="text-center">No hay trabajadores registrados</td></tr>';
                    }
                    // Actualizar paginación
                    paginaActual = data.pagina_actual;
                    totalPaginas = data.total_paginas;
                    renderizarPaginacion();
                })
                .catch(err => {
                    document.getElementById('tbodyTrabajadores').innerHTML = '<tr><td colspan="4" class="text-center text-danger">Error al cargar los trabajadores</td></tr>';
                });
        }

        function renderizarPaginacion() {
            const paginacion = document.getElementById('paginacionTrabajadores');
            paginacion.innerHTML = '';
            if (totalPaginas <= 1) return;
            // Botón anterior
            paginacion.innerHTML += `<li class="page-item${paginaActual === 1 ? ' disabled' : ''}"><a class="page-link" href="#" data-pagina="${paginaActual - 1}">Anterior</a></li>`;
            // Números de página
            for (let i = 1; i <= totalPaginas; i++) {
                paginacion.innerHTML += `<li class="page-item${i === paginaActual ? ' active' : ''}"><a class="page-link" href="#" data-pagina="${i}">${i}</a></li>`;
            }
            // Botón siguiente
            paginacion.innerHTML += `<li class="page-item${paginaActual === totalPaginas ? ' disabled' : ''}"><a class="page-link" href="#" data-pagina="${paginaActual + 1}">Siguiente</a></li>`;
            // Eventos
            paginacion.querySelectorAll('a.page-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();
                    const pagina = parseInt(this.dataset.pagina);
                    if (!isNaN(pagina) && pagina >= 1 && pagina <= totalPaginas && pagina !== paginaActual) {
                        cargarTrabajadores(pagina);
                    }
                });
            });
        }

        function llenarFormularioEdicion(trabajador) {
            modoEdicion = true;
            idTrabajadorEditando = trabajador.id_trabajador;
            document.getElementById('modalNuevoTrabajadorLabel').textContent = 'Editar Trabajador';
            const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalNuevoTrabajador'));
            modal.show();
            document.getElementById('id_trabajador').value = trabajador.id_trabajador;
            document.getElementById('id_trabajador').setAttribute('readonly', 'readonly');
            document.getElementById('nombre').value = trabajador.nombre;
            document.getElementById('apellido_paterno').value = trabajador.apellido_paterno;
            document.getElementById('apellido_materno').value = trabajador.apellido_materno;
            document.getElementById('genero').value = trabajador.genero;
            document.getElementById('fecha_nacimiento').value = trabajador.fecha_nacimiento;
            document.getElementById('nss').value = trabajador.nss;
            document.getElementById('curp').value = trabajador.curp;
            document.getElementById('calleynum').value = trabajador.calleynum;
            document.getElementById('colonia').value = trabajador.colonia;
            document.getElementById('municipio').value = trabajador.municipio;
            document.getElementById('estado').value = trabajador.estado;
            document.getElementById('cp').value = trabajador.cp;
            document.getElementById('tel').value = trabajador.tel;
            document.getElementById('email').value = trabajador.email;
            document.getElementById('cargo').value = trabajador.cargo;
            document.getElementById('fecha_ingreso').value = trabajador.fecha_ingreso;
            document.getElementById('fecha_registro').value = trabajador.fecha_registro;
            document.getElementById('salario_diario').value = trabajador.salario_diario;
        }

        function cambiarEstadoTrabajador(id, estadoActual) {
            fetch('../../secciones/trabajador/cambiar_estado.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: `id_trabajador=${encodeURIComponent(id)}&estado=${estadoActual == 1 ? 0 : 1}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    cargarTrabajadores(paginaActual);
                } else {
                    alert(data.message || 'Error al cambiar el estado');
                }
            })
            .catch(() => {
                alert('Error al cambiar el estado');
            });
        }

        // Funcionalidad de exportar Excel y PDF para trabajadores
        document.getElementById('btnExportarExcelTrabajadores').addEventListener('click', function() {
            var tabla = document.querySelector('.table');
            if (!tabla) {
                alert('No se encontró la tabla para exportar.');
                return;
            }
            var wb = XLSX.utils.table_to_book(tabla, {sheet: "Trabajadores"});
            XLSX.writeFile(wb, 'trabajadores.xlsx');
        });
        document.getElementById('btnExportarPDFTrabajadores').addEventListener('click', function() {
            var tabla = document.querySelector('.table');
            if (!tabla) {
                alert('No se encontró la tabla para exportar.');
                return;
            }
            var doc = new window.jspdf.jsPDF();
            doc.autoTable({ html: tabla, theme: 'grid', headStyles: { fillColor: [25, 135, 84] } });
            doc.save('trabajadores.pdf');
        });
    });
    </script>
</body>
</html> 