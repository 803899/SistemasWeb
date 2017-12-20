<?php
session_start();
if (isset($_SESSION['numPreguntas'])) {
    $mysqli = mysqli_connect("localhost", "id3131583_swg12", "veskojulen", "id3131583_quiz");
    if (!$mysqli) {
        echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
    } else {
        $nick = $_GET['nick'];
        if(strlen($nick)==0){
            exit("5");
        }
        $query = "SELECT * FROM ranking WHERE nick='$nick'";
        $res = mysqli_query($mysqli, $query);
        if ($res) {
            while ($row = mysqli_fetch_array($res)) {
                exit("2");
            }
        }
        $aciertos = $_SESSION['aciertos'];
        $fallos = $_SESSION['fallos'];
        $media = round($_SESSION['sumDificultad'] / $_SESSION['contador'], 2);
        $puntuacion = $_SESSION['puntuacion'];
        $query = "INSERT INTO ranking VALUES ('$nick','$aciertos','$fallos','$media','$puntuacion')";
        if (mysqli_query($mysqli, $query)) {
            unset($_SESSION['numPreguntas']);
            exit("1");
        }else{
            exit("3");
        }
    }
}else{
    exit("4");
}
?>