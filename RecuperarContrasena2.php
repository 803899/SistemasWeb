<?php
session_start();
if (isset($_SESSION['user'])) {
    header("Location: error.php");
    exit();
}
if (!isset($_GET['email'])) {
    header("Location: RecuperarContrasena.php");
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
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
        createSideBar(1);
        ?>
        <div class="col-12 col-md-9">
            <p class="float-left d-md-none">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="offcanvas">Navegación</button>
            </p>
            <div class="jumbotron">
                <form id="recuperar" name="recuperar" action="#">
                    <div class="form-group">
                        <label><h4>Recuperación de contraseña</h4></label>
                    </div>
                    <div class="form-group">
                        <label>Pregunta de seguridad:</label>
                        <label><b>
                                <?php
                                $mysqli = mysqli_connect("localhost", "id3131583_swg12", "veskojulen", "id3131583_quiz");
                                if (!$mysqli) {
                                    echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
                                }
                                $email = $_GET['email'];
                                $query = "SELECT pregunta FROM recuperarpass WHERE email='$email'";
                                $res = mysqli_query($mysqli, $query);
                                $done = 0;
                                while ($row = mysqli_fetch_array($res)) {
                                    switch ($row['pregunta']) {
                                        case 1:
                                            echo "¿Dónde se conocieron tus padres?";
                                            break;
                                        case 2:
                                            echo "¿Cuál fue el nombre de tu primera mascota?";
                                            break;
                                        case 3:
                                            echo "¿Cuál es el segundo apellido de tu madre?";
                                            break;
                                    }
                                    $done = 1;
                                }
                                if($done == 0){
                                    echo "<script>alert('No se encuentra el correo o no es posible cambiar la contraseña.'); window.location='RecuperarContrasena.php';</script>";
                                }
                                ?>
                            </b>
                        </label>
                        <input type="text" id="respuesta" name="respuesta" size=50 class="form-control"
                               placeholder="Respuesta">
                    </div>
                    <div class="form-group">
                        <label>Nueva contraseña*:</label>
                        <input type="password" id="password" name="password" size=20 class="form-control"
                               onblur="comprobarPassword()">
                        <small id="resultado2" class="form-text text-muted"></small>
                    </div>
                    <div class="form-group">
                        <label>Repita contraseña*:</label>
                        <input type="password" id="password2" name="password2" size=20 class="form-control">
                    </div>
                    <input type="button" value="Recuperar" class="btn btn-info" onclick="recuperacionDeContraseña()">
                    <p id="resultado" style="text-align: center;"></p>
                </form>
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
        switch (xhr.readyState) {
            case 1:
                document.getElementById('resultado').innerHTML =
                    "<img src='images/loading.gif' height='100px'/>";
                break;
            case 4:
                var res = xhr.responseText;
                $("#resultado").text(res);
                if (res == "0") {
                    $("#resultado").text("Faltan datos");
                } else if (res == "1") {
                    $("#resultado").text("La contraseña es inválida");
                } else if (res == "2") {
                    $("#resultado").text("La respuesta no es correcta");
                } else if (res == "3") {
                    $("#resultado").text("Ok");
                    alert("La contraseña se ha cambiado satisfactoriamente");
                    window.location = "Login.php";
                }
        }
    }

    function recuperacionDeContraseña() {
        if ($("#password").val().length == 0 || $("#respuesta").val().length == 0 || $("#password2").val().length == 0) {
            $("#resultado").text("No puede haber campos vacíos");
        } else if ($("#password").val() == $("#password2").val()) {
            var respuesta = $("#respuesta").val();
            var info = "?email=<?php echo $email; ?>&respuesta=" + respuesta + "&password=" + $('#password').val();
            xhr.open("GET", "ajax/RecuperarContrasena.php" + info, true);
            xhr.send();
        } else {
            document.getElementById('resultado').innerHTML = "Las contraseñas no coinciden"
        }
    }

    xmlhttp2 = new XMLHttpRequest();
    xmlhttp2.onreadystatechange = function () {
        switch (xmlhttp2.readyState) { //Según el estado de la petición devolvemos un Texto
            case 0:
                document.getElementById('resultado2').innerHTML =
                    "Sin iniciar...";
                valpass = false;
                break;
            case 1:
                document.getElementById('resultado2').innerHTML =
                    "<b>Cargando...</b>";
                break;
            case 2:
                document.getElementById('resultado2').innerHTML =
                    "<b>Cargado...</b>";
                break;
            case 3:
                document.getElementById('resultado2').innerHTML =
                    "Interactivo...";
                break;
            case 4:
                response = xmlhttp2.responseText;
                if (response.trim() == 'VALIDA') {
                    $('#resultado2').text('Contraseña válida');
                } else {
                    $('#resultado2').text('Contraseña inválida');
                }
                break;
        }
    }


    function comprobarPassword() {
        if ($('#password').val().length != 0) {
            xmlhttp2.open("GET", "ajax/ComprobarPassword.php?password=" + $('#password').val(), true);
            xmlhttp2.send();
        }
    }
</script>
</html>
