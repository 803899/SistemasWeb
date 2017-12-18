<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: error.php");
}else{
    if (!(strcmp($_SESSION['type'], "Alumno")==0)) {
        header("Location: error.php");
    }
}
    $xslDoc = new DOMDocument();
    $xslDoc->load("../xml/VerPreguntas.xsl");
    $xmlDoc = new DOMDocument();
    $xmlDoc->load("../xml/preguntas.xml");
    $proc = new XSLTProcessor();
    $proc->importStylesheet($xslDoc);
    echo $proc->transformToXML($xmlDoc);
?>