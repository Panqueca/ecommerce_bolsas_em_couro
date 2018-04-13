<?php
    session_start();
    $nomeEmpresa = "Bolsas em Couro";
    $descricaoPagina = "DESCRIÇÃO MODELO ATUALIZAR...";
    $tituloPagina = "Institucional - $nomeEmpresa";
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
            <br><br>
            
            <?php
                require_once "@classe-minha-conta.php";
                $cls_conta = new MinhaConta();
                $cls_conta->verify_session_start();
            
                $is_logado = false;
            
                if(isset($_SESSION["minha_conta"])){
                    $auth = $cls_conta->auth($_SESSION["minha_conta"]["email"], $_SESSION["minha_conta"]["senha"]);
                    $is_logado = $auth == true ? true : false;
                }
            
                function block(){
                    echo "<center><h3 align=center>Erro:</h3>";
                    echo "<a href='index.php' class='link-padrao'>Voltar á página inicial</a>";
                    die();
                }
            
                function confirm_code($codigo){
                    global $cls_conta;
                    
                    require_once "@pew/pew-system-config.php";
                    
                    $getID = $cls_conta->query_minha_conta("md5(md5(email)) = '$codigo'");
                    
                    if($getID != false){
                        $confirma = $cls_conta->confirmar_conta($getID);
                        
                        if($confirma == "already"){
                            echo "<center><h3 align=center>O seu e-mail já está confirmado!</h3>";
                            echo "<a href='index.php' class='link-padrao'>Voltar á página inicial</a>";
                        }else if($confirma == "true"){
                            echo "<center><h3 align=center>Parabéns o seu e-mail foi confirmado!</h3>";
                            echo "<a href='index.php' class='link-padrao'>Voltar á página inicial</a>";
                        }else{
                            block();
                        }
                    }else{
                        block();
                    }
                }
            
                if(isset($_GET["confirm"])){
                    confirm_code($_GET["confirm"]);
                }else{
                    
                    if($is_logado == false){
                        block();
                    }

                    $sessionEmail = $_SESSION["minha_conta"]["email"];
                    $sessionSenha = $_SESSION["minha_conta"]["senha"];

                    $idConta = $cls_conta->query_minha_conta("md5(email) = '$sessionEmail' and senha = '$sessionSenha'");

                    $infoConta = null;
                    if($cls_conta->montar_minha_conta($idConta)){
                        $infoConta = $cls_conta->montar_array();
                    }else{
                        block();
                    }

                    echo "<h1 align=center>REENVIANDO E-MAIL</h1>";
                    echo "<article align=center style='padding: 20px;'>";
                        echo "Reenviando link de confirmação para: <b>{$infoConta["email"]}</b>";
                    echo "</article>";  
                    
                }
            
            ?>
        </div>
        <!--END THIS PAGE CONTENT-->
        <?php
            require_once "@include-footer-principal.php";
        ?>
        <!--END REQUIRES PADRAO-->
    </body>
</html>