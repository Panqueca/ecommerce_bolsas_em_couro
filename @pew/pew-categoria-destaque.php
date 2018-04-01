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
    $navigation_title = "Categorias destaque - $efectus_empresa_administrativo";
    $page_title = "Gerenciamento das Categorias Destaque";
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
            var cadastrando = false;
            var classDestaqueActive = "box-categoria-active";
            var classGerActive = "display-ger-categorias-active";
            var attrIdDestaque = "pew-id-categoria-destaque";
            var animationDelay = 100;
            var objGerDestaque = null;
            var lastBoxDestaque = null;
            var destaqueAtivo = null;
            var botaoCadastrar = null;
            var classIconOpen = "fa-folder-open";
            var classIconClose = "fa-folder";
            var qtdCategorias = 0;
            var btnCadCategoria = "";
            var lastDepartamento = null;
            function carregarDestaque(idDestaque, boxDestaque){
                destaqueAtivo = idDestaque;
                boxDestaque.addClass(classDestaqueActive);
                var icone = boxDestaque.children("h3").children("i");
                if(boxDestaque != null){
                    icone.removeClass(classIconClose).addClass(classIconOpen);
                }
                if(filaAtiva){
                    unselectDestaque();
                    objGerDestaque.removeClass(classGerActive);
                }
                filaAtiva = true;

                function loadPage(){
                    lastBoxDestaque = boxDestaque;
                    if(!cadastrando){
                        var url = "pew-edita-categoria-destaque.php";
                        objGerDestaque.load(url, {id_categoria_destaque: idDestaque}, function(){
                            setTimeout(function(){
                                objGerDestaque.addClass(classGerActive);
                            }, 300);
                        });
                    }
                }
                setTimeout(function(){
                    loadPage();
                }, animationDelay);
            }

            function destaqueFocus(idDestaque){
                setTimeout(function(){
                    $(".box-categoria").each(function(){
                        var box = $(this);
                        var id = box.attr(attrIdDestaque);
                        if(id == idDestaque){
                            unselectDestaque();
                            carregarDestaque(id, box);
                        }
                    });
                }, animationDelay);
            }

            function unselectDestaque(){
                if(qtdCategorias > 0){
                    btnCadCategoria.removeClass("btn-add-colecao-active");
                    if(lastBoxDestaque != null){
                        var lastIcone = lastBoxDestaque.children("h3").children("i");
                        lastIcone.removeClass(classIconOpen).addClass(classIconClose);
                        lastBoxDestaque.removeClass(classDestaqueActive);
                    }
                    lastBoxDestaque = null;
                    destaqueAtivo = null;
                }
            }

            $(document).ready(function(){
                objGerDestaque = $(".display-ger-categorias");
                btnCadCategoria = $(".btn-add-categoria");

                var firstCategoria = true;
                $(".box-categoria").each(function(){
                    qtdCategorias++;
                    var boxDestaque = $(this);
                    var botaoAlternativo = boxDestaque.children("h3");
                    var idDestaque = boxDestaque.attr(attrIdDestaque);
                    function selectCategoria(){
                        var selecionar = destaqueAtivo != idDestaque ? true : false;
                        if(selecionar){
                            carregarDestaque(idDestaque, boxDestaque);
                        }
                    }
                    if(firstCategoria){
                        firstCategoria = false;
                        selectCategoria();
                    }
                    boxDestaque.off().on("click", function(){
                        selectCategoria();
                    });
                    botaoAlternativo.off().on("click", function(){
                        if(destaqueAtivo == idDestaque){
                            destaqueAtivo = null;
                            filaAtiva = false;
                        }
                        carregarDestaque(idDestaque, boxDestaque);
                    });
                });
                btnCadCategoria.off().on("click", function(){
                    if(!cadastrando){
                        cadastrando = true;
                        var url = "pew-cadastra-categoria-destaque.php";
                        $(".mensagem-padrao").hide();
                        unselectDestaque();
                        objGerDestaque.removeClass(classGerActive);
                        setTimeout(function(){
                            objGerDestaque.load(url, function(){
                                objGerDestaque.addClass(classGerActive);
                                cadastrando = false;
                            });
                        }, animationDelay);
                    }
                });
            });
        </script>
        <style>
            .btn-add-colecao{
                width: 95%;
                height: 20px;
                padding: 2%;
                padding-top: 5px;
                padding-bottom: 5px;
                background-color: #f1f1f1;
                margin-bottom: 2px;
                font-size: 16px;
                text-align: left;
                position: relative;
                transition: .3s;
                border-left: 3px solid #df2321;
                overflow: hidden;
                cursor: pointer;
                color: #df2321;
            }
            .btn-add-colecao-active{
                color: #f78a14;
                border-color: #f78a14;
            }
        </style>
    </head>
    <body>
        <?php
            /*REQUIRE PADRAO*/
            require_once "header-efectus-web.php";
            require_once "pew-interatividade.php";
            /*FIM PADRAO*/

            if(isset($_GET["focus"])){
                $focus = $_GET["focus"];
                echo "<script>$(document).ready(function(){ destaqueFocus('$focus'); })</script>";
            }
        ?>
        <h1 class="titulos"><?php echo $page_title; ?></a></h1>
        <section class="conteudo-painel">
            <center><a class="btn-padrao btn-add-categoria" title="Adicionar categoria a vitrine">Adicionar categoria destaque</a></center>
            <div class='painel-categorias'>
                <?php
                    require_once "pew-system-config.php";
                    $tabela_categoria_destaque = $pew_custom_db->tabela_categoria_destaque;
                    $contar = mysqli_query($conexao, "select count(id) as total from $tabela_categoria_destaque");
                    $contagem = mysqli_fetch_assoc($contar);
                    $totalCategoriaDestaque = $contagem["total"];
                    $ctrlQtdDestaques = 0;
                    $iconCategorias = "<i class='fa fa-folder icone-categorias' aria-hidden='true'></i>";
                    $iconPlus = "<i class='fa fa-plus icone-categorias' aria-hidden='true'></i>";
                    if($totalCategoriaDestaque > 0){
                        echo "<h2 class='titulo'>Categoria Destaque:</h2>";
                        echo "<div class='display-categorias'>";
                        $queryCatDestaque = mysqli_query($conexao, "select id, titulo from $tabela_categoria_destaque");
                        while($categoriaDestaque = mysqli_fetch_array($queryCatDestaque)){
                            $idDestaque = $categoriaDestaque["id"];
                            $tituloDestaque = $categoriaDestaque["titulo"];
                            $ctrlQtdDestaques++;
                            echo "<div class='box-categoria' style='height: 20px;' pew-id-categoria-destaque='$idDestaque'>";
                                echo "<h3 class='alter-button-box-categoria' pew-id-categoria-destaque='$idDestaque' >".$iconCategorias." $tituloDestaque</h3>";
                            echo "</div>";
                        }
                        echo "</div>";
                    }
                ?>
            </div>
            <?php
                $class = "";
                if($ctrlQtdDestaques == 0){
                    echo "<br style='clear: both;'><h3 class='mensagem-padrao'>Nenhuma categoria destaque foi encontrada. <a class='link-padrao btn-add-categoria'>Clique aqui e cadastre</a></h3>";
                    $class = "display-ger-center";
                }
                echo "<div class='display-ger-categorias $class'></div>";
            ?>
        </section>
    </body>
</html>
<?php
    mysqli_close($conexao);
}else{
    header("location: index.php?msg=Área Restrita. É necessário fazer login para continuar.");
}
?>
