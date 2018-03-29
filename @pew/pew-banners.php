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
    $navigation_title = "Banners - $efectus_empresa_administrativo";
    $page_title = "Gerenciamento de Banners";
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
        <!--THIS PAGE LINKS-->
        <script type="text/javascript" src="js/banners.js"></script>
        <!--FIM THIS PAGE LINKS-->
        <!--THIS PAGE CSS-->
        <style>
            .lista-banners{
                padding: 20px;
                padding-top: 50px;
                padding-bottom: 50px;
            }
            .box-banner{
                position: relative;
                width: 40%;
                margin: 4.5%;
                padding: 0.5%;
                padding-top: 10px;
                padding-bottom: 10px;
                border-radius: 20px;
                float: left;
            }
            .box-banner .indice{
                width: 40px;
                height: 40px;
                border-radius: 50%;
                background-color: #fff;
                color: #111;
                font-weight: bold;
                position: absolute;
                top: -15px;
                left: -15px;
                font-size: 28px;
            }
            .box-banner .img-banner{
                width: 100%;
            }
            .box-banner .img-banner img{
                width: 100%;
                border-radius: 10px;
            }
            .box-banner .controllers{
                position: absolute;
                display: flex;
                bottom: 0px;
                width: 100%;
                justify-content: center;
                height: 70px;
                line-height: 50px;
                background: rgba(255, 255, 255, 0.4);
            }
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
            <a href="pew-cadastra-banner.php" class="btn-padrao" title="Cadastre um novo banner">Cadastrar novo</a>
            <div class="lista-banners">
                <?php
                    $tabela_banners = $pew_db->tabela_banners;
                    $contarBanners = mysqli_query($conexao, "select count(id) as total_banners from $tabela_banners");
                    $contagemBanners = mysqli_fetch_assoc($contarBanners);
                    $totalBanners = $contagemBanners["total_banners"];
                    $i = 0;
                    if($totalBanners > 0){
                        $queryBanners = mysqli_query($conexao, "select * from $tabela_banners order by posicao");
                        while($banners = mysqli_fetch_array($queryBanners)){
                            $i++;
                            $id = $banners["id"];
                            $imagem = $banners["imagem"];
                            $posicao = $banners["posicao"];
                            $status = $banners["status"];
                            if($i % 2 == 1){
                                echo "<br style='clear: both;'>";
                            }
                            $btnStatus = $status == 1 ? "<a class='btn-desativar btn-status-banner' data-banner-id='$id' data-acao='desativar' title='Clique para alterar o status do banner'>Desativar</a>" : "<a class='btn-ativar btn-status-banner' data-banner-id='$id' data-acao='ativar' title='Clique para alterar o status do banner'>Ativar</a>";
                            echo "<div class='box-banner'>";
                                echo "<div class='indice'>$i</div>";
                                echo "<div class='img-banner'><img src='../imagens/banners/$imagem'></div>";
                                echo "<div class='controllers'>";
                                    echo "<div class='small'>";
                                        echo $btnStatus;
                                    echo "</div>";
                                    echo "<div class='small'>";
                                        echo "<a href='pew-edita-banner.php?id_banner=$id' class='btn-alterar' title='Clique para alterar o banner'>Alterar</a>";
                                    echo "</div>";
                                echo "</div>";
                            echo "</div>";
                        }
                    }else{
                        echo "<h3 align='center'>Nenhum banner foi cadastrado. <a href='pew-cadastra-banner.php' class='link-padrao'>Clique aqui e cadastre</a></h3>";
                    }
                ?>
            </div>
            <br style="clear: both;">
        </section>
    </body>
</html>
<?php
    mysqli_close($conexao);
}else{
    header("location: index.php?msg=Área Restrita. É necessário fazer login para continuar.");
}
?>
