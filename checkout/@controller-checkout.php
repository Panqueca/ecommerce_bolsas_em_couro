<?php

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    session_start();

    if(isset($_POST["acao"])){
        
        $acao = $_POST["acao"];
        
        require_once "@classe-checkout.php";
        
        $cls_checkout_acao = new Checkout();
        
        switch($acao){
            case "get_session_id":
                $sessionID = $cls_checkout_acao->set_pagseguro_session();
                echo $sessionID;
                break;
            case "get_view_checkout":
                $valorCarrinho = isset($_POST["valor_final"]) ? $_POST["valor_final"] : null;
                $metodosEnvio = isset($_POST["metodos_envio"]) ? $_POST["metodos_envio"] : null;
                $codigoTransporte = isset($_POST["codigo_transporte"]) ? $_POST["codigo_transporte"] : null;
                
                $valorTransporte = null;
                
                if($metodosEnvio != null && is_array($metodosEnvio)){
                    foreach($metodosEnvio as $infoTransporte){
                        $codigo = $infoTransporte["codigo"];
                        $valor = $infoTransporte["valor"];
                        if($codigo == $codigoTransporte){
                            $valorTransporte = $valor;
                        }
                    }
                }
                
                $info = $cls_checkout_acao->view_checkout($valorCarrinho, $valorTransporte, $codigoTransporte);
                break;
        }
    }

    $dataAtual = date("Y-m-d h:i:s");

    $sendDataForm = json_decode(file_get_contents('php://input'), true);

    if($sendDataForm != null){
        
        $enviarDados = true;
        
        function clear_number($cpf){
            return preg_replace("/[^0-9]/", "", $cpf);
        }
        
        function format_phone($type, $string){
            switch($type){
                case "ddd":
                    return substr($string, 0, 4);
                    break;
                default:
                    return substr($string, 4);
            }
        }
        
        require_once "../pagseguro/ws-pagseguro-config.php";
        $pagseguro['token'] = $pagseguro_config->get_token();
        $pagseguro['email'] = $pagseguro_config->get_email();
        
        // Standard
        $tokenCarrinho = isset($_SESSION["carrinho"]["token"]) ? $_SESSION["carrinho"]["token"] : "CTK" . substr(md5(time()), 0, 10);
        $pagseguro["senderHash"] = $sendDataForm["senderHash"];
        $pagseguro['reference'] = "RF".substr(md5(uniqid(time())), 0, 8); // REFERENCIA UNICA CRIADA PARA O PEDIDO
        $pagseguro['shippingType'] = 1;
        $pagseguro['shippingCost'] = $sendDataForm["shippingPrice"];
        $pagseguro['shippingAddressStreet'] = $sendDataForm["shippingAddressStreet"];
        $pagseguro['shippingAddressNumber'] = $sendDataForm["shippingAddressNumber"];
        $pagseguro['shippingAddressComplement'] = $sendDataForm["shippingAddressComplement"];
        $pagseguro['shippingAddressDistrict'] =  $sendDataForm["shippingAddressDistrict"];
        $pagseguro['shippingAddressPostalCode'] = $sendDataForm["shippingAddressPostalCode"];
        $pagseguro['shippingAddressCity'] = $sendDataForm["shippingAddressCity"];
        $pagseguro['shippingAddressState'] = $sendDataForm["shippingAddressState"];
        $pagseguro['shippingAddressCountry'] = "BRA";
        $pagseguro['currency'] = "BRL";
        
        // Produtos
        $ctrlProdutos = 1;
        foreach($sendDataForm["jsonProdutos"] as $infoProduto){
            $pagseguro["itemId$ctrlProdutos"] = $infoProduto["id"];
            $pagseguro["itemDescription$ctrlProdutos"] = $infoProduto["titulo"];
            $pagseguro["itemAmount$ctrlProdutos"] = $infoProduto["preco"];
            $pagseguro["itemQuantity$ctrlProdutos"] = $infoProduto["quantidade"];
            $ctrlProdutos++;
        }
        
        $pagseguro["paymentMethod"] = $sendDataForm["paymentMethod"];
        switch($sendDataForm["paymentMethod"]){
            case "creditCard":
                $sendDataForm["creditCardHolderCPF"] = clear_number($sendDataForm["creditCardHolderCPF"]);
                $sendDataForm["creditCardHolderAreaCode"] = clear_number(format_phone("ddd", $sendDataForm["creditCardHolderPhone"]));
                $sendDataForm["creditCardHolderPhone"] = clear_number(format_phone("number", $sendDataForm["creditCardHolderPhone"]));
                
                $pagseguro["creditCardHolderName"] = $sendDataForm["creditCardHolderName"];
                $pagseguro["creditCardHolderCPF"] = clear_number($sendDataForm["creditCardHolderCPF"]);
                $pagseguro["creditCardHolderBirthDate"] = $sendDataForm["creditCardHolderBirthDate"];
                $pagseguro["creditCardHolderAreaCode"] = $sendDataForm["creditCardHolderAreaCode"];
                $pagseguro["creditCardHolderPhone"] = $sendDataForm["creditCardHolderPhone"];
                $pagseguro["creditCardToken"] = $sendDataForm["creditCardToken"];
                break;
        }
        
        // Dados cliente
        if(isset($_SESSION["minha_conta"])){
            require_once "../@classe-minha-conta.php";
            $sessaoConta = $_SESSION["minha_conta"];
            
            $emailConta = isset($sessaoConta["email"]) ? $sessaoConta["email"] : null;
            $senhaConta = isset($sessaoConta["senha"]) ? $sessaoConta["senha"] : null;
            
            $loginConta = new MinhaConta();
            
            if($loginConta->auth($emailConta, $senhaConta) == true){
                $idConta = $loginConta->query_minha_conta("md5(email) = '$emailConta' and senha = '$senhaConta'");
                
                $loginConta->montar_minha_conta($idConta);
                $infoCliente = $loginConta->montar_array();
                
                $pagseguro["senderName"] = $infoCliente["usuario"];
                $pagseguro["senderCPF"] = $infoCliente["cpf"];
                $pagseguro["senderAreaCode"] = clear_number(format_phone("ddd", $infoCliente["celular"]));
                $pagseguro["senderPhone"] = clear_number(format_phone("number", $infoCliente["celular"]));
                $pagseguro["senderEmail"] = $infoCliente["email"];
                                                         
                $infoEndereco = $infoCliente["enderecos"];
                
                $pagseguro["billingAddressStreet"] = $infoEndereco["rua"];
                $pagseguro["billingAddressNumber"] = $infoEndereco["numero"];
                $pagseguro["billingAddressComplement"] = $infoEndereco["complemento"];
                $pagseguro["billingAddressDistrict"] = $infoEndereco["bairro"];
                $pagseguro["billingAddressState"] = $infoEndereco["estado"];
                $pagseguro["billingAddressCity"] = $infoEndereco["cidade"];
                $pagseguro["billingAddressPostalCode"] = $infoEndereco["cep"];
                $pagseguro["billingAddressCountry"] = "BR";
                
            }else{
                $enviarDados = false;
            }
        }else{
            $enviarDados = false;
        }
        
        // Parcelamento
        if(isset($sendDataForm["arrayInstallments"])){
            foreach($sendDataForm["arrayInstallments"] as $infoParcela){
                $quantity = $infoParcela["quantity"];
                $amount = $infoParcela["amount"];

                if($sendDataForm["selectedInstallment"] == $quantity){
                    $pagseguro["installmentQuantity"] = $quantity;
                    $pagseguro["installmentValue"] = $amount;
                }
            }
        }
        
        //print_r($pagseguro); exit();
        
        if($enviarDados){
            $curl = curl_init();
    
            $url = "https://ws.pagseguro.uol.com.br/v2/transactions/";
            $charset = 'UTF-8';

            $options = array(
                CURLOPT_URL => $url,
                CURLOPT_HTTPHEADER => array(
                    "Content-Type: application/x-www-form-urlencoded; charset=" . $charset
                ),
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HEADER => false,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_CONNECTTIMEOUT => 20,
                CURLOPT_POST => false,
                CURLOPT_POSTFIELDS => http_build_query($pagseguro),
            );

            curl_setopt_array($curl, $options);

            $xml = curl_exec($curl);

            curl_close($curl);

            //echo $xml; exit; // Depuracao caso precise

            $xml = simplexml_load_string($xml);

            if(count($xml->errors) == 0){

                if(isset($xml->error)){
                    
                    print_r($xml);
                    
                    echo "false";
                    
                }else{
                    require_once "../@pew/pew-system-config.php";
                    require_once "../@classe-system-functions.php";

                    $tabela_carrinhos = $pew_custom_db->tabela_carrinhos;
                    $tabela_pedidos = $pew_custom_db->tabela_pedidos;
                    $tabela_produtos = $pew_custom_db->tabela_produtos;
                    
                    $xmlProdutos = "";
                    
                    foreach($sendDataForm["jsonProdutos"] as $infoProduto){
                        $idProduto = $infoProduto["id"];
                        $tituloProduto = $infoProduto["titulo"];
                        $quantidadeProduto = $infoProduto["quantidade"];
                        $precoProduto = $infoProduto["preco"];
                        
                        mysqli_query($conexao, "insert into $tabela_carrinhos (token_carrinho, id_produto, nome_produto, quantidade_produto, preco_produto, data_controle, status) values ('$tokenCarrinho', '$idProduto', '$tituloProduto', '$quantidadeProduto', '$precoProduto', '$dataAtual', 1)");
                        
                        $xmlProdutos .= "<item><codigo>$idProduto</codigo><descricao>$tituloProduto</descricao><un>Un</un><qtde>$quantidadeProduto</qtde><vlr_unit>$precoProduto</vlr_unit></item>";
                    }
                    
                    $codigoTransacao = $xml->code;
                    $referencia = $xml->reference;
                    $statusPagamento = $xml->status;
                    $codigoPagamento = $xml->paymentMethod->type;
                    
                    $paymentLink = isset($xml->paymentLink) ? $xml->paymentLink : null;
                    
                    mysqli_query($conexao, "insert into $tabela_pedidos (codigo_confirmacao, codigo_transacao, codigo_transporte, vlr_frete, codigo_pagamento, codigo_rastreamento, payment_link, referencia, token_carrinho, id_cliente, nome_cliente, cpf_cliente, email_cliente, cep, rua, numero, complemento, bairro, cidade, estado, data_controle, status) values ('$codigoTransacao', '$codigoTransacao', '{$sendDataForm["shippingCode"]}', '{$pagseguro["shippingCost"]}', '$codigoPagamento', 0, '$paymentLink', '$referencia', '$tokenCarrinho', '$idConta', '{$pagseguro["senderName"]}', '{$pagseguro["senderCPF"]}', '{$pagseguro["senderEmail"]}', '{$pagseguro["billingAddressPostalCode"]}', '{$pagseguro["billingAddressStreet"]}', '{$pagseguro["billingAddressNumber"]}', '{$pagseguro["billingAddressComplement"]}', '{$pagseguro["billingAddressDistrict"]}', '{$pagseguro["billingAddressCity"]}', '{$pagseguro["billingAddressState"]}', '$dataAtual', '$statusPagamento')");
                    
                    $queryID = mysqli_query($conexao, "select last_insert_id()");
                    $infoData = mysqli_fetch_array($queryID);
                    $idPedido = $infoData["last_insert_id()"];
                    
                    switch($statusPagamento){
                        case 3:
                            $resposta = "pago";
                            break;
                        case 4:
                            $resposta = "pago";
                            break;
                        case 6:
                            $resposta = "cancelado";
                            break;
                        case 7:
                            $resposta = "cancelado";
                            break;
                        default:
                            $resposta = "aguardando";
                    }
                    
                    if($paymentLink != null){
                        $resposta = '{"paymentLink": "'.$paymentLink.'"}';
                    }
                    
                    //print_r($xml); exit;
                    echo $resposta;
                    
                    // GRAVAR NO BLING
                    
                    switch($sendDataForm["shippingCode"]){
                        case "7777":
                            $strTransporte = "Retirada na Loja";
                            break;
                        case "8888":
                            $strTransporte = "Motoboy";
                            break;
                        case "40010":
                            $strTransporte = "SEDEX";
                            break;
                        case "40215":
                            $strTransporte = "SEDEX 10";
                            break;
                        case "40290":
                            $strTransporte = "SEDEX Hoje";
                            break;
                        default:
                            $strTransporte = "PAC";
                    }
                    
                    $url = 'https://bling.com.br/Api/v2/pedido/json/';
        
                    function executeSendOrder($url, $data){
                        $curl_handle = curl_init();
                        curl_setopt($curl_handle, CURLOPT_URL, $url);
                        curl_setopt($curl_handle, CURLOPT_POST, count($data));
                        curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data);
                        curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
                        $response = curl_exec($curl_handle);
                        curl_close($curl_handle);
                        return $response;
                    }

                    $infoPedido = "
                    <numero>$idPedido</numero>
                    <cliente>
                        <nome>{$pagseguro['senderName']}</nome>
                        <cpf_cnpj>{$pagseguro['senderCPF']}</cpf_cnpj>
                        <email>{$pagseguro['senderEmail']}</email>
                        <tipoPessoa>J</tipoPessoa>
                        <endereco>{$pagseguro['shippingAddressStreet']}</endereco>
                        <numero>{$pagseguro['shippingAddressNumber']}</numero>
                        <complemento>{$pagseguro['shippingAddressComplement']}</complemento>
                        <bairro>{$pagseguro['shippingAddressDistrict']}</bairro>
                        <cep>{$pagseguro['shippingAddressPostalCode']}</cep>
                        <cidade>{$pagseguro['shippingAddressCity']}</cidade>
                        <uf>{$pagseguro['shippingAddressState']}</uf>
                    </cliente>
                    <transporte>
                        <transportadora>$strTransporte</transportadora>
                        <tipo_frete>R</tipo_frete>
                        <servico_correios>$strTransporte</servico_correios>
                        <dados_etiqueta>
                            <nome>Endereço de entrega</nome>
                            <endereco>{$pagseguro['shippingAddressStreet']}</endereco>
                            <numero>{$pagseguro['shippingAddressNumber']}</numero>
                            <complemento>{$pagseguro['shippingAddressComplement']}</complemento>
                            <municipio>{$pagseguro['shippingAddressCity']}</municipio>
                            <uf>{$pagseguro['shippingAddressState']}</uf>
                            <cep>{$pagseguro['shippingAddressPostalCode']}</cep>
                            <bairro>{$pagseguro['shippingAddressDistrict']}</bairro>
                        </dados_etiqueta>
                    </transporte>
                    <vlr_frete>{$pagseguro["shippingCost"]}</vlr_frete>
                    <vendedor>Site - Bolsas em Couro</vendedor>
                    <itens>
                        $xmlProdutos
                    </itens>";

                    $xmlPedido = "<pedido>$infoPedido</pedido>";

                    $posts = array (
                        "apikey" => "a0d67ab3925a9df897d78510a6ccf847dfdfb78dfd78641cb1504e8de0a311eab831c42b",
                        "xml" => rawurlencode($xmlPedido)
                    );

                    $retorno = executeSendOrder($url, $posts);

                    //echo $retorno;
                    // END GRAVAR NO BLING
                }

            }else{
                //print_r($xml->errors);
                echo "false";
            }
            
        }else{
            echo "false";
        }
    }