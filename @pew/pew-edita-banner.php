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
    $navigation_title = "Edita Banner - $efectus_empresa_administrativo";
    $page_title = "Editar Banner";
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
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/standard.js"></script>
        <!--FIM LINKS e JS PADRAO-->
        <script>
            $(document).ready(function(){
                $(".btn-excluir").each(function(){
                    var botao = $(this);
                    var link =  botao.attr("href");
                    botao.off().on("click", function(){
                        event.preventDefault();
                        function excluir(){
                            window.location.href=link;
                        }
                        mensagemConfirma("Tem certeza que deseja excluir este banner?", excluir);
                    });
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
    ?>
    <h1 class="titulos"><?php echo $page_title; ?><a href="pew-banners.php" class="btn-voltar"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</a></h1>
<?php
    $tabela_banners = $pew_db->tabela_banners;
    if(isset($_GET["id_banner"])){
        $idBanner = (int)$_GET["id_banner"];
        $idBanner = is_int($idBanner) ? $idBanner : 0;
        $contarBanner = mysqli_query($conexao, "select count(id) as total_banner from $tabela_banners where id = '$idBanner'");
        $contagem = mysqli_fetch_assoc($contarBanner);
        if($contagem["total_banner"] > 0){
            $queryBanner = mysqli_query($conexao, "select * from $tabela_banners where id = '$idBanner'");
            $banner = mysqli_fetch_array($queryBanner);
            $titulo = $banner["titulo"];
            $descricao = $banner["descricao"];
            $imagem = $banner["imagem"];
            $link = $banner["link"];
?>
        <section class="conteudo-painel">
            <form method="post" action="pew-update-banner.php" enctype="multipart/form-data">
                <input type="hidden" name="id_banner" value="<?php echo $idBanner;?>">
                <input type="hidden" name="imagem_antiga" value="<?php echo $imagem;?>">
                <label class="label-medium">
                    <h2>Título do Banner</h2>
                    <input type="text" name="titulo" placeholder="Título" min="3" class="input-full" value="<?php echo $titulo;?>" required>
                </label>
                <label class="label-medium">
                    <h2>Descrição do Banner</h2>
                    <input type="text" name="descricao" placeholder="Descrição" min="3" class="input-full" value="<?php echo $descricao;?>" required>
                </label>
                <label class="label-medium">
                    <h2>Link de redirecionamento</h2>
                    <input type="text" name="link" placeholder="www.efectusweb.com.br" class="input-full" value="<?php echo $link;?>" required>
                </label>
                <label class="label-full">
                    <label class="label-half">
                        <img src="../imagens/banners/<?php echo $imagem;?>" width="100%">
                    </label>
                    <label class="label-half">
                        <h2>Selecione a imagem do banner: (1200px : 450px)</h2>
                        <input type="file" name="imagem" class="input-full">
                    </label>
                </label>
                <br style="clear: both;">
                <a href="pew-deleta-banner.php?id_banner=<?php echo $idBanner;?>&acao=deletar" class='btn-excluir'>Excluir Banner</a>
                <label class="label-full">
                    <input type="submit" class="btn-submit" value="Atualizar Banner">
                </label>
                <br style="claer: both;">
                <br><br><br><a href='pew-banners.php' class='link-padrao'>Voltar</a>
            </form>
        </section>
<?php
        }else{
            echo "<center><h3>Nenhum banner foi encontrado...</h3><br><a href='pew-banners.php' class='btn-padrao'>Voltar</a></center>";
        }
    }else{
        echo "<script>window.location.href='pew-banners.php?msg=Selecione um banner para editar';</script>";
    }
    mysqli_close($conexao);
}else{
    header("location: index.php?msg=Área Restrita. É necessário fazer login para continuar.");
}
?>
    </body>
</html>
