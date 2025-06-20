<?php
if(!isset($_POST['username'])) {
    header('Location: ../login.php');
    exit();
}
require_once '../../vendor/autoload.php'; // Asegúrate de que la ruta sea correcta para tu proyecto

// Importar las clases necesarias de PHPMailer
// Asegúrate de que la ruta sea correcta para tu proyecto
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;


include_once "../../php/conexion.php";
$username = $_POST['username'] ?? '';
if (empty($username)) {
    header('Location: ../login.php?error=empty_username');
    exit();
}

if (isset($_POST['username'])) {

    $incrip = base64_encode($_POST['username']);
    $correo = $_POST['username'] ?? '';
    $Verificacion_email = $conn->prepare("SELECT * FROM usuario WHERE correo = ?");
    $Verificacion_email->bind_param("s", $correo);
    $Verificacion_email->execute();
    $Verificacion_email = $Verificacion_email->get_result();
    // echo "Email". $consulta_email;
    if ($Verificacion_email && mysqli_num_rows($Verificacion_email) > 0) {
        // Configuración del servidor SMTP (asegúrate de configurar esto adecuadamente para tu entorno)
        $enlace = "https://tueds.42web.io/TuEDS/adm/contra.php?correo=$incrip";
        // die($enlace);
        $phpmailer = new PHPMailer(true); // Usar `true` para habilitar excepciones
        // Configuración SMTP
        $phpmailer->isSMTP();
        $phpmailer->Host = 'smtp.gmail.com';
        $phpmailer->SMTPAuth = true;
        $phpmailer->Port = 587; // Asegúrate de usar el puerto correcto
        $phpmailer->SMTPSecure = 'tls'; // O 'ssl' si el servidor lo requiere
        $phpmailer->Username = 'aplicativosawebs@gmail.com';
        $phpmailer->Password = 'apvzceiqghrfqlef';
        // Configuración del correo
        $phpmailer->setFrom('aplicativosawebs@gmail.com', 'TU - EDS'); // Cambia el nombre y correo según sea necesario
        $phpmailer->addAddress($correo);
        $phpmailer->Subject = 'Recuperar Cuenta';
        $phpmailer->isHTML(true); // Habilitar HTML
    
        $phpmailer->Body = "
   <div style='font-family: Arial, sans-serif; background: #1e1e1e; color: #ffffff; line-height: 1.6; 
   max-width: 600px; margin: auto; border: solid 2px #333; border-radius: 12px; padding: 15px;'>
    <h1 style='color: #4CAF50; text-align: center;'>Recuperación de Acceso - TU EDS</h1>
    <p>Hola,</p>
    <p>Hemos recibido una solicitud para restablecer el acceso a tu cuenta en la plataforma de TU EDS.</p>
    <p>Si realizaste esta solicitud, haz clic en el botón a continuación para establecer una nueva contraseña:</p>
    <br>
    <p style='text-align: center;'>
        <button style='border-radius: 8px; box-shadow: 10px 10px 20px 0px #ffcc53 ; background-color: #0b7f46; color: white; 
        padding: 10px 20px;'>
            <a href='$enlace' style='background-color: #0b7f46; color: white; padding: 10px 20px; text-decoration: none;
             border-radius: 5px;'>Restablecer Contraseña</a>
        </button>
    </p>
    <br>
    <p>Si no solicitaste recuperar tu cuenta, puedes ignorar este mensaje sin preocuparte.</p>
    <p style='text-align: center; margin-top: 20px;'>
        <img src='https://tueds.42web.io/img/servicios.png' alt='Logo TU EDS' style='width: 150px; height: auto;'>
    </p>
    
    <p>Saludos,<br>Equipo de Soporte - TU EDS</p><br>
    <p style='text-align: center; margin-top: 20px; font-size: 12px; color: #aaa;'>
        Este correo ha sido generado automáticamente. Por favor, no respondas a este mensaje.
    </p>
    <br>
</div>
";
    
        // Alternativa para clientes que no soporten HTML
        $phpmailer->AltBody = "Hola, Haz solicitado recuperar tu cuenta. Haz clic en el enlace para crear una nueva 
        contraseña: $enlace. Si no realizaste esta solicitud, puedes ignorar este mensaje. Saludos, Equipo TU EDS";       
        if ($phpmailer->send()) { 
            // die("El mensaje ha sido enviado");
            echo "<script>
                    location.href ='../rest.php?respuesta=1';
                    </script>";                                   
        } else { 
            //  die("El mensaje no ha sido enviado");
            echo "<script>
                    location.href ='../rest.php?respuesta=2';
                </script>";
        }
    } else { 
        // die("El mensaje ha sido enviado");
        // Si el correo no existe en la base de datos
        echo "<script>
            location.href ='../rest.php?respuesta=0';
        </script>";
        exit();
    }
}