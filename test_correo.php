<?php
require_once 'php/config.php';
require 'vendor/autoload.php';

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
    $mail->Subject = "Prueba de correo - Sistema de Inventario";
    $mail->Body = "
        <h2>Prueba de Correo</h2>
        <p>Este es un correo de prueba para verificar que el sistema de alertas funciona correctamente.</p>
        <p>Si recibes este correo, significa que la configuración está correcta.</p>
    ";

    $mail->send();
    echo "Correo enviado correctamente";
} catch (Exception $e) {
    echo "Error al enviar el correo: " . $mail->ErrorInfo;
}
?> 