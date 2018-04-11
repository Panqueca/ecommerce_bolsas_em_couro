<?php
$post_fields = array("cep_destino", "codigo_servico", "comprimento", "largura", "altura", "peso", "valor_mercadoria");
$invalid_fileds = array();
$calcular = true;
$i = 0;
foreach($post_fields as $post_name){
    /*Validação se todos campos foram enviados*/
    if(!isset($_POST[$post_name])){
        $calcular = false;
        $i++;
        $invalid_fileds[$i] = $post_name;
    }
}

if($calcular){

    $cepDestino = str_replace("-", "", $_POST["cep_destino"]);
    $codigoServico = $_POST["codigo_servico"] != "" && $_POST["codigo_servico"] > 0 ? $_POST["codigo_servico"] : "41106";
    $comprimento = $_POST["comprimento"];
    $largura = $_POST["largura"];
    $altura = $_POST["altura"];
    $peso = $_POST["peso"];
    $valorMercadoria = $_POST["valor_mercadoria"] > 0 ? $_POST["valor_mercadoria"] : '0';

    $cepEnvio = "80710110";

    $data['nCdEmpresa'] = '';
    $data['sDsSenha'] = '';
    $data['sCepOrigem'] = $cepEnvio;
    $data['sCepDestino'] = $cepDestino;
    $data['nVlPeso'] = $peso;
    $data['nCdFormato'] = '1';
    $data['nVlComprimento'] = $comprimento;
    $data['nVlAltura'] = $altura;
    $data['nVlLargura'] = $largura;
    $data['nVlDiametro'] = '0';
    $data['sCdMaoPropria'] = 'n';
    $data['nVlValorDeclarado'] = $valorMercadoria;
    $data['sCdAvisoRecebimento'] = 'n';
    $data['StrRetorno'] = 'xml';
    $data['nCdServico'] = $codigoServico;
    $data = http_build_query($data);


    $curl = curl_init($url . '?' . $data);
    
    $url = "http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx?$data";
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
        CURLOPT_POSTFIELDS => http_build_query($data),
    );

    curl_setopt_array($curl, $options);
    
    $xml = curl_exec($curl);
    
    curl_close($curl);
    
    $xml = simplexml_load_string($xml);
    
    foreach($xml -> cServico as $row){
        $row->Valor = str_replace(",", ".", $row->Valor);
        $row->ValorSemAdicionais = str_replace(",", ".", $row->ValorSemAdicionais);
        $row->ValorMaoPropria = str_replace(",", ".", $row->ValorMaoPropria);
        $row->ValorAvisoRecebimento = str_replace(",", ".", $row->ValorAvisoRecebimento);
        $row->ValorValorDeclarado = str_replace(",", ".", $row->ValorValorDeclarado);
        if($row->Erro == 0){
            $jsonRow = json_encode($row);
            print_r($jsonRow);
        }else{
            echo "false";
        }
    }
}else{
    echo "false";
}