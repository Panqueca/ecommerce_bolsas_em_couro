<?php

    if(isset($_POST["notificationCode"])){
        require_once "ws-pagseguro-config.php";
        
        $token = $pagseguro_config->get_token();
        $email = $pagseguro_config->get_email();
        $codigo_notificacao = $_POST["notificationCode"];
        
        $urlBusca = "https://ws.pagseguro.uol.com.br/v2/transactions/notifications/$codigo_notificacao?email=$email&token=$token";
        
        
        $curl = curl_init($urlBusca);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $http = curl_getinfo($curl);

        if($response == 'Unauthorized'){
            print_r($response);
            exit;
        }
        
        curl_close($curl);
        $response = simplexml_load_string($response);

        if(count($response->error) > 0){
            print_r($response);
            exit;
        }
        
        $referencia = $response->reference;
        $codigoTransacao = $response->code;
        $codigoPagamento = $response->paymentMethod->code;
        
        // CONFIGURAVEL DE ACORDO COM O SISTEMA
        require_once "../@pew/pew-system-config.php";
        $tabela_pedidos = $pew_custom_db->tabela_pedidos;
        
        mysqli_query($conexao, "update $tabela_pedidos set codigo_transacao = '$codigoTransacao', codigo_pagamento = '$codigoPagamento' where referencia = '$referencia'");
        
        
    }