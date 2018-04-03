<?php
    session_start();
    
    $thisPageURL = substr($_SERVER["REQUEST_URI"], strpos($_SERVER["REQUEST_URI"], '@pew'));
    $_POST["next_page"] = str_replace("@pew/", "", $thisPageURL);
    $_POST["invalid_levels"] = array(1);
    
    require_once "@link-important-functions.php";
    require_once "@valida-sessao.php";

    $navigation_title = "Editar notícia - " . $pew_session->empresa;
    $page_title = "Editar notícia";
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
            $(document).ready(function(){
                var enviando = false;
                $("#formularioUpdateNoticia").off().on("submit", function(){
                    event.preventDefault();
                    if(enviando == false){
                        enviando = true;
                        var objTitulo = $("#tituloNoticia");
                        var objTexto = $("#textoNoticia");
                        if(objTitulo.val().length < 3){
                            mensagemAlerta("O campo título deve ter no mínimo 3 caracteres.", objTitulo);
                            enviando = false;
                            return false;
                        }
                        if(objTexto.val().length < 120){
                            mensagemAlerta("O campo texto deve ter no mínimo 120 caracteres.", objTexto);
                            enviando = false;
                            return false;
                        }
                        $(this).submit();
                    }
                });

                $(".botao-acao").off().on("click", function(){
                    var botao = $(this);
                    var idNoticia = botao.attr("data-id-noticia");
                    var acao = botao.attr("data-acao");
                    function statusProduto(){
                        $.ajax({
                            type: "POST",
                            url: "pew-status-noticia.php",
                            data: {id_noticia: idNoticia, acao: acao},
                            beforeSend: function(){
                                notificacaoPadrao("Aguarde...", "success");
                            },
                            error: function(){
                                setTimeout(function(){
                                    notificacaoPadrao("Não foi possível "+acao+" a notícia", "error", 5000);
                                }, 1000);
                            },
                            success: function(respota){
                                setTimeout(function(){
                                    var resultado = null;
                                    switch(acao){
                                        case "excluir":
                                            resultado  = "excluida";
                                            break;
                                        case "desativar":
                                            resultado = "desativada";
                                            break;
                                        default:
                                            resultado = "ativada";
                                    }
                                    if(respota == "true"){
                                        mensagemAlerta("A notícia foi "+resultado+"!", "", "limegreen", "pew-noticias.php");
                                    }else{
                                        notificacaoPadrao("Não foi possível completar a ação", "error", 5000);
                                    }
                                }, 500);
                            }
                        });
                    }
                    mensagemConfirma("Tem certeza que deseja "+acao+" este produto?", statusProduto);
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
            $tabela_noticias = $pew_custom_db->tabela_noticias;
            $id = isset($_GET["id_noticia"]) ? pew_string_format($_GET["id_noticia"]) : 0;
            $contarNoticias = mysqli_query($conexao, "select count(id) as total_noticias from $tabela_noticias where id = '$id'");
            $contagemProdutos = mysqli_fetch_assoc($contarNoticias);
            $totalNoticias = $contagemProdutos["total_noticias"];
            if($totalNoticias > 0){
                $queryNoticia = mysqli_query($conexao, "select * from $tabela_noticias where id = '$id'");
                $noticia = mysqli_fetch_array($queryNoticia);
                $titulo = $noticia["titulo"];
                $texto = $noticia["texto"];
                $imagem = $noticia["imagem"];
                $status = $noticia["status"];
                $dirImagens = "../imagens/news";
            }else{
                echo "<script>window.location.href='pew-noticias.php?msg=Nenhum notícia foi encontrada';</script>";
            }
        ?>
        <!--PAGE CONTENT-->
        <h1 class="titulos"><?php echo $page_title; ?><a href="pew-noticias.php" class="btn-voltar"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</a></h1>
        <section class="conteudo-painel">
            <form action="pew-update-noticia.php" method="post" id="formularioUpdateNoticia" enctype="multipart/form-data">
                <input type="hidden" name="id_noticia" value="<?php echo $id;?>">
                <label class="label-full">
                    <h2 class="input-title">Título</h2>
                    <input type="text" name="titulo" id="tituloNoticia" placeholder="Título da notícia" value="<?php echo $titulo; ?>" class="input-full">
                </label>
                <label class="label-full">
                    <h2 class="input-title">Texto</h2>
                    <textarea name="texto" id="textoNoticia" placeholder="Texto" class="input-full" rows="10"><?php echo $texto; ?></textarea>
                </label>
                <label class="label-medium">
                    <h2 class="input-title">Imagem atual</h2>
                    <img src="<?php echo $dirImagens."/".$imagem;?>" class="input-full">
                </label>
                <label class="label-medium">
                    <h2 class="input-title">Nova imagem (700px : 700px)</h2>
                    <input type="file" accept="image/*" name="imagem">
                </label>
                <br style="clear: both;">
                <br style="clear: both;">
                <br style="clear: both;">
                <input type="button" class="btn-excluir botao-acao" data-id-noticia="<?php echo $id;?>" data-acao="excluir" value="Excluir">
                <?php
                    $botao = $status == 1 ? "<input type='button' class='btn-excluir botao-acao' data-id-noticia='$id' data-acao='desativar' value='Desativar notícia'>" : "<input type='button' class='btn-submit botao-acao' data-id-noticia='$id' data-acao='ativar' value='Ativar notícia'>";
                    echo $botao;
                ?>
                <input type="submit" class="btn-submit" value="Atualizar">
            </form>
            <br><br>
            <a href="pew-noticias.php" class="link-padrao">Voltar</a>
        </section>
    </body>
</html>