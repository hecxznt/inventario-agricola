$(document).ready(function() {
    // Cargar todas las alertas al iniciar la página
    cargarStockBajo();
    cargarProductosCaducidad();
    cargarMovimientosRecientes();
});

function actualizarAlertas() {
    cargarStockBajo();
    cargarProductosCaducidad();
    cargarMovimientosRecientes();
}

function cargarStockBajo() {
    $.ajax({
        url: '../../secciones/alertas/obtener_stock_bajo.php',
        type: 'GET',
        success: function(response) {
            $('#tablaStockBajo').html(response);
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar stock bajo:', error);
            $('#tablaStockBajo').html('<tr><td colspan="5" class="text-center text-danger">Error al cargar los datos</td></tr>');
        }
    });
}

function cargarProductosCaducidad() {
    $.ajax({
        url: '../../secciones/alertas/obtener_caducidad.php',
        type: 'GET',
        success: function(response) {
            $('#tablaCaducidad').html(response);
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar productos próximos a caducar:', error);
            $('#tablaCaducidad').html('<tr><td colspan="4" class="text-center text-danger">Error al cargar los datos</td></tr>');
        }
    });
}

function cargarMovimientosRecientes() {
    $.ajax({
        url: '../../secciones/alertas/obtener_movimientos_recientes.php',
        type: 'GET',
        success: function(response) {
            $('#tablaMovimientos').html(response);
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar movimientos recientes:', error);
            $('#tablaMovimientos').html('<tr><td colspan="5" class="text-center text-danger">Error al cargar los datos</td></tr>');
        }
    });
} 