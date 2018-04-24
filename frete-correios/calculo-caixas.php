<?php

define("MIN_LARGURA", 11);
define("MAX_LARGURA", 105);

define("MIN_ALTURA", 2);
define("MAX_ALTURA", 105);

define("MIN_COMPRIMENTO", 16);
define("MAX_COMPRIMENTO", 105);

define("MIN_LARGURA", 11);

define("MIN_SOMA_CLA", 29);
define("MAX_SOMA_CLA", 300);


function ordenar_carrinho($ordened_carrinho = null){
    
    if(!is_array($ordened_carrinho)) return false;

        foreach ($ordened_carrinho as $k => $infoProduto){
        $new_altura = min( $infoProduto['A'], $infoProduto['L'], $infoProduto['C'] );
        $new_comprimento = max( $infoProduto['A'], $infoProduto['L'], $infoProduto['C'] );
        $_new_largura = array( $infoProduto['A'], $infoProduto['L'], $infoProduto['C'] );
            
        sort($_new_largura);
        array_shift($_new_largura);
        array_pop($_new_largura);

        $infoProduto['L'] = isset($_new_largura[0]) ? $_new_largura[0] : $new_altura;
        $infoProduto['A'] = $new_altura;
        $infoProduto['C'] = $new_comprimento;
        $infoProduto['LC'] = $infoProduto['L'] * $infoProduto['C'];
        $ordened_carrinho[$k] = $infoProduto;

    }

    function order_largura_comprimento($a, $b){
        return $a['LC'] < $b['LC'];
    }

    usort($ordened_carrinho, 'order_largura_comprimento');

    return $ordened_carrinho;
}

$caixas = array();
$ctrl_caixas = -1;
function set_caixa(){
    global $ctrl_caixas;
    
    $caixa = array(
        'altura' => 3,
        'largura' => 3,
        'comprimento' => 3,
        'qtd_itens' => 0,
        'message' => null,
        'volume' => 0,
        'volume_itens' => 0,
        'volume_vazio' => 0,
        'peso' => 0.1,
        'valor_mercadoria' => 0,
        'comprimento_remanescente' => 0,
        'largura_remanescente' => 0,
        'altura_remanescente' => 0,
        'status' => "vazia"
    );
    
    $ctrl_caixas++;
    return $caixa;
}

