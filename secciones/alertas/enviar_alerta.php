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
        
        foreach ($alertasCaducidad as $alerta) {
            $fechaCaducidad = new DateTime($alerta['fecha_caducidad']);
            $hoy = new DateTime();
            $diferencia = $hoy->diff($fechaCaducidad);
            
            // Preparar el mensaje según el tiempo restante
            if ($diferencia->days == 0) {
                $tiempoRestante = $diferencia->h . " horas";
            } else {
                $tiempoRestante = $diferencia->days . " días";
            }
            
            $asunto = "¡Alerta Crítica! Producto por Caducar";
            $mensaje = "
                <h2>Alerta de Caducidad</h2>
                <p>El siguiente producto está próximo a caducar:</p>
                <ul>
                    <li><strong>Producto:</strong> {$alerta['nombre']}</li>
                    <li><strong>Stock Actual:</strong> {$alerta['cantidad']}</li>
                    <li><strong>Fecha de Caducidad:</strong> " . date('d/m/Y', strtotime($alerta['fecha_caducidad'])) . "</li>
                    <li><strong>Tiempo Restante:</strong> {$tiempoRestante}</li>
                </ul>
                <p>Por favor, tome las medidas necesarias.</p>
            ";
            
            // Enviar correo directamente
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
        
        foreach ($alertasStock as $alerta) {
            $asunto = "¡Alerta Crítica! Stock Mínimo Alcanzado";
            $mensaje = "
                <h2>Alerta de Stock Mínimo</h2>
                <p>El siguiente producto ha alcanzado su stock mínimo:</p>
                <ul>
                    <li><strong>Producto:</strong> {$alerta['nombre']}</li>
                    <li><strong>Stock Actual:</strong> {$alerta['cantidad']}</li>
                    <li><strong>Stock Mínimo:</strong> {$alerta['stock_minimo']}</li>
                </ul>
                <p>Por favor, realice un nuevo pedido para reponer el inventario.</p>
            ";
            
            // Enviar correo directamente
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