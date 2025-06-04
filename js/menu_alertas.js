function verificarAlertas() {
    $.ajax({
        url: '../../secciones/alertas/verificar_alertas.php',
        type: 'GET',
        success: function(response) {
            const alertas = JSON.parse(response);
            const indicador = $('#indicadorAlertas');
            
            if (alertas.total > 0) {
                indicador.html(`
                    <i class="bi bi-exclamation-triangle-fill text-warning"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                        ${alertas.total}
                    </span>
                `).show();
            } else {
                indicador.hide();
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al verificar alertas:', error);
        }
    });
}

// Verificar alertas cada 5 minutos
$(document).ready(function() {
    verificarAlertas();
    setInterval(verificarAlertas, 300000); // 5 minutos
}); 