global $itens, $ctrl_itens;
$itens = array();
$ctrl_itens = 0;
function calcular_caixas($carrinho = null){
    global $ctrl_caixas, $caixas, $itens, $ctrl_itens;
    global $carrinho_frete;
    $carrinho_frete = $carrinho;

    if(!is_array($carrinho_frete)) return false;
    
    $carrinho_frete = ordenar_carrinho($carrinho_frete);
    

    
    $newCaixa = set_caixa();

    $caixas[$ctrl_caixas] = json_decode(json_encode($newCaixa, FALSE));

    if(empty($carrinho_frete)){
        return false;
    }
    
    function continuar_fila(){
        global $caixas, $ctrl_caixas, $carrinho_frete;
        $anotherCaixa = set_caixa();
        $caixas[$ctrl_caixas] = json_decode(json_encode($anotherCaixa, FALSE));
        //echo "<br><br>Continuando fila de produtos<br><b>Nova caixa criada</b><br>";
        
        empacotar_itens();
    }
    
    function espaco_disponivel(){
        global $caixas, $ctrl_caixas;
                
        $disponivel = true;
        
        // Recalculando volume da caixa
        $caixas[$ctrl_caixas]->volume = ($caixas[$ctrl_caixas]->altura * $caixas[$ctrl_caixas]->largura * $caixas[$ctrl_caixas]->comprimento);

        // Espaço restante na caixa
        $caixas[$ctrl_caixas]->volume_vazio = $caixas[$ctrl_caixas]->volume - $caixas[$ctrl_caixas]->volume_itens;

        if(!empty($carrinho_frete)){        
            // Validando obrigações das dimensões da caixa
            if($caixas[$ctrl_caixas]->altura > 0 && $caixas[$ctrl_caixas]->altura < MIN_ALTURA) $caixas[$ctrl_caixas]->altura = MIN_ALTURA;
            if($caixas[$ctrl_caixas]->largura > 0 && $caixas[$ctrl_caixas]->largura < MIN_LARGURA) $caixas[$ctrl_caixas]->largura = MIN_LARGURA;
            if($caixas[$ctrl_caixas]->comprimento > 0 && $caixas[$ctrl_caixas]->comprimento < MIN_COMPRIMENTO) $caixas[$ctrl_caixas]->comprimento = MIN_COMPRIMENTO;
        }

        // Validando limites das caixas
        if($caixas[$ctrl_caixas]->altura > MAX_ALTURA){
            $disponivel = false;
        }
        if($caixas[$ctrl_caixas]->largura > MAX_LARGURA){
            $disponivel = false;
        }
        if($caixas[$ctrl_caixas]->comprimento > MAX_COMPRIMENTO){
            $disponivel = false;
        }
        
        $retorno = $disponivel == true ? true : false;
        return $retorno;
    }
    
    function empacotar_itens(){
        global $carrinho_frete, $caixas, $ctrl_caixas, $itens, $ctrl_itens;
        if($carrinho_frete != false && $carrinho_frete != null){
            foreach($carrinho_frete as $indice_item => $infoProduto){
                //echo "<br>Produto: {$infoProduto["title"]} ID = {$infoProduto["id"]}";
                if($carrinho_frete[$indice_item]["empacotado"] == true){
                    //echo "<br>Produto já esta empacotado<br>";
                    continue;
                }
                
                $caixas[$ctrl_caixas]->volume_itens += ($carrinho_frete[$indice_item]['A'] * $carrinho_frete[$indice_item]['L'] * $carrinho_frete[$indice_item]['C']);

                // verifica se produto cabe na caixa
                $proxima_fila = false;
                if($caixas[$ctrl_caixas]->comprimento_remanescente >= $carrinho_frete[$indice_item]['C'] && $caixas[$ctrl_caixas]->largura_remanescente >= $carrinho_frete[$indice_item]['L']){

                    if($carrinho_frete[$indice_item]['A'] > $caixas[$ctrl_caixas]->altura_remanescente){
                        $caixas[$ctrl_caixas]->altura += $carrinho_frete[$indice_item]['A'] - $caixas[$ctrl_caixas]->altura_remanescente;
                    }

                    if($carrinho_frete[$indice_item]['C'] > $caixas[$ctrl_caixas]->comprimento){
                        $caixas[$ctrl_caixas]->comprimento = $carrinho_frete[$indice_item]['C'];
                    }

                    $caixas[$ctrl_caixas]->comprimento_remanescente = $caixas[$ctrl_caixas]->comprimento - $carrinho_frete[$indice_item]['C'];

                    $caixas[$ctrl_caixas]->largura_remanescente = $caixas[$ctrl_caixas]->largura_remanescente - $carrinho_frete[$indice_item]['L'];

                    $caixas[$ctrl_caixas]->altura_remanescente = $carrinho_frete[$indice_item]['A'] > $caixas[$ctrl_caixas]->altura_remanescente ? $carrinho_frete[$indice_item]['A'] : $caixas[$ctrl_caixas]->altura_remanescente;
                    $__['side'] = true;

                    $proxima_fila = true;
                }

                if($proxima_fila == false){
                    $alturaAntiga = $caixas[$ctrl_caixas]->altura;
                    $larguraAntiga = $caixas[$ctrl_caixas]->largura;
                    $comprimentoAntigo = $caixas[$ctrl_caixas]->comprimento;

                    $caixas[$ctrl_caixas]->altura += $carrinho_frete[$indice_item]['A']; // Sempre incrementa

                    if($carrinho_frete[$indice_item]['L'] > $caixas[$ctrl_caixas]->largura){
                        $caixas[$ctrl_caixas]->largura = $carrinho_frete[$indice_item]['L'];
                    }

                    if($carrinho_frete[$indice_item]['C'] > $caixas[$ctrl_caixas]->comprimento){
                        $caixas[$ctrl_caixas]->comprimento = $carrinho_frete[$indice_item]['C'];
                    }

                    if(espaco_disponivel() == false){
                        // calcular volume restante
                        $caixas[$ctrl_caixas]->altura = $alturaAntiga;
                        $caixas[$ctrl_caixas]->largura = $larguraAntiga;
                        $caixas[$ctrl_caixas]->comprimento = $comprimentoAntigo;
                        continuar_fila();
                    }else{
                        $carrinho_frete[$indice_item]["empacotado"] = true;
                        $caixas[$ctrl_caixas]->comprimento_remanescente = $caixas[$ctrl_caixas]->comprimento;
                        $caixas[$ctrl_caixas]->largura_remanescente = $caixas[$ctrl_caixas]->largura - $carrinho_frete[$indice_item]['L'];
                        $caixas[$ctrl_caixas]->altura_remanescente = $carrinho_frete[$indice_item]['A'];
                        $caixas[$ctrl_caixas]->peso += $carrinho_frete[$indice_item]["peso"];
                        $caixas[$ctrl_caixas]->valor_mercadoria += $carrinho_frete[$indice_item]["preco"];
                        $caixas[$ctrl_caixas]->qtd_itens++;
                    }
                }else{
                    continuar_fila();
                    break;
                }
            }  
        }
    }
    empacotar_itens();
    
    foreach($caixas as $index => $info){
        $larguraAtual = $caixas[$index]->largura;
        $comprimentoAtual = $caixas[$index]->comprimento;
        $caixas[$index]->largura = $larguraAtual < MIN_LARGURA ? MIN_LARGURA : $larguraAtual;
        $caixas[$index]->comprimento = $larguraAtual < MIN_COMPRIMENTO ? MIN_COMPRIMENTO : $comprimentoAtual;
    }
    
    return $caixas;
}