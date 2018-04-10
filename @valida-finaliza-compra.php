<?php
    $jsonData = json_decode(file_get_contents('php://input'), true);
    if($jsonData != null){
        $codigoCorreios = isset($jsonData["codigo_correios"]) ? $jsonData["codigo_correios"] : null;
        $cepDestino = isset($jsonData["cep_destino"]) ? $jsonData["cep_destino"] : null;
        $produtos = isset($jsonData["produtos"]) ? json_decode($jsonData["produtos"]) : null;
        $idEndereco = isset($jsonData["id_endereco"]) ? $jsonData["id_endereco"] : null;
        
        if($cepDestino != null && $produtos != null){
            $_POST["cep_destino"] = $cepDestino;
            $_POST["id_endereco"] = $idEndereco;
            $_POST["produtos"] = array();
            $i = 0;
            foreach($produtos as $objItem){
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
        }
        
        
        if($codigoCorreios != null) $_POST["codigo_correios"] = $codigoCorreios;
    }

    $post_fields = array("cep_destino", "produtos", "id_endereco");
    $invalid_fileds = array();
    $finalizar = true;
    $i = 0;
    foreach($post_fields as $post_name){
        if(!isset($_POST[$post_name])){
            $finalizar = false;
            $i++;
            $invalid_fileds[$i] = $post_name;
        }
    }

    if($finalizar){
        require_once "@classe-system-functions.php";
        require_once "frete-correios/calcular-frete.php";

        $codigoCorreios = isset($_POST["codigo_correios"]) ? $_POST["codigo_correios"] : "41106";
        
        $cepDestino = str_replace("-", "", $_POST["cep_destino"]);
        
        $idEndereco = $_POST["id_endereco"];
        
        $declararValor = isset($_POST["declarar_valor"]) ? $_POST["declarar_valor"] : false;

        $produtos = is_array($_POST["produtos"]) ? $_POST["produtos"] : array();
        
        $url_correios_api = 'localhost/xampp/github/ecommerce_bolsas_em_couro/frete-correios/ws-correios.php';
        
        $infoFrete = frete($produtos, $codigoCorreios, $cepDestino, $declararValor, $url_correios_api);
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
                require_once "@classe-enderecos.php";
                $loginConta = new MinhaConta();
                if($loginConta->auth($emailConta, $senhaConta) == true){
                    $idConta = $loginConta->query_minha_conta("md5(email) = '$emailConta' and senha = '$senhaConta'");
                    $loginConta->montar_minha_conta($idConta);
                    $infoConta = $loginConta->montar_array();
                    $endereco = new Enderecos();
                    $endereco->montar_endereco("id = '$idEndereco'");
                    $infoEndereco = $endereco->montar_array();
                    
                    $cep = $infoEndereco["cep"];
                    $rua = $infoEndereco["rua"];
                    $numero = $infoEndereco["numero"];
                    $complemento = $infoEndereco["complemento"];
                    $bairro = $infoEndereco["bairro"];
                    $estado = $infoEndereco["estado"];
                    $cidade = $infoEndereco["cidade"];
                    
                    $dadosCompra = [
                        'cep' => $cep,
                        'rua' => $rua,
                        'complemento' => $complemento,
                        'numero' => $numero,
                        'bairro' => $bairro,
                        'cidade' => $cidade,
                        'estado' => $estado,
                        'codigo_correios' => $codigoCorreios,
                        'valor_frete' => $valorFrete,
                        'carrinho' => http_build_query($produtos),
                    ];
                    
                    $dadosCompra = http_build_query($dadosCompra);
                    
                    $url_api_pagseguro = "localhost/xampp/github/ecommerce_bolsas_em_couro/@ws-pagseguro.php";

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $url_api_pagseguro);
                    curl_setopt($ch, CURLOPT_POST, true);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $dadosCompra);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                    $response = curl_exec($ch);
                    
                    echo $response;
                }else{
                    echo "false";
                }   
            }
        }else{
            echo "false";
        }
    }else{
        //print_r($invalid_fileds);
        echo "false";
    }
?>