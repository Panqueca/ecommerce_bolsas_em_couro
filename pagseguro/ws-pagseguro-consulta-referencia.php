<?php

    $diretorioAPI = isset($_POST["diretorio_db"]) ? str_replace(" ", "", $_POST["diretorio_db"]) : "../@pew/";

    $console = isset($_POST["console"]) && $_POST["console"] == true ? true : false;
    $codigoReferencia = isset($_POST["codigo_referencia"]) ? $_POST["codigo_referencia"] : null;
    if($codigoReferencia != null){
        require "ws-pagseguro-config.php";
        
        $token = $pagseguro_config->get_token();
        $email = $pagseguro_config->get_email();
        
        
        
        $curl = curl_init();
    
        $urlBusca = "https://ws.pagseguro.uol.com.br/v2/transactions/?email=$email&token=$token&reference=$codigoReferencia";
        $charset = 'UTF-8';

        $options = array(
            CURLOPT_URL => $urlBusca,
            CURLOPT_HTTPHEADER => array(
                "Content-Type: application/x-www-form-urlencoded; charset=" . $charset
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => false,
            CURLOPT_SSL_VERIFYPEER => false,
        );

        curl_setopt_array($curl, $options);

        $xml = curl_exec($curl);

        curl_close($curl);

        //echo $xml; exit; // Depuracao caso precise

        $xml = simplexml_load_string($xml);
        
        $obj = $xml->transactions->transaction;
        
        $referencia = $obj->reference;
        $codigoTransacao = $obj->code;
        $codigoPagamento = $obj->paymentMethod->type;
        $statusPagseguro = $obj->status;
        
        // CONFIGURAVEL DE ACORDO COM O SISTEMA
        require "{$diretorioAPI}pew-system-config.php";
        require "{$diretorioAPI}@include-global-vars.php";
        global $globalVars;
        $tabela_pedidos = $globalVars{"tabela_pedidos"};
        
        mysqli_query($conexao, "update $tabela_pedidos set codigo_transacao = '$codigoTransacao', codigo_pagamento = '$codigoPagamento', status = '$statusPagseguro' where referencia = '$referencia'");
        
    }