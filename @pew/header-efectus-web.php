<style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat');
    body{
        margin: 0px;
        font-family: 'Montserrat', sans-serif;
        background-color: #fdfdfd;
    }
    .section-header{
        width: 100%;
        height: 100px;
    }
    .header-efectus-web{
        width: 100%;
        background-color: #fbfbfb;
        -webkit-box-shadow: 2px 0px 10px 5px rgba(0, 0, 0, .1);
        -moz-box-shadow: 2px 0px 10px 5px rgba(0, 0, 0, .1);
        box-shadow: 2px 0px 10px 5px rgba(0, 0, 0, .1);
        position: fixed;
        top: 0px;
        left: 0px;
        z-index: 80;
    }
    .header-efectus-web .top-info{
        width: 100%;
        height: 30px;
        background-color: #eee;
        color: #666;
        line-height: 30px;
        position: relative;
    }
    .header-efectus-web .top-info .date-field{
        position: absolute;
        top: 0px;
        right: 0px;
        font-size: 14px;
        width: 120px;
        text-align: center;
    }
    .header-efectus-web .top-info .login-field{
        position: absolute;
        top: 0px;
        right: 120px;
        padding-left: 10px;
        border-right: 4px solid #dedede;
        padding-right: 10px;
        font-size: 14px;
        transition: .2s;
        cursor: pointer;
    }
    .header-efectus-web .top-info .login-field:hover{
        background-color: #df2321;
        color: #FFF;
        border-color: #df2321;
        border-radius: 5px;
        border-bottom-right-radius: 0px;
    }
    .header-efectus-web .top-info .login-field:hover .menu-field{
        opacity: 1;
        top: 30px;
        z-index: 10;
    }
    .header-efectus-web .top-info .login-field .menu-field{
        position: absolute;
        top: 25px;
        right: -4px;
        background-color: #df2321;
        font-size: 14px;
        border-bottom-left-radius: 10px;
        border-bottom-right-radius: 10px;
        z-index: -1;
        opacity: 0;
        transition: .2s;
        background-color: #c02423;
    }
    .header-efectus-web .top-info .login-field .menu-field li{
        display: block;
        list-style: none;
        text-decoration: none;
        color: #DDD;
        padding: 10px;
        padding-bottom: 0px;
        padding-top: 0px;
    }
    .header-efectus-web .top-info .login-field .menu-field a{
        text-decoration: none;
    }
    .header-efectus-web .top-info .login-field .menu-field li:hover{
        color: #999;
    }
    .header-efectus-web .nav-header{
        width: 100%;
    }
    .header-efectus-web .nav-header .background-nav{
        position: fixed;
        width: 100%;
        height: 100%;
        background-color: #000;
        top: 96px;
        z-index: -1;
        left: 0px;
        visibility: hidden;
        opacity: 0;
        transition: .4s;
        pointer-events: none;
    }
    .header-efectus-web .nav-header .logo-header{
        width: 250px;
        float: left;
    }
    .header-efectus-web .nav-header .logo-header img{
        width: 100%;
    }
    .header-efectus-web .nav-header .display-links{
        display: inline-block;
        padding: 0px;
        height: 68px;
        margin: 0px;
    }
    .header-efectus-web .nav-header .display-links:hover .background-nav{
        visibility: visible;
        opacity: .6;
        transition: visibilty 0s, opacity .3s;
    }
    .header-efectus-web .nav-header .display-links li{
        display: inline-block;
        position: relative;
        z-index: 51;
    }
    .header-efectus-web .nav-header .display-links .link-principal{
        display: inline-block;
        color: #f78a14;
        padding-left: 15px;
        padding-right: 15px;
        line-height: 65px;
        transition: .2s linear;
        border-top: 4px solid transparent;
        text-decoration: none;
    }
    .header-efectus-web .nav-header .display-links .sub-menu{
        background-color: #f6f6f6;
        padding: 0px;
        position: absolute;
        top: 65px;
        left: 0px;
        transition: .2s;
        visibility: hidden;
        opacity: 0;
    }
    .header-efectus-web .nav-header .display-links li:hover .link-principal{
        color: #df2321;
        border-color: #df2321;
        background-color: #f6f6f6;
        font-weight: bold;
    }
    .header-efectus-web .nav-header .display-links li:hover .sub-menu{
        opacity: 1;
        visibility: visible;
        transition: visibility 0s, opacity .2s;
    }
    .header-efectus-web .nav-header .display-links .sub-menu li{
        white-space: nowrap;
        font-size: 14px;
        min-width: 250px;
        width: 100%;
        position: relative;
    }
    .header-efectus-web .nav-header .display-links .sub-menu .sub-link{
        display: block;
        text-decoration: none;
        color: #f78a14;
        width: 85%;
        padding: 10px;
        padding-left: 5%;
        padding-right: 10%;
        transition: .2s;
    }
    .header-efectus-web .nav-header .display-links .sub-menu li:hover .sub-link{
        background-color: #f78a14;
        color: #f6f6f6;
        font-weight: bold;
    }
    .header-efectus-web .nav-header .display-links .sub-menu li .sub-sub-menu{
        position: absolute;
        top: 0px;
        left: 96%;
        z-index: -1;
        background-color: #f2f2f2;
        padding: 0px;
        opacity: 0;
        visibility: hidden;
    }
    .header-efectus-web .nav-header .display-links .sub-menu li:hover .sub-sub-menu{
        visibility: visible;
        opacity: 1;
        left: 100%;
        transition: visibility 0s, opacity .3s, left .2s;
    }
    .header-efectus-web .nav-header .display-links .sub-menu li .sub-sub-menu li{
        white-space: nowrap;
        font-size: 14px;
        min-width: 200px;
    }
    .header-efectus-web .nav-header .display-links .sub-menu li .sub-sub-menu .sub-sub-links{
        display: block;
        text-decoration: none;
        color: #df2321;
        width: 90%;
        padding: 10px;
        padding-left: 5%;
        padding-right: 5%;
        border-right: 2px solid transparent;
        transition: .2s;
    }
    .header-efectus-web .nav-header .display-links .sub-menu li .sub-sub-menu .sub-sub-links:hover{
        font-weight: bold;
        border-color: #f78a14;
        color: #f78a14;
    }
    .header-efectus-web .nav-header .display-links .sub-menu li .sub-sub-links-icon{
        position: absolute;
        top: 0px;
        right: 5px;
        width: 10%;
        height: 100%;
        line-height: 38px;
        color: #ccc;
        transition: .2s;
    }
    .header-efectus-web .nav-header .display-links .sub-menu li:hover .sub-sub-links-icon{
        color: #fff;
        right: 0px;
    }
