<?php
    require_once('../nusoap-master/src/nusoap.php');

    $soapclient = new nusoap_client( 'http://swg12.000webhostapp.com/servicios/ComprobarPassword.php?wsdl', true);

    if (isset($_GET['password'])){
        echo $soapclient->call('comprobarPassword',array( 'pass'=>$_GET['password']));
    }
?>