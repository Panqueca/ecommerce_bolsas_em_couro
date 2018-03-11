<?php
session_start();
require_once "pew-system-config.php";
$name_session_user = $pew_session->name_user;
$name_session_pass = $pew_session->name_pass;
$name_session_nivel = $pew_session->name_nivel;
$name_session_empresa = $pew_session->name_empresa;
if(isset($_SESSION[$name_session_user]) && isset($_SESSION[$name_session_pass]) && isset($_SESSION[$name_session_nivel]) && isset($_SESSION[$name_session_empresa])){
    $efectus_empresa_administrativo = $_SESSION[$name_session_empresa];
    $efectus_user_administrativo = $_SESSION[$name_session_user];
    $efectus_nivel_administrativo = $_SESSION[$name_session_nivel];
    $navigation_title = "Produtos - $efectus_empresa_administrativo";
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
        <!--LINKS e JS PADRAO-->
        <link type="image/png" rel="icon" href="imagens/sistema/identidadeVisual/icone-efectus-web.png">
        <link type="text/css" rel="stylesheet" href="css/estilo.css">
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/standard.js"></script>
        <!--FIM LINKS e JS PADRAO-->
        <!--THIS PAGE LINKS-->
        <script type="text/javascript" src="js/produtos.js"></script>
        <!--FIM THIS PAGE LINKS-->
        <!--THIS PAGE CSS-->
        <style>
            .lista-produtos{
                width: 80%;
                margin-left: 10%;
            }
            .box-produto{
                width: 98%;
                margin-top: 50px;
                border-radius: 10px;
                padding: 1%;
                padding-top: 10px;
                padding-bottom: 40px;
                -webkit-box-shadow: 0px 0px 45px 8px rgba(0,0,0,0.10);
                -moz-box-shadow: 0px 0px 45px 8px rgba(0,0,0,0.10);
                box-shadow: 0px 0px 45px 8px rgba(0,0,0,0.10);
                position: relative;
            }
            .box-produto .imagem{
                width: 20%;
                float: left;
                background-color: #fff;
                border-radius: 10px;
            }
            .box-produto .imagem img{
                width: 100%;
                border-radius: 10px;
            }
            .box-produto .informacoes{
                width: 78%;
                margin-left: 22%;
            }
            .box-produto .informacoes .nome-produto{
                text-align: left;
                font-size: 36px;
                padding-bottom: 5px;
                margin-bottom: 5px;
                border-bottom: 2px solid #111;
                margin: 0;
            }
            .box-produto .informacoes .nome-produto a{
                text-decoration: none;
                color: #111;
            }
            .info-small{
                width: 32.3%;
                margin: .5%;
                margin-top: 20px;
                height: 50px;
                margin-bottom: 10px;
                background-color: #fbfbfb;
                padding-top: 10px;
                padding-bottom: 10px;
                border-radius: 10px;
                position: relative;
                float: left;
            }
            .info-half{
                width: 49%;
                margin: .5%;
                margin-top: 20px;
                height: 50px;
                margin-bottom: 10px;
                background-color: #fbfbfb;
                padding-top: 10px;
                padding-bottom: 10px;
                border-radius: 10px;
                position: relative;
                float: left;
            }
            .info-full{
                width: 99%;
                margin: .5%;
                margin-top: 20px;
                height: 50px;
                margin-bottom: 10px;
                background-color: #fbfbfb;
                padding-top: 10px;
                padding-bottom: 10px;
                border-radius: 10px;
                position: relative;
                float: left;
            }
            .info-titulo{
                position: absolute;
                background-color: #111;
                color: #fff;
                padding: 5px;
                padding-left: 10px;
                padding-right: 10px;
                border-radius: 20px;
                top: -5px;
                left: -2px;
                margin: 0;
            }
            .btn-status-produto{
                border-color: #eee;
                position: absolute;
                bottom: -20px;
                right: 100px;
                padding: 15px;
                padding-left: 25px;
                padding-right: 25px;
            }
            .btn-ativar{
                padding-bottom: 5px;
                position: absolute;
                right: 100px;
                bottom: -10px;
            }
            .btn-ativar:hover{
                border-color: #00ff66;
            }
            .btn-alterar-produto{
                border-color: #eee;
                position: absolute;
                bottom: -10px;
                right: -10px;
                padding: 5px;
                padding-left: 25px;
                padding-right: 25px;
            }
        </style>
        <!--FIM THIS PAGE CSS-->
    </head>
    <body>
        <?php
            require_once "pew-system-config.php";
            require_once "header-efectus-web.php";
            require_once "pew-interatividade.php";
        ?>
        <h1 class="titulos"><?php echo $page_title; ?></h1>
        <section class="conteudo-painel">
            <a href="pew-cadastra-produto.php" class="btn-padrao" title="Cadastre um novo produto">Cadastrar novo</a>
            <div class="lista-produtos">
                <br><br>
                <form action="pew-produtos.php" method="get" class="form-busca">
                    <label class="field-busca">
                        <h3 class="titulo-busca">Busca de produtos</h3>
                        <input type="search" name="busca" placeholder="Pesquise por produtos, categorias, marcas ou descrição." class="barra-busca" title="Buscar">
                        <input type="submit" value="Buscar" class="btn-buscar">
                    </label>
                </form>
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
                        echo "<h3>Exibindo resultados para: $busca</h3>";
                    }else{
                        $strBusca = "";
                    }
                    $contarProdutos = mysqli_query($conexao, "select count(id) as total_produtos from $tabela_produtos $strBusca");
                    $contagemProdutos = mysqli_fetch_assoc($contarProdutos);
                    $totalSearchProd = $contagemProdutos["total_produtos"];

                    $selectedProds = array();
                    $count = 0;
                    function listarProdutos($searchCondition){
                        global $conexao, $tabela_produtos, $tabela_imagens_produtos, $tabela_categorias, $tabela_subcategorias, $tabela_categorias_produtos, $tabela_subcategorias_produtos, $tabela_departamentos, $tabela_departamentos_produtos;
                        $queryProdutos = mysqli_query($conexao, "select * from $tabela_produtos $searchCondition order by id desc");
                        while($produtos = mysqli_fetch_array($queryProdutos)){
                            $id = $produtos["id"];
                            $nome = $produtos["nome"];
                            $marca = $produtos["marca"];
                            $data = $produtos["data"];
                            $data = substr($data, 0, 10);
                            $data = inverterData($data);
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
                                    echo "<div class='info-half'><h4 class='info-titulo'><i class='fa fa-tag' aria-hidden='true'></i> Marca</h4><h3 class='info-descricao'>$marca</h3></div>";
                                    echo "<div class='info-half'><h4 class='info-titulo'><i class='fa fa-calendar' aria-hidden='true'></i> Data</h4><h3 class='info-descricao'>$data</h3></div>";
                                    echo "<div class='info-half'><h4 class='info-titulo'><i class='fa fa-eye' aria-hidden='true'></i> Visualizações</h4><h3 class='info-descricao'>$visualizacoes</h3></div>";
                                    echo "<div class='info-half'><h4 class='info-titulo'><i class='fa fa-power-off' aria-hidden='true'></i> Status</h4><h3 class='info-descricao' id='viewStatusProd'>$status</h3></div>";
                                    echo $btnStatus;
                                    echo "<a href='$urlAlteraProd' class='btn-alterar btn-alterar-produto' title='Clique para fazer alterações no produto'>Alterar</a>";
                                    echo "<br style='clear: both;'>";
                                echo "</div></div>";
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
<?php
}else{
    header("location: index.php?msg=Área Restrita. É necessário fazer login para continuar.");
}
?>
