<?php
session_start();
if (!isset($_SESSION['user']) && isset($_GET['id']) && isset($_GET['mode'])) {
    $mysqli = mysqli_connect("localhost", "id3131583_swg12", "veskojulen", "id3131583_quiz");
    if (!$mysqli) {
        echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
    } else {
        $mode = $_GET['mode'];
        $id = $_GET['id'];
        if (strcmp($mode, "like") == 0) {
            $query = "UPDATE preguntas SET likes = likes + 1 WHERE ID='$id'";
            if ($mysqli->query($query) === TRUE) {
                echo "1";
            } else {
                echo "Error";
            }
        } else {
            if ($mysqli->query($query) === TRUE) {
                echo "2";
            } else {
                echo "Error";
            }
        }


    }
    mysqli_close($mysqli);
}else{
    echo "Error";
}
?>