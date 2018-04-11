<?php
    require_once "@classe-vitrine-produtos.php";
    require_once "@classe-system-functions.php";
    require_once "@pew/pew-system-config.php";
    $vitrineProdutos[0] = new VitrineProdutos("standard", 5, "BOLSAS EM PROMOÇÃO");
    $taela_produtos = $pew_custom_db->tabela_produtos;
    $condicaoPromocao = "promocao_ativa = 1 and preco_promocao < preco";
    $total = $pew_functions->contar_resultados($taela_produtos, $condicaoPromocao);
    if($total > 0){
        $selectedPromocao = array();
        $i = 0;
        $queryIds = mysqli_query($conexao, "select id from $taela_produtos where $condicaoPromocao");
        while($info = mysqli_fetch_array($queryIds)){
            $selectedPromocao[$i] = $info["id"];
            $i++;
        }
        $vitrineProdutos[0]->montar_vitrine($selectedPromocao);
    }
    $vitrineProdutos[1] = new VitrineProdutos("standard", 5, "BOLSAS PEQUENAS");
    $vitrineProdutos[1]->montar_vitrine("");
    $vitrineProdutos[2] = new VitrineProdutos("standard", 5, "LINHA MASCULINA");
    $vitrineProdutos[2]->montar_vitrine();
?>
