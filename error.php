<?php
session_start();
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
        createSideBar(0);
        ?>
        <div class="col-12 col-md-9" style="text-align: center;">
            <p class="float-left d-md-none">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="offcanvas">Navegación</button>
            </p>
            <div class="jumbotron">
                <div class="row">
                    <div class="col-md-2"><img src="images/warning.png" width="100px"></div>
                    <div class="col-md-10">
                        ACCESO A ESTE APARTADO NO AUTORIZADO EN ESTE MOMENTO.
                        <?php
                        if (isset($_SESSION['user'])) {
                            echo "</br>No puedes acceder a este apartado porque estás logeado como " . $_SESSION['type'];
                        } else {
                            echo "</br>No puedes acceder porque no has iniciado sesión.";
                            echo "</br><a href='Login.php'>Iniciar sesión</a></br><a href='Registro.php'>Registrarse</a>";
                        }
                        ?>
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
</html>
