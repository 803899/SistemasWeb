<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: error.php");
} else {
    if (!(strcmp($_SESSION['type'], "Profesor") == 0)) {
        header("Location: error.php");
    }
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
<style>
    div > table {
        text-align: left;
        margin: 0 auto;
    }

    input {
        width: 400px;
    }
</style>
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
        createSideBar(5);
        ?>
        <div class="col-12 col-md-9" style="text-align: center;">
            <p class="float-left d-md-none">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="offcanvas">Navegación</button>
            </p>
            <div class="jumbotron">
                <?php
                $mysqli = mysqli_connect("localhost", "id3131583_swg12", "veskojulen", "id3131583_quiz");
                if (!$mysqli) {
                    echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
                } else {
                    $Query = "SELECT ID, Enunciado FROM preguntas";
                    $res = mysqli_query($mysqli, $Query);
                    echo "Elige la pregunta a revisar: <select id='preguntas' name='preguntas' onchange='cambiar()'>";
                    if($res->num_rows != 0) {
                        while ($row = mysqli_fetch_array($res)) {
                            echo "<option value='" . $row['ID'] . "'>Pregunta " . $row['ID'] . "</option>";
                        }
                    }
                    echo "</select>";
                    mysqli_close($mysqli);
                }
                ?>
                <div id="formulario"></div>
                <div id="actualizar"></div>
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
                document.getElementById('formulario').innerHTML = "<img src='images/loading.gif' height='200px'/>";
                break;
            case 4:
                document.getElementById('formulario').innerHTML = xhr.responseText;
                break;
        }
    }
    cambiar();

    function cambiar() {
        var id = document.getElementById('preguntas').value;
        xhr.open('GET', 'ajax/PreguntaEditar.php?id=' + id, true);
        xhr.send();
    }

    xhr2 = new XMLHttpRequest();
    xhr2.onreadystatechange = function () {
        if (xhr2.readyState == 4) {
            cambiar();
            document.getElementById('actualizar').innerHTML = xhr2.responseText;
        }
    }

    function modificar() {
        if(confirm("¿Estás seguro de que quieres modificar la pregunta?")) {
            var url = "?id=" + $('#preguntas').val()
                + "&enunciado=" + $('#enunciado').val()
                + "&correcta=" + $('#correcta').val()
                + "&incorrecta1=" + $('#incorrecta1').val()
                + "&incorrecta2=" + $('#incorrecta2').val()
                + "&incorrecta3=" + $('#incorrecta3').val()
                + "&complejidad=" + $('#complejidad').val()
                + "&tema=" + $('#tema').val();
            xhr2.open('GET', 'ajax/ActualizarPregunta.php' + url, true);
            xhr2.send();
        }
    }

    xhr3 = new XMLHttpRequest();
    xhr3.onreadystatechange = function () {
        switch (xhr3.readyState) {
            case 4:
                var resp = xhr3.responseText;
                if(resp == "ok"){
                    alert("La pregunta se ha eliminado correctamente.");
                    location.reload();
                }else{
                    alert("No ha sido posible eliminar la pregunta.");
                }
                break;
        }
    }

    function eliminar(){
        if(confirm("¿Estás seguro de que quieres eliminar la pregunta?")) {
            xhr3.open('GET', 'ajax/EliminarPregunta.php?id=' + $('#preguntas').val(), true);
            xhr3.send();
        }
    }
</script>
</html>
