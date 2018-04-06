<?php

function frete($produtos = null, $codigo_correios = "41106", $cep_destino = null, $declarar_valor = false, $url_api = null){
    
    require_once "classe-sistema-empacotamento.php";
    require_once "calculo-caixas.php";
    
    // EMPACOTAR PRODUTOS
    $empacotamento = new Empacotamento();
    foreach($produtos as $infoProduto){
        $id =  $infoProduto["id"];
        $titulo =  $infoProduto["titulo"];
        $preco =  $infoProduto["preco"];
        $comprimento =  $infoProduto["comprimento"];
        $largura =  $infoProduto["largura"];
        $altura =  $infoProduto["altura"];
        $peso =  $infoProduto["peso"];
        
        $empacotamento->add_produto($id, $titulo, $preco, $comprimento, $largura, $altura, $peso);
    }


    $carrinho = $empacotamento->configurar();
    
    $caixas = calcular_caixas($carrinho);

    function calcular_frete($servicoCorreios, $cepDestino, $declararValor, $url_api_transportadora){
        global $caixas;
        $frete_caixas = array();
        $ctrlFrete = 0;
        foreach($caixas as $infoCaixa){
            if($infoCaixa != false){
                $alturaCaixa = $infoCaixa->altura;
                $larguraCaixa = $infoCaixa->largura;
                $comprimentoCaixa = $infoCaixa->comprimento;
                $quantidadeItens = $infoCaixa->qtd_itens;
                $pesoCaixa = $infoCaixa->peso;
                $volumeCaixa = $infoCaixa->volume;
                $volumeItens = $infoCaixa->volume_itens;
                $valorItens = $infoCaixa->valor_mercadoria;
                $valorMercadoria = $declararValor == true ? $valorItens : 0;

                $dadosFrete = [
                    'cep_destino' => $cepDestino,
                    'codigo_servico' => $servicoCorreios,
                    'comprimento' => $comprimentoCaixa,
                    'largura' => $larguraCaixa,
                    'altura' => $alturaCaixa,
                    'peso' => $pesoCaixa,
                    'valor_mercadoria' => $valorMercadoria,
                ];

                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url_api_transportadora);
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dadosFrete);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                $response = curl_exec($ch);

                if($response != "false"){
                    $split_response = explode(",", $response);
                    $ctrlItens = 0;
                    $frete_caixas[$ctrlFrete] = array();

                    foreach($split_response as $info){
                        $split_info  = explode(":", $info);
                        $chave = str_replace('"', "", $split_info[0]);
                        $chave = str_replace('{', "", $chave);
                        $chave = str_replace('}', "", $chave);
                        $valor = $split_info[1];
                        $valor = str_replace('"', "", $split_info[1]);
                        $valor = str_replace('{', "", $valor);
                        $valor = str_replace('}', "", $valor);

                        $array = array();
                        $array[$chave] = $valor;

                        $frete_caixas[$ctrlFrete][$chave] = $valor;

                        $ctrlItens++;
                    }
                    $ctrlFrete++;
                }else{
                    return false;
                }

                curl_close($ch);
            }
        }

        $freteFinal = 0;
        if(count($frete_caixas) > 0){
            foreach($frete_caixas as $arrayCaixa){
                $valorFrete = $arrayCaixa["Valor"];
                $prazoEntrega = $arrayCaixa["PrazoEntrega"];
                //print_r($arrayCaixa);
                $freteFinal += $valorFrete;
            }
        }

        return $freteFinal;
    }

    $frete = calcular_frete($codigo_correios, $cep_destino, $declarar_valor, $url_api);
    return $frete;
}
?>