<?php

    $diretorio_api = isset($_POST["diretorio_db"]) ? str_replace(" ", "", $_POST["diretorio_db"]) : "../@pew/";

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
        
        if(is_object($xml)){
            $getData = isset($xml->resultsInThisPage) && $xml->resultsInThisPage == 0 ? false : true;
            if($getData){
                $obj = $xml->transactions->transaction;

                $referencia = $obj->reference;
                $codigoTransacao = $obj->code;
                $codigoPagamento = $obj->paymentMethod->type;
                $statusPagseguro = $obj->status;

                // CONFIGURAVEL DE ACORDO COM O SISTEMA
                require "{$diretorio_api}pew-system-config.php";
                require "{$diretorio_api}@include-global-vars.php";
                global $globalVars;
                $tabela_pedidos = $globalVars{"tabela_pedidos"};

                mysqli_query($conexao, "update $tabela_pedidos set codigo_transacao = '$codigoTransacao', codigo_pagamento = '$codigoPagamento', status = '$statusPagseguro' where referencia = '$referencia'");
                
                
                // UPDATE BLING STATUS
                function executeUpdateOrder($url, $data){
                    $curl_handle = curl_init();
                    
                    curl_setopt($curl_handle, CURLOPT_URL, $url);
                    curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, 'PUT');
                    curl_setopt($curl_handle, CURLOPT_POST, count($data));
                    curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data);
                    curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
                    
                    $response = curl_exec($curl_handle);
                    curl_close($curl_handle);
                    return $response;
                }
                
                $tabela_pedidos = $pew_custom_db->tabela_pedidos;
                
                $queryId = mysqli_query($conexao, "select id from $tabela_pedidos where referencia = '$codigoReferencia'");
                $infoP = mysqli_fetch_array($queryId);
                $getIdPedido = $infoP["id"];
                
                switch($statusPagseguro){
                    case 1:
                        $statusBling = 0;
                        break;
                    case 2:
                        $statusBling = 10;
                        break;
                    case 3:
                        $statusBling = 4;
                        break;
                    case 4:
                        $statusBling = 4;
                        break;
                    case 5:
                        $statusBling = 2;
                        break;
                    case 6:
                        $statusBling = 2;
                        break;
                    case 7:
                        $statusBling = 2;
                        break;
                    default:
                        $statusBling = 0;
                }
                
                $urlUpdateStatus = "https://bling.com.br/Api/v2/pedido/$getIdPedido/json";
                $xmlPedido = "<pedido><situacao>$statusBling</situacao></pedido>";
                $dataPostPedido = array (
                    'apikey' => 'a0d67ab3925a9df897d78510a6ccf847dfdfb78dfd78641cb1504e8de0a311eab831c42b',
                    'xml' => rawurlencode($xmlPedido)
                );
                
                $retorno = executeUpdateOrder($urlUpdateStatus, $dataPostPedido);
                // END UPDATE BLING STATUS
            }
        }
        
    }