<?php
    session_start();
    
    $thisPageURL = substr($_SERVER["REQUEST_URI"], strpos($_SERVER["REQUEST_URI"], '@pew'));
    $_POST["next_page"] = str_replace("@pew/", "", $thisPageURL);
    
    require_once "@link-important-functions.php";
    require_once "@valida-sessao.php";

    $navigation_title = "Contato - " . $pew_session->empresa;
    $page_title = "Gerenciamento de mensagens contato";
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
                            msgConfirma = "Você tem certeza que deseja excluir essa mensagem?";
                            msgErro = "Ocorreu um erro ao excluir a mensagem";
                            msgSucesso = "A mensagem foi excluida com sucesso!";
                            break;
                        default:
                            msgConfirma = "Você tem certeza que deseja mudar o status dessa mensagem?";
                            msgErro = "Ocorreu um erro ao mudar o status da mensagem";
                            msgSucesso = "O status da mensagem foi atualizado com sucesso!";
                    }
                    function acaoContato(){
                        $.ajax({
                            type: "POST",
                            url: "pew-status-contato.php",
                            data: {id_contato: idContato, acao: acao, status: status},
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
                                        mensagemAlerta(msgSucesso, "", "limegreen", "pew-contatos.php");
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
        <h1 class="titulos"><?php echo $page_title; ?></h1>
        <section class="conteudo-painel">
            <table class="table-padrao" cellspacing="0">
            <?php
                $tabela_contatos = $pew_db->tabela_contatos;
                if(!isset($_GET["id_contato"])){
                    header("location: pew-contatos.php?msg=Nenhum resultado encontrado");
                }else{
                    $idContato = pew_string_format($_GET["id_contato"]);
                }
                $contarContato = mysqli_query($conexao, "select count(id) as total_contato from $tabela_contatos where id = '$idContato'");
                $contagemProposta = mysqli_fetch_assoc($contarContato);
                $totalContato = $contagemProposta["total_contato"];
                if($totalContato > 0){
                    echo "<thead>";
                        echo "<td>Data</td>";
                        echo "<td>Nome</td>";
                        echo "<td>E-mail</td>";
                        echo "<td>Telefone</td>";
                        echo "<td>Assunto</td>";
                    echo "</thead>";
                    echo "<tbody>";
                    $queryContato = mysqli_query($conexao, "select * from $tabela_contatos where id = '$idContato'");
                    while($contatos = mysqli_fetch_array($queryContato)){
                        $id = $contatos["id"];
                        $nome = $contatos["nome"];
                        $email = $contatos["email"];
                        $telefone = $contatos["telefone"];
                        $assunto = $contatos["assunto"];
                        $mensagem = $contatos["mensagem"];
                        $data = inverterData(substr($contatos["data"], 0, 10));
                        $status = $contatos["status"];
                        switch($status){
                            case 1:
                                $status = "Manter contato";
                                break;
                            case 2:
                                $status = "Finalizado";
                                break;
                            case 3:
                                $status = "Cancelado";
                                break;
                            default:
                                $status = "Fazer primeiro contato";
                        }
                        echo "<td>$data</td>";
                        echo "<td>$nome</td>";
                        echo "<td>$email</td>";
                        echo "<td>$telefone</td>";
                        echo "<td>$assunto</td>";
                        echo "<thead><tr><td style='background-color: transparent;'></td></tr><td colspan=5>Mensagem</td></thead>";
                        echo "<tbody><td colspan=5>$mensagem</td></tbody>";
                    }
                    echo "</tbody>";?>
            </table>
            <br><br>
            <label class="label-medium">
                <select id="statusContato">
                    <option value="1">Manter Contato</option>
                    <option value="2">Finalizado</option>
                    <option value="3">Cancelado</option>
                    <option value="0">Fazer primeiro contato</option>
                </select>
                <input type="button" class="btn-submit botao-acao" data-id-contato='<?php echo $idContato; ?>' data-acao="atualizar" value="Atualizar Status">
            </label>
            <label class="label-small">
                <button class="btn-excluir botao-acao" data-id-contato='<?php echo $idContato; ?>' data-acao="excluir">
                    <i class="fa fa-trash" aria-hidden="true"></i> Excluir Mensagem
                </button>
            </label>
            <br style="clear: both;">
            <?php
                }else{
                    $msg = "Nenhum resultado encontrado.";
                    echo "<br><br><br><br><br><h3 align='center'>$msg <a href='pew-contatos.php' class='link-padrao'>Voltar</a></h3></td>";
                }
            ?>
        </section>
    </body>
</html>