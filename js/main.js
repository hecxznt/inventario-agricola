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

    // Manejar el envío del formulario de nuevo producto
    $('#btnGuardarProducto').on('click', function() {
        const form = $('#formNuevoProducto');
        
        // Validar el formulario
        if (form[0].checkValidity()) {
            // Recopilar datos del formulario
            const productoData = {
                nombre: $('#nombre').val(),
                categoria: $('#categoria').val(),
                presentacion: $('#presentacion').val(),
                stockMinimo: $('#stockMinimo').val(),
                fechaCaducidad: $('#fechaCaducidad').val(),
                ubicacion: $('#ubicacion').val(),
                proveedor: $('#proveedor').val()
            };

            // Aquí puedes agregar la lógica para enviar los datos al servidor
            console.log('Datos del producto:', productoData);
            
            // Cerrar el modal
            $('#nuevoProductoModal').modal('hide');
            
            // Limpiar el formulario
            form[0].reset();
            
            // Mostrar mensaje de éxito
            alert('Producto guardado exitosamente');
        } else {
            // Mostrar errores de validación
            form[0].reportValidity();
        }
    });

    // Limpiar el formulario cuando se cierra el modal
    $('#nuevoProductoModal').on('hidden.bs.modal', function () {
        $('#formNuevoProducto')[0].reset();
    });

    // Manejar la búsqueda
    $('#btnBuscar').on('click', function() {
        const nombre = $('#buscarNombre').val();
        const categoria = $('#buscarCategoria').val();
        const lugar = $('#buscarLugar').val();

        // Crear objeto con los criterios de búsqueda
        const criteriosBusqueda = {
            nombre: nombre,
            categoria: categoria,
            lugar: lugar
        };

        // Realizar la búsqueda
        realizarBusqueda(criteriosBusqueda);
    });

    // Función para realizar la búsqueda
    function realizarBusqueda(criterios) {
        $.ajax({
            url: 'php/buscar_productos.php',
            method: 'POST',
            data: criterios,
            success: function(response) {
                // Mostrar los resultados en la tabla
                $('.content').html(response);
            },
            error: function(xhr, status, error) {
                console.error('Error en la búsqueda:', error);
                $('.content').html('<div class="alert alert-danger">Error al realizar la búsqueda</div>');
            }
        });
    }
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