<?php
session_start();
if (!isset($_SESSION['user']) && isset($_SESSION['preguntas'])) {
    if (count($_SESSION['preguntas']) != 0 && $_SESSION['contador'] != 3) {
        $num = rand(0, count($_SESSION['preguntas']) - 1);
        $id = $_SESSION['preguntas'][$num];
        while (strcmp($id, null) == 0) { //Esto es porque a veces sale null
            $id = $_SESSION['preguntas'][$num];
            echo $id;
        }
        unset($_SESSION['preguntas'][$num]);
        $_SESSION['preguntas'] = array_values($_SESSION['preguntas']);
        $_SESSION['idPregunta'] = $id;
        $mysqli = mysqli_connect("localhost", "id3131583_swg12", "veskojulen", "id3131583_quiz");
        if (!$mysqli) {
            echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
        } else {
            $query = "SELECT * FROM preguntas WHERE id='$id'";
            $res = mysqli_query($mysqli, $query);
            if ($res) {
                while ($row = mysqli_fetch_array($res)) {
                    $_SESSION['contador'] += 1;
                    $_SESSION['sumDificultad'] += $row['Complejidad'];

                    $respuestas = array($row['Correcta'], $row['Incorrecta1'], $row['Incorrecta2'], $row['Incorrecta3']);
                    shuffle($respuestas);
                    $foto = $row['Imagen'];


                    echo '<br/><form id="form">
                    <div class="form-group" style="margin: 1px;">
                            <div class="row">
                            <div class="col-md-2">
                                <label><h3>Pregunta: </h3></label>
                            </div>
                            <div class="col-md-7" style="margin-top: 8px;">
                                <label>' . $row['Enunciado'] . '</label>
                            </div>
                            <div class="col-md-3 mr-auto" style="margin-top: 8px;">
                                <label style="float: right;">Preguntas: '. $_SESSION['contador'] . ' de ' . $_SESSION['numPreguntas'] .'</label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group" style="margin: 1px;">
                        <label>Complejidad: ' . $row['Complejidad'] . '</label>';
                        if(strlen($row['Tema'])!= 0){
                            echo '<label>&nbsp| Tema: ' . $row['Tema'] . '</label>';
                        }
                    echo '</div>';
                    if ($foto != null) {
                        echo "<div class='row'><div class='col-md-9'>";
                    }
                    echo '<div class="custom-controls-stacked" id="respuestas">
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
                    </div>';
                    if ($foto != null) {
                        echo "</div>
                            <div class='col-md-2' style='text-align: center;'>
                            <img src=\"data:image/jpeg;base64," . base64_encode($foto) . "\" style='max-height: 100px; max-width: 100px;'>
                            </div>
                                </div>";
                    }
                    echo '<div class="form-group">
                        <input type="button" id="saltar" value="Saltar" onclick="siguiente()" class="btn btn-primary" style="width: 110px; margin-top: 20px;">
                        <input type="button" value="Comprobar" onclick="comprobar()" class="btn btn-primary" style="width: 110px; margin-top: 20px;">
                        <input type="button" value="Acabar" onclick="acabar()" class="btn btn-primary" style="width: 110px; margin-top: 20px;">
                        <label style="margin-left: 10px; margin-top: 20px;">Puntuación:&nbsp</label>
                        <label id="puntuacion" style="margin-top: 20px;">' . $_SESSION['puntuacion'] . '</label>
                        <label id="resultado" style="margin-left: 10px; margin-top: 20px;"></label>
                    </div>
                    <div class="form-group" style="margin-top: 20px;">
                        <button class="btn btn-primary" onclick="like('.$id.')" style="width: 90px;" type="button" id="btnLike"><i class="far fa-thumbs-up"></i> Like</button>
                        <label>&nbspLikes totales: </label>
                        <label id="likes">'. $row['likes'] .'</label>
                    </div>
                    <div class="form-group" style="margin-top: 20px;">
                        <button class="btn btn-primary" onclick="dislike('.$id.')" style="width: 90px;" type="button" id="btnDislike"><i class="far fa-thumbs-down"></i> Dislike</button>
                        <label>&nbspDislikes totales: </label>
                        <label id="dislikes">'. $row['dislikes'] .'</label>
                    </div>
                    </form>';

                }

            } else {
                echo "Error";
            }
        }
        mysqli_close($mysqli);
    } else {
        echo "fin";
    }
} else {
    echo "Error";
}
?>