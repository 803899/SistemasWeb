<?php

    require_once('../nusoap-master/src/nusoap.php');
    function comprobarPassword($pass) {
        $filename = "toppasswords.txt";
        $fp = fopen($filename, 'r');

        while(!feof($fp)){
            $line = fgets($fp);
            if(strstr($line, $pass)){
                return "INVALIDA";
            }
        }
        return "VALIDA";
    }

    $server = new soap_server();
    $server->configureWSDL("ComprobarPassword", "urn:ComprobarPassword");

    $server->register("comprobarPassword",
        array("pass" => "xsd:string"),
        array("return" => "xsd:string"),
        "urn:ComprobarPassword",
        "urn:ComprobarPassword#comprobarPassword",
        "rpc",
        "encoded",
        "Nos dice si la contrasenia es valida o invalida");

    if ( !isset( $HTTP_RAW_POST_DATA ) ) $HTTP_RAW_POST_DATA =file_get_contents( 'php://input' );
    $server->service($HTTP_RAW_POST_DATA);
?>