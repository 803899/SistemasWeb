<?php
if (isset($_GET['email'])) {
    $email = $_GET['email'];
    $password = $_GET['password'];
    $respuesta = $_GET['respuesta'];

    require_once('../nusoap-master/src/nusoap.php');

    $soapclient = new nusoap_client('http://swg12.000webhostapp.com/servicios/ComprobarPassword.php?wsdl', true);
    $pass = $soapclient->call('comprobarPassword', array('pass' => $password));
    if (strstr($pass, 'INVALIDA')) {
        die('1');
    }
    $mysqli = mysqli_connect("localhost", "id3131583_swg12", "veskojulen", "id3131583_quiz");
    if (!$mysqli) {
        echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
    }
    $query = "SELECT respuesta FROM recuperarpass WHERE email='$email'";
    $res = mysqli_query($mysqli, $query);
    while ($row = mysqli_fetch_array($res)) {
        if(strcmp($row['respuesta'],$respuesta)!=0){
            die('2');
        }
    }
    $password = hash("sha256", $password);
    $query = "UPDATE user SET password='$password' WHERE email='$email'";
    if (mysqli_query($mysqli, $query)) {
        echo "3";
    }
    mysqli_close($mysqli);
}else{
    die("0");
}
?>