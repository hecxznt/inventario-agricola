<?php
require_once 'php/config.php';
require 'vendor/autoload.php';

try {
    // Obtener productos con alertas de stock mínimo
    $stmt = $conn->query("
        SELECT p.* 
        FROM productos p 
        WHERE p.activo = 1 
        AND p.cantidad <= p.stock_minimo
    ");
    
    $alertasStock = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "Productos con stock mínimo:\n";
    foreach ($alertasStock as $alerta) {
        echo "Producto: " . $alerta['nombre'] . "\n";
        echo "Stock Actual: " . $alerta['cantidad'] . "\n";
        echo "Stock Mínimo: " . $alerta['stock_minimo'] . "\n";
        echo "-------------------\n";
        
        // Intentar enviar correo
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
        
        try {
            $mail = new PHPMailer\PHPMailer\PHPMailer(true);
            
            // Configuración del servidor
            $mail->SMTPDebug = 2; // Habilitar debug detallado
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'industriaagro25@gmail.com';
            $mail->Password = 'jemb jigc zoaq osoa';
            $mail->SMTPSecure = PHPMailer\PHPMailer\PHPMailer::ENCRYPTION_SMTPS;
            $mail->Port = 465;
            $mail->CharSet = 'UTF-8';
            
            // Configuración adicional para Gmail
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            // Remitente y destinatario
            $mail->setFrom('industriaagro25@gmail.com', 'Sistema de Inventario');
            $mail->addAddress('industriaagro25@gmail.com');

            // Contenido
            $mail->isHTML(true);
            $mail->Subject = $asunto;
            $mail->Body = $mensaje;

            $mail->send();
            echo "Resultado del envío: Exitoso\n";
        } catch (Exception $e) {
            echo "Error al enviar correo: " . $mail->ErrorInfo . "\n";
        }
    }
    
} catch (PDOException $e) {
    echo "Error en la base de datos: " . $e->getMessage();
}
?> 