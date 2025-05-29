// Funciones para el manejo de movimientos
function verHistorial(idProducto) {
    // Mostrar el modal
    const modal = new bootstrap.Modal(document.getElementById('historialModal'));
    modal.show();
    
    // Cargar el historial
    $.ajax({
        url: BASE_URL + '/secciones/movimientos/obtener_historial.php',
        type: 'POST',
        data: { id_producto: idProducto },
        success: function(response) {
            $('#historialContenido').html(response);
        },
        error: function() {
            $('#historialContenido').html('<div class="alert alert-danger">Error al cargar el historial</div>');
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Inicializar eventos
    inicializarEventos();
});

function inicializarEventos() {
    // Evento para el selector de productos
    const selectProducto = document.getElementById('selectProducto');
    if (selectProducto) {
        selectProducto.addEventListener('change', function() {
            const idProducto = this.value;
            const idProductoInput = document.getElementById('id_producto');
            if (idProducto) {
                idProductoInput.value = idProducto;
                // Mostrar el stock actual en la consola para depuración
                const option = this.options[this.selectedIndex];
                const stock = option.getAttribute('data-stock');
                console.log('Producto seleccionado:', {
                    id: idProducto,
                    nombre: option.text,
                    stock: stock
                });
            } else {
                idProductoInput.value = '';
            }
        });
    }

    // Eventos para el tipo de movimiento
    document.querySelectorAll('input[name="tipo_movimiento"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const camposEntrada = document.getElementById('camposEntrada');
            const camposSalida = document.getElementById('camposSalida');
            const camposTransferencia = document.getElementById('camposTransferencia');
            
            // Ocultar todos los campos primero
            camposEntrada.style.display = 'none';
            camposSalida.style.display = 'none';
            camposTransferencia.style.display = 'none';
            
            // Mostrar los campos correspondientes
            switch(this.value) {
                case 'entrada':
                    camposEntrada.style.display = 'block';
                    break;
                case 'salida':
                    camposSalida.style.display = 'block';
                    break;
                case 'transferencia':
                    camposTransferencia.style.display = 'block';
                    break;
            }

            // Limpiar campos específicos al cambiar de tipo
            limpiarCamposEspecificos(this.value);
        });
    });

    // Evento para formatear monto en entradas
    const montoInput = document.querySelector('input[name="monto"]');
    if (montoInput) {
        montoInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^\d.]/g, '');
            if (value) {
                value = parseFloat(value).toFixed(2);
                e.target.value = value;
            }
        });
    }
}

function limpiarCamposEspecificos(tipo) {
    switch(tipo) {
        case 'entrada':
            document.querySelector('select[name="proveedor"]').value = '';
            document.querySelector('input[name="monto"]').value = '';
            break;
        case 'salida':
            document.querySelector('select[name="parcela"]').value = '';
            document.querySelector('select[name="trabajador"]').value = '';
            break;
        case 'transferencia':
            document.querySelector('select[name="destino"]').value = '';
            break;
    }
}

function validarMovimiento() {
    const tipo = document.querySelector('input[name="tipo_movimiento"]:checked')?.value;
    if (!tipo) {
        alert('Por favor seleccione un tipo de movimiento');
        return false;
    }

    const cantidad = parseFloat(document.querySelector('input[name="cantidad"]').value);
    if (isNaN(cantidad) || cantidad <= 0) {
        alert('La cantidad debe ser mayor a 0');
        return false;
    }

    // Validaciones específicas por tipo
    switch(tipo) {
        case 'entrada':
            const proveedor = document.querySelector('select[name="proveedor"]').value;
            const monto = document.querySelector('input[name="monto"]').value;
            if (!proveedor) {
                alert('Por favor seleccione un proveedor');
                return false;
            }
            if (!monto || parseFloat(monto) <= 0) {
                alert('El monto debe ser mayor a 0');
                return false;
            }
            break;

        case 'salida':
            const parcela = document.querySelector('select[name="parcela"]').value;
            const trabajador = document.querySelector('select[name="trabajador"]').value;
            if (!parcela) {
                alert('Por favor seleccione una parcela');
                return false;
            }
            if (!trabajador) {
                alert('Por favor seleccione un trabajador');
                return false;
            }
            break;

        case 'transferencia':
            const destino = document.querySelector('select[name="destino"]').value;
            if (!destino) {
                alert('Por favor seleccione un destino');
                return false;
            }
            break;
    }

    return true;
}

function guardarMovimiento() {
    if (!validarMovimiento()) {
        return;
    }

    const form = document.getElementById('formMovimiento');
    const formData = new FormData(form);
    formData.append('id_trabajador', 1); // Por ahora usamos un ID fijo

    $.ajax({
        url: BASE_URL + '/secciones/movimientos/guardar.php',
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.success) {
                alert(response.message);
                location.reload();
            } else {
                alert(response.message);
            }
        },
        error: function() {
            alert('Error al guardar el movimiento');
        }
    });
} 