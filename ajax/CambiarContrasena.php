<?php
if (isset($_SESSION['user'])) {
    echo "USUARIO YA LOGEADO";
} elseif (isset($_GET['email'])) {
    $email = $_GET['email'];
    $mysqli = mysqli_connect("localhost", "id3131583_swg12", "veskojulen", "id3131583_quiz");
    if (!$mysqli) {
        echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
        die();
    }
    $query = "SELECT password FROM user WHERE email='" . $email . "'";
    $res = mysqli_query($mysqli, $query);
    $done = 0;
    while ($row = mysqli_fetch_array($res)) {
        $pass = $row['password'];
        $done = 1;
    }
    if ($done == 1) {
        $cod = $email . $pass;
        $cod = hash('sha256', $cod);
        $insert = "INSERT INTO codContraseña VALUES ('" . $email . "','" . $cod . "')";
        mysqli_query($mysqli, $insert);
        $link = "http://localhost/SW/RecuperarContraseña.php?id=" . $cod;
        $mensaje = "Parece ser que estás intentando cambiar la contraseña!
                    </br>Podrás acceder a cambiar la contraseña mediante el siguiente link
                    </br></br><a href='" . $link . "'>CAMBIAR CONTRASEÑA</a>
                    </br></br>O copiando y pegando el link en el navegador:
                    </br></br>" . $link;
        require('mail/PHPMailerAutoload.php');
        $mail = new PHPMailer();

        $mail->IsSMTP();
        $mail->SMTPDebug  = 0;
        $mail->SMTPAuth = true;
        $mail->Host = "smtp.gmail.com"; // SMTP a utilizar. Por ej. smtp.elserver.com
        $mail->Username = "swg12sw@gmail.com"; // Correo completo a utilizar
        $mail->Password = "swg12345678"; // Contraseña
        $mail->Port = 587; // Puerto a utilizar
        $mail->SMTPSecure = 'tls';

        $mail->SetFrom('swg12sw@gmail.com', 'SWG12');

        $mail->AddAddress($email); // Esta es la dirección a donde enviamos
        $mail->IsHTML(true); // El correo se envía como HTML
        $mail->Subject = "Recuperación de contraseña"; // Este es el titulo del email.

        $mail->Body = $mensaje; // Mensaje a enviar
        if($mail->Send()){
            echo "El correo fue enviado correctamente.";
        } else {
            echo "Hubo un inconveniente. Contacta a un administrador." . $mail->ErrorInfo;
        }
    } else {
        echo "El email introducido no existe . ";
    }
    mysqli_close($mysqli);
} elseif (isset($_GET['id'])) {
    $id = $_GET['id'];
    $pass = $_GET['password'];
    $mysqli = mysqli_connect("localhost", "id3131583_swg12", "veskojulen", "id3131583_quiz");
    if (!$mysqli) {
        echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
        die();
    }
    $query = "SELECT email FROM codContraseña WHERE cod='".$id."'";
    $res = mysqli_query($mysqli, $query);
    $done = 0;
    while ($row = mysqli_fetch_array($res)) {
        $email = $row['email'];
        $done = 1;
    }
    if($done == 1){
        $pass = hash('sha256', $pass);
        $query = "UPDATE user SET password='".$pass."' WHERE eMail='".$email."'";
        mysqli_query($mysqli, $query);
        $query = "DELETE FROM codContraseña WHERE cod='".$id."'";
    }else{
        echo "No autorizado.";
    }
    mysqli_close($mysqli);
}
?>