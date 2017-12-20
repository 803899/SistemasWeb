<?php
session_start();
if (!isset($_SESSION['user'])) {
    $mysqli = mysqli_connect("localhost", "id3131583_swg12", "veskojulen", "id3131583_quiz");
    if (!$mysqli) {
        echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
    } else {
        unset($_SESSION['tema']);
        if(isset($_GET['tema'])){
            $tema = $_GET['tema'];
            $_SESSION['tema'] = $tema;
            $query = "SELECT id FROM preguntas WHERE Tema='$tema'";
        }else{
            $query = "SELECT id FROM preguntas";
        }

        $res = mysqli_query($mysqli, $query);
        if ($res) {
            $_SESSION['preguntas'] = array();
            $_SESSION['puntuacion'] = 0;
            $_SESSION['contador'] = 0;
            $_SESSION['sumDificultad'] = 0;
            $_SESSION['aciertos'] = 0;
            $_SESSION['fallos'] = 0;
            while ($row = mysqli_fetch_array($res)) {
                array_push($_SESSION['preguntas'], $row['id']);
            }
            if (count($_SESSION['preguntas']) == 0) {
                header('Location: SinPreguntas.php');
            }
            if(count($_SESSION['preguntas']) > 3){
                $_SESSION['numPreguntas'] = 3;
            }else{
                $_SESSION['numPreguntas'] = count($_SESSION['preguntas']);
            }

        } else {
            header('Location: SinPreguntas.php');
        }
    }
    mysqli_close($mysqli);
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
    <title>Preguntas</title>
    <link href="static/css/bootstrap.min.css" rel="stylesheet">
    <link href="static/css/offcanvas.css" rel="stylesheet">
    <link href="static/css/footer.css" rel="stylesheet">
</head>
<body>
<header>
    <?php
    include 'layout.php';
    createNavbar(0);
    ?>
</header>
<main role="main" class="container">
    <div class="row row-offcanvas row-offcanvas-left">
        <?php
        createSideBar(2);
        ?>
        <div class="col-12 col-md-9">
            <p class="float-left d-md-none">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="offcanvas">Navegación</button>
            </p>
            <div class="jumbotron" id="pregunta" style="height: 500px;">

            </div>
        </div>
    </div>
</main>
<?php
createFooter();
?>
</body>
<script src="lib/jquery.min.js"></script>
<script src="lib/popper.min.js"></script>
<script src="static/js/bootstrap.min.js"></script>
<script src="static/js/offcanvas.js"></script>
<script defer src="lib/fontawesome-all.js"></script>
<script>
    xhrSiguiente = new XMLHttpRequest();
    xhrSiguiente.onreadystatechange = function () {
        switch (xhrSiguiente.readyState) {
            case 1:
                document.getElementById("pregunta").innerHTML = "<img src='images/loading.gif' width='600px'>";
                break;
            case 4:
                var res = xhrSiguiente.responseText
                if(res == "fin"){
                    window.location = "FinJuego.php";
                }else {
                    document.getElementById("pregunta").innerHTML = res;
                }
                break;
        }
    }
    siguiente();

    function siguiente() {
        xhrSiguiente.open('GET', 'ajax/Siguiente.php', true);
        xhrSiguiente.send();
    }

    xhrComprobar = new XMLHttpRequest();
    xhrComprobar.onreadystatechange = function () {
        switch (xhrComprobar.readyState) {
            case 1:
                document.getElementById('resultado').innerHTML = "<img src='images/loading2.gif' width='20px'>";
                break;
            case 4:
                document.getElementById('saltar').value = "Siguiente"
                var respuesta = JSON.parse(xhrComprobar.responseText);
                if (respuesta[0] == "ok") {
                    document.getElementById('resultado').innerHTML = "Acierto";
                    document.getElementById('resultado').style.color = "green";
                    document.getElementById('puntuacion').innerHTML = respuesta[1];
                    if (document.getElementById('op1').checked) {
                        document.getElementById('t1').style.color = "green";
                        document.getElementById('t1').innerHTML = (document.getElementById('op1').value + " - CORRECTA").bold();
                    } else if (document.getElementById('op2').checked) {
                        document.getElementById('t2').style.color = "green";
                        document.getElementById('t2').innerHTML = (document.getElementById('op2').value + " - CORRECTA").bold();
                    } else if (document.getElementById('op3').checked) {
                        document.getElementById('t3').style.color = "green";
                        document.getElementById('t3').innerHTML = (document.getElementById('op3').value + " - CORRECTA").bold();
                    } else if (document.getElementById('op4').checked) {
                        document.getElementById('t4').style.color = "green";
                        document.getElementById('t4').innerHTML = (document.getElementById('op4').value + " - CORRECTA").bold();
                    }
                    console.log("Respuesta correcta");
                } else if (respuesta[0] == "no") {
                    document.getElementById('resultado').innerHTML = "Ya has comprobado";
                    document.getElementById('resultado').style.color = "black";
                    console.log("No se puede volver a comprobar");
                } else {
                    document.getElementById('resultado').innerHTML = "Fallo";
                    document.getElementById('resultado').style.color = "red";
                    document.getElementById('puntuacion').innerHTML = respuesta[2];
                    if (document.getElementById('op1').checked) {
                        document.getElementById('t1').style.color = "red";
                        document.getElementById('t1').innerHTML = (document.getElementById('op1').value + " - INCORRECTA").bold();
                    } else if (document.getElementById('op2').checked) {
                        document.getElementById('t2').style.color = "red";
                        document.getElementById('t2').innerHTML = (document.getElementById('op2').value + " - INCORRECTA").bold();
                    } else if (document.getElementById('op3').checked) {
                        document.getElementById('t3').style.color = "red";
                        document.getElementById('t3').innerHTML = (document.getElementById('op3').value + " - INCORRECTA").bold();
                    } else if (document.getElementById('op4').checked) {
                        document.getElementById('t4').style.color = "red";
                        document.getElementById('t4').innerHTML = (document.getElementById('op4').value + " - INCORRECTA").bold();
                    }
                    var corr = respuesta[1];
                    if (document.getElementById('op1').value == corr) {
                        document.getElementById('t1').style.color = "green";
                        document.getElementById('t1').innerHTML = (document.getElementById('op1').value + " - CORRECTA").bold();
                    } else if (document.getElementById('op2').value == corr) {
                        document.getElementById('t2').style.color = "green";
                        document.getElementById('t2').innerHTML = (document.getElementById('op2').value + " - CORRECTA").bold();
                    } else if (document.getElementById('op3').value == corr) {
                        document.getElementById('t3').style.color = "green";
                        document.getElementById('t3').innerHTML = (document.getElementById('op3').value + " - CORRECTA").bold();
                    } else if (document.getElementById('op4').value == corr) {
                        document.getElementById('t4').style.color = "green";
                        document.getElementById('t4').innerHTML = (document.getElementById('op4').value + " - CORRECTA").bold();
                    }
                }
                break;
        }
    }

    function comprobar() {
        var respuesta;
        if (document.getElementById('op1').checked) {
            respuesta = document.getElementById('op1').value;
        } else if (document.getElementById('op2').checked) {
            respuesta = document.getElementById('op2').value;
        } else if (document.getElementById('op3').checked) {
            respuesta = document.getElementById('op3').value;
        } else if (document.getElementById('op4').checked) {
            respuesta = document.getElementById('op4').value;
        }
        xhrComprobar.open('GET', 'ajax/ComprobarPregunta.php?respuesta=' + respuesta, true);
        xhrComprobar.send();
    }

    function acabar() {
        window.location = "FinJuego.php"
    }


    xhrNumeros = new XMLHttpRequest();
    xhrNumeros.onreadystatechange = function () {
        switch (xhrNumeros.readyState) {
            case 4:
                var res = xhrNumeros.responseText;
                console.log(res);
                if (res == "1") {
                    document.getElementById('likes').innerHTML = parseInt(document.getElementById('likes').textContent) + 1;
                } else if (res == "2") {
                    document.getElementById('dislikes').innerHTML = parseInt(document.getElementById('dislikes').textContent) + 1;
                }
                break;
        }
    }

    function like(id) {
        document.getElementById("btnLike").disabled = true;
        xhrNumeros.open('GET', 'ajax/EditLikeDislike.php?mode=like&id=' + id, true);
        xhrNumeros.send();
    }

    function dislike(id) {
        document.getElementById("btnDislike").disabled = true;
        xhrNumeros.open('GET', 'ajax/EditLikeDislike.php?mode=dislike&id=' + id, true);
        xhrNumeros.send();
    }
</script>
</html>
