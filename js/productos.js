// Funcionalidad específica para la página de productos
$(document).ready(function() {
    // Manejar el envío del formulario de nuevo producto
    $('#btnGuardarProducto').on('click', function() {
        const form = $('#formNuevoProducto');
        
        // Validar el formulario
        if (form[0].checkValidity()) {
            // Validar stock mínimo
            const stockMinimo = parseInt($('#stockMinimo').val());
            if (stockMinimo < 10) {
                mostrarAlerta('El stock mínimo debe ser de 10 unidades o más', 'danger');
                return;
            }

            // Validar cantidad
            const cantidad = parseInt($('#cantidad').val());
            if (cantidad < 10) {
                mostrarAlerta('La cantidad debe ser de 10 unidades o más', 'danger');
                return;
            }

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

            // Validar fecha de caducidad
            let fechaCaducidad = productoData.fechaCaducidad;
            if (fechaCaducidad) {
                let fechaActual = new Date();
                let fechaSeleccionada = new Date(fechaCaducidad);
                if (fechaSeleccionada < fechaActual) {
                    mostrarAlerta('La fecha de caducidad no puede ser anterior a la fecha actual', 'danger');
                    return;
                }
            }

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

    actualizarTabla();
    
    // Actualizar tabla cada 30 segundos
    setInterval(actualizarTabla, 30000);
});

// Función para guardar un nuevo producto
function guardarProducto(productoData) {
    $.ajax({
        url: '../../secciones/productos/guardar.php',
        method: 'POST',
        data: productoData,
        dataType: 'json',
        success: function(response) {
            console.log('Respuesta del servidor:', response);
            
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
                // Mostrar mensaje de error
                alert(response.message || 'Error al guardar el producto');
            }
        },
        error: function(xhr, status, error) {
            console.log('Error completo:', xhr.responseText);
            let mensaje = 'Error al guardar el producto';
            
            try {
                const response = JSON.parse(xhr.responseText);
                if (response && response.message) {
                    mensaje = response.message;
                }
            } catch(e) {
                console.error('Error al parsear la respuesta:', e);
            }
            
            alert(mensaje);
        }
    });
}

// Función para mostrar alertas
function mostrarAlerta(mensaje, tipo) {
    if (tipo === 'danger') {
        // Mostrar error en el modal
        $('#errorMessage').text(mensaje);
        $('#errorMessage').show();
    } else {
        // Mostrar alerta en la página
        const alerta = `
            <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
                ${mensaje}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        $('#alertasContainer').html(alerta);
    }
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
        type: 'GET',
        data: { id: id },
        success: function(producto) {
            $('#productoId').val(producto.id_producto);
            $('#nombre').val(producto.nombre);
            $('#categoria').val(producto.categoria);
            $('#presentacion').val(producto.presentacion);
            $('#cantidad').val(producto.cantidad);
            $('#stockMinimo').val(producto.stock_minimo);
            $('#fechaCaducidad').val(producto.fecha_caducidad);
            $('#ubicacion').val(producto.ubicacion);
            $('#proveedor').val(producto.proveedor);
            
            // Cambiar el título del modal
            $('#nuevoProductoModalLabel').text('Editar Producto');
            
            // Mostrar el modal
            $('#nuevoProductoModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error('Error al obtener el producto:', error);
            alert('Error al cargar el producto');
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

function actualizarTabla() {
    $.ajax({
        url: '../../secciones/productos/listar.php',
        type: 'GET',
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
// Funcionalidad específica para la página de productos
$(document).ready(function() {
    console.log('productos.js cargado');
    // Manejar el envío del formulario de nuevo producto
    $('#btnGuardarProducto').off('click').on('click', function() {
        const form = $('#formNuevoProducto');
        
        // Validar el formulario
        if (form[0].checkValidity()) {
            // Validar stock mínimo
            const stockMinimo = parseInt($('#stockMinimo').val());
            if (stockMinimo < 10) {
                mostrarAlerta('El stock mínimo debe ser de 10 unidades o más', 'danger');
                return;
            }

            // Validar cantidad
            const cantidad = parseInt($('#cantidad').val());
            if (cantidad < 10) {
                mostrarAlerta('La cantidad debe ser de 10 unidades o más', 'danger');
                return;
            }

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

            // Validar fecha de caducidad
            let fechaCaducidad = productoData.fechaCaducidad;
            if (fechaCaducidad) {
                let fechaActual = new Date();
                let fechaSeleccionada = new Date(fechaCaducidad);
                if (fechaSeleccionada < fechaActual) {
                    mostrarAlerta('La fecha de caducidad no puede ser anterior a la fecha actual', 'danger');
                    return;
                }
            }

            // Agregar precio solo si es insumo
            if (productoData.categoria === 'insumos') {
                const precio = $('#precio').val();
                if (!precio || precio <= 0) {
                    mostrarAlerta('El precio es obligatorio para insumos y debe ser mayor a 0', 'danger');
                    return;
                }
                productoData.precio = precio;
            }

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
        realizarBusqueda();
    });

    // Búsqueda al presionar Enter en los campos de búsqueda
    $('#buscarNombre, #buscarCategoria, #buscarLugar').on('keypress', function(e) {
        if (e.which === 13) { // Tecla Enter
            realizarBusqueda();
        }
    });

    // Botón limpiar búsqueda
    $('#btnLimpiar').on('click', function() {
        $('#buscarNombre').val('');
        $('#buscarCategoria').val('');
        $('#buscarLugar').val('');
        location.reload(); // Recargar la página para mostrar todos los productos
    });

    // Función para realizar la búsqueda
    function realizarBusqueda() {
        const nombre = $('#buscarNombre').val().trim();
        const categoria = $('#buscarCategoria').val();
        const lugar = $('#buscarLugar').val();

        // Validar que al menos un criterio de búsqueda esté presente
        if (!nombre && !categoria && !lugar) {
            alert('Por favor, ingrese al menos un criterio de búsqueda (nombre, categoría o lugar)');
            return;
        }

        // Crear objeto con los criterios de búsqueda
        const criteriosBusqueda = {
            nombre: nombre,
            categoria: categoria,
            lugar: lugar
        };

        // Realizar la búsqueda
        buscarProductos(criteriosBusqueda);
    }

    actualizarTabla();
    
    // Actualizar tabla cada 30 segundos
    setInterval(actualizarTabla, 30000);

    $('#btnExportarExcelProductos').off('click').on('click', function() {
        console.log('Click exportar Excel productos');
        var tabla = document.querySelector('.table');
        if (!tabla) {
            alert('No se encontró la tabla para exportar.');
            return;
        }
        var wb = XLSX.utils.table_to_book(tabla, {sheet: "Productos"});
        XLSX.writeFile(wb, 'productos.xlsx');
    });
    $('#btnExportarPDFProductos').off('click').on('click', function() {
        console.log('Click exportar PDF productos');
        var tabla = document.querySelector('.table');
        if (!tabla) {
            alert('No se encontró la tabla para exportar.');
            return;
        }
        var doc = new window.jspdf.jsPDF();
        doc.autoTable({ html: tabla, theme: 'grid', headStyles: { fillColor: [220, 53, 69] } });
        doc.save('productos.pdf');
    });

    // Mostrar/ocultar campo de precio según el tipo de producto
    $('#categoria').on('change', function() {
        if ($(this).val() === 'insumos') {
            $('#campoPrecio').show();
            $('#precio').prop('required', true);
        } else {
            $('#campoPrecio').hide();
            $('#precio').prop('required', false).val('');
        }
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
            console.log('Respuesta del servidor:', response);
            
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
                // Mostrar mensaje de error
                alert(response.message || 'Error al guardar el producto');
            }
        },
        error: function(xhr, status, error) {
            console.log('Error completo:', xhr.responseText);
            let mensaje = 'Error al guardar el producto';
            
            try {
                const response = JSON.parse(xhr.responseText);
                if (response && response.message) {
                    mensaje = response.message;
                }
            } catch(e) {
                console.error('Error al parsear la respuesta:', e);
            }
            
            alert(mensaje);
        }
    });
}

// Función para mostrar alertas
function mostrarAlerta(mensaje, tipo) {
    if (tipo === 'danger') {
        // Mostrar error en el modal
        $('#errorMessage').text(mensaje);
        $('#errorMessage').show();
    } else {
        // Mostrar alerta en la página
        const alerta = `
            <div class="alert alert-${tipo} alert-dismissible fade show" role="alert">
                ${mensaje}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        $('.content').prepend(alerta);
        
        // Auto-ocultar después de 5 segundos
        setTimeout(() => {
            $('.alert').fadeOut();
        }, 5000);
    }
}

// Función para editar un producto
function editarProducto(id) {
    $.ajax({
        url: '../../secciones/productos/obtener.php',
        method: 'GET',
        data: { id: id },
        dataType: 'json',
        success: function(producto) {
            // Llenar el formulario con los datos del producto
            $('#productoId').val(producto.id_producto);
            $('#nombre').val(producto.nombre);
            $('#categoria').val(producto.categoria);
            $('#presentacion').val(producto.presentacion);
            $('#cantidad').val(producto.cantidad);
            $('#stockMinimo').val(producto.stock_minimo);
            $('#fechaCaducidad').val(producto.fecha_caducidad);
            $('#ubicacion').val(producto.ubicacion);
            $('#proveedor').val(producto.proveedor);
            
            // Manejar el campo precio
            if (producto.categoria === 'insumos') {
                $('#campoPrecio').show();
                $('#precio').prop('required', true);
                $('#precio').val(producto.precio || '');
            } else {
                $('#campoPrecio').hide();
                $('#precio').prop('required', false).val('');
            }
            
            // Cambiar el título del modal
            $('#nuevoProductoModalLabel').text('Editar Producto');
            $('#btnGuardarProducto').text('Actualizar');
            
            // Abrir el modal
            $('#nuevoProductoModal').modal('show');
        },
        error: function(xhr, status, error) {
            console.error('Error al obtener el producto:', error);
            alert('Error al cargar los datos del producto');
        }
    });
}

// Función para cambiar el estado de un producto
function cambiarEstado(id) {
    if (confirm('¿Está seguro de que desea cambiar el estado de este producto?')) {
        $.ajax({
            url: '../../secciones/productos/cambiar_estado.php',
            method: 'POST',
            data: { id: id },
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    cargarProductos();
                } else {
                    alert(response.message || 'Error al cambiar el estado');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Error al cambiar el estado del producto');
            }
        });
    }
}

// Función para cargar productos (placeholder)
function cargarProductos() {
    // Recargar la página para mostrar los cambios
    location.reload();
}

// Función para buscar productos
function buscarProductos(criterios) {
    console.log('Buscando productos con criterios:', criterios);
    
    // Mostrar indicador de carga
    $('.content').html('<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Buscando...</span></div></div>');
    
    $.ajax({
        url: '../../secciones/productos/buscar.php',
        method: 'POST',
        data: criterios,
        success: function(response) {
            console.log('Respuesta de búsqueda:', response);
            
            // Actualizar el contenido con los resultados
            $('.content').html(response);
            
            // Si no hay resultados, mostrar mensaje
            if (response.includes('No se encontraron productos')) {
                $('.content').html(response);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error en la búsqueda:', error);
            console.error('Respuesta del servidor:', xhr.responseText);
            
            $('.content').html(`
                <div class="alert alert-danger">
                    <h5>Error en la búsqueda</h5>
                    <p>No se pudo realizar la búsqueda. Por favor, inténtelo de nuevo.</p>
                    <button class="btn btn-primary" onclick="location.reload()">Recargar página</button>
                </div>
            `);
        }
    });
}

// Función para actualizar tabla (placeholder)
function actualizarTabla() {
    // Implementar actualización si es necesario
    console.log('Actualizando tabla de productos');
}