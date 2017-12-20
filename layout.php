<?php
function createNavbar($selected)
{
    echo '<nav class="navbar navbar-expand-md fixed-top navbar-dark bg-dark">
                    <a class="navbar-brand" href="index.php">QUIZZES</a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                
                    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
                        <ul class="navbar-nav mr-auto">
                            <a class="nav-link disabled">El juego de las preguntas</a>
                        </ul>
                        <ul class="navbar-nav ml-auto">';
    if (isset($_SESSION['user'])) {
        echo '<li class="nav-item">
                <a class="nav-link disabled">Bienvenido ' . $_SESSION['type'] . ', ' . $_SESSION['nick'] . ' | </a>
            </li>';
        echo "<li class='nav-item'><a class='nav-link' href='#' onClick='xmlhttp3 = new XMLHttpRequest();
                xmlhttp3.open(\"GET\",\"ajax/UserNum.php?fun=logout&q=\"+new Date().getTime(),true);
                xmlhttp3.send();
                alert(\"Hasta otra!\");
                location.replace(\"logout.php\");'>Logout</a></li>";
        if ($_SESSION['foto'] == null) {
            echo "<li class='nav-item'><img src=\"images/unknown.png\" width=40px></li> ";
        } else {
            echo "<li class='nav-item'><img src=\"data:image/jpeg;base64," . base64_encode($_SESSION['foto']) . "\" width=40px></li> ";
        }

    } else {
        if ($selected == 1) {
            echo '<li class="nav-item active">
                   <a class="nav-link" href="Login.php">Iniciar sesión<span class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="Registro.php">Registro</a>
                            </li>';
        } elseif ($selected == 2) {
            echo '<li class="nav-item">
                    <a class="nav-link" href="Login.php">Iniciar sesión</a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="Registro.php">Registro<span class="sr-only">(current)</span></a>
                            </li>';
        } else {
            echo '<li class="nav-item">
                    <a class="nav-link" href="Login.php">Iniciar sesión</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="Registro.php">Registro</a>
                            </li>';
        }
    }
    echo '</ul>
            </div>
        </nav>';
}

function createSideBar($selected)
{
    echo '<div class="col-6 col-md-3 sidebar-offcanvas" id="sidebar">
            <div class="list-group">';
    if ($selected == 1) {
        echo '<a href="index.php" class="list-group-item active">Inicio</a>';
    } else {
        echo '<a href="index.php" class="list-group-item">Inicio</a>';
    }
    if(isset($_SESSION['user'])){
        if(strcmp($_SESSION['type'],'Alumno')==0) {
            if($selected == 4){
                echo "<a href='GestionPreguntas.php' class='list-group-item active'>Gestionar preguntas</a>";
            }else{
                echo "<a href='GestionPreguntas.php' class='list-group-item'>Gestionar preguntas</a>";
            }
        }else{
            if($selected == 5){
                echo "<a href='RevisarPreguntas.php' class='list-group-item active'>Revisar preguntas</a>";
            }else{
                echo "<a href='RevisarPreguntas.php' class='list-group-item'>Revisar preguntas</a>";
            }
        }
    }else {
        if ($selected == 2) {
            echo '<a href="ModoJuego.php" class="list-group-item active">Jugar</a>';
        } else {
            echo '<a href="ModoJuego.php" class="list-group-item">Jugar</a>';
        }
        if($selected == 6){
            echo '<a href="Ranking.php" class="list-group-item active">Ver Ranking</a>';
        } else {
            echo '<a href="Ranking.php" class="list-group-item">Ver Ranking</a>';
        }
    }
    if ($selected == 3) {
        echo '<a href="creditos.php" class="list-group-item active">Créditos</a>';
    } else {
        echo '<a href="creditos.php" class="list-group-item">Créditos</a>';
    }
    echo '</div>
        </div>';
}

function createFooter()
{
    echo '<footer class="footer">
            <div class="container">
                Sistemas web | 
                <a href="https://en.wikipedia.org/wiki/Quiz" target="_blank">Que es un Quiz?</a> |
                <a href="https://github.com/vawer/SW-Public" target="_blank">Link GITHUB</a>
            </div>
        </footer>';
}

?>