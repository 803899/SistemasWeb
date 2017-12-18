<?php
session_start();
if (!isset($_SESSION['user']) && isset($_SESSION['preguntas'])) {
    if (count($_SESSION['preguntas']) != 0) {
        $num = rand(0, count($_SESSION['preguntas']) - 1);
        $id = $_SESSION['preguntas'][$num];
        while (strcmp($id, null) == 0) { //Esto es porque a veces sale null
            $id = $_SESSION['preguntas'][$num];
        }
        $_SESSION['preguntas'] = array_diff($_SESSION['preguntas'], array($id));
        $_SESSION['idPregunta'] = $id;
        $mysqli = mysqli_connect("localhost", "id3131583_swg12", "veskojulen", "id3131583_quiz");
        if (!$mysqli) {
            echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
        } else {
            $query = "SELECT * FROM preguntas WHERE id='$id'";
            $res = mysqli_query($mysqli, $query);
            if ($res) {
                while ($row = mysqli_fetch_array($res)) {
                    $respuestas = array($row['Correcta'], $row['Incorrecta1'], $row['Incorrecta2'], $row['Incorrecta3']);
                    shuffle($respuestas);

                    echo '<form id="form">
                    <div class="form-group">
                        <label><h3>Pregunta: &nbsp&nbsp</h3></label>
                        <label>' . $row['Enunciado'] . '</label>
                    </div>
                    <div class="custom-controls-stacked" id="respuestas">
                        <label class="custom-control custom-radio">
                            <input id="op1" name="respuesta" type="radio" class="custom-control-input" value="' . $respuestas[0] . '">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description" id="t1">' . $respuestas[0] . '</span>
                        </label>
                        <label class="custom-control custom-radio">
                            <input id="op2" name="respuesta" type="radio" class="custom-control-input" value="' . $respuestas[1] . '">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description" id="t2">' . $respuestas[1] . '</span>
                        </label>
                        <label class="custom-control custom-radio">
                            <input id="op3" name="respuesta" type="radio" class="custom-control-input" value="' . $respuestas[2] . '">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description" id="t3">' . $respuestas[2] . '</span>
                        </label>
                        <label class="custom-control custom-radio">
                            <input id="op4" name="respuesta" type="radio" class="custom-control-input" value="' . $respuestas[3] . '">
                            <span class="custom-control-indicator"></span>
                            <span class="custom-control-description" id="t4">' . $respuestas[3] . '</span>
                        </label>
                    </div>
                    <div class="form-group" style="margin-top: 20px;">
                        <input type="button" value="Siguiente" onclick="siguiente()" class="btn btn-info">
                        <input type="button" value="Comprobar" onclick="comprobar()" class="btn btn-info">
                        <input type="button" value="Acabar" onclick="acabar()" class="btn btn-info">
                        <label style="margin-left: 10px;">Puntuación:&nbsp</label>
                        <label id="puntuacion">'.$_SESSION['puntuacion'].'</label>
                        <label id="resultado" style="margin-left: 10px;"></label>
                    </div>
                </form>';
                }

            } else {
                echo "Error";
            }
        }
        mysqli_close($mysqli);
    } else {
        echo "No quedan más preguntas.";
    }
} else {
    echo "Error";
}
?>