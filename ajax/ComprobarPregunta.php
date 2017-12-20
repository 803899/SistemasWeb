<?php
session_start();
if (!isset($_SESSION['user']) && isset($_SESSION['preguntas']) && isset($_GET['respuesta']) && isset($_SESSION['idPregunta'])) {
    $mysqli = mysqli_connect("localhost", "id3131583_swg12", "veskojulen", "id3131583_quiz");
    $id = $_SESSION['idPregunta'];
    if (!$mysqli) {
        echo json_encode(array("Fallo al conectar a MySQL: " . $mysqli->connect_error));
    } else {
        $query = "SELECT correcta, complejidad FROM preguntas WHERE id='$id'";
        $res = mysqli_query($mysqli, $query);
        if ($res) {
            while ($row = mysqli_fetch_array($res)) {
                unset($_SESSION['idPregunta']);
                if (strcmp($_GET['respuesta'], $row['correcta']) == 0) {
                    $_SESSION['puntuacion'] += 10*$row['complejidad'];
                    $_SESSION['aciertos'] += 1;
                    echo json_encode(array("ok", $_SESSION['puntuacion']));
                } else {
                    $_SESSION['puntuacion'] -= 5*$row['complejidad'];
                    if($_SESSION['puntuacion'] < 0){
                        $_SESSION['puntuacion'] = 0;
                    }
                    $_SESSION['fallos'] += 1;
                    echo json_encode(array("er", $row['correcta'], $_SESSION['puntuacion']));
                }
            }
        }
    }
    mysqli_close($mysqli);
} else {
    echo json_encode(array("no"));
}
?>