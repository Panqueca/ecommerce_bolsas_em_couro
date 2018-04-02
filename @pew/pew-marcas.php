<?php
    session_start();
    
    $thisPageURL = substr($_SERVER["REQUEST_URI"], strpos($_SERVER["REQUEST_URI"], '@pew'));
    $_POST["next_page"] = str_replace("@pew/", "", $thisPageURL);
    
    require_once "@link-important-functions.php";
    require_once "@valida-sessao.php";

    $navigation_title = "Marcas - " . $pew_session->empresa;
    $page_title = "Gerenciamento de Marcas";
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
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
        <script type="text/javascript" src="js/standard.js"></script>
        <!--FIM LINKS e JS PADRAO-->
        <!--THIS PAGE LINKS-->
        <!--FIM THIS PAGE LINKS-->
        <script>
            var filaAtiva = false;
            var cadastrando = false;
            var classMarcaActive = "box-categoria-active";
            var classGerActive = "display-ger-categorias-active";
            var attrIdMarca = "pew-id-marca";
            var attrTituloMarca = "pew-titulo-marca";
            var animationDelay = 100;
            var objGerMarca = null;
            var lastBoxMarca = null;
            var marcaAtiva = null;
            var botaoCadastrar = null;
            var classBtnActive = "active-box";
            var classIconOpen = "fa-folder-open";
            var classIconClose = "fa-folder";
            var qtdMarca = 0;
            function carregarMarca(idMarca, boxMarca){
                marcaAtiva = idMarca;
                boxMarca.addClass(classMarcaActive);
                var icone = boxMarca.children("h3").children("i");
                icone.removeClass(classIconClose).addClass(classIconOpen);
                if(filaAtiva){
                    if(lastBoxMarca != null){
                        var lastIcone = lastBoxMarca.children("h3").children("i");
                        lastIcone.removeClass(classIconOpen).addClass(classIconClose);
                        lastBoxMarca.removeClass(classMarcaActive);
                    }
                    objGerMarca.removeClass(classGerActive);
                }
                filaAtiva = true;

                function loadPage(){
                    lastBoxMarca = boxMarca;
                    if(!cadastrando){
                        var url = "pew-edita-marca.php";
                        objGerMarca.load(url, {id_marca: idMarca}, function(){
                            setTimeout(function(){
                                objGerMarca.addClass(classGerActive);
                            }, 300);
                        });
                    }
                }
                setTimeout(function(){
                    loadPage();
                }, animationDelay);
            }

            function marcaFocus(tituloMarca){
                setTimeout(function(){
                    unselectMarca();
                    $(".box-categoria").each(function(){
                        var box = $(this);
                        var titulo = box.attr(attrTituloMarca);
                        var id = box.attr(attrIdMarca);
                        if(titulo == tituloMarca){
                            carregarMarca(id, box);
                        }
                    });
                }, animationDelay);
            }

            function unselectMarca(){
                if(qtdMarca > 0 && lastBoxMarca != null){
                    var lastIcone = lastBoxMarca.children("h3").children("i");
                    lastIcone.removeClass(classIconOpen).addClass(classIconClose);
                    lastBoxMarca.removeClass(classMarcaActive);
                    lastBoxMarca = null;
                    marcaAtiva = null;
                }
            }

            $(document).ready(function(){
                objGerMarca = $(".display-ger-categorias");
                botaoCadastrar = $(".btn-cad-categoria");

                var firstMarca = true;
                $(".box-categoria").each(function(){
                    qtdMarca++;
                    var boxMarca = $(this);
                    var botaoAlternativo = boxMarca.children("h3");
                    var idMarca = boxMarca.attr(attrIdMarca);
                    function selectMarca(){
                        if(marcaAtiva != idMarca){
                            carregarMarca(idMarca, boxMarca);
                        }
                    }
                    if(firstMarca){
                        firstMarca = false;
                        selectMarca();
                    }
                    boxMarca.off().on("click", function(){
                        selectMarca();
                    });
                    botaoAlternativo.off().on("click", function(){
                        if(marcaAtiva == idMarca){
                            marcaAtiva = null;
                            filaAtiva = false;
                        }
                        carregarMarca(idMarca, boxMarca);
                    });
                });
                botaoCadastrar.off().on("click", function(){
                    if(!cadastrando){
                        cadastrando = true;
                        var url = "pew-cadastra-marca.php";
                        $(".mensagem-padrao").hide();
                        unselectMarca();
                        objGerMarca.removeClass(classGerActive);
                        setTimeout(function(){
                            objGerMarca.load(url, function(){
                                objGerMarca.addClass(classGerActive);
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
                echo "<script>$(document).ready(function(){ marcaFocus('$focus'); })</script>";
            }
        ?>
        <h1 class="titulos"><?php echo $page_title; ?></h1>
        <section class="conteudo-painel">
            <div class="full label clear">
                <a class="btn-flat btn-cad-categoria" title="Cadastre uma nova marca"><i class="fas fa-plus"></i> Cadastrar nova marca</a>
            </div>
            <div class='painel-categorias full'>
                <?php
                    require_once "pew-system-config.php";
                    $tabela_marcas = $pew_custom_db->tabela_marcas;
                    $contarMarcas = mysqli_query($conexao, "select count(id) as total_marcas from $tabela_marcas where status = 1");
                    $contagem = mysqli_fetch_assoc($contarMarcas);
                    $totalMarcasAtivas = $contagem["total_marcas"];
                    $ctrlQtdCategorias = 0;
                    $iconCategorias = "<i class='fa fa-folder icone-categorias' aria-hidden='true'></i>";
                    $iconPlus = "<i class='fa fa-plus icone-categorias' aria-hidden='true'></i>";
                    if($totalMarcasAtivas > 0){
                        echo "<h2 class='titulo'>Marcas ativas:</h2>";
                        echo "<div class='display-categorias'>";
                        $queryMarcas = mysqli_query($conexao, "select id, marca from $tabela_marcas where status = 1 order by marca asc");
                        while($marca = mysqli_fetch_array($queryMarcas)){
                            $idMarca = $marca["id"];
                            $nomeMarca = $marca["marca"];
                            $ctrlQtdCategorias++;
                            echo "<div class='box-categoria' pew-id-marca='$idMarca' style='height: 20px;' pew-titulo-marca='$nomeMarca'>";
                                echo "<h3 class='alter-button-box-categoria' pew-id-marca='$idMarca' pew-titulo-marca='$nomeMarca'>".$iconCategorias." ".$nomeMarca."</h3>";
                            echo "</div>";
                        }
                        echo "</div>";
                    }
                    $contarMarcasDesativadas = mysqli_query($conexao, "select count(id) as total_marcas_desativadas from $tabela_marcas where status = 0");
                    $contagem = mysqli_fetch_assoc($contarMarcasDesativadas);
                    $totalCategoriasDesativadas = $contagem["total_marcas_desativadas"];
                    if($totalCategoriasDesativadas > 0){
                        echo "<h2 class='titulo'>Marcas desativadas:</h2>";
                        echo "<div class='display-categorias'>";
                        $queryMarcas = mysqli_query($conexao, "select id, marca from $tabela_marcas where status = 0 order by marca asc");
                        while($marca = mysqli_fetch_array($queryMarcas)){
                            $idMarca = $marca["id"];
                            $nomeMarca = $marca["marca"];
                            $ctrlQtdCategorias++;
                            echo "<div class='box-categoria disable-categorias' pew-id-marca='$idMarca' pew-titulo-marca='$nomeMarca'>$iconCategorias $nomeMarca</div>";
                        }
                        echo "</div>";
                    }
                ?>
            </div>
            <?php
                $class = "";
                if($ctrlQtdCategorias == 0){
                    echo "<br style='clear: both;'><h3 class='mensagem-padrao'>Nenhuma marca foi encontrada. <a class='link-padrao btn-cad-categoria'>Clique aqui e cadastre</a></h3>";
                    $class = "display-ger-center";
                }
                echo "<div class='display-ger-categorias $class'></div>";
            ?>
        </section>
    </body>
</html>