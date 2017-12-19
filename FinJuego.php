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
            <div class="jumbotron" id="pregunta">
                <h2>Fin de la partida</h2>
                <p>
                    <?php
                    $puntuacion = $_SESSION['puntuacion'];
                    if($puntuacion == 1){
                        echo "¡Has obtenido ". $puntuacion ." punto!";
                    }else{
                        echo "¡Has obtenido ". $puntuacion ." puntos!";
                    }
                    ?>
                </p>
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
</html>
