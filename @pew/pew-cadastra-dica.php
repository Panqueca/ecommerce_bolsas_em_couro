<?php
    session_start();
    
    $thisPageURL = substr($_SERVER["REQUEST_URI"], strpos($_SERVER["REQUEST_URI"], '@pew'));
    $_POST["next_page"] = str_replace("@pew/", "", $thisPageURL);
    $_POST["invalid_levels"] = array(1);
    
    require_once "@link-important-functions.php";
    require_once "@valida-sessao.php";

    $navigation_title = "Cadastrar dica - " . $pew_session->empresa;
    $page_title = "Cadastrar Dica";
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
                CKEDITOR.replace("descricaoLonga");
            });
        </script>
        <!--THIS PAGE CSS-->
        <style>
            .file-field{
                height: 140px;
                line-height: 140px;
            }
            .file-field:hover{
                line-height: 140px;
            }
        </style>
    </head>
    <body>
        <?php
            // STANDARD REQUIRE
            require_once "@include-body.php";
            if(isset($block_level) && $block_level == true){
                $pew_session->block_level();
            }
        ?>
        <!--PAGE CONTENT-->
        <h1 class="titulos"><?php echo $page_title; ?><a href="pew-dicas.php" class="btn-voltar"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</a></h1>
        <section class="conteudo-painel">
            <form method="post" action="pew-grava-dica.php" enctype="multipart/form-data">
                <!--LINHA 1-->
                <div class="label medium">
                    <h2 class='label-title'>Titulo</h2>
                    <input type="text" name="titulo" id="titulo" placeholder="Titulo da dica" class="label-input">
                </div>
                <div class="label half">
                    <h2 class='label-title'>Subtitulo</h2>
                    <input type="text" name="subtitulo" id="subtitulo" placeholder="Subtitulo da dica" class="label-input">
                </div>
                <div class="label xsmall">
                    <h2 class='label-title'>Status</h2>
                    <select name="status" class="label-input">
                        <?php
                            $possibleStatus = array(1, 0);
                            foreach($possibleStatus as $selectStatus){
                                $nameStatus = $selectStatus == 1 ? "Ativo" : "Inativo";
                                echo "<option value='$selectStatus'>$nameStatus</option>";
                            }
                        ?>
                    </select>
                </div> 
                
                <br class="clear">
                <br class="clear">
                <br class="clear">
                
                <div class="label medium">
                    <h2 class="label-title">Imagens da dica: (1300px : 400px) OBRIGATÓRIO</h2>
                    <input class="label-input" type="file" name="imagem">
                </div>
                <div class="label medium">
                    <h2 class="label-title">Thumbnail da dica: (500px : 500px) OBRIGATÓRIO</h2>
                    <input class="label-input" type="file" name="thumbnail">
                </div>
                <div class="label medium" align="left">
                    <h3 class="label-title">Iframe Vídeo</h3>
                    <input type="text" class="label-input" name="url_video" placeholder="<iframe></iframe>">
                </div>
                
                <br class="clear">
                <br class="clear">
                <br class="clear">
                
                <div class="label half">
                    <h2 class='label-title'>Descrição Curta SEO Google<br>(Recomendado 156 caracteres)</h2>
                    <textarea placeholder="Descrição do Dica" name="descricao_curta" maxlength="180" id="descricaoCurta" class="label-textarea" rows="3"></textarea>
                </div>
                <div class="label half">
                    <h2 class='label-title'>Descrição Longa</h2>
                    <textarea placeholder="Descrição do Dica" name="descricao_longa" id="descricaoLonga" class="label-input" rows="5"></textarea>
                </div>
                <br class="clear">
                <br class="clear">
                <div class="full label jc-center">
                    <div class="small clear">
                        <input type="submit" class="btn-submit label-input" value="Cadastrar Dica">
                    </div>
                </div>
                <div class="full" align=center>
                    <a href="pew-dicas.php" class="link-padrao">Voltar</a>
                </div>
            </form>
        </section>
    </body>
</html>