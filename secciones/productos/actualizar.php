<?php
require_once '../../php/config.php';
require_once '../../php/correo.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn->beginTransaction();
        
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $presentacion = $_POST['presentacion'];
        $cantidad = $_POST['cantidad'];
        $stock_minimo = $_POST['stock_minimo'];
        $fecha_caducidad = $_POST['fecha_caducidad'];
        $ubicacion = $_POST['ubicacion'];
        $proveedor = $_POST['proveedor'];
        $precio = (isset($_POST['precio']) && $categoria === 'insumo') ? floatval($_POST['precio']) : null;
        
        // Obtener datos actuales del producto
        $stmt = $conn->prepare("SELECT cantidad, stock_minimo, fecha_caducidad FROM productos WHERE id_producto = ?");
        $stmt->execute([$id]);
        $producto_actual = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Validar stock mínimo
        if ($stock_minimo < 10) {
            throw new Exception("El stock mínimo no puede ser menor a 10");
        }
        
        // Validar cantidad inicial
        if ($cantidad < 10) {
            throw new Exception("La cantidad inicial no puede ser menor a 10");
        }
        
        // Validar fecha de caducidad
        $fecha_actual = new DateTime();
        $fecha_cad = new DateTime($fecha_caducidad);
        if ($fecha_cad < $fecha_actual) {
            throw new Exception("La fecha de caducidad no puede ser anterior a la fecha actual");
        }
        
        // Actualizar producto
        $sql = "UPDATE productos SET 
                nombre = :nombre,
                categoria = :categoria,
                presentacion = :presentacion,
                cantidad = :cantidad,
                stock_minimo = :stock_minimo,
                fecha_caducidad = :fecha_caducidad,
                ubicacion = :ubicacion,
                proveedor = :proveedor,
                precio = :precio
                WHERE id_producto = :id";
                
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            ':nombre' => $nombre,
            ':categoria' => $categoria,
            ':presentacion' => $presentacion,
            ':cantidad' => $cantidad,
            ':stock_minimo' => $stock_minimo,
            ':fecha_caducidad' => $fecha_caducidad,
            ':ubicacion' => $ubicacion,
            ':proveedor' => $proveedor,
            ':precio' => $precio,
            ':id' => $id
        ]);
        
        // Verificar si se debe enviar alerta de stock mínimo
        if ($cantidad <= $stock_minimo && $producto_actual['cantidad'] > $producto_actual['stock_minimo']) {
            // Verificar si ya se envió una alerta en las últimas 24 horas
            $stmt = $conn->prepare("SELECT COUNT(*) FROM alertas_enviadas WHERE id_producto = ? AND tipo_alerta = 'stock_minimo' AND fecha_alerta > DATE_SUB(NOW(), INTERVAL 24 HOUR)");
            $stmt->execute([$id]);
            $alerta_reciente = $stmt->fetchColumn();
            
            if (!$alerta_reciente) {
                $asunto = "Alerta: Stock Mínimo - " . $nombre;
                $mensaje = "El producto " . $nombre . " ha alcanzado su stock mínimo.\n";
                $mensaje .= "Stock actual: " . $cantidad . "\n";
                $mensaje .= "Stock mínimo: " . $stock_minimo;
                
                enviarCorreo($asunto, $mensaje);
                
                // Registrar la alerta enviada
                $stmt = $conn->prepare("INSERT INTO alertas_enviadas (id_producto, tipo_alerta, fecha_alerta) VALUES (?, 'stock_minimo', NOW())");
                $stmt->execute([$id]);
            }
        }
        
        // Verificar si se debe enviar alerta de caducidad
        $fecha_actual = new DateTime();
        $fecha_cad = new DateTime($fecha_caducidad);
        $dias_para_caducar = $fecha_actual->diff($fecha_cad)->days;
        
        if ($dias_para_caducar <= 7 && $producto_actual['fecha_caducidad'] != $fecha_caducidad) {
            // Verificar si ya se envió una alerta en las últimas 24 horas
            $stmt = $conn->prepare("SELECT COUNT(*) FROM alertas_enviadas WHERE id_producto = ? AND tipo_alerta = 'caducidad' AND fecha_alerta > DATE_SUB(NOW(), INTERVAL 24 HOUR)");
            $stmt->execute([$id]);
            $alerta_reciente = $stmt->fetchColumn();
            
            if (!$alerta_reciente) {
                $asunto = "Alerta: Producto por Caducar - " . $nombre;
                $mensaje = "El producto " . $nombre . " está próximo a caducar.\n";
                $mensaje .= "Fecha de caducidad: " . $fecha_caducidad . "\n";
                $mensaje .= "Días restantes: " . $dias_para_caducar;
                
                enviarCorreo($asunto, $mensaje);
                
                // Registrar la alerta enviada
                $stmt = $conn->prepare("INSERT INTO alertas_enviadas (id_producto, tipo_alerta, fecha_alerta) VALUES (?, 'caducidad', NOW())");
                $stmt->execute([$id]);
            }
        }
        
        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Producto actualizado correctamente']);
        
    } catch(Exception $e) {
        $conn->rollBack();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Método no permitido']);
}
?> 