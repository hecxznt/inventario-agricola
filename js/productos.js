// Funcionalidad específica para la página de productos
$(document).ready(function() {
    // Manejar el envío del formulario de nuevo producto
    $('#btnGuardarProducto').on('click', function() {
        const form = $('#formNuevoProducto');
        
        // Validar el formulario
        if (form[0].checkValidity()) {
            // Recopilar datos del formulario
            const productoData = {
                id: $('#productoId').val(),
                nombre: $('#nombre').val(),
                categoria: $('#categoria').val(),
                presentacion: $('#presentacion').val(),
                cantidad: $('#cantidad').val(),
                stockMinimo: $('#stockMinimo').val(),
                fechaCaducidad: $('#fechaCaducidad').val(),
                ubicacion: $('#ubicacion').val(),
                proveedor: $('#proveedor').val()
            };

            // Enviar datos al servidor
            guardarProducto(productoData);
        } else {
            // Mostrar errores de validación
            form[0].reportValidity();
        }
    });

    // Limpiar el formulario cuando se cierra el modal
    $('#nuevoProductoModal').on('hidden.bs.modal', function () {
        $('#formNuevoProducto')[0].reset();
        $('#productoId').val('');
        $('#nuevoProductoModalLabel').text('Nuevo Producto');
        $('#btnGuardarProducto').text('Guardar');
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
        buscarProductos(criteriosBusqueda);
    });
});

// Función para guardar un nuevo producto
function guardarProducto(productoData) {
    $.ajax({
        url: '../../secciones/productos/guardar.php',
        method: 'POST',
        data: productoData,
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Cerrar el modal
                $('#nuevoProductoModal').modal('hide');
                
                // Limpiar el formulario
                $('#formNuevoProducto')[0].reset();
                
                // Mostrar mensaje de éxito
                alert(response.message);
                
                // Recargar la tabla de productos
                cargarProductos();
            } else {
                alert(response.message || 'Error al guardar el producto');
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al guardar el producto:', error);
            let mensaje = 'Error al guardar el producto';
            try {
                const response = JSON.parse(xhr.responseText);
                mensaje = response.message || mensaje;
            } catch(e) {}
            alert(mensaje);
        }
    });
}

// Función para buscar productos
function buscarProductos(criterios) {
    $.ajax({
        url: '../../secciones/productos/buscar.php',
        method: 'POST',
        data: criterios,
        success: function(response) {
            // Actualizar la tabla con los resultados
            $('.table-responsive').html(response);
        },
        error: function(xhr, status, error) {
            console.error('Error en la búsqueda:', error);
            console.error('Respuesta del servidor:', xhr.responseText);
            alert('Error al realizar la búsqueda. Por favor, intente nuevamente.');
        }
    });
}

// Función para editar producto
function editarProducto(id) {
    $.ajax({
        url: '../../secciones/productos/obtener.php',
        method: 'GET',
        data: { id: id },
        dataType: 'json',
        success: function(response) {
            // Cambiar el título del modal
            $('#nuevoProductoModalLabel').text('Editar Producto');
            $('#btnGuardarProducto').text('Actualizar');
            
            // Llenar el formulario con los datos del producto
            $('#productoId').val(response.id_producto);
            $('#nombre').val(response.nombre);
            $('#categoria').val(response.categoria);
            $('#presentacion').val(response.presentacion);
            $('#cantidad').val(response.cantidad);
            $('#stockMinimo').val(response.stock_minimo);
            $('#fechaCaducidad').val(response.fecha_caducidad);
            $('#ubicacion').val(response.ubicacion);
            $('#proveedor').val(response.proveedor);
            
            // Mostrar el modal
            $('#nuevoProductoModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error('Error al obtener el producto:', error);
            console.error('Respuesta del servidor:', xhr.responseText);
            alert('Error al cargar los datos del producto');
        }
    });
}

// Función para cambiar estado del producto
function cambiarEstado(id) {
    console.log('ID del producto:', id);
    
    $.ajax({
        url: '../../secciones/productos/cambiar_estado.php',
        type: 'POST',
        data: {
            id: id
        },
        dataType: 'json',
        success: function(response) {
            console.log('Respuesta del servidor:', response);
            if (response.success) {
                // Recargar la tabla de productos
                cargarProductos();
                // Mostrar mensaje de éxito
                alert(response.message);
            } else {
                alert('Error: ' + response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error al cambiar el estado:', error);
            console.error('Respuesta del servidor:', xhr.responseText);
            alert('Error al cambiar el estado del producto');
        }
    });
}

// Función para cargar todos los productos
function cargarProductos() {
    $.ajax({
        url: '../../secciones/productos/listar.php',
        method: 'GET',
        success: function(response) {
            $('.table-responsive').html(response);
        },
        error: function(xhr, status, error) {
            console.error('Error al cargar los productos:', error);
            console.error('Respuesta del servidor:', xhr.responseText);
            alert('Error al cargar los productos. Por favor, recargue la página.');
        }
    });
} 