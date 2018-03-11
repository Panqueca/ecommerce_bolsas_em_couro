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
    $navigation_title = "Usuários Administrativos - $efectus_empresa_administrativo";
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
        <!--LINKS e JS PADRAO-->
        <link type="image/png" rel="icon" href="imagens/sistema/identidadeVisual/icone-efectus-web.png">
        <link type="text/css" rel="stylesheet" href="css/estilo.css">
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/standard.js"></script>
        <!--FIM LINKS e JS PADRAO-->
        <style>
            .display-usuarios{
                margin-top: 50px;
                margin-bottom: 50px;
            }
            .box-usuario{
                height: 50px;
                line-height: 50px;
                margin-left: 10%;
                margin-bottom: 50px;
                width: 80%;
                -webkit-box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.2);
                -moz-box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.2);
                box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.2);
                border-radius: 20px;
            }
            .box-usuario .indice{
                width: 7%;
                background-color: #111;
                color: #fff;
                font-weight: bold;
                border-top-left-radius: 20px;
                border-bottom-left-radius: 20px;
                float: left;
            }
            .box-usuario .name-field{
                width: 44.8%;
                height: 50px;
                float: left;
                background-color: #fff;
                position: relative;
                font-size: 24px;
                font-weight: bold;
                text-align: left;
                padding-left: 2%;
                transition: .2s;
                border-right: 2px solid #111;
            }
            .box-usuario .name-field:hover{
                background-color: #fbfbfb;
            }
            .box-usuario .nivel-field{
                width: 20.6%;
                height: 50px;
                background-color: #fff;
                position: relative;
                border-right: 2px solid #111;
                font-size: 24px;
                font-weight: bold;
                margin: 0px;
                transition: .2s;
                float: left;
            }
            .box-usuario .nivel-field:hover{
                background-color: #fbfbfb;
            }
            .box-usuario .control-field{
                width: 25%;
                margin-left: 75%;
                height: 50px;
                background-color: #fff;
                position: relative;
                font-size: 24px;
                font-weight: bold;
                border-top-right-radius: 20px;
                border-bottom-right-radius: 20px;
                transition: .2s;
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
            /*REQUIRE PADRAO*/
            require_once "header-efectus-web.php";
            require_once "pew-interatividade.php";
            /*FIM PADRAO*/
        ?>
        <h1 class="titulos">Gerenciamento de Usuários Administrativos</h1>
        <section class="conteudo-painel">
            <a href="pew-cadastra-usuario.php" class="btn-padrao">Cadastrar novo</a>
            <br style="clear: both;">
            <br style="clear: both;">
            <form action="pew-usuarios.php" method="get" class="form-busca">
                <div>
                    <label class="field-busca">
                        <h3 class="titulo-busca">Buscar usuários</h3>
                        <input type="search" name="busca" placeholder="Busque por nome do usuário, e-mail ou nível" class="barra-busca" title="Busque por nome do usuário, e-mail ou nível">
                        <input type="submit" value="Buscar" class="btn-buscar">
                    </label>
                </div>
            </form>
            <div class="display-usuarios">
                <?php
                    $tabela_usuarios = $pew_db->tabela_usuarios_administrativos;
                    $strBusca = isset($_GET["busca"]) ? $_GET["busca"] : "";
                    $busca = "";
                    if($strBusca != ""){
                        $busca = "where usuario like '%".$strBusca."%' or nivel like '%".$strBusca."%' or email like '%".$strBusca."%'";
                        echo "<h2 align='center'>Exibindo resultados para: $strBusca</h2><br>";
                    }else{
                        echo "<h2 align='center'>Listagem de Usuários</h2><br><br>";
                    }
                    $contarUsuarios = mysqli_query($conexao, "select count(id) as total_usuarios from $tabela_usuarios $busca");
                    $contagem = mysqli_fetch_assoc($contarUsuarios);
                    if($contagem["total_usuarios"] > 0){
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
                            echo "<div class='box-usuario'><div class='indice'>$i</div><div class='name-field'><h3 class='title'>Usuário</h3>$usuario</div><div class='nivel-field'><h3 class='title'>Nível</h3>$nivel</div><div class='control-field'><h3 class='title'>Editar</h3><a href='pew-edita-usuario.php?id_usuario=$idUsuario' class='btn-editar'><i class='fa fa-pencil' aria-hidden='true'></i> Editar</a></div></div>";
                        }
                    }else{
                        echo "<h3 align='center'>Não foram encontrados usuários.</h3>";
                    }
                ?>
            </div>
        </section>
    </body>
</html>
<?php
    mysqli_close($conexao);
}else{
    header("location: index.php?msg=Área Restrita. É necessário fazer login para continuar.");
}
?>
