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
    $navigation_title = "Mensagem orçamento - $efectus_empresa_administrativo";
    $page_title = "Gerenciamento de pedido de orçamento";
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
        <script>
            $(document).ready(function(){
                $(".botao-acao").off().on("click", function(){
                    var botao = $(this);
                    var idContato = botao.attr("data-id-contato");
                    var acao = botao.attr("data-acao");
                    var status = $("#statusContato").val();
                    var msgConfirma = null;
                    var msgErro = null;
                    var msgSucesso = null;
                    switch(acao){
                        case "excluir":
                            msgConfirma = "Você tem certeza que deseja excluir esse pedido?";
                            msgErro = "Ocorreu um erro ao excluir a mensagem";
                            msgSucesso = "O pedido foi excluido com sucesso!";
                            break;
                        default:
                            msgConfirma = "Você tem certeza que deseja mudar o status desse pedido?";
                            msgErro = "Ocorreu um erro ao mudar o status do pedido";
                            msgSucesso = "O status do pedido foi atualizado com sucesso!";
                    }
                    function acaoContato(){
                        $.ajax({
                            type: "POST",
                            url: "pew-status-orcamento.php",
                            data: {id_orcamento: idContato, acao: acao, status: status},
                            beforeSend: function(){
                                notificacaoPadrao("Aguarde...", "success");
                            },
                            error: function(){
                                setTimeout(function(){
                                    notificacaoPadrao(msgErro, "error", 5000);
                                }, 1000);
                            },
                            success: function(respota){
                                console.log(respota);
                                setTimeout(function(){
                                    if(respota == "true"){
                                        mensagemAlerta(msgSucesso, "", "limegreen", "pew-orcamentos.php");
                                    }else{
                                        notificacaoPadrao(msgErro, "error", 5000);
                                    }
                                }, 500);
                            }
                        });
                    }
                    mensagemConfirma(msgConfirma, acaoContato);
                });
            });
        </script>
    </head>
    <body>
        <?php
            /*REQUIRE PADRAO*/
            require_once "header-efectus-web.php";
            require_once "pew-interatividade.php";
            /*FIM PADRAO*/
        ?>
        <h1 class="titulos"><?php echo $page_title; ?><a href="pew-orcamentos.php" class="btn-voltar"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</a></h1>
        <section class="conteudo-painel">
            <h3 align=center>Em manutenção</h3>
            <h3 align=center>Prazo: 26/02/18</h3>
        </section>
    </body>
</html>
<?php
    mysqli_close($conexao);
}else{
    header("location: index.php?msg=Área Restrita. É necessário fazer login para continuar.");
}
?>
