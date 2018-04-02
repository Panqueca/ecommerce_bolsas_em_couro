<?php
    session_start();
    
    $thisPageURL = substr($_SERVER["REQUEST_URI"], strpos($_SERVER["REQUEST_URI"], '@pew'));
    $_POST["next_page"] = str_replace("@pew/", "", $thisPageURL);
    
    require_once "@link-important-functions.php";
    require_once "@valida-sessao.php";

    $navigation_title = "Categorias - " . $pew_session->empresa;
    $page_title = "Gerenciamento de Categorias";
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
        <link type="text/css" rel="stylesheet" href="css/categorias.css">
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/standard.js"></script>
        <!--FIM LINKS e JS PADRAO-->
        <!--THIS PAGE LINKS-->
        <!--FIM THIS PAGE LINKS-->
        <script>
            var filaAtiva = false;
            var filaSubAtiva = false;
            var cadastrando = false;
            var classCategoriaActive = "box-categoria-active";
            var classSubcategoriaActive = "box-subcategoria-active";
            var classGerActive = "display-ger-categorias-active";
            var attrIdCategoria = "pew-id-categoria";
            var attrTituloCategoria = "pew-titulo-categoria";
            var attrIdSubcategoria = "pew-id-subcategoria";
            var attrTituloSubcategoria = "pew-titulo-subcategoria";
            var animationDelay = 100;
            var objGerCategoria = null;
            var lastBoxCategoria = null;
            var lastBoxSubcategoria = null;
            var categoriaAtiva = null;
            var subcategoriaAtiva = null;
            var botaoCadastrar = null;
            var botaoCadastrarSub = null;
            var classBtnActive = "active-box";
            var classIconOpen = "fa-folder-open";
            var classIconClose = "fa-folder";
            var qtdCategorias = 0;
            var selecionandoSubCategoria = false;
            function carregarCategoria(idCategoria, boxCategoria){
                categoriaAtiva = idCategoria;
                boxCategoria.addClass(classCategoriaActive);
                var icone = boxCategoria.children("h3").children("i");
                icone.removeClass(classIconClose).addClass(classIconOpen);
                if(filaAtiva){
                    if(lastBoxCategoria != null){
                        var lastIcone = lastBoxCategoria.children("h3").children("i");
                        lastIcone.removeClass(classIconOpen).addClass(classIconClose);
                        lastBoxCategoria.removeClass(classCategoriaActive);
                    }
                    objGerCategoria.removeClass(classGerActive);
                }
                if(filaSubAtiva && !selecionandoSubCategoria){
                    if(lastBoxSubcategoria != null){
                        var lastIcone = lastBoxSubcategoria.children("i");
                        lastIcone.removeClass(classIconOpen).addClass(classIconClose);
                        lastBoxSubcategoria.removeClass(classSubcategoriaActive);
                    }
                    objGerCategoria.removeClass(classGerActive);
                }
                lastBoxSubcategoria = null;
                subcategoriaAtiva = null;
                filaAtiva = true;
                selecionandoSubCategoria = false;
                botaoCadastrarSub.removeClass(classBtnActive);

                function loadPage(){
                    lastBoxCategoria = boxCategoria;
                    if(!cadastrando && !selecionandoSubCategoria){
                        var url = "pew-edita-categoria.php";
                        objGerCategoria.load(url, {id_categoria: idCategoria}, function(){
                            setTimeout(function(){
                                objGerCategoria.addClass(classGerActive);
                            }, 300);
                        });
                    }
                }
                setTimeout(function(){
                    loadPage();
                }, animationDelay);
            }

            function carregarSubcategoria(idSubcategoria, boxSubcategoria){
                botaoCadastrarSub.removeClass(classBtnActive);
                if(!selecionandoSubCategoria){
                    selecionandoSubCategoria = true;
                    subcategoriaAtiva = idSubcategoria;
                    boxSubcategoria.addClass(classSubcategoriaActive);
                    var icone = boxSubcategoria.children("i");
                    icone.removeClass(classIconClose).addClass(classIconOpen);
                    if(filaSubAtiva){
                        if(lastBoxSubcategoria != null){
                            var lastIcone = lastBoxSubcategoria.children("i");
                            lastIcone.removeClass(classIconOpen).addClass(classIconClose);
                            lastBoxSubcategoria.removeClass(classSubcategoriaActive);
                        }
                        objGerCategoria.removeClass(classGerActive);
                    }
                    filaSubAtiva = true;
                    function loadPage(){
                        lastBoxSubcategoria = boxSubcategoria;
                        if(!cadastrando){
                            var idCategoria = boxSubcategoria.attr(attrIdCategoria);
                            var url = "pew-edita-subcategoria.php";
                            objGerCategoria.load(url, {id_categoria: idCategoria, id_subcategoria: idSubcategoria}, function(){
                                setTimeout(function(){
                                    selecionandoSubCategoria = false;
                                    objGerCategoria.addClass(classGerActive);
                                }, 300);
                            });
                        }
                    }
                    setTimeout(function(){
                        loadPage();
                    }, animationDelay);
                }
            }

            function categoriaFocus(tituloCategoria){
                setTimeout(function(){
                    unselectCategoria();
                    $(".box-categoria").each(function(){
                        var box = $(this);
                        var titulo = box.attr(attrTituloCategoria);
                        var id = box.attr(attrIdCategoria);
                        if(titulo == tituloCategoria){
                            carregarCategoria(id, box);
                        }
                    });
                }, animationDelay);
            }
            function subcategoriaFocus(tituloSubcategoria, idCategoria){
                setTimeout(function(){
                    unselectCategoria();
                    $(".box-categoria").each(function(){
                        var box = $(this);
                        var id = box.attr(attrIdCategoria);
                        if(id == idCategoria){
                            carregarCategoria(id, box);
                            box.children("div").find(".box-subcategoria").each(function(){
                                var boxSub = $(this);
                                var titulo = boxSub.attr(attrTituloSubcategoria);
                                var idSub  = boxSub.attr(attrIdSubcategoria);
                                if(titulo == tituloSubcategoria){
                                    carregarSubcategoria(idSub, boxSub);
                                }
                            });
                        }
                    });
                }, animationDelay);
            }

            function unselectCategoria(){
                if(qtdCategorias > 0 && lastBoxCategoria != null){
                    var lastIcone = lastBoxCategoria.children("h3").children("i");
                    lastIcone.removeClass(classIconOpen).addClass(classIconClose);
                    lastBoxCategoria.removeClass(classCategoriaActive);
                    lastBoxCategoria = null;
                    categoriaAtiva = null;
                }
            }

            $(document).ready(function(){
                objGerCategoria = $(".display-ger-categorias");
                botaoCadastrar = $(".btn-cad-categoria");
                botaoCadastrarSub = $(".btn-cad-subcategoria");

                var firstCategoria = true;
                $(".box-categoria").each(function(){
                    qtdCategorias++;
                    var boxCategoria = $(this);
                    var botaoAlternativo = boxCategoria.children("h3");
                    var idCategoria = boxCategoria.attr(attrIdCategoria);
                    function selectCategoria(){
                        if(categoriaAtiva != idCategoria){
                            carregarCategoria(idCategoria, boxCategoria);
                        }
                    }
                    if(firstCategoria){
                        firstCategoria = false;
                        selectCategoria();
                    }
                    boxCategoria.off().on("click", function(){
                        selectCategoria();
                    });
                    botaoAlternativo.off().on("click", function(){
                        if(categoriaAtiva == idCategoria){
                            categoriaAtiva = null;
                            filaAtiva = false;
                        }
                        carregarCategoria(idCategoria, boxCategoria);
                    });
                });
                $(".box-subcategoria").each(function(){
                    var boxSubcategoria = $(this);
                    var idSubcategoria = boxSubcategoria.attr(attrIdSubcategoria);
                    function selectSubcategoria(){
                        if(subcategoriaAtiva != idSubcategoria){
                            carregarSubcategoria(idSubcategoria, boxSubcategoria);
                        }
                    }
                    boxSubcategoria.off().on("click", function(){
                        selectSubcategoria();
                    });
                });
                botaoCadastrar.off().on("click", function(){
                    if(!cadastrando){
                        cadastrando = true;
                        var url = "pew-cadastra-categoria.php";
                        $(".mensagem-padrao").hide();
                        unselectCategoria();
                        objGerCategoria.removeClass(classGerActive);
                        setTimeout(function(){
                            objGerCategoria.load(url, function(){
                                objGerCategoria.addClass(classGerActive);
                                cadastrando = false;
                            });
                        }, animationDelay);
                    }
                });
                botaoCadastrarSub.off().on("click", function(){
                    $(this).addClass(classBtnActive);
                    var idCategoria = $(this).attr("pew-id-categoria");
                    if(!cadastrando){
                        cadastrando = true;
                        var url = "pew-cadastra-subcategoria.php";
                        objGerCategoria.removeClass(classGerActive);
                        if(filaSubAtiva){
                            if(lastBoxSubcategoria != null){
                                var lastIcone = lastBoxSubcategoria.children("i");
                                lastIcone.removeClass(classIconOpen).addClass(classIconClose);
                                lastBoxSubcategoria.removeClass(classSubcategoriaActive);
                            }
                            objGerCategoria.removeClass(classGerActive);
                        }
                        lastBoxSubcategoria = null;
                        subcategoriaAtiva = null;
                        filaSubAtiva = false;
                        setTimeout(function(){
                            objGerCategoria.load(url, {id_categoria: idCategoria}, function(){
                                objGerCategoria.addClass(classGerActive);
                                cadastrando = false;
                            });
                        }, animationDelay);
                    }
                });
            });
        </script>
    </head>
    <body>
        <?php
            /*REQUIRE PADRAO*/
            require_once "header-efectus-web.php";
            require_once "pew-interatividade.php";
            /*FIM PADRAO*/

            if(isset($_GET["focus"])){
                $focus = $_GET["focus"];
                echo "<script>$(document).ready(function(){ categoriaFocus('$focus'); })</script>";
            }
            if(isset($_GET["subfocus"]) && $_GET["id_categoria"]){
                $focus = $_GET["subfocus"];
                $idCategoria = $_GET["id_categoria"];
                echo "<script>$(document).ready(function(){ subcategoriaFocus('$focus', '$idCategoria'); })</script>";
            }
        ?>
        <h1 class="titulos"><?php echo $page_title; ?></h1>
        <section class="conteudo-painel">
            <div class="full label clear">
                <a class="btn-cad-categoria btn-flat medium" title="Cadastre uma nova categoria"><i class="fas fa-plus"></i> Cadastrar nova categoria</a>
            </div>
            <div class='painel-categorias full clear'>
                <?php
                    require_once "pew-system-config.php";
                    $tabela_categorias = $pew_db->tabela_categorias;
                    $tabela_subcategorias = $pew_db->tabela_subcategorias;
                    $contarCategoriasAtivas = mysqli_query($conexao, "select count(id) as total_categorias_ativas from $tabela_categorias where status = 1");
                    $contagem = mysqli_fetch_assoc($contarCategoriasAtivas);
                    $totalCategoriasAtivas = $contagem["total_categorias_ativas"];
                    $ctrlQtdCategorias = 0;
                    $iconCategorias = "<i class='fa fa-folder icone-categorias' aria-hidden='true'></i>";
                    $iconPlus = "<i class='fa fa-plus icone-categorias' aria-hidden='true'></i>";
                    if($totalCategoriasAtivas > 0){
                        echo "<h2 class='titulo'>Categorias ativas:</h2>";
                        echo "<div class='display-categorias'>";
                        $queryCategorias = mysqli_query($conexao, "select id, categoria from $tabela_categorias where status = 1 order by categoria asc");
                        while($categoria = mysqli_fetch_array($queryCategorias)){
                            $idCategoria = $categoria["id"];
                            $nomeCategoria = $categoria["categoria"];
                            $ctrlQtdCategorias++;
                            echo "<div class='box-categoria' pew-id-categoria='$idCategoria' pew-titulo-categoria='$nomeCategoria'>";
                                echo "<h3 class='alter-button-box-categoria' pew-id-categoria='$idCategoria' pew-titulo-categoria='$nomeCategoria'>".$iconCategorias." ".$nomeCategoria."</h3>";
                                $contarSubcategoria = mysqli_query($conexao, "select count(id) as total_subcategorias from $tabela_subcategorias where id_categoria = '$idCategoria'");
                                $contagem = mysqli_fetch_assoc($contarSubcategoria);
                                echo "<div class='display-subcategorias'>";
                                if($contagem["total_subcategorias"] > 0){
                                    $querySubcategorias = mysqli_query($conexao, "select id, subcategoria from $tabela_subcategorias where id_categoria = '$idCategoria' order by subcategoria asc");
                                    while($subcategorias = mysqli_fetch_array($querySubcategorias)){
                                        $idSubcategoria = $subcategorias["id"];
                                        $tituloSubcategoria = $subcategorias["subcategoria"];
                                        echo "<div class='box box-subcategoria' pew-id-subcategoria='$idSubcategoria' pew-titulo-subcategoria='$tituloSubcategoria' pew-id-categoria='$idCategoria'>$iconCategorias $tituloSubcategoria</div>";
                                    }

                                }
                                    echo "<div class='box btn-cad-subcategoria' pew-id-categoria='$idCategoria'>$iconPlus Adicionar subcategoria</div>";
                                echo "</div>";
                            echo "</div>";
                        }
                        echo "</div>";
                    }
                    $contarCategoriasDesativadas = mysqli_query($conexao, "select count(id) as total_categorias_desativadas from $tabela_categorias where status = 0");
                    $contagem = mysqli_fetch_assoc($contarCategoriasDesativadas);
                    $totalCategoriasDesativadas = $contagem["total_categorias_desativadas"];
                    if($totalCategoriasDesativadas > 0){
                        echo "<h2 class='titulo'>Categorias desativadas:</h2>";
                        echo "<div class='display-categorias'>";
                        $queryCategorias = mysqli_query($conexao, "select id, categoria from $tabela_categorias where status = 0 order by categoria asc");
                        while($categoria = mysqli_fetch_array($queryCategorias)){
                            $idCategoria = $categoria["id"];
                            $nomeCategoria = $categoria["categoria"];
                            $ctrlQtdCategorias++;
                            echo "<div class='box-categoria disable-categorias' pew-id-categoria='$idCategoria' pew-titulo-categoria='$nomeCategoria'>$iconCategorias $nomeCategoria</div>";
                        }
                        echo "</div>";
                    }
                ?>
            </div>
            <?php
                $class = "";
                if($ctrlQtdCategorias == 0){
                    echo "<br style='clear: both;'><h3 class='mensagem-padrao'>Nenhuma categoria foi encontrada. <a class='link-padrao btn-cad-categoria'>Clique aqui e cadastre</a></h3>";
                    $class = "display-ger-center";
                }
                echo "<div class='display-ger-categorias $class'></div>";
            ?>
        </section>
    </body>
</html>