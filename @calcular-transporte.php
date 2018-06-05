<?php
    
    $codigoTransporte = null;
    
    $jsonData = json_decode(file_get_contents('php://input'), true);
    if($jsonData != null){
        $codigoTransporte = isset($jsonData["codigo_transporte"]) ? $jsonData["codigo_transporte"] : null;   
        $cepDestino = isset($jsonData["cep_destino"]) ? $jsonData["cep_destino"] : null;
        $_POST["produtos"] = $jsonData["produtos"];
    }

    $infoFrete = false;

    function calcular_correios(){
        global $codigoTransporte, $infoFrete;
        $_POST["codigo_correios"] = $codigoTransporte;
        require_once "frete-correios/@trigger-calculo.php";
    }

    function calcular_motoboy($cepDestino){
        global $infoFrete;
        $cepDestino = str_replace("-", "", $cepDestino);
        $strPrazo = "7 dias úteis";
        $fretePadrao = "15.00";
        
        $faixaCep[0] = array();
        $faixaCep[0]["from"] = "80000000";
        $faixaCep[0]["to"] = "89999999";
        $faixaCep[0]["valor"] = "12.00";
        
        $faixaCep[1] = array();
        $faixaCep[1]["from"] = "90000000";
        $faixaCep[1]["to"] = "99999999";
        $faixaCep[1]["valor"] = "14.00";
            
        $freteFinal = null;
        
        foreach($faixaCep as $infoCep){
            $from = $infoCep["from"];
            $to = $infoCep["to"];
            $valor = $infoCep["valor"];
            
            if($cepDestino >= $from && $cepDestino <= $to){
                $freteFinal = $valor;
            }
        }
        
        $freteFinal = $freteFinal != null ? $freteFinal : $fretePadrao; 
        
        $infoFrete = '{"valor": ' . $freteFinal . ', "prazo": "' . $strPrazo . '"}';
    }

    function retirada_loja(){
        global $infoFrete;
        $infoFrete = '{"valor": 0.00, "prazo": "0"}';
    }

    if($codigoTransporte != null){
        switch($codigoTransporte){
            case "7777":
                retirada_loja();
                break;
            case "8888":
                calcular_motoboy($cepDestino);
                break;
            default:
                calcular_correios();
        }
    }else{
        echo "false";
    }


    if(!isset($_POST["no_console"])){
        echo $infoFrete;
    }

    // EXEMPLO DO RETORNO JSON = '{"valor": 15.00, "prazo": "7 dias úteis"}';