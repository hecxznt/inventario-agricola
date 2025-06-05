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
        // Limpiar los campos de fecha
        $('#fechaDesde').val('');
        $('#fechaHasta').val('');
        
        // Ocultar el botón de regresar
        $('#btnRegresar').hide();
        
        // Recargar la tabla con todos los movimientos
        cargarMovimientos();
    });
});

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

    $.ajax({
        url: '../../secciones/movimientos/obtener_historial.php',
        type: 'GET',
        data: {
            fecha_desde: fechaDesde,
            fecha_hasta: fechaHasta
        },
        success: function(response) {
            $('tbody').html(response);
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