<?php
    session_start();
    
    $thisPageURL = substr($_SERVER["REQUEST_URI"], strpos($_SERVER["REQUEST_URI"], '@pew'));
    $_POST["next_page"] = str_replace("@pew/", "", $thisPageURL);
    $_POST["invalid_levels"] = array(1, 2);
    
    require_once "@link-important-functions.php";
    require_once "@valida-sessao.php";

    $navigation_title = "Usuários - " . $pew_session->empresa;
    $page_title = "Gerenciamento de Usuários Administrativos";
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
        <style>
            .display-usuarios{
                margin-top: 50px;
                margin-bottom: 50px;
            }
            .box-usuario{
                width: 50%;
                height: 35px;
                line-height: 35px;
                margin-bottom: 50px;
                -webkit-box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.2);
                -moz-box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.2);
                box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.2);
                border-radius: 20px;
                background-color: #fff;
                font-size: 16px;
                display: flex;
                flex-flow: row wrap;
                line-height: 48px;
            }
            .box-usuario .indice{
                width: 40px;
                line-height: 40px;
                text-align: center;
                background-color: #111;
                color: #fff;
                font-weight: bold;
                border-top-left-radius: 20px;
                border-bottom-left-radius: 20px;
            }
            .box-usuario .name-field{
                position: relative;
                width: 200px;
                padding: 0px 0px 0px 20px;
                transition: .2s;
                border-right: 2px solid #111;
            }
            .box-usuario .name-field:hover{
                background-color: #fbfbfb;
            }
            .box-usuario .nivel-field{
                position: relative;
                border-right: 2px solid #111;
                padding: 0px 20px 0px 20px;
                transition: .2s;
            }
            .box-usuario .nivel-field:hover{
                background-color: #fbfbfb;
            }
            .box-usuario .control-field{
                position: relative;
                border-top-right-radius: 20px;
                border-bottom-right-radius: 20px;
                padding: 0px 0px 0px 20px;
                transition: .2s;
            }
            .box-usuario .control-field .btn-editar{
                font-size: 16px;   
            }
            .box-usuario .control-field:hover{
                background-color: #fbfbfb;
            }
            .box-usuario .title{
                position: absolute;
                font-size: 18px;
                line-height: 18px;
                background-color: #fff;
                color: #111;
                padding: 5px;
                padding-left: 15px;
                padding-right: 15px;
                border-radius: 20px;
                margin: 0px;
                top: -14px;
                left: 5px;
                float: left;
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
        <h1 class="titulos">Gerenciamento de Usuários Administrativos</h1>
        <section class="conteudo-painel">
            <div class="group clear">
                <form action="pew-usuarios.php" method="get" class="label half clear">
                    <label class="group">
                        <div class="group">
                            <h3 class="label-title">Busca de produtos</h3>
                        </div>
                        <div class="group">
                            <div class="xlarge" style="margin-left: -5px; margin-right: 0px;">
                                <input type="search" name="busca" placeholder="Busque por usuário, email, ou nível." class="label-input" title="Buscar">
                            </div>
                            <div class="xsmall" style="margin-left: 0px;">
                                <button type="submit" class="btn-submit label-input btn-flat" style="margin: 10px;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </label>
                </form>
                <div class="label half jc-left">
                    <div class="full">
                        <h4 class="subtitulos" align=left>Mais funções</h4>
                    </div>
                    <div class="label full">
                        <a href="pew-cadastra-usuario.php" class="btn-flat" title="Cadastre um novo usuário"><i class="fas fa-plus"></i> Cadastrar usuário</a>
                    </div>
                </div>
            </div>
            <div class="display-usuarios full clear">
                <?php
                    $tabela_usuarios = $pew_db->tabela_usuarios_administrativos;
                    $strBusca = isset($_GET["busca"]) ? $_GET["busca"] : "";
                    $busca = "";
                    if($strBusca != ""){
                        $busca = "where usuario like '%".$strBusca."%' or nivel like '%".$strBusca."%' or email like '%".$strBusca."%'";
                        echo "<div class='group'><h3>Exibindo resultados para: $strBusca</h3></div>";
                    }else{
                        echo "<div class='full' style='padding-top: 40px;'><h3 class='subtitulos'>Listagem de Usuários</h3></div>";
                    }
                    $contarUsuarios = mysqli_query($conexao, "select count(id) as total_usuarios from $tabela_usuarios $busca");
                    $contagem = mysqli_fetch_assoc($contarUsuarios);
                    if($contagem["total_usuarios"] > 0){
                        echo "<div class='full' style='margin-top: 40px;'>";
                        $queryUsuarios = mysqli_query($conexao, "select * from $tabela_usuarios $busca order by usuario asc");
                        $i = 0;
                        while($usuarios = mysqli_fetch_array($queryUsuarios)){
                            $idUsuario = $usuarios["id"];
                            $usuario  = $usuarios["usuario"];
                            $nivel  = $usuarios["nivel"];
                            switch($nivel){
                                case 2:
                                    $nivel = "Comercial";
                                    break;
                                case 3:
                                    $nivel = "Administrador";
                                    break;
                                default:
                                    $nivel = "Designer";
                            }
                            $i++;
                            echo "<div class='box-usuario'>";
                                echo "<div class='indice'>$i</div>";
                                echo "<div class='name-field'>";
                                    echo "<h3 class='title'>Usuário</h3>";
                                    echo $usuario;
                                echo "</div>";
                                echo "<div class='nivel-field'>";
                                    echo "<h3 class='title'>Nível</h3>";
                                    echo $nivel;
                                echo "</div>";
                                echo "<div class='control-field'>";
                                    echo "<h3 class='title'>Editar</h3>";
                                    echo "<a href='pew-edita-usuario.php?id_usuario=$idUsuario' class='btn-editar'><i class='fas fa-edit'></i> Editar</a>";
                                echo "</div>";
                            echo "</div>";
                        }
                        echo "</div>";
                    }else{
                        echo "<h3 class='subtitulos'>Não foram encontrados usuários.</h3>";
                    }
                ?>
            </div>
        </section>
    </body>
</html>