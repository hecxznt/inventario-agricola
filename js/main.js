// Esperar a que el documento esté listo
$(document).ready(function() {
    // Inicializar tooltips de Bootstrap
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Manejar la navegación del sidebar
    $('.nav-link').on('click', function(e) {
        e.preventDefault();
        $('.nav-link').removeClass('active');
        $(this).addClass('active');
        
        // Aquí puedes agregar la lógica para cargar el contenido dinámicamente
        const page = $(this).attr('href').substring(1);
        loadContent(page);
    });
});

// Función para cargar contenido dinámicamente
function loadContent(page) {
    $.ajax({
        url: 'php/' + page + '.php',
        method: 'GET',
        success: function(response) {
            $('.content').html(response);
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar el contenido:', error);
            $('.content').html('<div class="alert alert-danger">Error al cargar el contenido</div>');
        }
    });
} 