<?php
session_start();
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
            <div class="jumbotron" style="text-align: center;">
                <img src="images/quiz.png" height="150px">
                <p>Ranking top 10 de jugadores:</p>
                <table class="table table-hover table-responsive-sm">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nick</th>
                        <th scope="col">Puntuacion</th>
                        <th scope="col">Aciertos</th>
                        <th scope="col">Fallos</th>
                        <th scope="col">Media dificultad</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $mysqli = mysqli_connect("localhost", "id3131583_swg12", "veskojulen", "id3131583_quiz");
                    if (!$mysqli) {
                        echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
                    } else {
                        $query = "SELECT * FROM ranking ORDER BY puntuacion DESC";
                        $res = mysqli_query($mysqli, $query);
                        if ($res) {
                            $cont = 1;
                            while ($row = mysqli_fetch_array($res)) {
                                if($cont==11){
                                    break;
                                }
                                echo "<tr>
                                        <th scope='row'>".$cont."</th>
                                        <td>".$row['nick']."</td>
                                        <td>".$row['puntuacion']."</td>
                                        <td>".$row['aciertos']."</td>
                                        <td>".$row['fallos']."</td>
                                        <td>".$row['media']."</td>
                                      </tr>";
                                $cont += 1;
                            }
                        }
                    }
                    ?>
                    </tbody>
                </table>
                <button onclick="window.location = 'ModoJuego.php';" class="btn btn-primary">Jugar</button>
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
