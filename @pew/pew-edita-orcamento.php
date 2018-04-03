<?php
    session_start();
    
    $thisPageURL = substr($_SERVER["REQUEST_URI"], strpos($_SERVER["REQUEST_URI"], '@pew'));
    $_POST["next_page"] = str_replace("@pew/", "", $thisPageURL);
    $_POST["invalid_levels"] = array(1);
    
    require_once "@link-important-functions.php";
    require_once "@valida-sessao.php";

    $navigation_title = "Orçamentos - " . $pew_session->empresa;
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
        <?php
            require_once "@link-standard-styles.php";
            require_once "@link-standard-scripts.php";
        ?>
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
            // STANDARD REQUIRE
            require_once "@include-body.php";
            if(isset($block_level) && $block_level == true){
                $pew_session->block_level();
            }
        ?>
        <!--PAGE CONTENT-->
        <h1 class="titulos"><?php echo $page_title; ?><a href="pew-orcamentos.php" class="btn-voltar"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</a></h1>
        <section class="conteudo-painel">
            <h3 align=center>Em manutenção</h3>
            <h3 align=center>Prazo: 26/02/18</h3>
        </section>
    </body>
</html>