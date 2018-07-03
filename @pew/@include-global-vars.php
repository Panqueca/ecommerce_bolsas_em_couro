<?php
    require_once "pew-system-config.php";
    $globalVars = array(
        "conexao" => $conexao,
        "tabela_departamentos" => $pew_custom_db->tabela_departamentos,
        "tabela_categorias" => $pew_db->tabela_categorias,
        "tabela_subcategorias" => $pew_db->tabela_subcategorias,
        "tabela_produtos" => $pew_custom_db->tabela_produtos,
        "tabela_cores" => $pew_custom_db->tabela_cores,
        "tabela_marcas_produtos" => $pew_custom_db->tabela_marcas_produtos,
        "tabela_imagens_produtos" => $pew_custom_db->tabela_imagens_produtos,
        "tabela_departamentos_produtos" => $pew_custom_db->tabela_departamentos_produtos,
        "tabela_categorias_produtos" => $pew_custom_db->tabela_categorias_produtos,
        "tabela_subcategorias_produtos" => $pew_custom_db->tabela_subcategorias_produtos,
        "tabela_categorias_vitrine" => $pew_custom_db->tabela_categorias_vitrine,
        "tabela_categoria_destaque" => $pew_custom_db->tabela_categoria_destaque,
        "tabela_especificacoes" => $pew_custom_db->tabela_especificacoes,
        "tabela_especificacoes_produtos" => $pew_custom_db->tabela_especificacoes_produtos,
        "tabela_produtos_relacionados" => $pew_custom_db->tabela_produtos_relacionados,
        "tabela_cores_relacionadas" => $pew_custom_db->tabela_cores_relacionadas,
        "tabela_minha_conta" => $pew_custom_db->tabela_minha_conta,
        "tabela_enderecos" => $pew_custom_db->tabela_enderecos,
        "tabela_carrinhos" => $pew_custom_db->tabela_carrinhos,
        "tabela_pedidos" => $pew_custom_db->tabela_pedidos,
        "tabela_orcamentos" => $pew_custom_db->tabela_orcamentos,
    );
    global $globalVars;
?>