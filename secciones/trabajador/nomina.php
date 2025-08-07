<?php
// Página específica para la gestión de nóminas
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Nómina - Sistema de Inventario</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="/inventario/css/styles.css?v=1.0">
    <style>
    /* Estilos para la tabla de nómina en pantalla completa */
    #tabla-nomina th, #tabla-nomina td {
        padding: 0.5rem 0.3rem !important;
        font-size: 0.95rem;
        text-align: center;
        vertical-align: middle;
    }
    #tabla-nomina input[type="number"] {
        width: 80px;
        padding: 0.25rem 0.5rem;
        font-size: 0.95rem;
        text-align: right;
        margin: 0 auto;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }
    #tabla-nomina input[type="number"]:focus {
        border-color: #86b7fe;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
    }
    #tabla-nomina {
        width: 100%;
        margin: 0;
    }
    .table-responsive {
        border-radius: 0.375rem;
        overflow: hidden;
    }
    .btn-guardar-nomina {
        min-width: 80px;
    }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <?php include '../includes/sidebar.php'; ?>
            <!-- Main content -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h2">Gestión de Nómina</h1>
                </div>
                
                <!-- Cuadro de nómina semanal -->
                <div class="card mb-3">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-cash-coin"></i> Nómina Semanal</h5>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="semana">Selecciona un día de la semana:</label>
                                <input type="date" id="semana" class="form-control">
                            </div>
                            <div class="col-md-4" id="rango-semana" style="padding-top: 2.2em; min-height: 1.5em;">
                                <!-- Aquí se mostrará el rango de la semana -->
                            </div>
                            <div class="col-md-4" style="padding-top: 2.2em;">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="incluirDomingo">
                                    <label class="form-check-label" for="incluirDomingo">
                                        Agregar domingo
                                    </label>
                                </div>
                            </div>
                        </div>
                        <!-- Tabla de nómina -->
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped" id="tabla-nomina">
                                <thead class="table-dark">
                                    <tr>
                                        <th style="min-width: 200px;">Trabajador</th>
                                        <th>Lun</th>
                                        <th>Mar</th>
                                        <th>Mié</th>
                                        <th>Jue</th>
                                        <th>Vie</th>
                                        <th>Sáb</th>
                                        <th class="columna-domingo" style="display: none;">Dom</th>
                                        <th>Total</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Aquí se insertarán las filas dinámicamente -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    
    <!-- Scripts de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    // Calcula el lunes, sábado y domingo de la semana seleccionada
    function getWeekRange(dateStr) {
        const date = new Date(dateStr);
        const day = date.getDay(); // 0=domingo, 1=lunes, ..., 6=sábado
        // Si es domingo, retrocede 6 días para llegar al lunes anterior
        const monday = new Date(date);
        monday.setDate(date.getDate() - ((day === 0 ? 7 : day) - 1));
        const saturday = new Date(monday);
        saturday.setDate(monday.getDate() + 5);
        const sunday = new Date(monday);
        sunday.setDate(monday.getDate() + 6);
        return {
            monday: monday,
            saturday: saturday,
            sunday: sunday
        };
    }

    function formatDate(date) {
        return date.toLocaleDateString('es-MX', { day: '2-digit', month: 'short' });
    }

    document.getElementById('semana').addEventListener('change', function() {
        const val = this.value;
        if (val) {
            const rango = getWeekRange(val);
            const incluirDomingo = document.getElementById('incluirDomingo').checked;
            const fechaFin = incluirDomingo ? rango.sunday : rango.saturday;
            document.getElementById('rango-semana').innerText =
                `Semana del ${formatDate(rango.monday)} al ${formatDate(fechaFin)}`;
        } else {
            document.getElementById('rango-semana').innerText = '';
        }
    });

    // Evento para el checkbox de incluir domingo
    document.getElementById('incluirDomingo').addEventListener('change', function() {
        const incluirDomingo = this.checked;
        const columnasDomingo = document.querySelectorAll('.columna-domingo');
        
        columnasDomingo.forEach(columna => {
            columna.style.display = incluirDomingo ? 'table-cell' : 'none';
        });

        // Actualizar el rango de la semana si hay una fecha seleccionada
        const semanaInput = document.getElementById('semana');
        if (semanaInput.value) {
            semanaInput.dispatchEvent(new Event('change'));
        }

        // Recalcular totales
        recalcularTodosLosTotales();
    });

    // Cargar trabajadores activos y generar la tabla de nómina
    document.addEventListener('DOMContentLoaded', function() {
        fetch('obtener_trabajadores_activos.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const tbody = document.querySelector('#tabla-nomina tbody');
                    tbody.innerHTML = '';
                    data.trabajadores.forEach(trabajador => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td class="nombre-trabajador" data-id="${trabajador.id_trabajador}">${trabajador.nombre_completo}</td>
                            <td><input type="number" min="0" class="form-control monto-dia" data-dia="0"></td>
                            <td><input type="number" min="0" class="form-control monto-dia" data-dia="1"></td>
                            <td><input type="number" min="0" class="form-control monto-dia" data-dia="2"></td>
                            <td><input type="number" min="0" class="form-control monto-dia" data-dia="3"></td>
                            <td><input type="number" min="0" class="form-control monto-dia" data-dia="4"></td>
                            <td><input type="number" min="0" class="form-control monto-dia" data-dia="5"></td>
                            <td class="columna-domingo" style="display: none;"><input type="number" min="0" class="form-control monto-dia" data-dia="6"></td>
                            <td class="total-semana">$0.00</td>
                            <td><button class="btn btn-success btn-sm btn-guardar-nomina guardar-nomina">Guardar</button></td>
                        `;
                        tbody.appendChild(tr);
                    });
                    agregarEventosNomina();
                } else {
                    alert('No se pudieron cargar los trabajadores activos');
                }
            });

        function agregarEventosNomina() {
            // Calcular total por fila
            document.querySelectorAll('#tabla-nomina tbody tr').forEach(tr => {
                tr.querySelectorAll('.monto-dia').forEach(input => {
                    input.addEventListener('input', function() {
                        recalcularTotalFila(tr);
                    });
                });
                // Guardar nómina individual
                tr.querySelector('.guardar-nomina').addEventListener('click', function() {
                    const id_trabajador = tr.querySelector('.nombre-trabajador').dataset.id;
                    const nombre = tr.querySelector('.nombre-trabajador').innerText;
                    const semana = document.getElementById('semana').value;
                    if (!semana) {
                        alert('Selecciona una fecha de la semana.');
                        return;
                    }
                                    const montos = [];
                const incluirDomingo = document.getElementById('incluirDomingo').checked;
                
                tr.querySelectorAll('.monto-dia').forEach((inp, index) => {
                    // Solo incluir domingo si está habilitado
                    if (index < 6 || (index === 6 && incluirDomingo)) {
                        montos.push(parseFloat(inp.value) || 0);
                    }
                });
                
                const total = montos.reduce((a, b) => a + b, 0);
                const rango = getWeekRange(semana);
                    // Guardar en la base de datos
                    fetch('guardar_nomina_trabajador.php', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                            body: new URLSearchParams({
                        id_trabajador: id_trabajador,
                        semana_inicio: rango.monday.toISOString().slice(0,10),
                        semana_fin: incluirDomingo ? rango.sunday.toISOString().slice(0,10) : rango.saturday.toISOString().slice(0,10),
                        montos: JSON.stringify(montos)
                    })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Nómina guardada correctamente para ' + nombre);
                        } else {
                            alert('Error: ' + (data.message || 'No se pudo guardar la nómina.'));
                        }
                    })
                    .catch(() => {
                        alert('Error al guardar la nómina.');
                    });
                });
            });
        }

        // Función para recalcular el total de una fila específica
        function recalcularTotalFila(tr) {
            let total = 0;
            const incluirDomingo = document.getElementById('incluirDomingo').checked;
            
            tr.querySelectorAll('.monto-dia').forEach((inp, index) => {
                // Solo incluir domingo si está habilitado
                if (index < 6 || (index === 6 && incluirDomingo)) {
                    total += parseFloat(inp.value) || 0;
                }
            });
            
            tr.querySelector('.total-semana').innerText = `$${total.toFixed(2)}`;
        }

        // Función para recalcular todos los totales
        function recalcularTodosLosTotales() {
            document.querySelectorAll('#tabla-nomina tbody tr').forEach(tr => {
                recalcularTotalFila(tr);
            });
        }
    });
    </script>
</body>
</html> 