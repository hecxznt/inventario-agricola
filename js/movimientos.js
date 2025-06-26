$(document).ready(function() {
    // Cargar productos en el select
    cargarProductos();
    
    // Cargar movimientos
    cargarMovimientos();

    // Evento para guardar movimiento
    $('#btnGuardarMovimiento').click(function() {
        guardarMovimiento();
    });

    // Evento para buscar por fechas
    $('#btnBuscarFechas').click(function() {
        // Mostrar el botón de regresar inmediatamente al hacer clic en buscar
        $('#btnRegresar').show();
        cargarMovimientos();
    });

    // Manejar el botón de regresar
    $('#btnRegresar').on('click', function() {
        // Limpiar los campos de fecha y producto
        $('#fechaDesde').val('');
        $('#fechaHasta').val('');
        $('#buscarProducto').val('');
        productoSeleccionado = null;
        
        // Ocultar el botón de regresar
        $('#btnRegresar').hide();
        
        // Recargar la tabla con todos los movimientos
        cargarMovimientos();
    });

    // Evento para el campo de búsqueda de productos
    $('#buscarProducto').on('input', function() {
        buscarProductos($(this).val());
    });

    // Cerrar resultados al hacer clic fuera
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#buscarProducto, #resultadosBusqueda').length) {
            $('#resultadosBusqueda').hide();
        }
    });

    $('#btnExportarExcel').on('click', function() {
        var tabla = document.querySelector('.table');
        if (!tabla) {
            alert('No se encontró la tabla para exportar.');
            return;
        }
        var wb = XLSX.utils.table_to_book(tabla, {sheet: "Movimientos"});
        XLSX.writeFile(wb, 'datos.xlsx');
    });
    $('#btnExportarPDFMovimientos').off('click').on('click', function() {
        var tabla = document.querySelector('.table');
        if (!tabla) {
            alert('No se encontró la tabla para exportar.');
            return;
        }
        var doc = new window.jspdf.jsPDF();
        doc.autoTable({ html: tabla, theme: 'grid', headStyles: { fillColor: [220, 53, 69] } });
        doc.save('datos.pdf');
    });

    // Autocompletado de productos en el modal de nuevo movimiento
    $('#nuevoMovimientoModal').on('shown.bs.modal', function () {
        $('#inputProductoAutocomplete').val('').focus();
        $('#autocompleteResultados').hide();
    });

    // Crear input de autocompletado si no existe
    if ($('#inputProductoAutocomplete').length === 0) {
        $('#producto').parent().prepend('<input type="text" class="form-control mb-2" id="inputProductoAutocomplete" placeholder="Buscar producto..."><div id="autocompleteResultados" class="list-group position-absolute w-100" style="z-index: 2000; display: none;"></div>');
    }

    // Evento de autocompletado
    $(document).on('input', '#inputProductoAutocomplete', function() {
        const query = $(this).val();
        if (query.length < 1) {
            $('#autocompleteResultados').hide();
            return;
        }
        $.get('../../secciones/productos/buscar_autocomplete.php', {q: query}, function(data) {
            if (data.success && data.productos.length > 0) {
                let html = '';
                data.productos.forEach(function(prod) {
                    html += `<a href="#" class="list-group-item list-group-item-action" data-id="${prod.id_producto}" data-nombre="${prod.nombre}">${prod.nombre}</a>`;
                });
                $('#autocompleteResultados').html(html).show();
            } else {
                $('#autocompleteResultados').hide();
            }
        }, 'json');
    });

    // Selección de producto del autocompletado
    $(document).on('click', '#autocompleteResultados a', function(e) {
        e.preventDefault();
        const id = $(this).data('id');
        const nombre = $(this).data('nombre');
        $('#inputProductoAutocomplete').val(nombre);
        $('#id_producto').val(id);
        $('#autocompleteResultados').hide();
    });

    // Al abrir el modal, limpiar autocompletado
    $('#nuevoMovimientoModal').on('show.bs.modal', function () {
        $('#inputProductoAutocomplete').val('');
        $('#id_producto').val('');
        $('#autocompleteResultados').hide();
    });
});

// Variable para almacenar el producto seleccionado
let productoSeleccionado = null;

// Función para buscar productos
function buscarProductos(termino) {
    if (termino.length < 1) {
        $('#resultadosBusqueda').hide();
        return;
    }

    $.ajax({
        url: '../../secciones/productos/buscar_autocomplete.php',
        type: 'GET',
        data: { q: termino },
        success: function(response) {
            const resultadosDiv = $('#resultadosBusqueda .list-group');
            resultadosDiv.empty();

            if (response.success && response.productos.length > 0) {
                response.productos.forEach(function(producto) {
                    const item = $(`<li class="list-group-item list-group-item-action">${producto.nombre}</li>`);
                    item.click(function() {
                        seleccionarProducto(producto.id_producto, producto.nombre);
                    });
                    resultadosDiv.append(item);
                });
                $('#resultadosBusqueda').show();
            } else {
                $('#resultadosBusqueda').hide();
            }
        }
    });
}

// Función para seleccionar un producto
function seleccionarProducto(id, nombre) {
    productoSeleccionado = { id: id, nombre: nombre };
    $('#buscarProducto').val(nombre);
    $('#resultadosBusqueda').hide();
    cargarMovimientos(); // Recargar movimientos con el producto seleccionado
}

