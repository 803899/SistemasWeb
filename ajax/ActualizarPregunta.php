<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: error.php");
}else{
    if (!(strcmp($_SESSION['type'], "Profesor")==0)) {
        header("Location: error.php");
    }
}
if (isset($_GET['id'])) {
    $mysqli = mysqli_connect("localhost", "id3131583_swg12", "veskojulen", "id3131583_quiz");
    if (!$mysqli) {
        echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
    } else {
        $statement = "UPDATE preguntas SET Enunciado='".$_GET['enunciado']."', 
            Correcta='".$_GET['correcta']."', 
            Incorrecta1='".$_GET['incorrecta1']."', 
            Incorrecta2='".$_GET['incorrecta2']."', 
            Incorrecta3='".$_GET['incorrecta3']."', 
            Complejidad='".$_GET['complejidad']."',
            Tema='".$_GET['tema']."' WHERE ID='". $_GET['id']."'";
        if($mysqli->query($statement) === TRUE){
            echo "Modificado con éxito";
        }else{
            echo "No se ha podido modificar en este momento";
        }
        mysqli_close($mysqli);
    }
}
?>