<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

$nombre = $_POST['nombre'];
$correo = $_POST['correo'];
$tipo = $_POST['tipo'];
$mensaje = $_POST['mensaje'];

$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
try {
    //Server settings
    $mail->SMTPDebug = 2;                                 // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'correo';                 // SMTP username
    $mail->Password = 'clave';                           // SMTP password
    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
    $mail->Port = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('correo', 'nombre ');  //De quien manda
    $mail->addAddress('correo', 'nombre ');   //De quien recibe
    //$mail->addAddress('ellen@example.com');               // Name is optional
    //$mail->addReplyTo('info@example.com', 'Information');
   // $mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
    //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

    //Content
    $mail->isHTML(false);                                  // Set email format to HTML
    $mail->Subject = $tipo;
   //$mail->Body    = 'Nombre: ' . $nombre . '\n'
   //  . 'Correo: ' . $correo;

    $mail->Body = 
<<<EOT
Nombre: {$nombre}
Correo: {$correo}
-----------------
{$mensaje}
EOT;

    //$mail->AltBody = 'Phenomenal ';

    $mail->SMTPOptions = array(
    'ssl' => array(
    'verify_peer' => false,
    'verify_peer_name' => false,
    'allow_self_signed' => true
    )
);

    $mail->send();
    $estado = 'Enviado';
    header("Location: form.html?estado=".$estado);
} catch (Exception $e) {
    $estado = 'No hemos podido generar tu consulta';
    $mail->ErrorInfo;
    header("Location: form.html?estado=".$estado);
}