<?php
session_start();

$thisPageURL = substr($_SERVER["REQUEST_URI"], strpos($_SERVER["REQUEST_URI"], '@pew'));
$_POST["next_page"] = str_replace("@pew/", "", $thisPageURL);
$_POST["invalid_levels"] = array(1);

require_once "@link-important-functions.php";
require_once "@valida-sessao.php";

$navigation_title = "Relatório de vendas - " . $pew_session->empresa;
$page_title = "Relatório de vendas";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Acesso Restrito. Efectus Web.">
        <meta name="author" content="Efectus Web">
        <title><?php echo $navigation_title; ?></title>
        <?php
        require_once "@link-standard-styles.php";
        require_once "@link-standard-scripts.php";
        ?>
    </head>
    <style>
        .filter-display{
            position: relative;
            width: 100%;
            background-color: #fff;
            min-height: 150px;
            -webkit-box-shadow: 1px 1px 15px 0px rgba(0, 0, 0, .3);
            -moz-box-shadow: 1px 1px 15px 0px rgba(0, 0, 0, .3);
            box-shadow: 1px 1px 15px 0px rgba(0, 0, 0, .3);
            border-radius: 5px;
            display: none;
            opacity: 0;
            transition: .4s;
        }
        .filter-display-active{
            opacity: 1;
        }
        .filter-display .fields{
            display: flex;
            padding: 20px 0px 10px 0px;
        }
        .filter-display .filter-field{
            flex: 1 1 0;
            border-right: 1px solid #ccc;
        }
        .filter-display .filter-field .title{
            color: #111;
            font-weight: normal;
            margin: 0px;
            padding: 0px 0px 15px 0px;
            text-align: center;
            border-bottom: 1px solid #eee;
        }
        .filter-display .last-field{
            border-right: none;
        }
        .filter-display .bottom{
            padding: 10px 0px 10px 0px;
        }
        .filter-display .bottom .btn-filtrar{
            padding: 10px;
            background-color: #ccc;
            color: #111;
            border: none;
            font-size: 14px;
            margin: 0px 10px 0px 10px;
            cursor: pointer;
        }
        .filter-display .bottom .btn-filtrar:hover{
            background-color: #333;
            color: #fff;
        }
        .filter-display .label-title{
            font-weight: normal;
        }
        .filter-display .label-input{
            margin-top: 5px;   
        }
        .seg-tree {
            padding: 0;
            margin: 0;
            list-style-type: none;
            position: relative;
        }
        .seg-tree li {
            list-style-type: none;
            border-left: 2px solid #666;
            margin-left: 0px;
        }
        .seg-tree li div {
            padding-left: 15px;
            position: relative;
        }
        .seg-tree li div::before {
            content:'';
            position: absolute;
            top: 0;
            left: -2px;
            bottom: 50%;
            width: 0.75em;
            border: 2px solid #666;
            border-top: 0 none transparent;
            border-right: 0 none transparent;
        }
        .seg-tree > li:last-child {
            border-left: 2px solid transparent;
        }
        .seg-tree ul{
            padding-left: 20px;
        }
        .mensagem-table{
            font-size: 13px;
        }
        @media print{
            .no-print{
                display: none;
            }
            .table-padrao{
                margin: 0px;
                padding: 0px;
            }
            .table-padrao thead td{
                color: #111;
            }
            .table-padrao td{
                border-bottom: 1px solid #ccc;   
            }
            .titulos{
                margin: 10px 0px 0px 0px;
                border: none;
                color: #111;
            }
            .conteudo-painel{
                margin: 0px;
            }
        }
    </style>
    <script>
        $(document).ready(function(){

            var filterOpen = false;
            function toggle_filter(){
                var objFilter = $(".filter-display");
                if(!filterOpen){
                    filterOpen = true;
                    objFilter.css("display", "block");
                    setTimeout(function(){
                        objFilter.addClass("filter-display-active");
                    }, 50);
                }else{
                    objFilter.removeClass("filter-display-active");
                    setTimeout(function(){
                        filterOpen = false;
                        objFilter.css("display", "none");
                    }, 400);
                }
            }

            $("#buttonFilter").off().on("click", function(){
                toggle_filter();
            });

            $("#buttonPrint").off().on("click", function(){
                window.print(); 
            });

        });
    </script>
    <body>
        <span class="no-print">
            <?php
            // STANDARD REQUIRE
            require_once "@include-body.php";
            if(isset($block_level) && $block_level == true){
                $pew_session->block_level();
            }
            ?>
            <!--PAGE CONTENT-->
        </span>
        <h1 class="titulos"><?php echo $page_title; ?></h1>
        <section class="conteudo-painel">
            <span class="no-print">
                <div class="group clear">
                    <form action="pew-relatorios.php" method="get" class="label half clear">
                        <label class="group">
                            <div class="group">
                                <h3 class="label-title">Busca</h3>
                            </div>
                            <div class="group">
                                <div class="xlarge" style="margin-left: -5px; margin-right: 0px;">
                                    <input type="search" name="busca" placeholder="CPF, nome, referência do pedido" class="label-input" title="Busque por CPF, nome, referência do pedido">
                                </div>
                                <div class="xsmall" style="margin-left: 0px;">
                                    <button type="submit" class="btn-submit label-input btn-flat" style="margin: 10px;">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </label>
                    </form>
                    <div class="label half jc-left">
                        <div class="full">
                            <h4 class="subtitulos" align=left>Mais funções</h4>
                        </div>
                        <div class="label full">
                            <a class="btn-flat" title="Filtrar" id="buttonFilter"><i class="fas fa-sliders-h"></i> Filtro</a>
                            <a class="btn-flat" title="Imprimir" id="buttonPrint"><i class="fas fa-print"></i> Imprimir</a>
                        </div>
                    </div>
                </div>
                <br class="clear">
                <div class="full">
                    <form class="filter-display" method="post" id="form_filtro_relatorios">
                        <?php
                        $dInicial = isset($_POST["data_inicial"]) ? $_POST["data_inicial"] : null;
                        $dFinal = isset($_POST["data_final"]) ? $_POST["data_final"] : null;
                        $pInicial = isset($_POST["preco_inicial"]) ? $_POST["preco_inicial"] : null;
                        $pFinal = isset($_POST["preco_final"]) ? $_POST["preco_final"] : null;
                        $formD = isset($_POST["filter_departamentos"]) ? $_POST["filter_departamentos"] : array();
                        $formC = isset($_POST["filter_categorias"]) ? $_POST["filter_categorias"] : array();
                        $formSc = isset($_POST["filter_subcategorias"]) ? $_POST["filter_subcategorias"] : array();

                        if(!isset($_SESSION["start_standard_filter"])){
                            $_SESSION["start_standard_filter"] = "false";
                            $_POST["somente_pagos"] = "on";
                        }

                        $strButtonDepartamentos = count($formD) > 0 ? "Selecionados (" . count($formD) . ")" : "- Qualquer -";
                        $strButtonCategorias = count($formC) > 0 ? "Selecionados (" . count($formC) . ")" : "- Qualquer -";
                        $strButtonSubcategorias = count($formSc) > 0 ? "Selecionados (" . count($formSc) . ")" : "- Qualquer -";

                        $_GET["ref-option-url"] = "@classe-departamentos.php";

                        $_GET["ref-option"] = "departamento";
                        $_GET["ref-option-id"] = "multiSelectFilterDepartamento";
                        $_GET["ref-option-button"] = "multiSelectFilterDepartamentoBtn";
                        $_GET["ref-option-name"] = "filter_departamentos";
                        $_GET["ref-option-check-array"] = $formD;
                        $_GET["ref-option-parameter"] = "search_get_departamentos";
                        require "relatorios/@include-multi-select-filter.php";

                        $_GET["ref-option"] = "categoria";
                        $_GET["ref-option-id"] = "multiSelectFilterCategoria";
                        $_GET["ref-option-button"] = "multiSelectFilterCategoriaBtn";
                        $_GET["ref-option-name"] = "filter_categorias";
                        $_GET["ref-option-check-array"] = $formC;
                        $_GET["ref-option-parameter"] = "search_get_categorias";
                        require "relatorios/@include-multi-select-filter.php";

                        $_GET["ref-option"] = "subcategoria";
                        $_GET["ref-option-id"] = "multiSelectFilterSubcategoria";
                        $_GET["ref-option-button"] = "multiSelectFilterSubcategoriaBtn";
                        $_GET["ref-option-name"] = "filter_subcategorias";
                        $_GET["ref-option-check-array"] = $formSc;
                        $_GET["ref-option-parameter"] = "search_get_subcategorias";
                        require "relatorios/@include-multi-select-filter.php";
                        ?>
                        <input type="hidden" name="filtro_relatorios" value="true">
                        <div class="fields">
                            <div class="filter-field">
                                <h3 class="title">Datas</h3>
                                <div class="group">
                                    <div class="full">
                                        <h4 class="label-title">Data início</h4>
                                        <input type="date" class="label-input" name="data_inicial" value="<?= $dInicial ?>">
                                    </div>
                                    <div class="full">
                                        <h4 class="label-title">Data final</h4>
                                        <input type="date" class="label-input" name="data_final" value="<?= $dFinal ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="filter-field">
                                <h3 class="title">Preços</h3>
                                <div class="group">
                                    <div class="half">
                                        <h4 class="label-title">Preço início</h4>
                                        <input type="text" class="label-input" name="preco_inicial" placeholder="0.00" value="<?= $pInicial ?>">
                                    </div>
                                    <div class="half">
                                        <h4 class="label-title">Preço final</h4>
                                        <input type="text" class="label-input" name="preco_final" placeholder="0.00" value="<?= $pFinal ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="filter-field">
                                <h3 class="title">Departamentos</h3>
                                <div class="group">
                                    <div class="full">
                                        <h4 class="label-title">Departamento</h4>
                                        <input type="button" class="label-input" value="<?= $strButtonDepartamentos ?>" id="multiSelectFilterDepartamentoBtn">
                                    </div>
                                    <div class="full">
                                        <h4 class="label-title">Categorias</h4>
                                        <input type="button" class="label-input" value="<?= $strButtonCategorias ?>" id="multiSelectFilterCategoriaBtn">
                                    </div>
                                    <div class="full">
                                        <h4 class="label-title">Subcategorias</h4>
                                        <input type="button" class="label-input" value="<?= $strButtonSubcategorias ?>" id="multiSelectFilterSubcategoriaBtn">
                                    </div>
                                </div>
                            </div>
                            <div class="filter-field last-field">
                                <h3 class="title">Outros</h3>
                                <div class="group">
                                    <div class="full">
                                        <label class="label-title">
                                            <input type="checkbox" name="somente_pagos" <?php if(isset($_POST["somente_pagos"])) echo "checked"; ?> >
                                            Somente pedidos pagos
                                        </label>
                                    </div>
                                    <div class="full">
                                        <label class="label-title">
                                            <input type="checkbox" name="esconder_departamentos" <?php if(isset($_POST["esconder_departamentos"])) echo "checked"; ?> >
                                            Esconder departamentos
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="label group jc-right bottom">
                            <button type="submit" class="btn-filtrar">Filtrar</button>
                        </div>
                    </form>
                </div>
            </span>
            <table class="table-padrao" cellspacing="0">
                <thead>
                    <td>Data</td>
                    <td>Cliente</td>
                    <td>Produtos</td>
                    <td class='prices'>Total bruto</td>
                    <td class='prices'>Total compra</td>
                    <?php
                    if(!isset($_POST["somente_pagos"])){
                        echo "<td class='prices'>Total pago</td>";
                    }
                    ?>
                    <td class='prices'>Descontos</td>
                    <td class='prices'>Frete</td>
                    <td>Pagamento</td>
                    <?php
                    if(!isset($_POST["esconder_departamentos"])){
                        echo "<td>Departamentos</td>";
                    }
                    ?>
                </thead>
                <tbody>
                    <?php
                    require_once "@classe-pedidos.php";
                    require_once "../@classe-produtos.php";
                    $cls_pedidos = new Pedidos();
                    $cls_produtos = new Produtos();

                    $tabela_produtos = $pew_custom_db->tabela_produtos;
                    $tabela_pedidos = $pew_custom_db->tabela_pedidos;

                    $selectedPedidos = array();
                    function add_pedido($id, $array){
                        global $selectedPedidos;
                        if(!in_array($id, $selectedPedidos)){
                            $insert = array();
                            $insert["id"] = $id;
                            $insert["array"] = $array;
                            array_push($selectedPedidos, $insert);
                        }
                    }

                    $bottomTotal = array();
                    $bottomTotal["produtos"] = null;
                    $bottomTotal["total"] = 0;
                    $bottomTotal["total_bruto"] = 0;
                    $bottomTotal["total_pago"] = 0;
                    $bottomTotal["frete"] = null;
                    $bottomTotal["descontos"] = 0;

                    $ctrl_produtos_listados = 0;

                    $arrayBuscaPedidos = false;

                    if(isset($_GET["busca"])){
                        $busca = addslashes($_GET["busca"]);
                        $colluns = array("referencia", "nome_cliente", "cpf_cliente");
                        $condicaoBusca = "";
                        $i = 0;
                        foreach($colluns as $collun){
                            $condicaoBusca .= $i == 0 ? $collun . " like '%".$busca."%'" : " or " . $collun . " like '%".$busca."%'";
                            $i++;
                        }
                        $arrayBuscaPedidos = $cls_pedidos->buscar_pedidos($condicaoBusca);
                        if(!is_array($arrayBuscaPedidos)){
                            $arrayBuscaPedidos = array();
                        }
                        echo "<h3 class='no-print'>Exibindo resultados para: $busca</h3>";
                    }

                    if(isset($_POST["filtro_relatorios"])){
                        // Datas
                        $dataInicial = $_POST["data_inicial"];
                        $dataFinal = $_POST["data_final"] != null ? $_POST["data_final"] : date("Y-m-d");
                        // Preços
                        $precoInicial = $_POST["preco_inicial"];
                        $precoFinal = $_POST["preco_final"] != null ? $_POST["preco_final"] : 999999999;
                        // Departamentos
                        $departamentos = isset($_POST["filter_departamentos"]) ? $_POST["filter_departamentos"] : array();
                        $categorias = isset($_POST["filter_categorias"]) ? $_POST["filter_categorias"] : array();
                        $subcategorias = isset($_POST["filter_subcategorias"]) ? $_POST["filter_subcategorias"] : array();


                        $selectedProdutos = array();

                        $cls_departamentos = new Departamentos();

                        function add_filter_produtos($id){
                            global $selectedProdutos;
                            if(!in_array($id, $selectedProdutos)){
                                array_push($selectedProdutos, $id);
                            }
                        }

                        function compare($type, $value){
                            global $dataInicial, $dataFinal, $precoInicial, $precoFinal;
                            switch($type){
                                case "data_inicial":
                                    return $value >= $dataInicial;
                                    break;
                                case "data_final":
                                    return $value <= $dataFinal;
                                    break;
                                case "preco_inicial":
                                    return $value >= $precoInicial;
                                    break;
                                case "preco_final":
                                    return $value <= $precoFinal;
                                    break;
                            }
                        }

                        if(count($subcategorias) > 0){
                            foreach($subcategorias as $idSubcategoria){
                                $arrayProdutos = $cls_departamentos->get_produtos_subcategoria($idSubcategoria);
                                foreach($arrayProdutos as $idProduto){
                                    add_filter_produtos($idProduto['id_produto']);
                                }
                            }
                        }else if(count($categorias) > 0){
                            foreach($categorias as $idCategoria){
                                $arrayProdutos = $cls_departamentos->get_produtos_categoria($idCategoria);
                                foreach($arrayProdutos as $idProduto){
                                    add_filter_produtos($idProduto['id_produto']);
                                }
                            }
                        }else if(count($departamentos) > 0){
                            foreach($departamentos as $idDepartamento){
                                $arrayProdutos = $cls_departamentos->get_produtos_departamento($idDepartamento);
                                foreach($arrayProdutos as $idProduto){
                                    add_filter_produtos($idProduto['id_produto']);
                                }
                            }
                        }else{
                            $query = mysqli_query($conexao, "select id from $tabela_pedidos where data_controle between '$dataInicial' and '$dataFinal'");
                            while($info = mysqli_fetch_array($query)){
                                $cls_pedidos->montar($info["id"]);
                                $infoArray = $cls_pedidos->montar_array();
                                if(compare("preco_inicial", $infoArray["valor_sfrete"]) && compare("preco_final", $infoArray["valor_sfrete"])){
                                    add_pedido($info["id"], $infoArray);
                                }
                            }
                        }


                        if(count($selectedProdutos) > 0){
                            $arrayPedidos = $cls_pedidos->get_pedidos_by_produtos($selectedProdutos);
                            foreach($arrayPedidos as $idPedido){
                                $query = mysqli_query($conexao, "select data_controle from $tabela_pedidos where id = '$idPedido'");
                                $cls_pedidos->montar($idPedido);
                                $infoArray = $cls_pedidos->montar_array();
                                if(compare("data_inicial", $infoArray["data_controle"]) && compare("data_final", $infoArray["data_controle"]) && compare("preco_inicial", $infoArray["valor_sfrete"]) && compare("preco_final", $infoArray["valor_sfrete"])){
                                    add_pedido($idPedido, $infoArray);
                                }
                            }
                        }

                    }else{
                        $condicao = "true";
                        $queryPedidos = mysqli_query($conexao, "select id from $tabela_pedidos where $condicao");
                        while($info = mysqli_fetch_array($queryPedidos)){
                            $cls_pedidos->montar($info["id"]);
                            $infoArray = $cls_pedidos->montar_array();
                            add_pedido($info["id"], $infoArray);
                        }
                    }

                    $strFilterFinal = "";
                    if(count($selectedPedidos) > 0){
                        // Mensagem filtro
                        $filterDataInicial = isset($_POST["data_inicial"]) ? $_POST["data_inicial"] : null;
                        $filterDataFinal = isset($_POST["data_final"]) ? $_POST["data_final"] : null;

                        $strFilterData = null;
                        if($filterDataInicial != null){
                            if($filterDataFinal == null){
                                $strFilterData = "de " . $pew_functions->inverter_data($filterDataInicial) . " até " . $pew_functions->inverter_data(date("Y-m-d"));
                            }else{
                                $strFilterData = "de " . $pew_functions->inverter_data($filterDataInicial) . " até " . $pew_functions->inverter_data($filterDataFinal);
                            }
                        }else if($filterDataFinal != null){
                            $strFilterData = "do início até " . $pew_functions->inverter_data($filterDataFinal);
                        }

                        $filterPrecoInicial = isset($_POST["preco_inicial"]) ? $_POST["preco_inicial"] : null;
                        $filterPrecoFinal = isset($_POST["preco_final"]) ? $_POST["preco_final"] : null;

                        $strFilterPreco = null;
                        if($filterPrecoInicial != null){
                            if($filterPrecoFinal == null){
                                $strFilterPreco = " de R$ " . $filterPrecoInicial . " até R$ " . 999999.99;
                            }else{
                                $strFilterPreco = " de R$ " . $filterPrecoInicial . " até R$ " . $filterPrecoFinal;
                            }
                        }else if($filterPrecoFinal != null){
                            $strFilterPreco = " de R$ 0.00 até R$ " . $filterPrecoFinal;
                        }

                        if($strFilterData != null){
                            $strFilterData .= ";";
                            $strFilterPreco .= ";";
                            if($strFilterPreco == null){
                                $strFilterFinal = $strFilterData;
                            }else{
                                $strFilterFinal = $strFilterData . $strFilterPreco;
                            }
                        }else if($strFilterPreco != null){
                            $strFilterPreco .= ";";
                            $strFilterFinal = $strFilterPreco;
                        }

                        $strDepartamentos = isset($_POST["filter_departamentos"]) ? " departamentos;" : "";
                        $strDepartamentos .= isset($_POST["filter_categorias"]) ? " categorias;" : "";
                        $strDepartamentos .= isset($_POST["filter_subcategorias"]) ? " subcategorias;" : "";

                        $strFilterFinal .= $strDepartamentos;

                        if(strlen($strFilterFinal) > 3){
                            echo "<tr><td colspan=10 class='mensagem-table'>Filtro: $strFilterFinal</td></tr>";
                        }
                        // End mensagem filtro
                        foreach($selectedPedidos as $infoPedido){
                            $idPedido = $infoPedido["id"];
                            $infoArray = $infoPedido["array"];
                            $valorTotal = $infoArray["valor_sfrete"];
                            $valorFrete = $infoArray["valor_frete"];
                            $data = $infoArray["data_controle"];
                            $data = $pew_functions->inverter_data(substr($data, 0, 10));
                            $infoProdutos = $cls_pedidos->get_produtos_pedido();
                            $totalProdutos = count($infoProdutos);
                            $pagamento = $cls_pedidos->get_pagamento_string($infoArray["codigo_pagamento"]);
                            $pago = $infoArray["status"] == 3 || $infoArray["status"] == 4 ? true : false;
                            $cancelado = $infoArray["status"] == 5 || $infoArray["status"] == 6 || $infoArray["status"] == 7 ? true : false;

                            $tree = array();
                            $tree["categorias"] = array();

                            if(!function_exists("add_tree_categoria")){
                                function add_tree_categoria($idCategoria, $tituloCategoria){
                                    global $tree;
                                    $array = array();
                                    $array["id"] = $idCategoria;
                                    $array["titulo"] = $tituloCategoria;
                                    $array["subcategorias"] = array();
                                    array_push($tree, $array);
                                }
                            }

                            if(!function_exists("add_tree_subcategoria")){
                                function add_tree_subcategoria($idCategoria, $idSubcategoria, $tituloSubcategoria){
                                    global $tree;
                                    $indexCategoria = null;
                                    $array = array();
                                    $array["id"] = $idSubcategoria;
                                    $array["titulo"] = $tituloSubcategoria;
                                    foreach($tree as $mainIndex => $segCategoria){
                                        if(array_search($idCategoria, $segCategoria)){
                                            array_push($tree[$mainIndex]["subcategorias"], $array);
                                        }
                                    }
                                }
                            }

                            $valorBruto = 0;
                            foreach($infoProdutos as $infoProduto){

                                $queryPrecoBruto = mysqli_query($conexao, "select preco from $tabela_produtos where id = '{$infoProduto["id"]}'");
                                $infoPreco = mysqli_fetch_array($queryPrecoBruto);
                                $precoBrutoProduto = $infoPreco["preco"];
                                $valorBruto += $precoBrutoProduto;

                                if(!isset($_POST["esconder_departamentos"])){
                                    $categoriasProduto = $cls_produtos->get_categorias_produto($infoProduto["id"]);
                                    if(is_array($categoriasProduto)){
                                        foreach($categoriasProduto as $infoCategoria){
                                            add_tree_categoria($infoCategoria["id"], $infoCategoria["titulo"]);
                                        }
                                    }
                                    $subcategoriasProduto = $cls_produtos->get_subcategorias_produto($infoProduto["id"]);
                                    if(is_array($subcategoriasProduto)){
                                        foreach($subcategoriasProduto as $infoSubcategoria){
                                            add_tree_subcategoria($infoSubcategoria["id_categoria"], $infoSubcategoria["id_subcategoria"], $infoSubcategoria["titulo"]);
                                        }
                                    }
                                }
                            }

                            $listar = true;
                            if(isset($_POST["somente_pagos"]) && $pago == false){
                                $listar = false;
                            }

                            if(is_array($arrayBuscaPedidos) && !in_array($infoArray["id"], $arrayBuscaPedidos)){
                                $listar = false;
                            }

                            if($listar && $cancelado == false){
                                $ctrl_produtos_listados++;
                                $valorDesconto = abs($valorBruto - $valorTotal);

                                $bottomTotal["total"] += $valorTotal;
                                $bottomTotal["total_bruto"] += $valorBruto;
                                $bottomTotal["frete"] += $valorFrete;
                                $bottomTotal["produtos"] += $totalProdutos;
                                $bottomTotal["descontos"] += $valorDesconto;

                                $valorBruto = $pew_functions->custom_number_format($valorBruto);
                                $valorDesconto = $pew_functions->custom_number_format($valorDesconto);

                                echo "<tr>";
                                echo "<td>$data</td>";
                                echo "<td>{$infoArray['nome_cliente']}</td>";
                                echo "<td align=center>$totalProdutos</td>";
                                echo "<td class='prices'>R$ $valorBruto</td>";
                                echo "<td class='prices'>R$ {$pew_functions->custom_number_format($valorTotal)}</td>";
                                if(!isset($_POST["somente_pagos"])){
                                    $valorPago = $pago == true ? $valorBruto : "0.00";
                                    echo "<td class='prices'>R$ $valorPago</td>";
                                    if($pago == true){
                                        $bottomTotal["valor_pago"] += $valorPago;
                                    }
                                }
                                echo "<td class='prices'>R$ $valorDesconto</td>";
                                echo "<td class='prices'>R$ $valorFrete</td>";
                                echo "<td>$pagamento</td>";
                                if(!isset($_POST["esconder_departamentos"])){
                                    echo "<td>";
                                    echo "<ul class='seg-tree'>";
                                    foreach($tree as $infoTree){
                                        if(count($infoTree) > 0){
                                            $titulo = $infoTree["titulo"];
                                            $subcategorias = $infoTree["subcategorias"];
                                            echo "<li>";
                                            echo "<div>$titulo</div>";
                                            if(count($subcategorias) > 0){
                                                echo "<ul>";
                                                foreach($subcategorias as $infoSubTree){
                                                    $titulo = $infoSubTree["titulo"];
                                                    echo "<li><div>$titulo</div></li>";
                                                }
                                                echo "</ul>";
                                            }
                                            echo "</li>";
                                        }
                                    }
                                    echo "</ul>";
                                    echo "</td>";
                                }
                                echo "</tr>";
                            }
                        }

                        if($ctrl_produtos_listados == 0){
                            echo "<tr><td colspan=10>Nenhum resultado encontrado</td></tr>";
                        }

                        $bottomTotal["total"] = $pew_functions->custom_number_format($bottomTotal["total"]);
                        $bottomTotal["total_bruto"] = $pew_functions->custom_number_format($bottomTotal["total_bruto"]);
                        $bottomTotal["total_pago"] = $pew_functions->custom_number_format($bottomTotal["total_pago"]);
                        $bottomTotal["frete"] = $pew_functions->custom_number_format($bottomTotal["frete"]);
                        $bottomTotal["descontos"] = $pew_functions->custom_number_format($bottomTotal["descontos"]);
                        echo "<tfoot>";
                        echo "<td colspan=2 align=center>TOTAL</td>";
                        echo "<td align=center>{$bottomTotal['produtos']}</td>";
                        echo "<td class='prices'>R$ {$bottomTotal['total_bruto']}</td>";
                        echo "<td class='prices'>R$ {$bottomTotal['total']}</td>";
                        if(!isset($_POST["somente_pagos"])){
                            echo "<td class='prices'>R$ {$bottomTotal['total_pago']}</td>";
                        }
                        echo "<td class='prices'>R$ {$bottomTotal['descontos']}</td>";
                        echo "<td class='prices'>R$ {$bottomTotal['frete']}</td>";
                        echo "<td colspan=2></td>";
                        echo "</tfoot>";
                    }else{
                        echo "<td colspan=9>Nenhum resultado encontrado</td>";
                    }
                    ?>
                </tbody>
            </table>
        </section>
    </body>
</html>