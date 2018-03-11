<?php
    require_once "@classe-vitrine-produtos.php";
    $vitrineProdutos[0] = new VitrineProdutos("standard", 5, "BOLSAS EM PROMOÇÃO");
    $vitrineProdutos[0]->montar_vitrine();
    $vitrineProdutos[1] = new VitrineProdutos("standard", 5, "BOLSAS PEQUENAS");
    $vitrineProdutos[1]->montar_vitrine();
    $vitrineProdutos[2] = new VitrineProdutos("standard", 5, "LINHA MASCULINA");
    $vitrineProdutos[2]->montar_vitrine();
?>
