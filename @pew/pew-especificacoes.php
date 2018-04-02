<?php
    session_start();
    
    $thisPageURL = substr($_SERVER["REQUEST_URI"], strpos($_SERVER["REQUEST_URI"], '@pew'));
    $_POST["next_page"] = str_replace("@pew/", "", $thisPageURL);
    
    require_once "@link-important-functions.php";
    require_once "@valida-sessao.php";

    $navigation_title = "Especificações - " . $pew_session->empresa;
    $page_title = "Gerenciamento de Especificações técnicas";
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
            var attrIdEspecificacao = "pew-id-especificacao";
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
            function carregarMarca(idEspecificacao, boxMarca){
                marcaAtiva = idEspecificacao;
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
                        var url = "pew-edita-especificacao.php";
                        objGerMarca.load(url, {id_especificacao: idEspecificacao}, function(){
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
                        var id = box.attr(attrIdEspecificacao);
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
                    var idEspecificacao = boxMarca.attr(attrIdEspecificacao);
                    function selectMarca(){
                        if(marcaAtiva != idEspecificacao){
                            carregarMarca(idEspecificacao, boxMarca);
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
                        if(marcaAtiva == idEspecificacao){
                            marcaAtiva = null;
                            filaAtiva = false;
                        }
                        carregarMarca(idEspecificacao, boxMarca);
                    });
                });
                botaoCadastrar.off().on("click", function(){
                    if(!cadastrando){
                        cadastrando = true;
                        var url = "pew-cadastra-especificacao.php";
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
                <a class="btn-flat btn-cad-categoria" title="Cadastre uma nova especificação"><i class="fas fa-plus"></i> Cadastrar nova especificação</a>
            </div>
            <div class='painel-categorias full'>
                <?php
                    require_once "pew-system-config.php";
                    $tabela_especificacoes = $pew_custom_db->tabela_especificacoes;
                    $contar = mysqli_query($conexao, "select count(id) as total_marcas from $tabela_especificacoes where status = 1");
                    $contagem = mysqli_fetch_assoc($contar);
                    $totalAtivas = $contagem["total_marcas"];
                    $ctrlQtdCategorias = 0;
                    $iconCategorias = "<i class='fa fa-folder icone-categorias' aria-hidden='true'></i>";
                    $iconPlus = "<i class='fa fa-plus icone-categorias' aria-hidden='true'></i>";
                    if($totalAtivas > 0){
                        echo "<h2 class='titulo'>Especificações ativas:</h2>";
                        echo "<div class='display-categorias'>";
                        $queryEspecificacoes = mysqli_query($conexao, "select id, titulo from $tabela_especificacoes where status = 1 order by titulo asc");
                        while($marca = mysqli_fetch_array($queryEspecificacoes)){
                            $idEspecificacao = $marca["id"];
                            $tituloEspecificacao = $marca["titulo"];
                            $ctrlQtdCategorias++;
                            echo "<div class='box-categoria' pew-id-especificacao='$idEspecificacao' pew-titulo-marca='$tituloEspecificacao'>";
                                echo "<h3 class='alter-button-box-categoria' pew-id-especificacao='$idEspecificacao' pew-titulo-marca='$tituloEspecificacao'>".$iconCategorias." ".$tituloEspecificacao."</h3>";
                            echo "</div>";
                        }
                        echo "</div>";
                    }
                    $contarDesativadas = mysqli_query($conexao, "select count(id) as total_desativadas from $tabela_especificacoes where status = 0");
                    $contagem = mysqli_fetch_assoc($contarDesativadas);
                    $totalDesativadas = $contagem["total_desativadas"];
                    if($totalDesativadas > 0){
                        echo "<h2 class='titulo'>Especificações desativadas:</h2>";
                        echo "<div class='display-categorias'>";
                        $queryEspecificacoes = mysqli_query($conexao, "select id, titulo from $tabela_especificacoes where status = 0 order by titulo asc");
                        while($especificacao = mysqli_fetch_array($queryEspecificacoes)){
                            $idEspecificacao = $especificacao["id"];
                            $tituloEspecificacao = $especificacao["titulo"];
                            $ctrlQtdCategorias++;
                            echo "<div class='box-categoria disable-categorias' pew-id-especificacao='$idEspecificacao' pew-titulo-marca='$tituloEspecificacao'>$iconCategorias $tituloEspecificacao</div>";
                        }
                        echo "</div>";
                    }
                ?>
            </div>
            <?php
                $class = "";
                if($ctrlQtdCategorias == 0){
                    echo "<br style='clear: both;'><h3 class='mensagem-padrao'>Nenhuma especificação foi encontrada. <a class='link-padrao btn-cad-categoria'>Clique aqui e cadastre</a></h3>";
                    $class = "display-ger-center";
                }
                echo "<div class='display-ger-categorias $class'></div>";
            ?>
        </section>
    </body>
</html>