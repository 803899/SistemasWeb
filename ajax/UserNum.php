<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: error.php");
}
$numero = simplexml_load_file('../xml/numusuarios.xml');
if ($numero == false) {
    echo "Error abriendo el archivo xml.";
} else {
    if (isset($_GET['fun'])) {
        $fun = $_GET['fun'];
        if (strcmp($fun, "enter") == 0) {
            $numero[0] = $numero + 1;
            echo $numero -1;
            $numero->asXML('../xml/numusuarios.xml');
        } elseif (strcmp($fun, "logout") == 0) {
            $numero[0] = $numero - 1;
            $numero->asXML('../xml/numusuarios.xml');
        } elseif (strcmp($fun, "consulta") == 0) {
            echo $numero -1;
        }
    }
}
?>