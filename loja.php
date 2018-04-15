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
            require_once "@classe-vitrine-produtos.php";
            require_once "@classe-produtos.php";
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
            
            $getDepartamento = $buscarDepartamento == true ? addslashes($_GET["departamento"]) : null;
            $getCategoria = $buscarCategoria == true ? addslashes($_GET["categoria"]) : null;
            $getSubcategoria = $buscarSubcategoria == true ? addslashes($_GET["subcategoria"]) : null;
            
            $selectedProdutos = array();
            $ctrlProdutos = 0;
            
            $cls_produtos = new Produtos();
            
            function valida_array($array){
                $retorno = is_array($array) && count($array) > 0 ? true : false;
                return $retorno;
            }
            
            function add_produto($id){
                global $selectedProdutos, $ctrlProdutos;
                if(array_search($id, $selectedProdutos) == ""){
                    $selectedProdutos[$ctrlProdutos] = $id;
                    $ctrlProdutos++;
                }
            }
            
            $tituloVitrine = "Ocorreu um erro. Contate um administrador!";
            
            if($buscarSubcategoria){
                $selected = array();
                $ctrlSelected = 0;
                $selectedFinal = array();
                $ctrlSelectedFinal = 0;
                
                $tituloVitrine = $cls_produtos->get_titulo_relacionado("subcategoria", "ref = '$getSubcategoria'");
                
                if($buscarDepartamento && $buscarCategoria){
                    
                    $selectedDepartamento = $cls_produtos->search_departamentos_produtos("ref = '$getDepartamento'");
                    $selectedCategoria = $cls_produtos->search_categorias_produtos("ref = '$getCategoria'");
                    $selectedSubcategoria = $cls_produtos->search_subcategorias_produtos("ref = '$getSubcategoria'");
                    
                    
                    foreach($selectedCategoria as $idProduto){
                        if(array_search($idProduto, $selectedDepartamento) != ""){
                            $selected[$ctrlSelected] = $idProduto;
                            $ctrlSelected++;
                        }
                    }
                    
                    foreach($selectedSubcategoria as $idProduto){
                        if(array_search($idProduto, $selected) != ""){
                            $selectedFinal[$ctrlSelectedFinal] = $idProduto;
                            $ctrlSelectedFinal++;
                        }
                    }
                    
                }else if($buscarCategoria){
                    
                    $selectedCategoria = $cls_produtos->search_categorias_produtos("ref = '$getCategoria'");
                    $selectedSubcategoria = $cls_produtos->search_subcategorias_produtos("ref = '$getSubcategoria'");
                    
                    foreach($selectedSubcategoria as $idProduto){
                        if(array_search($idProduto, $selectedCategoria) != ""){
                            $selectedFinal[$ctrlSelectedFinal] = $idProduto;
                            $ctrlSelectedFinal++;
                        }
                    }
                    
                }else{
                    $selectedSubcategoria = $cls_produtos->search_subcategorias_produtos("ref = '$getSubcategoria'");
                    
                    foreach($selectedSubcategoria as $idProduto){
                        $selectedFinal[$ctrlSelectedFinal] = $idProduto;
                        $ctrlSelectedFinal++;
                    }
                }
                
                foreach($selectedFinal as $id){
                    add_produto($id);
                }
                
            }else if($buscarCategoria){
                
            }else if($buscarDepartamento){
                
            }
            
            //print_r($selectedProdutos); // Produtos que foram filtrados
            
            
            $iconArrow = "<i class='fas fa-angle-right icon'></i>"; 
            $navigationTree = "<div class='navigation-tree'><a href='index.php'>Página inicial</a> $iconArrow <a href='#'>Feminino</a></a></div>";

            $vitrineProdutos[0] = new VitrineProdutos("standard", 20, "<h1>$tituloVitrine</h1>", "Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor desconhecido pegou uma bandeja de tipos e os embaralhou para fazer um livro de modelos de tipos.");
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