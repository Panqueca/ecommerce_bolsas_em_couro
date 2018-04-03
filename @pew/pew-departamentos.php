<?php
    session_start();
    
    $thisPageURL = substr($_SERVER["REQUEST_URI"], strpos($_SERVER["REQUEST_URI"], '@pew'));
    $_POST["next_page"] = str_replace("@pew/", "", $thisPageURL);
    $_POST["invalid_levels"] = array(1);
    
    require_once "@link-important-functions.php";
    require_once "@valida-sessao.php";

    $navigation_title = "Departamentos - " . $pew_session->empresa;
    $page_title = "Gerenciamento de Departamentos";
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
        <script>
            var filaAtiva = false;
            var cadastrando = false;
            var classDepartamentoActive = "box-categoria-active";
            var classGerActive = "display-ger-categorias-active";
            var attrIdDepartamento = "pew-id-departamento";
            var attrTituloDepartamento = "pew-titulo-departamento";
            var animationDelay = 100;
            var objGerDepartamento = null;
            var lastBoxDepartamento = null;
            var departamentoAtivo = null;
            var botaoCadastrar = null;
            var classIconOpen = "fa-folder-open";
            var classIconClose = "fa-folder";
            var qtdCategorias = 0;
            function carregarDepartamento(idDepartamento, boxDepartamento){
                departamentoAtivo = idDepartamento;
                boxDepartamento.addClass(classDepartamentoActive);
                var icone = boxDepartamento.children("h3").children("i");
                icone.removeClass(classIconClose).addClass(classIconOpen);
                if(filaAtiva){
                    if(lastBoxDepartamento != null){
                        var lastIcone = lastBoxDepartamento.children("h3").children("i");
                        lastIcone.removeClass(classIconOpen).addClass(classIconClose);
                        lastBoxDepartamento.removeClass(classDepartamentoActive);
                    }
                    objGerDepartamento.removeClass(classGerActive);
                }
                filaAtiva = true;

                function loadPage(){
                    lastBoxDepartamento = boxDepartamento;
                    if(!cadastrando){
                        var url = "pew-edita-departamento.php";
                        objGerDepartamento.load(url, {id_departamento: idDepartamento}, function(){
                            setTimeout(function(){
                                objGerDepartamento.addClass(classGerActive);
                            }, 300);
                        });
                    }
                }
                setTimeout(function(){
                    loadPage();
                }, animationDelay);
            }

            function categoriaFocus(tituloCategoria){
                setTimeout(function(){
                    unselectCategoria();
                    $(".box-categoria").each(function(){
                        var box = $(this);
                        var titulo = box.attr(attrTituloDepartamento);
                        var id = box.attr(attrIdDepartamento);
                        if(titulo == tituloCategoria){
                            carregarDepartamento(id, box);
                        }
                    });
                }, animationDelay);
            }

            function unselectCategoria(){
                if(qtdCategorias > 0){
                    var lastIcone = lastBoxDepartamento.children("h3").children("i");
                    lastIcone.removeClass(classIconOpen).addClass(classIconClose);
                    lastBoxDepartamento.removeClass(classDepartamentoActive);
                    lastBoxDepartamento = null;
                    departamentoAtivo = null;
                }
            }

            $(document).ready(function(){
                objGerDepartamento = $(".display-ger-categorias");
                botaoCadastrar = $(".btn-cad-categoria");

                var firstCategoria = true;
                $(".box-categoria").each(function(){
                    qtdCategorias++;
                    var boxDepartamento = $(this);
                    var botaoAlternativo = boxDepartamento.children("h3");
                    var idDepartamento = boxDepartamento.attr(attrIdDepartamento);
                    function selectCategoria(){
                        if(departamentoAtivo != idDepartamento){
                            carregarDepartamento(idDepartamento, boxDepartamento);
                        }
                    }
                    if(firstCategoria){
                        firstCategoria = false;
                        selectCategoria();
                    }
                    boxDepartamento.off().on("click", function(){
                        selectCategoria();
                    });
                    botaoAlternativo.off().on("click", function(){
                        if(departamentoAtivo == idDepartamento){
                            departamentoAtivo = null;
                            filaAtiva = false;
                        }
                        carregarDepartamento(idDepartamento, boxDepartamento);
                    });
                });
                botaoCadastrar.off().on("click", function(){
                    if(!cadastrando){
                        cadastrando = true;
                        var url = "pew-cadastra-departamento.php";
                        $(".mensagem-padrao").hide();
                        unselectCategoria();
                        objGerDepartamento.removeClass(classGerActive);
                        setTimeout(function(){
                            objGerDepartamento.load(url, function(){
                                objGerDepartamento.addClass(classGerActive);
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
            // STANDARD REQUIRE
            require_once "@include-body.php";
            if(isset($block_level) && $block_level == true){
                $pew_session->block_level();
            }

            if(isset($_GET["focus"])){
                $focus = $_GET["focus"];
                echo "<script>$(document).ready(function(){ categoriaFocus('$focus'); })</script>";
            }
        ?>
        <!--PAGE CONTENT-->
        <h1 class="titulos"><?php echo $page_title; ?><a href="pew-produtos.php" class="btn-voltar"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</a></h1>
        <section class="conteudo-painel">
            <div class="full label clear">
                <a class="btn-flat btn-cad-categoria" title="Cadastre um novo departamento"><i class="fas fa-plus"></i> Cadastrar novo</a>
            </div>
            <div class='painel-categorias full'>
                <?php
                    require_once "pew-system-config.php";
                    $tabela_departamentos = $pew_custom_db->tabela_departamentos;
                    $contarDepartamentosAtivos = mysqli_query($conexao, "select count(id) as total_departamentos_ativos from $tabela_departamentos where status = 1");
                    $contagem = mysqli_fetch_assoc($contarDepartamentosAtivos);
                    $totalDepartamentos = $contagem["total_departamentos_ativos"];
                    $ctrlQuantidadeDepartamentos = 0;
                    $iconCategorias = "<i class='fa fa-folder icone-categorias' aria-hidden='true'></i>";
                    $iconPlus = "<i class='fa fa-plus icone-categorias' aria-hidden='true'></i>";
                    if($totalDepartamentos > 0){
                        echo "<h2 class='titulo'>Departamentos ativos:</h2>";
                        echo "<div class='display-categorias'>";
                        $queryCategorias = mysqli_query($conexao, "select id, departamento from $tabela_departamentos where status = 1 order by departamento asc");
                        while($departamento = mysqli_fetch_array($queryCategorias)){
                            $idDepartamento = $departamento["id"];
                            $nomeDepartamento = $departamento["departamento"];
                            $ctrlQuantidadeDepartamentos++;
                            echo "<div class='box-categoria' style='height: 20px;' pew-id-departamento='$idDepartamento' pew-titulo-departamento='$nomeDepartamento'>";
                                echo "<h3 class='alter-button-box-categoria' pew-id-departamento='$idDepartamento' pew-titulo-departamento='$nomeDepartamento'>".$iconCategorias." ".$nomeDepartamento."</h3>";
                            echo "</div>";
                        }
                        echo "</div>";
                    }
                    $contarDepartamentosDesativados = mysqli_query($conexao, "select count(id) as total_departamentos_desativados from $tabela_departamentos where status = 0");
                    $contagem = mysqli_fetch_assoc($contarDepartamentosDesativados);
                    $totalDepartDesativado = $contagem["total_departamentos_desativados"];
                    if($totalDepartDesativado > 0){
                        echo "<h2 class='titulo'>Departamentos desativados:</h2>";
                        echo "<div class='display-categorias'>";
                        $queryDepart = mysqli_query($conexao, "select id, departamento from $tabela_departamentos where status = 0 order by departamento asc");
                        while($departamento = mysqli_fetch_array($queryDepart)){
                            $idDepartamento = $departamento["id"];
                            $nomeDepartamento = $departamento["departamento"];
                            $ctrlQuantidadeDepartamentos++;
                            echo "<div class='box-categoria' style='height: 20px;' pew-id-departamento='$idDepartamento' pew-titulo-departamento='$nomeDepartamento'>$iconCategorias $nomeDepartamento</div>";
                        }
                        echo "</div>";
                    }
                ?>
            </div>
            <?php
                $class = "";
                if($ctrlQuantidadeDepartamentos == 0){
                    echo "<br style='clear: both;'><h3 class='mensagem-padrao'>Nenhum departamento foi encontrado. <a class='link-padrao btn-cad-categoria'>Clique aqui e cadastre</a></h3>";
                    $class = "display-ger-center";
                }
                echo "<div class='display-ger-categorias $class'></div>";
            ?>
        </section>
    </body>
</html>