function mostrarCamposAdicionales() {
    const tipoMovimiento = $('#tipo_movimiento').val();
    
    // Ocultar todos los campos adicionales
    $('#camposEntrada, #camposSalida').hide();
    
    // Mostrar campos según el tipo de movimiento
    if (tipoMovimiento === 'entrada') {
        $('#camposEntrada').show();
        $('#proveedor, #monto').prop('required', true);
        $('#parcela, #trabajador').prop('required', false);
    } else if (tipoMovimiento === 'salida') {
        $('#camposSalida').show();
        $('#parcela, #trabajador').prop('required', true);
        $('#proveedor, #monto').prop('required', false);
    } else {
        $('#proveedor, #monto, #parcela, #trabajador').prop('required', false);
    }
}

function cargarProductos() {
    $.ajax({
        url: '../../secciones/productos/listar.php',
        type: 'GET',
        data: { selector: true },
        success: function(response) {
            if (response.success) {
                let options = '<option value="">Seleccione un producto</option>';
                response.productos.forEach(function(producto) {
                    options += `<option value="${producto.id_producto}">${producto.nombre}</option>`;
                });
                $('#producto').html(options);
            } else {
                alert('Error al cargar productos: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar productos:', error);
            console.error('Respuesta del servidor:', xhr.responseText);
            alert('Error al cargar productos');
        }
    });
}

function cargarMovimientos() {
    const fechaDesde = $('#fechaDesde').val();
    const fechaHasta = $('#fechaHasta').val();
    const idProducto = productoSeleccionado ? productoSeleccionado.id : null;

    $.ajax({
        url: '../../secciones/movimientos/obtener_historial.php',
        type: 'GET',
        data: {
            fecha_desde: fechaDesde,
            fecha_hasta: fechaHasta,
            id_producto: idProducto
        },
        success: function(response) {
            $('#historialMovimientos').html(response);
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar movimientos:', error);
            console.error('Respuesta del servidor:', xhr.responseText);
            alert('Error al cargar movimientos');
        }
    });
}

function guardarMovimiento() {
    const tipoMovimiento = $('#tipo_movimiento').val();
    const datos = {
        id_producto: $('#producto').val(),
        tipo_movimiento: tipoMovimiento,
        cantidad: $('#cantidad').val(),
        motivo: $('#motivo').val()
    };

    // Agregar campos adicionales según el tipo de movimiento
    if (tipoMovimiento === 'entrada') {
        datos.proveedor = $('#proveedor').val();
        datos.monto = $('#monto').val();
    } else if (tipoMovimiento === 'salida') {
        datos.parcela = $('#parcela').val();
        datos.trabajador = $('#trabajador').val();
    }

    // Validar campos requeridos
    if (!datos.id_producto || !datos.tipo_movimiento || !datos.cantidad || !datos.motivo) {
        alert('Por favor complete todos los campos requeridos');
        return;
    }

    // Validar campos adicionales según el tipo
    if (tipoMovimiento === 'entrada' && (!datos.proveedor || !datos.monto)) {
        alert('Por favor complete los campos de proveedor y monto');
        return;
    } else if (tipoMovimiento === 'salida' && (!datos.parcela || !datos.trabajador)) {
        alert('Por favor complete los campos de parcela y trabajador');
        return;
    }

    $.ajax({
        url: '../../secciones/movimientos/guardar.php',
        type: 'POST',
        data: datos,
        success: function(response) {
            if (response.success) {
                alert('Movimiento guardado correctamente');
                $('#nuevoMovimientoModal').modal('hide');
                $('#formNuevoMovimiento')[0].reset();
                // Limpiar los filtros de fecha
                $('#fechaDesde').val('');
                $('#fechaHasta').val('');
                // Ocultar campos adicionales
                $('#camposEntrada, #camposSalida').hide();
                // Recargar la tabla
                cargarMovimientos();
            } else {
                alert('Error al guardar movimiento: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al guardar movimiento:', error);
            console.error('Respuesta del servidor:', xhr.responseText);
            alert('Error al guardar movimiento');
        }
    });
}

function eliminarMovimiento(id_movimiento) {
    if (!confirm('¿Está seguro de eliminar este movimiento?')) {
        return;
    }

    $.ajax({
        url: '../../secciones/movimientos/eliminar.php',
        type: 'POST',
        data: { id_movimiento: id_movimiento },
        success: function(response) {
            if (response.success) {
                alert('Movimiento eliminado correctamente');
                cargarMovimientos();
            } else {
                alert('Error al eliminar movimiento: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al eliminar movimiento:', error);
            console.error('Respuesta del servidor:', xhr.responseText);
            alert('Error al eliminar movimiento');
        }
    });
}

// Función para cambiar de página en la paginación de movimientos
function cambiarPagina(pagina) {
    const fechaDesde = $('#fechaDesde').val();
    const fechaHasta = $('#fechaHasta').val();
    const idProducto = productoSeleccionado ? productoSeleccionado.id : null;

    $.ajax({
        url: '../../secciones/movimientos/obtener_historial.php',
        type: 'GET',
        data: {
            fecha_desde: fechaDesde,
            fecha_hasta: fechaHasta,
            id_producto: idProducto,
            pagina: pagina
        },
        success: function(response) {
            $('#historialMovimientos').html(response);
        },
        error: function(xhr, status, error) {
            alert('Error al cambiar de página');
        }
    });
}

window.cambiarPagina = cambiarPagina;
console.log('cambiarPagina global:', window.cambiarPagina); 