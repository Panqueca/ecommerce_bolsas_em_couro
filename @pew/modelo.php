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
    $navigation_title = "Página Modelo - $efectus_empresa_administrativo";
    $page_title = "Página Modelo";
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
        <script type="text/javascript" src="../js/jquery.min.js"></script>
        <script type="text/javascript" src="js/standard.js"></script>
        <!--FIM LINKS e JS PADRAO-->
        <!--THIS PAGE LINKS-->
        <script type="text/javascript" src="js/painel-controle.js"></script>
        <!--FIM THIS PAGE LINKS-->
        <!--THIS PAGE CSS-->
        <style>

        </style>
        <!--FIM THIS PAGE CSS-->
    </head>
    <body>
        <?php
            /*REQUIRE PADRAO*/
            require_once "header-efectus-web.php";
            require_once "pew-interatividade.php";
            /*FIM PADRAO*/
        ?>
        <h1 class="titulos"><?php echo $page_title; ?></h1>
        <section class="conteudo-painel">
            <h3 align='center'>Em manutenção...</h3>
        </section>
    </body>
</html>
<?php
    mysqli_close($conexao);
}else{
    header("location: index.php?msg=Área Restrita. É necessário fazer login para continuar.");
}
?>
