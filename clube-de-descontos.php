<?php
    session_start();
    
    require_once "@classe-paginas.php";

    $cls_paginas->set_titulo("Clube de Descontos");
    $cls_paginas->set_descricao("DESCRIÇÃO MODELO ATUALIZAR...");
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <meta name="HandheldFriendly" content="true">
        <meta name="description" content="<?php echo $cls_paginas->descricao;?>">
        <meta name="author" content="Efectus Web">
        <title><?php echo $cls_paginas->titulo;?></title>
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
                width: 80%;
                margin: 0 auto;
                min-height: 300px;
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
            <h1 align=center>CLUBE DE DESCONTOS</h1>
            <article>Ao contrário do que se acredita, Lorem Ipsum não é simplesmente um texto randômico. Com mais de 2000 anos, suas raízes podem ser encontradas em uma obra de literatura latina. Lorem Ipsum não é simplesmente um texto randômico. Com mais de 2000 anos, suas raízes podem ser encontradas em uma obra de literatura latina.</article>
        </div>
        <!--END THIS PAGE CONTENT-->
        <?php
            require_once "@include-footer-principal.php";
        ?>
        <!--END REQUIRES PADRAO-->
    </body>
</html>