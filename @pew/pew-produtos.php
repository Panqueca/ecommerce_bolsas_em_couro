<?php
    session_start();
    
    $thisPageURL = substr($_SERVER["REQUEST_URI"], strpos($_SERVER["REQUEST_URI"], '@pew'));
    $_POST["next_page"] = str_replace("@pew/", "", $thisPageURL);
    $_POST["invalid_levels"] = array(1);
    
    require_once "@link-important-functions.php";
    require_once "@valida-sessao.php";

    $navigation_title = "Produtos - " . $pew_session->empresa;
    $page_title = "Gerenciamento de Produtos";
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
        <script type="text/javascript" src="js/produtos.js"></script>
        
        <!--THIS PAGE CSS-->
        <style>
            .lista-produtos{
                width: calc(100% - 30px);
                margin: 40px 15px 40px 15px;
                padding-top: 50px;
                display: flex;
                flex-flow: row wrap;
                justify-content: left;
            }
            .box-produto{
                position: relative;
                width: calc(25% - 22px);
                padding: 10px 0px 40px 0px;
                margin: 0px 20px 0px 0px;
                background-color: #fff;
                border: 1px solid #ccc;
                transition: .2s;
                color: #666;
            }
            .box-produto:hover{
                -webkit-box-shadow: 0px 0px 15px 8px rgba(0, 0, 0, .1);
                -moz-box-shadow: 0px 0px 15px 8px rgba(0, 0, 0, .1);
                box-shadow: 0px 0px 15px 8px rgba(0, 0, 0, .1); 
            }
            .box-produto .imagem{
                width: 100%;
                background-color: #fff;
                border-bottom: 1px solid #ccc;
            }
            .box-produto .imagem:hover{
                opacity: .9;   
            }
            .box-produto .imagem img{
                width: 100%;
                border-radius: 10px;
            }
            .box-produto .informacoes{
                width: calc(100%);
                padding: 0px;
                margin: 0px auto;
            }
            .box-produto .informacoes .nome-produto{
                text-align: left;
                font-size: 18px;
                margin: 10px 0px 10px 15px;
            }
            .box-produto .informacoes .nome-produto a{
                text-decoration: none;
                color: #111;
            }
            .box-produto .informacoes .nome-produto a:hover{
                color: #f78a14;
            }
            .box-info{
                position: relative;
                text-align: left;
                margin-bottom: 20px;
            }
            .box-info .titulo{
                font-size: 14px;
                border-bottom: 1px solid #ccc;
                padding: 5px 0px 5px 0px;
                margin: 0px;
                color: #111;
            }
            .box-info .descricao{
                font-size: 14px; 
                margin: 5px 0px 5px 0px;
            }
            .bottom-buttons{
                position: absolute;
                width: 100%;
                bottom: 0px;
                display: flex;
                flex-flow: row wrap;
                align-items: flex-end;
                font-size: 12px;
            }
            .bottom-buttons .box-button{
                width: 50%;
            }
            .bottom-buttons .btn-status-produto{
                width: 100%;
                margin: 0px;
                padding: 0px;
                border: none;
                border-bottom: 2px solid #bf1e1c;
                border-radius: 0px;
            }
            .bottom-buttons .btn-ativar{
                border-color: #2f912f;
            }
            .bottom-buttons .btn-alterar-produto{
                width: 100%;
                margin: 0px;
                padding: 0px;
                border: none;
                border-bottom: 2px solid #333;
                border-radius: 0px;
            }
            .bottom-buttons .btn-status-produto:hover, .bottom-buttons .btn-alterar-produto:hover{
                background-color: #f0f0f0;
                transform: scale(1);
            }
        </style>
        <!--FIM THIS PAGE CSS-->
    </head>
    <body>
        <?php
            // STANDARD REQUIRE
            require_once "@include-body.php";
            if(isset($block_level) && $block_level == true){
                $pew_session->block_level();
            }
        ?>
        <!--PAGE CONTENT-->
        <h1 class="titulos"><?php echo $page_title; ?></h1>
            <section class="conteudo-painel">
            <div class="group clear">
                <form action="pew-produtos.php" method="get" class="label half clear">
                    <label class="group">
                        <div class="group">
                            <h3 class="label-title">Busca de produtos</h3>
                        </div>
                        <div class="group">
                            <div class="xlarge" style="margin-left: -5px; margin-right: 0px;">
                                <input type="search" name="busca" placeholder="Busque por titulo, categorias, marcas..." class="label-input" title="Buscar">
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
                        <a href="pew-cadastra-produto.php" class="btn-flat" title="Cadastre um novo produto"><i class="fas fa-plus"></i> Cadastrar produto</a>
                        <a href="pew-marcas.php" class="btn-flat" title="Gerenciamento de marcas"><i class="fas fa-plus"></i> Marcas</a>
                        <a href="pew-cores.php" class="btn-flat" title="Gerenciamento de cores"><i class="fas fa-plus"></i> Cores</a>
                        <a href="pew-produtos-relatorios.php" class="btn-flat" title="Ver Relatórios"><i class="fas fa-chart-pie"></i> Relatórios</a>
                    </div>
                </div>
            </div>
            <div class="lista-produtos full clear">
                <h4 class="subtitulos group clear" align=left style="margin-bottom: 10px">Listagem de produtos</h4>
                <?php
                    $tabela_produtos = $pew_custom_db->tabela_produtos;
                    $tabela_imagens_produtos = $pew_custom_db->tabela_imagens_produtos;
                    $tabela_categorias = $pew_db->tabela_categorias;
                    $tabela_subcategorias = $pew_db->tabela_subcategorias;
                    $tabela_categorias_produtos = $pew_custom_db->tabela_categorias_produtos;
                    $tabela_subcategorias_produtos = $pew_custom_db->tabela_subcategorias_produtos;
                    if(isset($_GET["busca"]) && $_GET["busca"] != ""){
                        $busca = pew_string_format($_GET["busca"]);
                        $strBusca = "where id like '%".$busca."%' or nome like '%".$busca."%' or marca like '%".$busca."%' or descricao_curta like '%".$busca."%' or descricao_longa like '%".$busca."%'";
                        echo "<div class='group clear'><h3>Exibindo resultados para: $busca</h3></div>";
                    }else{
                        $strBusca = "";
                    }
                    $contarProdutos = mysqli_query($conexao, "select count(id) as total_produtos from $tabela_produtos $strBusca");
                    $contagemProdutos = mysqli_fetch_assoc($contarProdutos);
                    $totalSearchProd = $contagemProdutos["total_produtos"];

                    $selectedProds = array();
                    $count = 0;
                    function listarProdutos($searchCondition){
                        global $conexao, $tabela_produtos, $tabela_imagens_produtos, $tabela_categorias, $tabela_subcategorias, $tabela_categorias_produtos, $tabela_subcategorias_produtos, $tabela_departamentos, $tabela_departamentos_produtos, $pew_functions;
                        $queryProdutos = mysqli_query($conexao, "select * from $tabela_produtos $searchCondition order by id desc");
                        while($produtos = mysqli_fetch_array($queryProdutos)){
                            $id = $produtos["id"];
                            $nome = $produtos["nome"];
                            $marca = $produtos["marca"] != "" ? $produtos["marca"] : "Não selecionada";
                            $estoque = $produtos["estoque"];
                            $sku = $produtos["sku"];
                            $data = $produtos["data"];
                            $data = substr($data, 0, 10);
                            $data = $pew_functions->inverter_data($data);
                            $visualizacoes = $produtos["visualizacoes"];
                            $status = $produtos["status"] == 1 ? "Ativo" : "Desativado";
                            $btnStatus = $status == "Ativo" ? "<a class='btn-desativar btn-status-produto' data-produto-id='$id' data-acao='desativar' title='Clique para alterar o status do produto'>Desativar</a>" : "<a class='btn-ativar btn-status-produto' data-produto-id='$id' data-acao='ativar' title='Clique para alterar o status do produto'>Ativar</a>";
                            $contarIMG = mysqli_query($conexao, "select count(id) as total_imagens from $tabela_imagens_produtos where id_produto = '$id'");
                            $contagemIMG = mysqli_fetch_assoc($contarIMG);
                            if($contagemIMG > 0){
                                $queryIMG = mysqli_query($conexao, "select * from $tabela_imagens_produtos where id_produto = '$id' and status = 1 order by posicao");
                                $arrayIMG = mysqli_fetch_assoc($queryIMG);
                                $imagem = $arrayIMG["imagem"];
                            }else{
                                $imagem = "produto-padrao.png";
                            }
                            $dirIMG = "../imagens/produtos/$imagem";
                            if(!file_exists($dirIMG) || $imagem == ""){
                                $dirIMG = "../imagens/produtos/produto-padrao.png";
                            }
                            $urlAlteraProd = "pew-edita-produto.php?id_produto=$id";
                            echo "<div class='box-produto' id='boxProduto$id'>";
                                echo "<div class='imagem'><a href='$urlAlteraProd'><img src='$dirIMG'></a></div>";
                                echo "<div class='informacoes'>";
                                    echo "<h3 class='nome-produto'><a href='$urlAlteraProd'>$nome</a></h3>";
                                    echo "<div class='half box-info'>";
                                        echo "<h4 class='titulo'><i class='fa fa-power-off' aria-hidden='true'></i> Status</h4>";
                                        echo "<h3 class='descricao' id='viewStatusProd'>$status</h3>";
                                    echo "</div>";
                                    echo "<div class='half box-info'>";
                                        echo "<h4 class='titulo'><i class='fa fa-tag' aria-hidden='true'></i> Marca</h4>";
                                        echo "<h3 class='descricao'>$marca</h3>";
                                    echo "</div>";
                                    echo "<div class='half box-info'>";
                                        echo "<h4 class='titulo'><i class='fas fa-cubes'></i> Estoque</h4>";
                                        echo "<h3 class='descricao'>$estoque</h3>";
                                    echo "</div>";
                                    echo "<div class='half box-info'>";
                                        echo "<h4 class='titulo'><i class='fas fa-hashtag'></i> SKU</h4>";
                                        echo "<h3 class='descricao'>$sku</h3>";
                                    echo "</div>";
                                    echo "<div class='bottom-buttons group clear'>";
                                        echo "<div class='box-button' style='margin: 0px;'>";
                                            echo $btnStatus;
                                        echo "</div>";
                                        echo "<div class='box-button' style='margin: 0px;'>";
                                            echo "<a href='$urlAlteraProd' class='btn-alterar btn-alterar-produto' title='Clique para fazer alterações no produto'>Alterar</a>";
                                        echo "</div>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                            global $count, $selectedProds;
                            $count++;
                            $selectedProds[$count] = $id;
                        }
                    }
                    if($totalSearchProd > 0){
                        listarProdutos($strBusca);
                    }
                    $ctrlTotalProdutos = $totalSearchProd;

                    function validarBuscaProduto($table, $searchCondition){
                        global $conexao, $ctrlTotalProdutos, $selectedProds;
                        $queryIdProdutos = mysqli_query($conexao, "select id_produto from $table $searchCondition");
                        while($arrayProduto = mysqli_fetch_array($queryIdProdutos)){
                            $ctrlTotalProdutos++;
                            $idProduto = $arrayProduto["id_produto"];
                            $buscar = "where id = '$idProduto'";
                            $listar = true;
                            foreach($selectedProds as $searchedProd){
                                if($searchedProd == $idProduto){
                                    $listar = false;
                                }
                            }
                            if($listar){
                                listarProdutos($buscar);
                            }
                        }
                    }

                    function buscarQuantidadeId($first_table, $first_condition, $second_table, $second_condition){
                        global $conexao;
                        $contar = mysqli_query($conexao, "select count(id) as contagem from $first_table $first_condition");
                        $contagem = mysqli_fetch_assoc($contar);
                        $totalFirst = $contagem["contagem"];
                        if($totalFirst > 0){
                            $resultIds = array();
                            $i = 0;
                            $firstQuery = mysqli_query($conexao, "select id from $first_table $first_condition");
                            while($arrayFirstQuery = mysqli_fetch_array($firstQuery)){
                                $i++;
                                $selectedId = $arrayFirstQuery["id"];
                                $resultIds[$i++] = $selectedId;
                                $second_condition = str_replace("replace_result_id", $selectedId, $second_condition);
                                $secondQuery = mysqli_query($conexao, "select count(id) as contagem_two from $second_table $second_condition");
                                $arraySecondQuery = mysqli_fetch_assoc($secondQuery);
                                $totalSecond = $arraySecondQuery["contagem_two"];
                                $second_condition = str_replace($selectedId, "replace_result_id", $second_condition);
                            }
                            return $resultIds;
                        }else{
                            return false;
                        }
                    }

                    if(isset($_GET["busca"]) && $_GET["busca"] != ""){
                        $busca = pew_string_format($_GET["busca"]);
                        /*Buscar categorias*/
                        $buscaCategorias = buscarQuantidadeId($tabela_categorias, "where categoria like '%$busca%'", $tabela_categorias_produtos, "where id_categoria = 'replace_result_id'");
                        if($buscaCategorias != false){
                            foreach($buscaCategorias as $idCategoria){
                                validarBuscaProduto($tabela_categorias_produtos, "where id_categoria = '$idCategoria'");
                            }
                        }
                        /*Buscar subcategorias*/
                        $buscaSubcategorias = buscarQuantidadeId($tabela_subcategorias, "where subcategoria like '%$busca%'", $tabela_subcategorias_produtos, "where id_subcategoria = 'replace_result_id'");
                        if($buscaSubcategorias != false){
                            foreach($buscaSubcategorias as $idSubcategoria){
                                validarBuscaProduto($tabela_subcategorias_produtos, "where id_subcategoria = '$idSubcategoria'");
                            }
                        }
                    }

                    if($ctrlTotalProdutos == 0){
                        if($strBusca == ""){
                            echo "<br><h3 align='center'>Nenhum Produto foi cadastrado. <a href='pew-cadastra-produto.php' class='link-padrao'>Clique aqui é cadastre</a></h3>";
                        }else{
                            echo "<br><h3 align='center'>Nenhum Produto foi encontrado. <a href='pew-produtos.php' class='link-padrao'>Voltar</a></h3>";
                        }
                    }
                ?>
            </div>
            <br style="clear: both;">
        </section>
    </body>
</html>