</style>
<link type="text/css" rel="stylesheet" href="fontes/font-awesome-4.7.0/css/font-awesome.min.css">
<?php
/*Função para inversão de data buscada no banco de dados*/
function inverterData($data){
    if(count(explode("-",$data)) > 1){
        return implode("/",array_reverse(explode("-",$data)));
    }elseif(count(explode("/",$data)) > 1){
        return implode("-",array_reverse(explode("/",$data)));
    }
}
/*FIM Função para inversão de data buscada no banco de dados*/
?>
<section class="section-header">
    <header class="header-efectus-web">
        <div class="top-info">
            <div class="date-field">
                <i class='fa fa-calendar' aria-hidden='true'></i> <?php echo inverterData(substr(date("Y-m-d h:i:s"), 0, 10)); ?>
            </div>
            <div class="login-field"><i class='fa fa-user-circle-o' aria-hidden='true'></i>
                <?php
                    $pew_usuario = $_SESSION[$name_session_user];
                    $pew_nivel = (int)$_SESSION[$name_session_nivel];
                    $pew_usuario = ucwords($pew_usuario);
                    switch($pew_nivel){
                        case 2:
                            $pew_nivel = "Comercial";
                            break;
                        case 3:
                            $pew_nivel = "Administrador";
                            break;
                        default:
                            $pew_nivel = "Designer";
                    }
                ?>
                <?php echo $pew_usuario." | ".$pew_nivel; ?>
                <div class="menu-field">
                    <a href="pew-configurar-conta.php"><li>Configurar conta</li></a>
                    <a href="deslogar.php"><li>Sair</li></a>
                </div>
            </div>
        </div>
        <nav class="nav-header">
            <div class="logo-header"><a href="pew-banners.php"><img src="imagens/sistema/identidadeVisual/logo-efectus-web.png" alt="Efectus Web - Desenvolvimento de Softwares e Plataformas Web" title="Painel de Controle"></a></div>
            <?php
                /*Primeiro Link*/
                $linksPrincipais[0]["titulo_link"] = "Banners";
                $linksPrincipais[0]["url_link"] = "pew-banners.php";
                $linksPrincipais[0]["sub_link"][0]["titulo_sub_link"] = "<i class='fa fa-picture-o' aria-hidden='true'></i> Listar Banners";
                $linksPrincipais[0]["sub_link"][0]["url_sub_link"] = "pew-banners.php";
                $linksPrincipais[0]["sub_link"][1]["titulo_sub_link"] = "<i class='fa fa-plus' aria-hidden='true'></i> Cadastrar novo";
                $linksPrincipais[0]["sub_link"][1]["url_sub_link"] = "pew-cadastra-banner.php";
                /*Segundo Link*/
                $linksPrincipais[1]["titulo_link"] = "Produtos";
                $linksPrincipais[1]["url_link"] = "pew-produtos.php";
                $linksPrincipais[1]["sub_link"][0]["titulo_sub_link"] = "<i class='fa fa-th' aria-hidden='true'></i> Listar Produtos";
                $linksPrincipais[1]["sub_link"][0]["url_sub_link"] = "pew-produtos.php";
                $linksPrincipais[1]["sub_link"][1]["titulo_sub_link"] = "<i class='fa fa-plus' aria-hidden='true'></i> Cadastrar novo";
                $linksPrincipais[1]["sub_link"][1]["url_sub_link"] = "pew-cadastra-produto.php";
                $linksPrincipais[1]["sub_link"][2]["titulo_sub_link"] = "<i class='fa fa-tag' aria-hidden='true'></i> Marcas";
                $linksPrincipais[1]["sub_link"][2]["url_sub_link"] = "pew-marcas.php";
                $linksPrincipais[1]["sub_link"][3]["titulo_sub_link"] = "<i class='fa fa-cogs' aria-hidden='true'></i> Especificações técnicas";
                /*Terceiro Link*/
                $linksPrincipais[2]["titulo_link"] = "Vitrine";
                $linksPrincipais[2]["url_link"] = "pew-categorias-vitrine.php";
                $linksPrincipais[2]["sub_link"][0]["titulo_sub_link"] = "<i class='fa fa-tag' aria-hidden='true'></i> Categorias da vitrine";
                $linksPrincipais[2]["sub_link"][0]["url_sub_link"] = "pew-categorias-vitrine.php";
                $linksPrincipais[2]["sub_link"][1]["titulo_sub_link"] = "<i class='fa fa-star' aria-hidden='true'></i> Categoria destaque";
                $linksPrincipais[2]["sub_link"][1]["url_sub_link"] = "pew-categoria-destaque.php";
                /*Quarto Link*/
                $linksPrincipais[3]["titulo_link"] = "Orçamentos";
                $linksPrincipais[3]["url_link"] = "pew-orcamentos.php";
                $linksPrincipais[3]["sub_link"][0]["titulo_sub_link"] = "<i class='fa fa-money' aria-hidden='true'></i> Pedidos de orçamento";
                $linksPrincipais[3]["sub_link"][0]["url_sub_link"] = "pew-orcamentos.php";
                $linksPrincipais[3]["sub_link"][1]["titulo_sub_link"] = "<i class='fa fa-plus' aria-hidden='true'></i> Cadastrar orçamento";
                $linksPrincipais[3]["sub_link"][1]["url_sub_link"] = "pew-cadastra-orcamento.php";
                $linksPrincipais[3]["sub_link"][2]["titulo_sub_link"] = "<i class='fa fa-cogs' aria-hidden='true'></i> Opções orçamentos";
                $linksPrincipais[3]["sub_link"][2]["url_sub_link"] = "pew-config-orcamentos.php";
                /*Quinto Link*/
                $linksPrincipais[4]["titulo_link"] = "Mensagens";
                $linksPrincipais[4]["url_link"] = "pew-newsletter.php";
                $linksPrincipais[4]["sub_link"][0]["titulo_sub_link"] = "<i class='fa fa-tags' aria-hidden='true'></i> E-mails newsletter";
                $linksPrincipais[4]["sub_link"][0]["url_sub_link"] = "pew-newsletter.php";
                /*Sexto Link*/
                $linksPrincipais[5]["titulo_link"] = "Categorias";
                $linksPrincipais[5]["url_link"] = "pew-categorias.php";
                $linksPrincipais[5]["sub_link"][0]["titulo_sub_link"] = "<i class='fa fa-tags' aria-hidden='true'></i> Listar Categorias";
                $linksPrincipais[5]["sub_link"][0]["url_sub_link"] = "pew-categorias.php";
                $linksPrincipais[5]["sub_link"][1]["url_sub_link"] = "pew-departamentos.php";
                $linksPrincipais[5]["sub_link"][1]["titulo_sub_link"] = "<i class='fa fa-th-list' aria-hidden='true'></i> Departamentos";
                $linksPrincipais[5]["sub_link"][1]["url_sub_link"] = "pew-departamentos.php";
                /*Setimo Link*/
                $linksPrincipais[6]["titulo_link"] = "Usuários";
                $linksPrincipais[6]["url_link"] = "pew-usuarios.php";
                $linksPrincipais[6]["sub_link"][0]["titulo_sub_link"] = "<i class='fa fa-users' aria-hidden='true'></i> Listar Usuários";
                $linksPrincipais[6]["sub_link"][0]["url_sub_link"] = "pew-usuarios.php";
                $linksPrincipais[6]["sub_link"][1]["titulo_sub_link"] = "<i class='fa fa-plus' aria-hidden='true'></i> Cadastrar novo";
                $linksPrincipais[6]["sub_link"][1]["url_sub_link"] = "pew-cadastra-usuario.php";

                $quantidadeLinks = count($linksPrincipais);
                if($quantidadeLinks > 0){
                    echo "<ul class='display-links'>";
                    echo "<span class='background-nav'></span>";
                    $i = 0;
                    foreach($linksPrincipais as $linkMenu){
                        $i++;
                        $tituloLink = $linkMenu["titulo_link"];
                        $urlLink = $linkMenu["url_link"];
                        $idLink = "linkPrincipal$i";
                                echo "<li id='$idLink'>";
                                    echo "<a href='$urlLink' class='link-principal' data-target-id='$idLink'>$tituloLink</a>";
                                    $quantidadeSubLinks = isset($linkMenu["sub_link"]) ? count($linkMenu["sub_link"]) : 0;
                                    if($quantidadeSubLinks > 0){
                                        echo "<ul class='sub-menu'>";
                                            foreach($linkMenu["sub_link"] as $subLinks){
                                                $tituloSubLink = $subLinks["titulo_sub_link"];
                                                $urlSubLink = $subLinks["url_sub_link"];
                                                $quantidadeSubSubLinks = isset($subLinks["sub_sub_link"]) ? count($subLinks["sub_sub_link"]) : 0;
                                                echo "<li><a href='$urlSubLink' class='sub-link'>$tituloSubLink</a>";
                                                if($quantidadeSubSubLinks > 0){
                                                    echo "<span class='sub-sub-links-icon'><i class='fa fa-arrow-right' aria-hidden='true'></i></span>";
                                                    echo "<ul class='sub-sub-menu'>";
                                                    foreach($subLinks["sub_sub_link"] as $subSubLink){
                                                        $title = $subSubLink["titulo_sub_sub_link"];
                                                        $url = $subSubLink["url_sub_sub_link"];
                                                        echo "<li><a href='$url' class='sub-sub-links'>$title</a></li><br>";
                                                    }
                                                    echo "</ul>";
                                                }
                                                echo "</li>";
                                            }
                                        echo "</ul>";
                                    }
                                echo "</li>";
                    }
                    echo "</ul>";
                    echo "<br style='clear:both;'>";
                }
            ?>
        </nav>
    </header>
</section>
