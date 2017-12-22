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
<body>
<?php
if (isset($_SESSION['user'])) {
    header("Location: error.php");
}
?>
<header>
    <?php
    include 'layout.php';
    createNavbar(1);
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
                <form id="registrar" name="registrar" action="Login.php" method="POST"
                      enctype="multipart/form-data">
                    <div class="form-group">
                        <label><h4>Introduce tus datos:</h4></label>
                    </div>
                    <div class="form-group">
                        <label>Email*:</label>
                        <input type="text" name="email" class="form-control" placeholder="john@doe.com">
                    </div>
                    <div class="form-group">
                        <label>Password*:</label>
                        <input type="password" name="password" class="form-control" placeholder="··············">
                    </div>
                    <input type="submit" value="Iniciar sesión" class="btn btn-primary">
                </form>
                <p>¿No te acuerdas de tu contraseña? <a href="RecuperarContrasena.php">¡Recupérala!</a></p>
                <?php
                if (isset($_POST["email"])) {
                    $email = $_POST["email"];
                    $password = $_POST["password"];
                    $mysqli = mysqli_connect("localhost", "id3131583_swg12", "veskojulen", "id3131583_quiz");
                    if (!$mysqli) {
                        echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
                    }
                    $password = hash('sha256', $password);
                    $Query = "SELECT password, nick, foto FROM user WHERE email='$email'";
                    $res = mysqli_query($mysqli, $Query);
                    $done = 0;
                    while ($row = mysqli_fetch_array($res)) {
                        if ($row['password'] == $password) {
                            $_SESSION['user'] = $email;
                            $_SESSION['nick'] = $row['nick'];
                            $_SESSION['foto'] = $row['foto'];
                            if (strcmp($email, "web000@ehu.es") == 0) {
                                $_SESSION['type'] = 'Profesor';
                            } else {
                                $_SESSION['type'] = 'Alumno';
                            }
                            echo "<script type='text/javascript'>
                            xmlhttp = new XMLHttpRequest();
                            xmlhttp.open(\"GET\",\"ajax/UserNum.php?fun=enter&q=\"+new Date().getTime(),true);
                            xmlhttp.send();
                            alert('Bienvenido!');</script>";
                            echo "<script language=\"javascript\">window.location=\"index.php\"</script>";
                            exit();
                            $done = 1;
                        }
                    }
                    if ($done == 0) {
                        echo "<script type='text/javascript'>alert('Datos incorrectos');</script>";
                    }
                    mysqli_close($mysqli);
                }
                ?>
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

