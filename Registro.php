<?php
session_start();
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
<style>
    label {
        text-align: left;
    }
</style>
<body>
<?php
if (isset($_SESSION['user'])) {
    header("Location: error.php");
}
?>
<header>
    <?php
    include 'layout.php';
    createNavbar(2);
    ?>
</header>
<main role="main" class="container">
    <div class="row row-offcanvas row-offcanvas-left">
        <?php
        createSideBar(0);
        ?>
        <div class="col-12 col-md-9">
            <p class="float-left d-md-none">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="offcanvas">Navegación</button>
            </p>
            <div class="jumbotron">
                <form id="registrar" name="registrar" action="Registro.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label><h4>Introduce tus datos:</h4></label>
                    </div>
                    <div class="form-group row">
                        <label for="email" class="col-sm-3 col-form-label">Email*:</label>
                        <div class="col-sm-9">
                            <input type="text" id="email" name="email" size=50 onblur="comprobarEmail()"
                                   class="form-control" value="<?php if(isset($_POST['email'])){echo $_POST['email'];}?>">
                            <small id="resultado" class="form-text text-muted"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nomape" class="col-sm-3 col-form-label">Nombre y apellidos*:</label>
                        <div class="col-sm-9">
                            <input type="text" id="nomape" name="nomape" size=80 class="form-control" value="<?php if(isset($_POST['nomape'])){echo $_POST['nomape'];}?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="nick" class="col-sm-3 col-form-label">Nick*:</label>
                        <div class="col-sm-9">
                            <input type="text" id="nick" name="nick" size=40 class="form-control" value="<?php if(isset($_POST['nick'])){echo $_POST['nick'];}?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password" class="col-sm-3 col-form-label"> Password*:</label>
                        <div class="col-sm-9">
                            <input type="password" id="password" name="password" size=20 class="form-control"
                                   onblur="comprobarPassword()">
                            <small id="resultado2" class="form-text text-muted"></small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="password2" class="col-sm-3 col-form-label">Repetir password*:</label>
                        <div class="col-sm-9">
                            <input type="password" id="password2" name="password2" size=20 class="form-control">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="pregunta" class="col-sm-3 col-form-label">Pregunta de seguridad*:</label>
                        <div class="col-sm-9">
                            <select class="custom-select" name="pregunta" id="pregunta">
                                <option value="1" selected>¿Dónde se conocieron tus padres?</option>
                                <option value="2">¿Cuál fue el nombre de tu primera mascota?</option>
                                <option value="3">¿Cuál es el segundo apellido de tu madre?</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="respuesta" class="col-sm-3 col-form-label">Respuesta de seguridad*:</label>
                        <div class="col-sm-9">
                            <input type="text" id="respuesta" name="respuesta" size=50 class="form-control" value="<?php if(isset($_POST['respuesta'])){echo $_POST['respuesta'];}?>">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="foto" class="col-sm-3">Foto:</label>
                        <div class="col-sm-9">
                            <input type="file" class="form-control-file" id="foto" name="foto" onchange="fileInput(this)">
                            <br/>
                            <img id="preview" style="max-height: 80px; max-width: 80px;"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="submit" id="boton" value="Registrarse" disabled class="btn btn-primary">
                        <input type="button" id="delete" value="Eliminar imagen" class="btn btn-primary"
                               onclick="deleteImage()" style="visibility: hidden">
                    </div>
                </form>
                <p id="loginError" style="width: 100%; text-align: center;"></p>
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
    function fileInput(input) {
        var fname = input.value;
        var re = /(\.jpg|\.jpeg|\.bmp|\.gif|\.png)$/i;
        if (!re.exec(fname)) {
            input.value = "";
            $('#preview').attr('src', '');
            $('#delete').css('visibility', 'hidden');
            alert("¡Este tipo de archivo no está permitido!");
        } else {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#preview')
                        .attr('src', e.target.result);
                };
                $('#delete').css('visibility', 'visible');
                reader.readAsDataURL(input.files[0]);
            }
        }
    }

    function deleteImage() {
        $('#preview').attr('src', '');
        $('#delete').css('visibility', 'hidden');
        document.getElementById("foto").value = "";
    }

    var valemail = false;
    var valpass = false;

    xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function () {
        switch (xmlhttp.readyState) { //Según el estado de la petición devolvemos un Texto
            case 0:
                document.getElementById('resultado').innerHTML =
                    "Sin iniciar...";
                valemail = false;
                actualizarBoton();
                break;
            case 1:
                document.getElementById('resultado').innerHTML =
                    "<b>Cargando...</b>";
                break;
            case 2:
                document.getElementById('resultado').innerHTML =
                    "<b>Cargado...</b>";
                break;
            case 3:
                document.getElementById('resultado').innerHTML =
                    "Interactivo...";
                break;
            case 4:
                document.getElementById('resultado').innerHTML =
                    response = xmlhttp.responseText;
                if (response.trim() == 'SI') {
                    $('#resultado').text('Email válido');
                    valemail = true;
                } else {
                    $('#resultado').text('Email inválido');
                    valemail = false;
                }
                actualizarBoton();
                break;
        }
    }

    function comprobarEmail() {
        if ($('#email').val().length != 0) {
            xmlhttp.open("GET", "ajax/UsuariosVIP.php?email=" + $('#email').val(), true);
            xmlhttp.send();
        }
    }
    comprobarEmail();
    xmlhttp2 = new XMLHttpRequest();
    xmlhttp2.onreadystatechange = function () {
        switch (xmlhttp2.readyState) { //Según el estado de la petición devolvemos un Texto
            case 0:
                document.getElementById('resultado2').innerHTML =
                    "Sin iniciar...";
                valpass = false;
                actualizarBoton();
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
                document.getElementById('resultado2').innerHTML =
                    response = xmlhttp2.responseText;
                if (response.trim() == 'VALIDA') {
                    $('#resultado2').text('Contraseña válida');
                    valpass = true;
                } else {
                    $('#resultado2').text('Contraseña inválida');
                    valpass = false;
                }
                actualizarBoton();
                break;
        }
    }

    function comprobarPassword() {
        if ($('#password').val().length != 0) {
            xmlhttp2.open("GET", "ajax/ComprobarPassword.php?password=" + $('#password').val(), true);
            xmlhttp2.send();
        }
    }
    function actualizarBoton() {
        if (valemail && valpass) {
            $('#boton').removeAttr('disabled');
        } else {
            $('#boton').attr('disabled', 'disabled');
        }
    }
