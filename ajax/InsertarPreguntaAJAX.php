<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: error.php");
} else {
    if (!(strcmp($_SESSION['type'], "Alumno") == 0)) {
        header("Location: error.php");
    }
}

$Email = $_GET["email"];
$Pregunta = $_GET["pregunta"];
$Correcta = $_GET["correcta"];
$Incorrecta1 = $_GET["incorrecta1"];
$Incorrecta2 = $_GET["incorrecta2"];
$Incorrecta3 = $_GET["incorrecta3"];
$Complejidad = $_GET["complejidad"];
$Subject = $_GET["subject"];
$pattern = '/^([a-z]+[0-9]{3})+\@((ikasle)+\.)+((ehu)+\.)+((es)|(eus))+$/';
if (preg_match($pattern, $Email) == 0) {
    die('Email incorrecto<br><a href="javascript:history.back()">Volver</a>');
}
if (empty($Pregunta)) {
    die('La pregunta no puede estar vacía<br><a href="javascript:history.back()">Volver</a>');
}
if (empty($Correcta)) {
    die('La respuesta correcta no puede estar vacía<br><a href="javascript:history.back()">Volver</a>');
}
if (empty($Incorrecta1)) {
    die('La respuesta incorrecta 1 no puede estar vacía<br><a href="javascript:history.back()">Volver</a>');
}
if (empty($Incorrecta2)) {
    die('La respuesta incorrecta 2 no puede estar vacía<br><a href="javascript:history.back()">Volver</a>');
}
if (empty($Incorrecta3)) {
    die('La respuesta incorrecta 3 no puede estar vacía<br><a href="javascript:history.back()">Volver</a>');
}
$pattern2 = '/^([1-5]{1})+$/';
if (preg_match($pattern2, $Complejidad) == 0) {
    die('La complejidad es incorrecta<br><a href="javascript:history.back()">Volver</a>');
}


$mysqli = mysqli_connect("localhost", "id3131583_swg12", "veskojulen", "id3131583_quiz");
if (!$mysqli) {
    echo "Fallo al conectar a MySQL: " . $mysqli->connect_error;
}

$Query = "INSERT INTO preguntas(eMail,Enunciado,Correcta,Incorrecta1,Incorrecta2,Incorrecta3,Complejidad,Tema)
     VALUES ('$Email','$Pregunta','$Correcta','$Incorrecta1','$Incorrecta2','$Incorrecta3','$Complejidad','$Subject')";
if (mysqli_query($mysqli, $Query)) {
    echo "Pregunta agregada correctamente a la base de datos.";
    echo '<br><a href="VerPreguntasConFoto.php?useremail=' . $Email . '">Ver preguntas</a>';

    $preguntas = simplexml_load_file('../xml/preguntas.xml');
    if ($preguntas == false) {
        echo "Error abriendo el archivo xml.";
    } else {
        $pregunta = $preguntas->addChild('assessmentItem');
        $pregunta->addAttribute('complexity', $Complejidad);
        $pregunta->addAttribute('subject', $Subject);
        $pregunta->addAttribute('author', $Email);

        $pregunta->addChild('itemBody')->addChild('p', $Pregunta);
        $pregunta->addChild('correctResponse')->addChild('value', $Correcta);
        $incorrect = $pregunta->addChild('incorrectResponses');
        $incorrect->addChild('value', $Incorrecta1);
        $incorrect->addChild('value', $Incorrecta2);
        $incorrect->addChild('value', $Incorrecta3);

        $domxml = new DOMDocument('1.0');
        $domxml->preserveWhiteSpace = false;
        $domxml->formatOutput = true;
        $domxml->loadXML($preguntas->asXML());
        $domxml->save('../xml/preguntas.xml');
        //$preguntas->asXML('xml/preguntas.xml');
        echo '<br>Pregunta agregada correctamente al archivo xml.';
        echo '<br><a href="../xml/preguntas.xml">Abrir xml</a>';
    }

} else {
    echo "ERROR: Could not able to execute $Query. " . mysqli_error($mysqli);
}
mysqli_close($mysqli);
?>