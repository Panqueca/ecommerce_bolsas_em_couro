<?php

    ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    session_start();
    
    require_once "@classe-paginas.php";

    $cls_paginas->set_titulo("Loja");
    $cls_paginas->set_descricao("...");

    $buscarDepartamento = isset($_GET["departamento"]) ? true : false;
    $buscarCategoria = isset($_GET["categoria"]) ? true : false;
    $buscarSubcategoria = isset($_GET["subcategoria"]) ? true : false;

    $getDepartamento = $buscarDepartamento == true ? addslashes($_GET["departamento"]) : null;
    $getCategoria = $buscarCategoria == true ? addslashes($_GET["categoria"]) : null;
    $getSubcategoria = $buscarSubcategoria == true ? addslashes($_GET["subcategoria"]) : null;

    require_once "@pew/pew-system-config.php";
    require_once "@classe-produtos.php";

    $cls_produtos = new Produtos();

    if($getSubcategoria != null){
        $headInfo = $cls_produtos->get_referencias("subcategoria", "ref = '$getSubcategoria'");
        if($headInfo != false){
            $cls_paginas->set_titulo($headInfo["titulo"]);
            $cls_paginas->set_descricao($headInfo["descricao"]);
        }
    }else if($getCategoria != null){
        $headInfo = $cls_produtos->get_referencias("categoria", "ref = '$getCategoria'");
        if($headInfo != false){
            $cls_paginas->set_titulo($headInfo["titulo"]);
            $cls_paginas->set_descricao($headInfo["descricao"]);
        }
    }else if($getDepartamento != null){
        $headInfo = $cls_produtos->get_referencias("departamento", "ref = '$getDepartamento'");
        if($headInfo != false){
            $cls_paginas->set_titulo($headInfo["titulo"]);
            $cls_paginas->set_descricao($headInfo["descricao"]);
        }
    }

    $dirImagensDepartamento = "imagens/departamentos/";
    $bgPadrao = "background-vitrine-padrao.png";

    if($getDepartamento != null){
        $tabela_departamentos = $pew_custom_db->tabela_departamentos;
        $queryImagem = mysqli_query($conexao, "select imagem from $tabela_departamentos where ref = '$getDepartamento'");
        $infoImagem = mysqli_fetch_array($queryImagem);
        
        $imagemDepartamento = $infoImagem["imagem"];
        
        if(!file_exists($dirImagensDepartamento.$imagemDepartamento) || $imagemDepartamento == ""){
            $backgroundVitrine = $dirImagensDepartamento.$bgPadrao;
        }else{
            $backgroundVitrine = $dirImagensDepartamento.$imagemDepartamento;
        }
        
    }else{
        $backgroundVitrine = $dirImagensDepartamento.$bgPadrao;
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <meta name="HandheldFriendly" content="true">
        <meta name="description" content="<?php echo $cls_paginas->descricao;?>">
        <meta name="author" content="Efectus Web">
        <title><?php echo $cls_paginas->titulo;?></title>
        <link type="image/png" rel="icon" href="imagens/identidadeVisual/logo-icon.png">
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
                min-height: 300px;
                background-color: #eee;
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
                
                var urlClasseVitrine = "@classe-vitrine-produtos.php";
                
                var btnShowMore = $(".js-btn-show-more");
                
                var iconPlus = "<i class='fas fa-plus'></i>";
                var iconLoading = "<i class='fas fa-spinner fa-spin'></i>";
                
                var arrayProdutos = $("#vitrineArrayProdutos").val();
                var exceptionProdutos = $("#vitrineAddedProdutos").val();
                
                var arrayProdutosFila = [];
                var arrayProdutosAdicionados = [];
                
                var adicionandoProdutos = false;
                
                JSON.parse(arrayProdutos).forEach(function(idProduto){
                    arrayProdutosFila[arrayProdutosFila.length] = idProduto;
                });
                
                JSON.parse(exceptionProdutos).forEach(function(idProduto){
                    arrayProdutosAdicionados[arrayProdutosAdicionados.length] = idProduto;
                });
                
                var maxAppend = $("#vitrineMaxAppend").val() > 0 ? $("#vitrineMaxAppend").val() : 20;
                
                function append_produtos(){
                    if(!adicionandoProdutos){
                        adicionandoProdutos = true;
                        var add_queue = [];
                        var ctrl_added = 0;
                        btnShowMore.html(iconLoading);
                        arrayProdutosFila.forEach(function(idProduto){
                            var add = true;

                            arrayProdutosAdicionados.forEach(function(idException){
                                if(idProduto == idException){
                                    add = false;
                                }
                            });

                            if(add && ctrl_added < maxAppend){
                                add_queue[ctrl_added] = idProduto;
                                arrayProdutosAdicionados[arrayProdutosAdicionados.length] = idProduto;
                                ctrl_added++;
                            }
                        });
                        
                        function finish(appendContent){
                            btnShowMore.html(iconPlus);
                            if(arrayProdutosFila.length == arrayProdutosAdicionados.length){
                                btnShowMore.remove();
                            }
                            adicionandoProdutos = false;
                            if(appendContent != false){
                                $(".vitrine-standard .display-produtos").append(appendContent);
                            }
                        }

                        $.ajax({
                            type: "POST",
                            url: urlClasseVitrine,
                            data: {acao_vitrine: "get_box_produto", produtos: add_queue},
                            error: function(){
                                notificacaoPadrao("Ocorreu um erro ao buscar os produtos");
                                finish(false);
                            },
                            success: function(resposta){
                                if(resposta != "false"){
                                    finish(resposta);   
                                }else{
                                    finish(false);   
                                }
                            }
                        });
                    }
                }
                
                btnShowMore.off().on("click", function(){
                    append_produtos();
                });
                
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
        ?>
        <!--THIS PAGE CONTENT-->
        <div class="background-loja">
            <img src="<?php echo $backgroundVitrine; ?>">
        </div>
        <div class="main-content">
        <?php
            
            $selectedProdutos = array();
            $ctrlProdutos = 0;
            
            function valida_array($array){
                $retorno = is_array($array) && count($array) > 0 ? true : false;
                return $retorno;
            }
            
            function add_produto($id){
                global $selectedProdutos, $ctrlProdutos;
                if(array_search($id, $selectedProdutos) >= 0){
                    $selectedProdutos[$ctrlProdutos] = $id;
                    $ctrlProdutos++;
                }
            }
            
            $tituloVitrine = "Ocorreu um erro. Contate um administrador!";
            $descricaoVitrine = "Ocorreu um erro. Contate um administrador!";
            
            $navigationTree = "";
            $ctrlNavigation = 0;
            
            function add_navigation($titulo, $url){
                global $navigationTree, $ctrlNavigation;
                
                $iconArrow = "<i class='fas fa-angle-right icon'></i>";
                
                $titulo = mb_convert_case($titulo, MB_CASE_TITLE, "UTF-8");
                
                $navigationTree .= $ctrlNavigation == 0 ? "<a href='$url'>$titulo</a>" : "$iconArrow <a href='$url'>$titulo</a>";
                $ctrlNavigation++;
            }
            
            add_navigation("Página inicial", "index.php");
            
            if($buscarSubcategoria){
                $selected = array();
                $ctrlSelected = 0;
                $selectedFinal = array();
                $ctrlSelectedFinal = 0;
                
                $infoVitrine = $cls_produtos->get_referencias("subcategoria", "ref = '$getSubcategoria'");
                if($infoVitrine != false){
                    
                    $tituloVitrine = $infoVitrine["titulo"];
                    $descricaoVitrine = $infoVitrine["descricao"];

                    if($buscarDepartamento && $buscarCategoria){
                        $selectedDepartamento = $cls_produtos->search_departamentos_produtos("ref = '$getDepartamento'");
                        $selectedCategoria = $cls_produtos->search_categorias_produtos("ref = '$getCategoria'");
                        $selectedSubcategoria = $cls_produtos->search_subcategorias_produtos("ref = '$getSubcategoria'");
                        foreach($selectedCategoria as $idProduto){
                            if(array_search($idProduto, $selectedDepartamento) >= 0 || array_search($idProduto, $selectedDepartamento) != null){
                                $selected[$ctrlSelected] = $idProduto;
                                $ctrlSelected++;
                            }
                        }
                        foreach($selectedSubcategoria as $idProduto){
                            if(array_search($idProduto, $selected) >= 0 || array_search($idProduto, $selected) != null){
                                $selectedFinal[$ctrlSelectedFinal] = $idProduto;
                                $ctrlSelectedFinal++;
                            }
                        }

                        $navInfoDepart = $cls_produtos->get_referencias("departamento", "ref = '$getDepartamento'");
                        if($navInfoDepart != false){
                            add_navigation($navInfoDepart["titulo"], "loja.php?departamento=$getDepartamento");
                        }
                        
                        $navInfoCat = $cls_produtos->get_referencias("categoria", "ref = '$getCategoria'");
                        if($navInfoCat != false){
                            add_navigation($navInfoCat["titulo"], "loja.php?departamento=$getDepartamento&categoria=$getCategoria");
                        }
                        
                        add_navigation($tituloVitrine, "loja.php?departamento=$getDepartamento&categoria=$getCategoria&subcategoria=$getSubcategoria");

                    }else if($buscarCategoria){
                        $selectedCategoria = $cls_produtos->search_categorias_produtos("ref = '$getCategoria'");
                        $selectedSubcategoria = $cls_produtos->search_subcategorias_produtos("ref = '$getSubcategoria'");

                        foreach($selectedSubcategoria as $idProduto){
                            if(array_search($idProduto, $selectedCategoria) >= 0 || array_search($idProduto, $selectedCategoria) != null){
                                $selectedFinal[$ctrlSelectedFinal] = $idProduto;
                                $ctrlSelectedFinal++;
                            }
                        }
                        
                        $navInfoCat = $cls_produtos->get_referencias("categoria", "ref = '$getCategoria'");
                        if($navInfoCat != false){
                            add_navigation($navInfoCat["titulo"], "loja.php?departamento=$getDepartamento&categoria=$getCategoria");
                        }
                        
                        add_navigation($tituloVitrine, "loja.php?categoria=$getCategoria&subcategoria=$getSubcategoria");
                        
                    }else{
                        $selectedSubcategoria = $cls_produtos->search_subcategorias_produtos("ref = '$getSubcategoria'");

                        foreach($selectedSubcategoria as $idProduto){
                            $selectedFinal[$ctrlSelectedFinal] = $idProduto;
                            $ctrlSelectedFinal++;
                        }
                        
                        add_navigation($tituloVitrine, "loja.php?subcategoria=$getSubcategoria");
                    }
                    
                    foreach($selectedFinal as $id){
                        add_produto($id);
                    }
                    
                }
            }else if($buscarCategoria){
                $selectedFinal = array();
                $ctrlSelectedFinal = 0;
                
                $infoVitrine = $cls_produtos->get_referencias("categoria", "ref = '$getCategoria'");
                $tituloVitrine = $infoVitrine["titulo"];
                $descricaoVitrine = $infoVitrine["descricao"];
                
                if($buscarDepartamento && $buscarCategoria){
                    $selectedDepartamento = $cls_produtos->search_departamentos_produtos("ref = '$getDepartamento'");
                    $selectedCategoria = $cls_produtos->search_categorias_produtos("ref = '$getCategoria'");
                    
                    foreach($selectedCategoria as $idProduto){
                        if(array_search($idProduto, $selectedDepartamento) >= 0 || array_search($idProduto, $selectedDepartamento) != null){
                            $selectedFinal[$ctrlSelectedFinal] = $idProduto;
                            $ctrlSelectedFinal++;
                        }
                    }
                    
                    $navInfoDepart = $cls_produtos->get_referencias("departamento", "ref = '$getDepartamento'");
                    if($navInfoDepart != false){
                        add_navigation($navInfoDepart["titulo"], "loja.php?departamento=$getDepartamento");
                    }
                    
                    add_navigation($tituloVitrine, "loja.php?departamento=$getDepartamento&categoria=$getCategoria");
                    
                }else{
                    $selectedCategoria = $cls_produtos->search_categorias_produtos("ref = '$getCategoria'");
                    foreach($selectedCategoria as $idProduto){
                        $selectedFinal[$ctrlSelectedFinal] = $idProduto;
                        $ctrlSelectedFinal++;
                    }
                    
                    add_navigation($tituloVitrine, "loja.php?categoria=$getCategoria");
                }
                foreach($selectedFinal as $id){
                    add_produto($id);
                }
            }else if($buscarDepartamento){
                $selected = array();
                $ctrlSelected = 0;
                $selectedFinal = array();
                $ctrlSelectedFinal = 0;
                
                $infoVitrine = $cls_produtos->get_referencias("departamento", "ref = '$getDepartamento'");
                $tituloVitrine = $infoVitrine["titulo"];
                $descricaoVitrine = $infoVitrine["descricao"];

                $selectedDepartamento = $cls_produtos->search_departamentos_produtos("ref = '$getDepartamento'");

                foreach($selectedDepartamento as $idProduto){
                    $selectedFinal[$ctrlSelectedFinal] = $idProduto;
                    $ctrlSelectedFinal++;
                }
                
                add_navigation($tituloVitrine, "loja.php?departamento=$getDepartamento");
                
                foreach($selectedFinal as $id){
                    add_produto($id);
                }
            }else if(isset($_GET["busca"])){
                $busca = addslashes($_GET["busca"]);
                $tituloVitrine = "Exibindo resultados para: " . $busca;
                $selectedProdutos = $cls_produtos->buscar($busca);
                $totalResultados = count($selectedProdutos);
                $descricaoVitrine = "Foram encontrados <b>$totalResultados resultados</b>";
                
            }
            
            //print_r($selectedProdutos); // Produtos que foram filtrados
            
            echo "<div class='navigation-tree'>" . $navigationTree . "</div>";
            
            
            $maxAppend = 20;
            
            $vitrineProdutos[0] = new VitrineProdutos("standard", $maxAppend, "<h1 class='titulo-vitrine'>$tituloVitrine</h1>", $descricaoVitrine);
            $vitrineProdutos[0]->montar_vitrine($selectedProdutos);
            $selectedExceptions = $vitrineProdutos[0]->get_exceptions();
            
            $jsonProdutos = json_encode($selectedProdutos);
            $jsonExceptions = json_encode($selectedExceptions);
            
            echo "<input type='hidden' value='$jsonProdutos' id='vitrineArrayProdutos'>";
            echo "<input type='hidden' value='$jsonExceptions' id='vitrineAddedProdutos'>";
            echo "<input type='hidden' value='$maxAppend' id='vitrineMaxAppend'>";
            
            echo "<div class='btn-show-more js-btn-show-more'><i class='fas fa-plus'></i></div>";
        ?>
        </div>
        <!--END THIS PAGE CONTENT-->
        <?php
            require_once "@include-footer-principal.php";
        ?>
        <!--END REQUIRES PADRAO-->
    </body>
</html>