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
