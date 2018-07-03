<?php

    session_start();
    
    require_once "@classe-paginas.php";

    $cls_paginas->set_titulo("Central de Atendimento");
    $cls_paginas->set_descricao("DESCRIÇÃO MODELO ATUALIZAR...");

?>
<!DOCTYPE html>
<html>
    <head>
        <base href="<?= $cls_paginas->get_full_path(); ?>/">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <meta name="HandheldFriendly" content="true">
        <meta name="description" content="<?php echo $cls_paginas->descricao;?>">
        <meta name="author" content="Efectus Web">
        <title><?php echo $cls_paginas->titulo;?></title>
        <link type="image/png" rel="icon" href="imagens/identidadeVisual/logo-icon.png">
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
        <script type="text/javascript" src="@pew/custom-textarea/ckeditor.js"></script>
        <!--REQUIRES PADRAO-->
        <?php
            require_once "@link-body-scripts.php";
            require_once "@classe-system-functions.php";
            require_once "@include-header-principal.php";
            require_once "@include-interatividade.php";
            /*PAGE CUSTONS*/
            $ticketsDIR = "ticket/";
            echo "<div class='main-content'>";
            if(!isset($_GET["action"])){
                require_once $ticketsDIR."index.php";
            }else{
                $action = $_GET["action"];
                if($action == "adicionar"){
                    require_once $ticketsDIR."create-ticket.php";
                }else if($action == "salvar"){
                    require_once $ticketsDIR."ticket-register.php";
                }else if($action == "interna"){
                    require_once $ticketsDIR."ticket.php";
                }else if($action == "enviar"){
                    require_once $ticketsDIR."ticket-send.php";
                }else if($action == "status"){
                    require_once $ticketsDIR."ticket-status.php";
                }
            }
            echo "</div>";
            /*END PAGE CUSTONS*/
            require_once "@include-footer-principal.php";
        ?>
        <!--END REQUIRES PADRAO-->
    </body>
</html>