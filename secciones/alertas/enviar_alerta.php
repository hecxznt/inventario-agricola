<?php
require_once '../../php/config.php';

// Función para verificar y enviar alertas críticas
function verificarYEnviarAlertas() {
    global $conn;
    
    try {
        // Obtener productos con alertas de caducidad
        $stmt = $conn->query("
            SELECT p.* 
            FROM productos p 
            WHERE p.activo = 1 
            AND p.fecha_caducidad IS NOT NULL 
            AND p.fecha_caducidad <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)
            AND p.fecha_caducidad > CURDATE()
        ");
        
        $alertasCaducidad = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // --- ALERTAS DE CADUCIDAD ---
        $productosCaducidad = [];
        foreach ($alertasCaducidad as $alerta) {
            // Intentar insertar la bandera primero
            $stmt_insert = $conn->prepare("INSERT IGNORE INTO alertas_enviadas (id_producto, tipo_alerta, fecha_alerta) VALUES (?, 'caducidad', NOW())");
            $inserted = $stmt_insert->execute([$alerta['id_producto']]);
            if ($stmt_insert->rowCount() > 0) {
                $productosCaducidad[] = $alerta;
            }
        }
        if (count($productosCaducidad) > 0) {
            $mensaje = "<h2>Alerta de Caducidad</h2><p>Los siguientes productos están próximos a caducar:</p><ul>";
            foreach ($productosCaducidad as $alerta) {
                $fechaCaducidad = new DateTime($alerta['fecha_caducidad']);
                $hoy = new DateTime();
                $diferencia = $hoy->diff($fechaCaducidad);
                $tiempoRestante = ($diferencia->days == 0) ? $diferencia->h . " horas" : $diferencia->days . " días";
                $mensaje .= "<li><strong>Producto:</strong> {$alerta['nombre']} | <strong>Stock Actual:</strong> {$alerta['cantidad']} | <strong>Fecha de Caducidad:</strong> " . date('d/m/Y', strtotime($alerta['fecha_caducidad'])) . " | <strong>Tiempo Restante:</strong> {$tiempoRestante}</li>";
            }
            $mensaje .= "</ul><p>Por favor, tome las medidas necesarias.</p>";
            $asunto = "¡Alerta Crítica! Productos por Caducar";
            enviarCorreoAlerta($asunto, $mensaje, 'industriaagro25@gmail.com');
        }

        // Obtener productos con alertas de stock mínimo
        $stmt = $conn->query("
            SELECT p.* 
            FROM productos p 
            WHERE p.activo = 1 
            AND p.cantidad <= p.stock_minimo
        ");
        
        $alertasStock = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // --- ALERTAS DE STOCK ---
        $productosStock = [];
        foreach ($alertasStock as $alerta) {
            $stmt_insert = $conn->prepare("INSERT IGNORE INTO alertas_enviadas (id_producto, tipo_alerta, fecha_alerta) VALUES (?, 'stock', NOW())");
            $inserted = $stmt_insert->execute([$alerta['id_producto']]);
            if ($stmt_insert->rowCount() > 0) {
                $productosStock[] = $alerta;
            }
        }
        if (count($productosStock) > 0) {
            $mensaje = "<h2>Alerta de Stock Mínimo</h2><p>Los siguientes productos han alcanzado su stock mínimo:</p><ul>";
            foreach ($productosStock as $alerta) {
                $mensaje .= "<li><strong>Producto:</strong> {$alerta['nombre']} | <strong>Stock Actual:</strong> {$alerta['cantidad']} | <strong>Stock Mínimo:</strong> {$alerta['stock_minimo']}</li>";
            }
            $mensaje .= "</ul><p>Por favor, realice un nuevo pedido para reponer el inventario.</p>";
            $asunto = "¡Alerta Crítica! Productos con Stock Mínimo";
            enviarCorreoAlerta($asunto, $mensaje, 'industriaagro25@gmail.com');
        }
        
        return true;
    } catch (PDOException $e) {
        error_log("Error al verificar alertas: " . $e->getMessage());
        return false;
    }
}

// Ejecutar la verificación
verificarYEnviarAlertas();
?> 