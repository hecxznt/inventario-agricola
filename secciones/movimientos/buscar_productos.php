<?php
// Activar la salida de errores para depuración
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Asegurarnos de que no haya salida antes del JSON
ob_start();

try {
    require_once '../../php/config.php';

    // Verificar la conexión
    if (!isset($conn) || !($conn instanceof PDO)) {
        throw new Exception('Error de conexión a la base de datos');
    }

    // Verificar si la tabla productos existe
    $stmt = $conn->query("SHOW TABLES LIKE 'productos'");
    if ($stmt->rowCount() === 0) {
        throw new Exception('La tabla productos no existe');
    }

    // Verificar la estructura de la tabla
    $stmt = $conn->query("DESCRIBE productos");
    $columnas = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
    // Verificar si hay datos en la tabla
    $stmt = $conn->query("SELECT COUNT(*) as total FROM productos");
    $total = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    if ($total === 0) {
        throw new Exception('No hay productos en la base de datos');
    }

    header('Content-Type: application/json');

    if (!isset($_POST['busqueda'])) {
        throw new Exception('No se proporcionó término de búsqueda');
    }

    $busqueda = '%' . $_POST['busqueda'] . '%';
    
    // Mostrar la consulta para depuración
    $sql = "SELECT id_producto, nombre, stock_actual 
            FROM productos 
            WHERE nombre LIKE ? 
            ORDER BY nombre 
            LIMIT 10";
    
    $stmt = $conn->prepare($sql);
    $stmt->execute([$busqueda]);
    $productos = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($productos)) {
        echo json_encode([
            'success' => false,
            'message' => 'No se encontraron productos que coincidan con: ' . $_POST['busqueda']
        ]);
        exit;
    }

    $html = '';
    foreach ($productos as $producto) {
        $html .= sprintf(
            '<a href="#" class="list-group-item list-group-item-action" 
                onclick="seleccionarProducto(%d, \'%s\', %f); return false;">
                <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1">%s</h6>
                    <small>Stock: %s</small>
                </div>
            </a>',
            $producto['id_producto'],
            htmlspecialchars($producto['nombre']),
            $producto['stock_actual'],
            htmlspecialchars($producto['nombre']),
            number_format($producto['stock_actual'], 2)
        );
    }

    // Limpiar cualquier salida anterior
    ob_clean();
    
    echo json_encode([
        'success' => true,
        'html' => $html,
        'debug' => [
            'busqueda' => $_POST['busqueda'],
            'total_productos' => count($productos)
        ]
    ]);

} catch (Exception $e) {
    // Limpiar cualquier salida anterior
    ob_clean();
    
    echo json_encode([
        'success' => false,
        'message' => 'Error: ' . $e->getMessage(),
        'debug' => [
            'error_type' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]
    ]);
}

// Enviar la salida
ob_end_flush();
?> 