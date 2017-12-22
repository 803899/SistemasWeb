<?php
session_start();
if(isset($_SESSION['user'])){
    header("Location: error.php");
    exit();
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
            <div class="jumbotron" id="pregunta">
                <h2>Jugar</h2>
                <hr/>
                <form style="text-align: center;">
                    <div class="form-group row">
                        <label for="tema" class="col-sm-3 col-form-label">Elige un tema:</label>
                        <div class="col-sm-6">
                            <select class="form-control" id="tema">
                                <?php
                                $mysqli = mysqli_connect("localhost", "id3131583_swg12", "veskojulen", "id3131583_quiz");
                                if (!$mysqli) {
                                    echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
                                } else {
                                    $query = "SELECT DISTINCT(Tema) FROM preguntas";
                                    $res = mysqli_query($mysqli, $query);
                                    if ($res) {
                                        while ($row = mysqli_fetch_array($res)) {
                                            if(strlen($row['Tema'])!=0) {
                                                echo "<option value='". $row['Tema'] ."'>" . $row['Tema'] . "</option>";
                                            }
                                        }
                                    }
                                }
                                mysqli_close($mysqli);
                                ?>
                            </select>
                        </div>
                        <div class="col-sm-3">
                            <input type="button" value="Jugar" class="btn btn-primary" style="width: 100%;" onclick="jugarTema()">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>o bien</label>
                    </div>
                    <div class="form-group">
                        <input type="button" value="Jugar en todos los temas" class="btn btn-primary"
                               style="width:80%;" onclick="window.location = 'Jugar.php';">
                    </div>
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
    function jugarTema(){
        var tema = $("#tema").val();
        window.location = "Jugar.php?tema=" + tema;
    }
</script>
</html>
