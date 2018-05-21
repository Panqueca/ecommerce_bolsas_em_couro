<?php

    $jsonData = json_decode(file_get_contents('php://input'), true);
    if($jsonData != null){
        $_POST["token_carrinho"] = $jsonData["token_carrinho"];
        $_POST["itens_carrinho"] = $jsonData["itens_carrinho"];
        $_POST["codigo_confirmacao"] = $jsonData["codigo_confirmacao"];
        $_POST["codigo_transacao"] = $jsonData["codigo_transacao"];
        $_POST["codigo_transporte"] = $jsonData["codigo_transporte"];
        $_POST["referencia"] = $jsonData["referencia"];
        $_POST["id_cliente"] = $jsonData["id_cliente"];
        $_POST["nome_cliente"] = $jsonData["nome_cliente"];
        $_POST["cpf_cliente"] = $jsonData["cpf_cliente"];
        $_POST["email_cliente"] = $jsonData["email_cliente"];
        $_POST["cep"] = $jsonData["cep"];
        $_POST["rua"] = $jsonData["rua"];
        $_POST["numero"] = $jsonData["numero"];
        $_POST["complemento"] = $jsonData["complemento"];
        $_POST["bairro"] = $jsonData["bairro"];
        $_POST["cidade"] = $jsonData["cidade"];
        $_POST["estado"] = $jsonData["estado"];
        $_POST["vlr_frete"] = $jsonData["vlr_frete"];

    }

    $post_fields = array("token_carrinho", "itens_carrinho", "codigo_confirmacao", "codigo_transacao", "codigo_transporte", "id_cliente", "nome_cliente", "cpf_cliente", "email_cliente", "cep", "rua", "numero", "complemento", "bairro", "cidade", "estado");
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
        require_once "@pew/pew-system-config.php";
        require_once "@classe-system-functions.php";
        
        $tabela_carrinhos = $pew_custom_db->tabela_carrinhos;
        $tabela_pedidos = $pew_custom_db->tabela_pedidos;
        $tabela_produtos = $pew_custom_db->tabela_produtos;
        
        $dataAtual = date("Y-m-d H:i:s");
        $codigoPagamento = 0;
        
        $totalCarrinho = $pew_functions->contar_resultados($tabela_carrinhos, "token_carrinho = '{$_POST["token_carrinho"]}'");
        if($totalCarrinho > 0){
            mysqli_query($conexao, "delete from $tabela_carrinhos where token_carrinho = '{$_POST["token_carrinho"]}'");
        }
        
        $xmlItens = "";
        
        $totalPedido = 0;
        $totalBruto = 0;
        $descontoFinal = 0;
        foreach($_POST["itens_carrinho"] as $infoProduto){ // Insere todos os produtos finalizados da compra
            $idProduto = $infoProduto["id"];
            $tituloProduto = $infoProduto["titulo"];
            $quantidadeProduto = $infoProduto["quantidade"];
            $precoProduto = $infoProduto["preco"];
            mysqli_query($conexao, "insert into $tabela_carrinhos (token_carrinho, id_produto, nome_produto, quantidade_produto, preco_produto, data_controle, status) values ('{$_POST["token_carrinho"]}', '$idProduto', '$tituloProduto', '$quantidadeProduto', '$precoProduto', '$dataAtual', 1)");
            
            $queryInfo = mysqli_query($conexao, "select sku, preco from $tabela_produtos where id = '$idProduto'");
            $info = mysqli_fetch_array($queryInfo);
            $skuProduto = $info["sku"];
            $precoAtual = $info["preco"];
            
            $totalPedido += $precoProduto;
            $totalBruto += $precoAtual;
            
        }
        $descontoFinal = $totalBruto - $totalPedido;
        
        mysqli_query($conexao, "insert into $tabela_pedidos (codigo_confirmacao, codigo_transacao, codigo_transporte, vlr_frete, codigo_pagamento, codigo_rastreamento, referencia, token_carrinho, id_cliente, nome_cliente, cpf_cliente, email_cliente, cep, rua, numero, complemento, bairro, cidade, estado, data_controle, status) values ('{$_POST["codigo_confirmacao"]}', '{$_POST["codigo_transacao"]}', '{$_POST["codigo_transporte"]}', '{$_POST["vlr_frete"]}', '$codigoPagamento', 0, '{$_POST["referencia"]}', '{$_POST["token_carrinho"]}', '{$_POST["id_cliente"]}', '{$_POST["nome_cliente"]}', '{$_POST["cpf_cliente"]}', '{$_POST["email_cliente"]}', '{$_POST["cep"]}', '{$_POST["rua"]}', '{$_POST["numero"]}', '{$_POST["complemento"]}', '{$_POST["bairro"]}', '{$_POST["cidade"]}', '{$_POST["estado"]}', '$dataAtual', 0)");

        
        switch($_POST["codigo_transporte"]){
            case "40010":
                $strTransporte = "Correios - SEDEX";
                break;
            case "40215":
                $strTransporte = "Correios - SEDEX 10";
                break;
            case "40290":
                $strTransporte = "Correios - SEDEX Hoje";
                break;
            default:
                $strTransporte = "Correios - PAC";
        }
        
        // GRAVAR NO BLING
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
            <nome>{$_POST['nome_cliente']}</nome>
            <cpf_cnpj>{$_POST['cpf_cliente']}</cpf_cnpj>
            <email>{$_POST['email_cliente']}</email>
            <tipoPessoa>J</tipoPessoa>
            <endereco>{$_POST['rua']}</endereco>
            <numero>{$_POST['numero']}</numero>
            <complemento>{$_POST['complemento']}</complemento>
            <bairro>{$_POST['bairro']}</bairro>
            <cep>{$_POST['cep']}</cep>
            <cidade>{$_POST['cidade']}</cidade>
            <uf>{$_POST['estado']}</uf>
        </cliente>
        <transporte>
            <transportadora>$strTransporte</transportadora>
            <tipo_frete>R</tipo_frete>
            <servico_correios>$strTransporte</servico_correios>
            <dados_etiqueta>
                <nome>Endereço de entrega</nome>
                <endereco>{$_POST['rua']}</endereco>
                <numero>{$_POST['numero']}</numero>
                <complemento>{$_POST['complemento']}</complemento>
                <municipio>{$_POST['cidade']}</municipio>
                <uf>{$_POST['estado']}</uf>
                <cep>{$_POST['cep']}</cep>
                <bairro>{$_POST['bairro']}</bairro>
            </dados_etiqueta>
        </transporte>
        <vlr_frete>{$_POST["vlr_frete"]}</vlr_frete>
        <vlr_desconto>$descontoFinal</vlr_desconto>
        <vendedor>Site - Bolsas em Couro</vendedor>
        <itens>
            $xmlItens
        </itens>";
        
        $xmlPedido = "<pedido>$infoPedido</pedido>";
        
        $posts = array (
            "apikey" => "a0d67ab3925a9df897d78510a6ccf847dfdfb78dfd78641cb1504e8de0a311eab831c42b",
            "xml" => rawurlencode($xmlPedido)
        );
        
        $retorno = executeSendOrder($url, $posts);
        
        //echo $retorno;
        // END GRAVAR NO BLING
        
        echo "true";
    }else{
        print_r($invalid_fields);
        //echo "false";
    }