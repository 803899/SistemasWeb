<?php
session_start();
if (isset($_SESSION['user']) || !isset($_SESSION['puntuacion'])) {
    header("Location: error.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="tipo_contenido" content="text/html;" http-equiv="content-type" charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
            <div class="jumbotron">
                <h2>Fin de la partida</h2>
                <p>
                    <?php
                    $puntuacion = $_SESSION['puntuacion'];
                    if ($puntuacion == 1) {
                        echo "¡Has obtenido " . $puntuacion . " punto!";
                    } else {
                        echo "¡Has obtenido " . $puntuacion . " puntos!";
                    }
                    ?>
                </p>
                <p>Número de aciertos: <?php echo $_SESSION['aciertos']; ?></p>
                <p>Número de fallos: <?php echo $_SESSION['fallos']; ?></p>
                <p>Dificultad media: <?php echo round($_SESSION['sumDificultad']/$_SESSION['contador'], 2); ?></p>
                <hr/>
                <div id="guardar">
                    <form id="form">
                        <label>Guarda tu puntuación:</label>
                        <div class="form-group row">
                            <label for="nick" class="col-md-1 col-form-label">Nick*: </label>
                            <div class="col-md-7">
                                <input type="text" id="nick" placeholder="Nick" class="form-control">
                            </div>
                            <div class="col-md-3">
                                <input type="button" value="Guardar" class="btn btn-primary" onclick="guardar()" id="boton" style="width: 100%;">
                            </div>
                            <div class="col-md-1" id="load">
                            </div>
                        </div>
                    </form>
                    <div id="mensaje">
                    </div>
                </div>
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
<script>
    xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        switch (xhr.readyState){
            case 1:
                document.getElementById("load").innerHTML = "<img src='images/loading2.gif' width='20px'/>";
                break;
            case 4:
                document.getElementById("load").innerHTML = "";
                var res = xhr.responseText;
                console.log(res);
                if(res == "1"){
                    document.getElementById("guardar").innerHTML = "Partida guardada correctamente";
                }else if(res == "2"){
                    document.getElementById("nick").classList.add('is-invalid');
                    document.getElementById("mensaje").innerHTML = "El nick está en uso";
                }else if(res == "3"){
                    document.getElementById("mensaje").innerHTML = "No se ha podido guardar por motivos desconocidos";
                }else if(res == "4"){
                    document.getElementById("guardar").innerHTML = "Esta partida ya ha sido guardada";
                }else if(res == "5"){
                    document.getElementById("nick").classList.add('is-invalid');
                    document.getElementById("mensaje").innerHTML = "El nick no puede estar vacío";
                }
                break;
        }
    }

    function guardar(){
        var nick = document.getElementById("nick").value;
        xhr.open('GET', 'ajax/GuardarPartida.php?nick='+nick, true);
        xhr.send();
    }
</script>
</html>