</script>

</html>
<?php
if (isset($_POST["email"])) {
    $email = $_POST["email"];
    $nomape = $_POST["nomape"];
    $nick = $_POST["nick"];
    $password = $_POST["password"];
    $password2 = $_POST["password2"];
    $pregunta = $_POST["pregunta"];
    $respuesta = $_POST["respuesta"];
    $pattern = '/^([a-z]+[0-9]{3})+\@((ikasle)+\.)+((ehu)+\.)+((es)|(eus))+$/';
    require_once('nusoap-master/src/nusoap.php');

    $soapclient = new nusoap_client('http://swg12.000webhostapp.com/servicios/ComprobarPassword.php?wsdl', true);
    $pass = $soapclient->call('comprobarPassword', array('pass' => $password));
    if (strstr($pass, 'INVALIDA')) {
        die('<script>$("#loginError").text("Contraseña no válida...");</script>');
    }
    $soapclient2 = new nusoap_client('http://ehusw.es/jav/ServiciosWeb/comprobarmatricula.php?wsdl', true);
    $mail = $soapclient->call('comprobar', array('x' => $email));
    if (strstr($mail, 'NO')) {
        die('<script>$("#loginError").text("Correo inválido...");</script>');
    }
    if (preg_match($pattern, $email) == 0) {
        die('<script>$("#loginError").text("Email incorrecto");</script>');
    }
    if (!preg_match('/\s/', $nomape) & strlen($nomape) < 3) {
        die('<script>$("#loginError").text("Nombre y apellidos incorrectos");</script>');
    }
    if (preg_match('/\s/', $nick) | strlen($nick) < 1) {
        die('<script>$("#loginError").text("Nick incorrecto");</script>');
    }
    if (strlen($password) < 6) {
        die('<script>$("#loginError").text("Longitud insuficiente de la contraseña");</script>');
    }
    if ($password != $password2) {
        die('<script>$("#loginError").text("Las contraseñas no coinciden");</script>');
    }
    if (strlen($respuesta) == 0) {
        die('<script>$("#loginError").text("La respuesta de seguridad no puede estar vacía");</script>');
    }

    $mysqli = mysqli_connect("localhost", "id3131583_swg12", "veskojulen", "id3131583_quiz");
    if (!$mysqli) {
        echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
    }
    if (!file_exists($_FILES['foto']['tmp_name']) || !is_uploaded_file($_FILES['foto']['tmp_name'])) {
        $image = '';
    } else {
        $image = addslashes(file_get_contents($_FILES['foto']['tmp_name']));
    }
    $password = hash('sha256', $password);
    $Query = "INSERT INTO user(email,nombreape,nick,password,foto)
                    VALUES ('$email','$nomape','$nick','$password','{$image}')";
    $Query2 = "INSERT INTO recuperarpass
                    VALUES ('$email','$pregunta','$respuesta')";
    if (mysqli_query($mysqli, $Query) && mysqli_query($mysqli, $Query2)) {
        session_start();
        $_SESSION['user'] = $email;
        $_SESSION['type'] = 'Alumno';
        $_SESSION['nick'] = $nick;
        $Query = "SELECT password, nick, foto FROM user WHERE email='$email'";
        $res = mysqli_query($mysqli, $Query);
        while ($row = mysqli_fetch_array($res)) {
            $_SESSION['foto'] = $row['foto'];
        }
        $numero = simplexml_load_file('xml/numusuarios.xml');
        if ($numero == false) {
            echo "Error abriendo el archivo xml.";
        } else {
            $numero[0] = $numero + 1;
            $numero->asXML('xml/numusuarios.xml');
        }
        echo "<script> alert('Usuario creado correctamente, bienvenido!'); 
                        location.replace(\"index.php\");</script>";
    } else {
        echo "ERROR: No se pudo registrar el usuario. " . mysqli_error($mysqli);
    }
    mysqli_close($mysqli);
}
?>
