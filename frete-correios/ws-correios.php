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

    $url = 'http://ws.correios.com.br/calculador/CalcPrecoPrazo.aspx';

    $curl = curl_init($url . '?' . $data);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $result = curl_exec($curl);
    $result = simplexml_load_string($result);
    foreach($result -> cServico as $row){
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