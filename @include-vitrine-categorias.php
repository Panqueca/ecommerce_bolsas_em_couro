<?php
    require_once "@classe-vitrine-produtos.php";
    $tituloCategorias = "<h1>CONHEÇA NOSSAS ATRAÇÕES</h1>";
    $vitrineCategorias = new VitrineProdutos("categorias", 4, $tituloCategorias);
    $vitrineCategorias->montar_vitrine();
?>