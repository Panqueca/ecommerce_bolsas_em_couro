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
    $navigation_title = "Newsletter - $efectus_empresa_administrativo";
    $page_title = "Gerenciamento de e-mails cadastrados";
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
        <link type="text/css" rel="stylesheet" href="css/estilo.css">
        <script type="text/javascript" src="../js/jquery.min.js"></script>
        <script type="text/javascript" src="js/standard.js"></script>
        <!--FIM LINKS e JS PADRAO-->
        <!--THIS PAGE LINKS-->
        <script type="text/javascript" src="js/produtos.js"></script>
        <!--FIM THIS PAGE LINKS-->
    </head>
    <script>
        $(document).ready(function(){
            $(".btn-excluir-newsletter").each(function(){
                var btnExcluir = $(this);
                var idNewsletter = btnExcluir.attr("data-id-newsletter");
                var msgSucesso = "O e-mail foi excluido com sucesso!";
                var msgErro = "Não foi possível excluir o e-mail. Recarregue a página e tente novamente.";

                btnExcluir.off().on("click", function(){
                    function excluir(){
                        $.ajax({
                            type: "POST",
                            url: "pew-status-newsletter.php",
                            data: {id_newsletter: idNewsletter, acao: "excluir"},
                            error: function(){
                                mensagemAlerta(msgErro);
                            },
                            success: function(resposta){
                                if(resposta == "true"){
                                    mensagemAlerta(msgSucesso, "",  "limegreen", "pew-newsletter.php");
                                }else{
                                    mensagemAlerta(msgErro);
                                }
                            }
                        });
                    }

                    mensagemConfirma("Tem certeza que deseja excluir este e-mail?", excluir);
                });
            });
        });
    </script>
    <body>
        <?php
            /*REQUIRE PADRAO*/
            require_once "header-efectus-web.php";
            require_once "pew-interatividade.php";
            /*FIM PADRAO*/
        ?>
        <h1 class="titulos"><?php echo $page_title; ?></h1>
        <section class="conteudo-painel">
            <br><br><br><br>
            <form class="form-busca" method="get" action="pew-newsletter.php">
                <label class="field-busca">
                    <h3 class="titulo-busca">Buscar newsletter</h3>
                    <input type="search" name="busca" placeholder="Busque por nome, e-mail, ou data" class="barra-busca" autocomplete="off">
                    <input type="submit" value="Buscar" class="btn-buscar">
                </label>
            </form>
            <table class="table-padrao" cellspacing="0">
            <?php
                $tabela_newsletter = $pew_custom_db->tabela_newsletter;
                if(isset($_GET["busca"]) && $_GET["busca"] != ""){
                    $busca = pew_string_format($_GET["busca"]);
                    $strBusca = "where nome like '%".$busca."%' or email like '%".$busca."%' or data like '%".$busca."%'";
                    $busca = $busca == "" ? "Todos e-mails" : $busca;
                    echo "<h3>Exibindo resultados para: $busca</h3>";
                }else{
                    $strBusca = "";
                }
                $contarNewsletter = mysqli_query($conexao, "select count(id) as total_newsletter from $tabela_newsletter $strBusca");
                $contagemNewsletter = mysqli_fetch_assoc($contarNewsletter);
                $totalNewsletter = $contagemNewsletter["total_newsletter"];
                if($totalNewsletter > 0){
                    echo "<thead>";
                        echo "<td>Data</td>";
                        echo "<td>Nome</td>";
                        echo "<td>E-mail</td>";
                        echo "<td>Excluir</td>";
                    echo "</thead>";
                    echo "<tbody>";
                    $queryNewsletter = mysqli_query($conexao, "select * from $tabela_newsletter $strBusca order by data desc");
                    while($newsletter = mysqli_fetch_array($queryNewsletter)){
                        $id = $newsletter["id"];
                        $nome = $newsletter["nome"];
                        $email = $newsletter["email"];
                        $data = inverterData(substr($newsletter["data"], 0, 10));
                        echo "<tr><td>$data</td>";
                        echo "<td>$nome</td>";
                        echo "<td>$email</td>";
                        echo "<td><a data-id-newsletter='$id' class='btn-editar btn-excluir-newsletter'><i class='fa fa-trash' aria-hidden='true'></i></a></td></tr>";
                    }
                    echo "</tbody>";
                }else{
                    $msg = $strBusca != "" ? "Nenhum resultado encontrado." : "Nenhum e-mail foi cadastrado.";
                    echo "<br><br><br><br><br><h3 align='center'>$msg</h3></td>";
                    echo "<br><br><a href='pew-newsletter.php' class='link-padrao'>Voltar</a>";
                }
            ?>
            </table>
        </section>
    </body>
</html>
<?php
    mysqli_close($conexao);
}else{
    header("location: index.php?msg=Área Restrita. É necessário fazer login para continuar.");
}
?>
