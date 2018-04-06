<?php
    $post_fields = array("cep_destino", "produtos");
    $invalid_fileds = array();
    $calcular = true;
    $i = 0;
    foreach($post_fields as $post_name){
        if(!isset($_POST[$post_name])){
            $calcular = false;
            $i++;
            $invalid_fileds[$i] = $post_name;
        }
    }

    if($calcular){

        require_once "calcular-frete.php";

        $codigoCorreios = isset($_POST["codigo_correios"]) ? $_POST["codigo_correios"] : "41106";
        
        $cepDestino = $_POST["cep_destino"];
        
        $declararValor = isset($_POST["declarar_valor"]) ? $_POST["declarar_valor"] : false;

        $produtos = is_array($_POST["produtos"]) ? $_POST["produtos"] : array();
        /*
        $produtos[0] = array();
        $produtos[0]["id"] = "#idProduto";
        $produtos[0]["titulo"] = "Titulo produto";
        $produtos[0]["preco"] = "35.00";
        $produtos[0]["comprimento"] = "12";
        $produtos[0]["largura"] = "40";
        $produtos[0]["altura"] = "35";
        $produtos[0]["peso"] = ".3";
        */
        
        $url_correios_api = 'localhost/xampp/github/frete-correios/ws-correios.php';

        $valorFrete = frete($produtos, $codigoCorreios, $cepDestino, $declararValor, $url_correios_api);
        if($valorFrete != false && $produtos != false){
            echo $valorFrete;
        }else{
            echo "false";
        }
        
    }else{
        echo "false";
    }
