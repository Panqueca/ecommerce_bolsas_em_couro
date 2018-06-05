<?php
    
    require "ws-pagseguro-config.php";

    $token = $pagseguro_config->get_token();
    $email = $pagseguro_config->get_email();

    $responseSessionID = "unauthorized";

    $curl = curl_init();

    $urlBusca = "https://ws.pagseguro.uol.com.br/v2/sessions/";

    $auth = array(
        "email" => $email,
        "token" => $token,
    );

    $options = array(
        CURLOPT_URL => $urlBusca,
        CURLOPT_URL => $urlBusca,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HEADER => false,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_POSTFIELDS => http_build_query($auth),
    );

    curl_setopt_array($curl, $options);

    $xml = curl_exec($curl);

    curl_close($curl);

    //echo $xml; exit; // Depuracao caso precise

    $xml = simplexml_load_string($xml);

    if(is_object($xml)){
        $getSession = isset($xml->id) ? true : false;
        if($getSession){
            $responseSessionID = $xml->id;
        }
    }