<?php
    $jsonData = json_decode(file_get_contents('php://input'), true);
    if($jsonData != null){
        $codigoTransporte = isset($jsonData["codigo_transporte"]) ? $jsonData["codigo_transporte"] : null;
        
        $cepDestino = isset($jsonData["cep_destino"]) ? $jsonData["cep_destino"] : null;
        $ruaDestino = isset($jsonData["rua_destino"]) ? $jsonData["rua_destino"] : null;
        $numeroDestino = isset($jsonData["numero_destino"]) ? $jsonData["numero_destino"] : null;
        $complementoDestino = isset($jsonData["complemento_destino"]) ? $jsonData["complemento_destino"] : null;
        $bairroDestino = isset($jsonData["bairro_destino"]) ? $jsonData["bairro_destino"] : null;
        $cidadeDestino = isset($jsonData["cidade_destino"]) ? $jsonData["cidade_destino"] : null;
        $estadoDestino = isset($jsonData["estado_destino"]) ? $jsonData["estado_destino"] : null;
        
        $infoCarrinho = isset($jsonData["produtos"]) ? json_decode($jsonData["produtos"]) : null;
        
        if($cepDestino != null && $infoCarrinho != null){
            $_POST["cep_destino"] = $cepDestino;
            $_POST["rua_destino"] = $ruaDestino;
            $_POST["numero_destino"] = $numeroDestino;
            $_POST["complemento_destino"] = $complementoDestino;
            $_POST["bairro_destino"] = $bairroDestino;
            $_POST["cidade_destino"] = $cidadeDestino;
            $_POST["estado_destino"] = $estadoDestino;
            $_POST["produtos"] = array();
            $i = 0;
            
            $infoCarrinho = (array)$infoCarrinho;
            foreach($infoCarrinho["itens"] as $objItem){
                $item = (array)$objItem;
                $_POST["produtos"][$i] = array();
                $_POST["produtos"][$i]["id"] = $item["id"];
                $_POST["produtos"][$i]["titulo"] = $item["nome"];
                $_POST["produtos"][$i]["preco"] = $item["preco"];
                $_POST["produtos"][$i]["estoque"] = $item["estoque"];
                $_POST["produtos"][$i]["quantidade"] = $item["quantidade"];
                $_POST["produtos"][$i]["comprimento"] = $item["comprimento"];
                $_POST["produtos"][$i]["largura"] = $item["largura"];
                $_POST["produtos"][$i]["altura"] = $item["altura"];
                $_POST["produtos"][$i]["peso"] = $item["peso"];
                $i++;
            }
            
            $tokenCarrinho = $infoCarrinho["token"];
        }
        
        
        if($codigoTransporte != null) $_POST["codigo_transporte"] = $codigoTransporte;
    }

    $post_fields = array("cep_destino", "produtos");
    $invalid_fields = array();
    $finalizar = true;
    $i = 0;
    foreach($post_fields as $post_name){
        if(!isset($_POST[$post_name])){
            $finalizar = false;
            $i++;
            $invalid_fields[$i] = $post_name;
        }
    }

    if($finalizar){
        require_once "@classe-system-functions.php";
        require_once "frete-correios/calcular-frete.php";
        
        $baseSite = "https://www.lareobra.com.br/dev/";
        /*$baseSite = "localhost/xampp/github/projeto-lareobra/";*/
        $pastaCorreios = "frete-correios/ws-correios.php";
        $pastaPagseguro = "pagseguro/ws-pagseguro.php";

        $codigoTransporte = isset($_POST["codigo_transporte"]) ? $_POST["codigo_transporte"] : "41106";
        
        $cepDestino = str_replace("-", "", $_POST["cep_destino"]);
        $ruaDestino = isset($_POST["rua_destino"]) ? $_POST["rua_destino"] : null;
        $numeroDestino = isset($_POST["numero_destino"]) ? $_POST["numero_destino"] : null;
        $complementoDestino = isset($_POST["complemento_destino"]) ? $_POST["complemento_destino"] : null;
        $bairroDestino = isset($_POST["bairro_destino"]) ? $_POST["bairro_destino"] : null;
        $cidadeDestino = isset($_POST["cidade_destino"]) ? $_POST["cidade_destino"] : null;
        $estadoDestino = isset($_POST["estado_destino"]) ? $_POST["estado_destino"] : null;
        
        
        $declararValor = isset($_POST["declarar_valor"]) ? $_POST["declarar_valor"] : false;

        $produtos = is_array($_POST["produtos"]) ? $_POST["produtos"] : array();
        
        $url_correios_api = $baseSite.$pastaCorreios;
        
        //$infoFrete = frete($produtos, $codigoTransporte, $cepDestino, $declararValor, $url_correios_api);
        
        $_POST["no_console"] = true;
        
        require_once "@calcular-transporte.php";
        
        if($infoFrete != false && $produtos != false){
            
            $valorFrete = null;
            $prazoFrete = null;
            
            $infoFrete = json_decode($infoFrete);
            foreach($infoFrete as $chave => $val){
                if($chave == "valor"){
                    $valorFrete = $pew_functions->custom_number_format($val);
                }
                if($chave == "prazo"){
                    $prazoFrete = $val;   
                }
            }
            session_start();
            if(isset($_SESSION["minha_conta"])){
                $sessaoConta = $_SESSION["minha_conta"];
                $emailConta = isset($sessaoConta["email"]) ? $sessaoConta["email"] : null;
                $senhaConta = isset($sessaoConta["senha"]) ? $sessaoConta["senha"] : null;
                require_once "@classe-minha-conta.php";
                $loginConta = new MinhaConta();
                if($loginConta->auth($emailConta, $senhaConta) == true){
                    
                    $idConta = $loginConta->query_minha_conta("md5(email) = '$emailConta' and senha = '$senhaConta'");   
                    
                    $dadosCompra = [
                        'cep' => $cepDestino,
                        'rua' => $ruaDestino,
                        'complemento' => $complementoDestino,
                        'numero' => $numeroDestino,
                        'bairro' => $bairroDestino,
                        'cidade' => $cidadeDestino,
                        'estado' => $estadoDestino,
                        'codigo_transporte' => $codigoTransporte,
                        'valor_frete' => $valorFrete,
                        'carrinho' => http_build_query($produtos),
                    ];
                    
                    $url_api_pagseguro = $baseSite.$pastaPagseguro;

                    $charset = "UTF-8";
                    
                    $curl = curl_init();
                    $options = array(
                        CURLOPT_URL => $url_api_pagseguro,
                        CURLOPT_HTTPHEADER => array(
                            "Content-Type: application/x-www-form-urlencoded; charset=" . $charset
                        ),
                        CURLOPT_RETURNTRANSFER => true,
                        CURLOPT_HEADER => false,
                        CURLOPT_SSL_VERIFYPEER => false,
                        CURLOPT_CONNECTTIMEOUT => 20,
                        CURLOPT_POST => false,
                        CURLOPT_POSTFIELDS => http_build_query($dadosCompra),
                    );
                    
                    curl_setopt_array($curl, $options);

                    $response = curl_exec($curl);
                    $total = count(json_decode($response));
                    
                    if($total > 0){
                        
                        echo $response; // RESPOSTA DO CODIGO PAGSEGURO E REFERENCIA PEDIDO
                        
                    }else{
                        echo $response;
                    }
                    
                    
                }else{
                    echo "false";
                }   
            }
        }else{
            echo "false";
        }
    }else{
        print_r($invalid_fields);
        //echo "false";
    }
?>