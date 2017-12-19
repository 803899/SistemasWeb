<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: error.php");
    exit();
} else {
    if (!(strcmp($_SESSION['type'], "Alumno") == 0)) {
        header("Location: error.php");
        exit();
    }
}
?>
<!DOCTYPE html>
<html>
<style>
    div.aviso {
        border-style: groove;
    }

    label {
        text-align: left;
    }
</style>
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
        createSideBar(4);
        ?>
        <div class="col-12 col-md-9" style="text-align: center;">
            <p class="float-left d-md-none">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="offcanvas">Navegación</button>
            </p>
            <div class="jumbotron">
                <div class='aviso'>
                    <p id='npreguntas'></p>
                </div>
                <div class='aviso'>
                    <p id='usuarios'></p>
                </div>
                <br/>
                <div>
                    <form id="fpreguntas" name="fpreguntas" method="POST" enctype="multipart/form-data">
                        <div class="form-group row">
                            <label for="email" class="col-sm-4 col-form-label">Email:</label>
                            <div class="col-sm-8">
                                <input type="text" name="email" id="email" size="32" readonly class="form-control"
                                       value='<?php echo $_SESSION['user']; ?>'>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="pregunta" class="col-sm-4 col-form-label">Enunciado de la pregunta*:</label>
                            <div class="col-sm-8">
                                <input type="text" name="pregunta" id="pregunta" size="80" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="correcta" class="col-sm-4 col-form-label">Respuesta correcta*:</label>
                            <div class="col-sm-8">
                                <input type="text" name="correcta" id="correcta" size="80" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="incorrecta1" class="col-sm-4 col-form-label">Respuesta incorrecta*:</label>
                            <div class="col-sm-8">
                                <input type="text" name="incorrecta1" id="incorrecta1" size="80" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="incorrecta2" class="col-sm-4 col-form-label">Respuesta incorrecta*:</label>
                            <div class="col-sm-8">
                                <input type="text" name="incorrecta2" id="incorrecta2" size="80" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="incorrecta3" class="col-sm-4 col-form-label">Respuesta incorrecta*:</label>
                            <div class="col-sm-8">
                                <input type="text" name="incorrecta3" id="incorrecta3" size="80" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="complejidad" class="col-sm-4 col-form-label">Complejidad (1..5)*:</label>
                            <div class="col-sm-8">
                                <input type="text" name="complejidad" id="complejidad" size="32" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="complejidad" class="col-sm-4 col-form-label">Tema (subject):</label>
                            <div class="col-sm-8">
                                <input type="text" name="subject" id="subject" size="32" class="form-control">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="foto" class="col-sm-4">Foto:</label>
                            <input type="file" class="form-control-file" id="foto" name="foto"
                                   onchange="fileInput(this)">
                        </div>
                        <div class="form-group" style="alignment: center;">
                            <img id="preview" style="max-height: 80px; max-width: 80px;"/>
                        </div>
                        <div class="form-group">
                            <input type="button" value="Enviar quiz" onclick='enviar()' class="btn btn-info">
                            <input type="button" onclick='verPreguntas()' value="Ver preguntas" class="btn btn-info">
                            <input type="button" id="delete" value="Eliminar imagen" class="btn btn-info"
                                   onclick="deleteImage()" style="visibility: hidden">
                        </div>
                    </form>
                </div>
                <br/>
                <div id='response'>
                </div>
                <div id='preguntas'>
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

    function enviar() {
        var form = $("#fpreguntas").get(0);

        $.ajax({
            url: 'ajax/InsertarPreguntaAJAX.php',
            type: 'POST',
            data: new FormData(form),
            dataType: 'json',
            mimeType: 'multipart/form-data',
            processData: false,
            contentType: false,
            success: function (response) {
                document.getElementById("response").innerHTML = response.responseText;
            },
            error: function (data) {
                document.getElementById("response").innerHTML = data.responseText;
            }
        });
        $('#fpreguntas')[0].reset();
        $('#preview').attr('src', '');
        $('#delete').css('visibility', 'hidden');
    }

    xmlhttp2 = new XMLHttpRequest();
    xmlhttp2.onreadystatechange = function () {
        if (xmlhttp2.readyState == 4 && xmlhttp2.status == 200) {
            document.getElementById("preguntas").innerHTML = xmlhttp2.responseText;
        }
    }

    function verPreguntas() {
        xmlhttp2.open("GET", "ajax/VerPreguntasAJAX.php", true);
        xmlhttp2.send();
    }


    function contadorPreguntas() {
        var total = 0;
        var propias = 0;
        var email = $('#email').val();
        $.ajax({
            type: "GET",
            url: "xml/preguntas.xml",
            cache: false,
            dataType: "xml",
            success: function (xml) {
                $(xml).find('assessmentItem').each(function () {
                    var author = $(this).attr('author');
                    total++;
                    if (email === author) {
                        propias++;
                    }
                })
                $('#npreguntas').text('Mis preguntas/Todas las preguntas: ' + propias + '/' + total);
            }
        });
    }

    contadorPreguntas();
    setInterval(contadorPreguntas, 20000);

    xmlhttp3 = new XMLHttpRequest();
    xmlhttp3.onreadystatechange = function () {
        if (xmlhttp3.readyState == 4 && xmlhttp3.status == 200) {
            document.getElementById("usuarios").innerHTML = "Número de usuarios conectados: " + xmlhttp3.responseText;
        }
    }

    function consultarUsuarios() {
        xmlhttp3.open("GET", "ajax/UserNum.php?fun=consulta&q=" + new Date().getTime(), true);
        xmlhttp3.send();
    }

    consultarUsuarios();
    setInterval(consultarUsuarios, 10000);

</script>
</html>
