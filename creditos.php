<?php
session_start();
?>
<!DOCTYPE html>
<html>
<style>
    table {
        text-align: left;
        margin: 0 auto;
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
        createSideBar(3);
        ?>
        <div class="col-12 col-md-9" style="text-align: center;">
            <p class="float-left d-md-none">
                <button type="button" class="btn btn-primary btn-sm" data-toggle="offcanvas">Navegación</button>
            </p>
            <div class="jumbotron">
                <h3>Aplicación desarrolada por Vesko y Julen<br/>
                    para Sistemas Web</h3><br/>
                Estudiantes de Ingeniería Informática (Ingeniería del Software)
                <br/>
                <img src="images/SW.png" width="150px"/><br/>
                <div>
                    <table>
                        <tr>
                            <th colspan="2">Información obtenida de la dirección IP</th>
                        </tr>
                        <tr>
                            <td>País:</td>
                            <td id="pais"></td>
                        </tr>
                        <tr>
                            <td>Región:</td>
                            <td id="region"></td>
                        </tr>
                        <tr>
                            <td>Ciudad:</td>
                            <td id="ciudad"></td>
                        </tr>
                        <tr>
                            <td>IP pública:</td>
                            <td id="ip"></td>
                        </tr>
                    </table>
                    <div class="container-fluid">
                        <?php
                        ini_set('max_execution_time', 300);
                        $request = 'http://api.population.io/1.0/population/Spain/today-and-tomorrow/';
                        $response = file_get_contents($request);
                        $jsonobj = json_decode($response);
                        echo "<br/>Populación en España:<br/>";
                        echo $jsonobj->{'total_population'}[0]->{'population'};
                        ?>
                    </div>
                </div>
                Ubicación en el mapa:<br/>
                <div id="mapa" style="height: 200px; width: 100%;"></div>
                <a href='index.php'>Volver a la pagina principal</a>
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
<script type="text/javascript"
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyC4FGd_P0t-3h9OARurBQywZIf7QbE28GM">
</script>
<script>
    var requestURL = "http://ip-api.com/json";
    var request = new XMLHttpRequest();
    request.open('GET', requestURL);
    request.responseType = 'json';
    request.send();
    request.onload = function () {
        var info = request.response;
        document.getElementById('pais').innerHTML = info['country'] + " (" + info['countryCode'] + ")";
        document.getElementById('region').innerHTML = info['regionName'] + " (" + info['region'] + ")";
        document.getElementById('ciudad').innerHTML = info['city'];
        document.getElementById('ip').innerHTML = info['query'];
        var lat = info['lat'];
        var lng = info['lon'];
        var latlng = new google.maps.LatLng(lat, lng);
        var myOptions = {
            zoom: 16,
            center: latlng,
            mapTypeId: google.maps.MapTypeId.SATELLITE
        };
        var map = new google.maps.Map(document.getElementById("mapa"), myOptions);
        var marker = new google.maps.Marker({
            position: map.getCenter(),
            map: map,
        });
    }
</script>
</html>
