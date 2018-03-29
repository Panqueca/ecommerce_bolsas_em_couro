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
    $navigation_title = "Cadastrar Banners - $efectus_empresa_administrativo";
    $page_title = "Cadastrar Banner";
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
    </head>
    <body>
        <?php
            /*REQUIRE PADRAO*/
            require_once "header-efectus-web.php";
            require_once "pew-interatividade.php";
            /*FIM PADRAO*/
        ?>
        <h1 class="titulos"><?php echo $page_title; ?><a href="pew-banners.php" class="btn-voltar"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</a></h1>
        <section class="conteudo-painel">
            <form method="post" action="pew-grava-banner.php" enctype="multipart/form-data">
                <div class="medium">
                    <h2 class="label-title">Título do Banner</h2>
                    <input type="text" name="titulo" placeholder="Título" min="3" class="label-input" required>
                </div>
                <div class="medium">
                    <h2 class="label-title">Descrição do Banner</h2>
                    <input type="text" name="descricao" placeholder="Descrição" min="3" class="label-input" required>
                </div>
                <div class="medium">
                    <h2 class="label-title">Link de redirecionamento</h2>
                    <input type="text" name="link" placeholder="www.efectusweb.com.br" class="label-input">
                </div>
                <div class="half">
                    <h2 class="label-title">Selecione a imagem do banner: (1200px : 450px)</h2>
                    <input type="file" name="imagem" class="label-input" required>
                </div>
                <div class="small clear">
                    <input type="submit" class="btn-submit label-input" value="Cadastrar Banner">
                </div>
            </form>
        </section>
    </body>
</html>
<?php
    mysqli_close($conexao);
}else{
    header("location: index.php?msg=Área Restrita. É necessário fazer login para continuar.");
}
?>
