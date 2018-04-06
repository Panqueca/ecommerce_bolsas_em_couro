<?php
    session_start();
    $nomeEmpresa = "Bolsas em Couro";
    $descricaoPagina = "DESCRIÇÃO MODELO ATUALIZAR...";
    $tituloPagina = "Titulo da dica - $nomeEmpresa";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <meta name="HandheldFriendly" content="true">
        <meta name="description" content="<?php echo $descricaoPagina;?>">
        <meta name="author" content="Efectus Web">
        <title><?php echo $tituloPagina;?></title>
        <!--DEFAULT LINKS-->
        <?php
            require_once "@link-standard-styles.php";
            require_once "@link-standard-scripts.php";
            require_once "@link-important-functions.php";
        ?>
        <!--END DEFAULT LINKS-->
        <!--PAGE CSS-->
        <style>
            .main-content{
                width: 100%;
                margin: 0 auto;
                min-height: 300px;
            }
            .main-content .box{
                position: relative;
            }
            .main-content .box img{
                width: 100%;
            }
            .main-content .box .breadcrumb{
                position: absolute;
                bottom: 5vw;
                left: 10vw;
                color: #fff;
                font-size: 1vw;
            }
            .main-content .display{
                width: 75vw;
                margin: 10vh auto;
                color: #aaa;
            }
        </style>
        <!--END PAGE CSS-->
        <!--PAGE JS-->
        <script>
            $(document).ready(function(){
                console.log("Página carregada");
            });
        </script>
        <!--END PAGE JS-->
    </head>
    <body>
        <!--REQUIRES PADRAO-->
        <?php
            require_once "@link-body-scripts.php";
            require_once "@classe-system-functions.php";
            require_once "@include-header-principal.php";
            require_once "@include-interatividade.php";
        ?>
        <!--THIS PAGE CONTENT-->
        <div class="main-content">
            <!--GET = titulo, ref-->
            <?php
                $getNome = isset($_GET["titulo"]) ? $_GET["titulo"] : "Produto não encontrado";
                $getToken = isset($_GET["token"]) ? $_GET["token"] : "Produto não encontrado";
                
            ?>
            <div class="box">
                <img title='' src='imagens/dicas/banner-interno.png' alt=''>
                <div class='breadcrumb'>
                    <h4>Página inicial > Dicas > Cuidados com o Couro</h4>
                    <h1>CUIDADOS COM O COURO</h1>
                    <h2>subtitulo</h2>
                </div>
            </div>
            <div class='display'>
                <article class="descricao">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris aliquet malesuada feugiat. Curabitur fermentum bibendum nulla, non dictum ipsum tincidunt non. Quisque convallis pharetra tempor. Donec id pretium leo. Pellentesque luctus massa non elit viverra pellentesque. Cras vitae neque molestie, rhoncus ipsum sit amet, lobortis dui. Fusce in urna sem. Vivamus vehicula dignissim augue et scelerisque. Etiam quam nisi, molestie ac dolor in, tincidunt tincidunt arcu. Praesent sed justo finibus, fringilla velit quis, porta erat. Donec blandit metus ut arcu iaculis iaculis. Cras nec dolor fringilla justo ullamcorper auctor. Aliquam eget pretium velit. Morbi urna justo, pulvinar id lobortis in, aliquet placerat orci.<br><br>
                    
                    Etiam nisi turpis, eleifend nec tellus id, efficitur pellentesque dolor. Proin vitae massa a augue sagittis vulputate. Duis vel fringilla magna, sit amet vestibulum enim. Fusce laoreet accumsan nisl eu sagittis. Morbi hendrerit sapien eget efficitur imperdiet. Aenean vitae nisl id est placerat congue a et nisi. Suspendisse vitae quam ipsum. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Suspendisse eu risus lacus. Ut tristique libero eget est dictum, commodo malesuada orci elementum. Proin molestie eu mi in tempus.<br><br>
                    
                    In hac habitasse platea dictumst. Cras augue nisl, cursus mattis mattis id, lacinia nec augue. Integer nec augue non metus interdum rhoncus. Proin non imperdiet ante. Sed mollis, justo ac dapibus auctor, tellus mi congue nisl, nec commodo ex justo ut eros. Etiam fringilla porta dolor vitae gravida. Nulla facilisi. Nam dui eros, mattis ut turpis at, eleifend accumsan odio. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Sed id ultrices erat, vehicula viverra ante. Etiam sit amet dignissim tellus, ac laoreet ligula. Aenean fringilla sodales lorem, ac maximus est hendrerit in.
                </article>
            </div>
        </div>
        <!--END THIS PAGE CONTENT-->
        <?php
            require_once "@include-footer-principal.php";
        ?>
        <!--END REQUIRES PADRAO-->
    </body>
</html>