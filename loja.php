<?php
    session_start();
    $nomeEmpresa = "Bolsas em Couro";
    $descricaoPagina = "DESCRIÇÃO MODELO ATUALIZAR...";
    $tituloPagina = "MUDAR TITULO - $nomeEmpresa";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <meta name="HandheldFriendly" content="true">
        <meta name="description" content="<?php echo $descricaoPagina;?>">
        <meta name="author" content="Efectus Web">
        <title><?php echo $tituloPagina;?></title>
        <!--DEFAULT LINKS-->
        <?php
            require_once "@link-standard-styles.php";
            require_once "@link-standard-scripts.php";
            require_once "@link-important-functions.php";
        ?>
        <!--END DEFAULT LINKS-->
        <!--PAGE CSS-->
        <style>
            .background-loja{
                width: 100%;
            }
            .background-loja img{
                width: 100%;
            }
            .main-content{
                position: relative;
                top: -200px;
                width: 90%;
                padding-top: 40px;
                margin: 0 auto;
                margin-bottom: -150px;
                min-height: 300px;
                background-color: #fff;
                overflow: hidden;
            }
            .vitrine-standard .titulo-vitrine{
                text-align: left;
            }
            @media screen and (max-width: 1100px){
                .main-content{
                    top: -150px;
                    margin-bottom: -100px;
                }
                @media screen and (max-width: 720px){
                    .main-content{
                        top: -100px;
                        margin-bottom: -50px;
                    }
                    @media screen and (max-width: 480px){
                         .main-content{
                            width: 100%;
                            padding: 0px;
                            top: 0px;
                            margin: 0 auto;
                        }
                    }
                }
            }
        </style>
        <!--END PAGE CSS-->
        <!--PAGE JS-->
        <script>
            $(document).ready(function(){
                console.log("Página carregada");
            });
        </script>
        <!--END PAGE JS-->
    </head>
    <body>
        <!--REQUIRES PADRAO-->
        <?php
            require_once "@link-body-scripts.php";
            require_once "@classe-system-functions.php";
            require_once "@include-header-principal.php";
            require_once "@include-interatividade.php";
        ?>
        <!--THIS PAGE CONTENT-->
        <div class="background-loja">
            <img src="imagens/departamentos/linha-feminina.png">
        </div>
        <div class="main-content">
        <?php
            $buscarDepartamento = isset($_GET["departamento"]) ? true : false;
            $buscarCategoria = isset($_GET["categoria"]) ? true : false;
            $buscarSubcategoria = isset($_GET["subcategoria"]) ? true : false;
            
            $selectedProdutos = array();
            $ctrlProdutos = 0;

            function buscarDepartamento($selectedDepartamento, $adicionarProduto = true){
                global $globalVars, $pew_functions, $selectedProdutos, $ctrlProdutos;
                $tabela_departamentos = $globalVars["tabela_departamentos"];
                $totalDepartamentos = $pew_functions->contar_resultados($tabela_departamentos, "ref = '$selectedDepartamento'");
                
                if($totalDepartamentos > 0){
                    $tabela_departamentos_produtos = $globalVars["tabela_departamentos_produtos"];
                    $sql = "SELECT pew_departamentos.ref AS refDepartamento, pew_departamentos.departamento AS nomeDepartamento, pew_produtos.id AS idProduto, pew_produtos.nome AS nomeProduto\n"
                    . "FROM pew_departamentos\n"
                    . "INNER JOIN pew_departamentos_produtos\n"
                    . "on pew_departamentos_produtos.id_departamento = pew_departamentos.id\n"
                    . "INNER JOIN pew_produtos\n"
                    . "on pew_produtos.id = pew_departamentos_produtos.id_produto\n"
                    . "WHERE ref = '$selectedDepartamento'";    
                    $query = mysqli_query($globalVars["conexao"], "$sql");
                    
                    $tituloDepartamento = null;
                    $refDepartamento = null;
                    while($info = mysqli_fetch_array($query)){
                        if($adicionarProduto){
                            $selectedProdutos[$ctrlProdutos] = $info["idProduto"];
                            $ctrlProdutos++;
                        }
                        $tituloDepartamento = $tituloDepartamento == null ? $info["nomeDepartamento"] : $tituloDepartamento;
                        $refDepartamento = $refDepartamento == null ? $info["refDepartamento"] : $refDepartamento;
                    }
                    $retorno = array();
                    $retorno["titulo"] = $tituloDepartamento;
                    $retorno["ref"] = $refDepartamento;

                    return $retorno;
                }else{
                    return false;
                }
            }
            
            function buscarCategoria($selectedCategoria, $adicionarProduto = true){
                global $globalVars, $pew_functions, $selectedProdutos, $ctrlProdutos;
                $tabela_categorias = $globalVars["tabela_categorias"];
                $totalCategorias = $pew_functions->contar_resultados($tabela_categorias, "ref = '$selectedCategoria'");
                
                if($totalCategorias > 0){
                    $tabela_categorias_produtos = $globalVars["tabela_categorias_produtos"];
                    $sql = "SELECT pew_categorias.ref AS refCategoria, pew_categorias.categoria AS nomeCategoria, pew_produtos.id AS idProduto, pew_produtos.nome AS nomeProduto\n"
                    . "FROM pew_categorias\n"
                    . "INNER JOIN pew_categorias_produtos\n"
                    . "on pew_categorias_produtos.id_categoria = pew_categorias.id\n"
                    . "INNER JOIN pew_produtos\n"
                    . "on pew_produtos.id = pew_categorias_produtos.id_produto\n"
                    . "WHERE ref = '$selectedCategoria'";
                    $query = mysqli_query($globalVars["conexao"], "$sql");

                    $tituloCategoria = null;
                    $refCategoria = null;
                    while($info = mysqli_fetch_array($query)){
                        if($adicionarProduto){
                            $selectedProdutos[$ctrlProdutos] = $info["idProduto"];
                            $ctrlProdutos++;
                        }
                        $tituloCategoria = $tituloCategoria == null ? $info["nomeCategoria"] : $tituloCategoria;
                        $refCategoria = $refCategoria == null ? $info["refCategoria"] : $refCategoria;
                    }
                    $retorno = array();
                    $retorno["titulo"] = $tituloCategoria;
                    $retorno["ref"] = $refCategoria;

                    return $retorno;
                }else{
                    return false;
                }
            }
            
            function buscarSubcategoria($selectedSubcategoria, $adicionarProduto = true){
                global $globalVars, $pew_functions, $selectedProdutos, $ctrlProdutos;
                $tabela_subcategorias = $globalVars["tabela_subcategorias"];
                $totalSubcategorias = $pew_functions->contar_resultados($tabela_subcategorias, "ref = '$selectedSubcategoria'");
                
                if($totalSubcategorias > 0){
                    $tabela_subcategorias_produto = $globalVars["tabela_subcategorias_produtos"];
                    $sql = "SELECT pew_subcategorias.ref AS refSubcategoria, pew_subcategorias.subcategoria AS nomeSubcategoria, pew_produtos.id AS idProduto, pew_produtos.nome AS nomeProduto\n"
                    . "FROM pew_subcategorias\n"
                    . "INNER JOIN pew_subcategorias_produtos\n"
                    . "on pew_subcategorias_produtos.id_subcategoria = pew_subcategorias.id\n"
                    . "INNER JOIN pew_produtos\n"
                    . "on pew_produtos.id = pew_subcategorias_produtos.id_produto\n"
                    . "WHERE ref = '$selectedSubcategoria'";
                    $query = mysqli_query($globalVars["conexao"], "$sql");

                    $tituloSubcategoria = null;
                    $refSubcategoria = null;
                    while($info = mysqli_fetch_array($query)){
                        if($adicionarProduto){
                            $selectedProdutos[$ctrlProdutos] = $info["idProduto"];
                            $ctrlProdutos++;
                        }
                        $tituloSubcategoria = $tituloSubcategoria == null ? $info["nomeSubcategoria"] : $tituloSubcategoria;
                        $refSubcategoria = $refSubcategoria == null ? $info["refSubcategoria"] : $refSubcategoria;
                    }
                    $retorno = array();
                    $retorno["titulo"] = $tituloSubcategoria;
                    $retorno["ref"] = $refSubcategoria;

                    return $retorno;
                }else{
                    return false;
                }
            }
            
            
            
            $iconArrow = "<i class='fas fa-angle-right icon'></i>"; 
            $navigationTree = "<div class='navigation-tree'><a href='index.php'>Página inicial</a> $iconArrow <a href='#'>Feminino</a></a></div>";
            if($buscarSubcategoria){
                $get = $_GET["subcategoria"];

                $beleza = buscarSubcategoria($get);
                
                $nome = $beleza["titulo"];
                $ref = $beleza["ref"];
                $navigationTree = "<div class='navigation-tree'><a href='index.php'>Página inicial</a> $iconArrow <a href='#'> $nome</a></a></div>";
            }else if($buscarCategoria){
                $get = $_GET["categoria"];
                
                $beleza = buscarCategoria($get);
                
                $nome = $beleza["titulo"];
                $ref = $beleza["ref"];
                $navigationTree = "<div class='navigation-tree'><a href='index.php'>Página inicial</a> $iconArrow <a href='#'> $nome</a></a></div>";
            }else if($buscarDepartamento){
                $get = $_GET["departamento"];
                
                $beleza = buscarDepartamento($get);
                
                $nome = $beleza["titulo"];
                $ref = $beleza["ref"];
                $navigationTree = "<div class='navigation-tree'><a href='index.php'>Página inicial</a> $iconArrow <a href='#'> $nome</a></a></div>";
            }else{
                header("location: index.php");
            }
            
            echo $navigationTree;
            
            require_once "@classe-vitrine-produtos.php";
            
            
            $condicaoFinal = "";
            $ctrl = 0;
            foreach($selectedProdutos as $idProduto){
                $condicaoFinal .= $ctrl == 0 ? "id = '$idProduto'" : " or id = '$idProduto'";
                $ctrl++;
            }

            $vitrineProdutos[0] = new VitrineProdutos("standard", 20, "<h1>$nome</h1>", "Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos.");
            $vitrineProdutos[0]->montar_vitrine($selectedProdutos);
        ?>
        </div>
        <!--END THIS PAGE CONTENT-->
        <?php
            require_once "@include-footer-principal.php";
        ?>
        <!--END REQUIRES PADRAO-->
    </body>
</html>
