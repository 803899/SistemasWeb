<?php
    require_once('../nusoap-master/src/nusoap.php');
    function ObtenerPregunta($id) {
        $mysqli = mysqli_connect("localhost", "id3131583_swg12", "veskojulen", "id3131583_quiz");
        if(!$mysqli) {
            return "Fallo al conectar a MySQL: " . $mysqli->connect_error;
        }
        $Query = "SELECT Enunciado, Correcta, Complejidad FROM preguntas WHERE ID='$id'";
        $res = mysqli_query($mysqli, $Query);
        $done = 0;
        while($row = mysqli_fetch_array($res)) {
            $array = array("enunciado" => $row['Enunciado'], "respuesta" => $row['Correcta'], "complejidad" => $row['Complejidad']);
            $done = 1;
        }
        mysqli_close($mysqli);
        if($done == 0){
            $array = array("enunciado" => "", "respuesta" => "", "complejidad" => 0);
        }
        return $array;
    }

    $server = new soap_server();
    $server->configureWSDL("ObtenerPreguntaSW", "urn:ObtenerPreguntaSW");

    $server->register("ObtenerPregunta",
        array("id" => "xsd:int"),
        array("enunciado" => "xsd:string", "respuesta" => "xsd:string", "complejidad" => "xsd:int"),
        "urn:ObtenerPreguntaSW",
        "urn:ObtenerPreguntaSW#ObtenerPregunta",
        "rpc",
        "encoded",
        "Dado el id de una pregunta se devuelve el enunciado, la respuesta correcta y la complejidad.");

    if ( !isset( $HTTP_RAW_POST_DATA ) ) $HTTP_RAW_POST_DATA =file_get_contents( 'php://input' );
    $server->service($HTTP_RAW_POST_DATA);
?>