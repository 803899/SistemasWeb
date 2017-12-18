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
        $id = $_GET['id'];
        $query = "DELETE FROM preguntas WHERE id='$id'";
        if($mysqli->query($query) === TRUE){
            echo "ok";
        }else{
            echo "er";
        }
        mysqli_close($mysqli);
    }
}
?>