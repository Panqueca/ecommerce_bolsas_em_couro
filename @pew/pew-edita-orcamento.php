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
                    var idOrcamento = botao.attr("data-id-orcamento");
                    var acao = botao.attr("data-acao");
                    var status = $("#statusOrcamento").val();
                    
                    var msgConfirma = null;
                    var msgErro = null;
                    var msgSucesso = null;
                    switch(acao){
                        case "excluir":
                            msgConfirma = "Você tem certeza que deseja excluir esse orçamento?";
                            msgErro = "Ocorreu um erro ao excluir o orçamento";
                            msgSucesso = "O orçamento foi excluido com sucesso!";
                            break;
                        case "enviar_email":
                            msgConfirma = "Você tem certeza que deseja enviar esse orçamento?";
                            msgErro = "Ocorreu um erro ao enviar o orçamento";
                            msgSucesso = "O orçamento foi enviado com sucesso!";
                            break;
                        default:
                            msgConfirma = "Você tem certeza que deseja mudar o status desse orçamento?";
                            msgErro = "Ocorreu um erro ao mudar o status do orçamento";
                            msgSucesso = "O status do orçamento foi atualizado com sucesso!";
                    }
                    function acaoContato(){
                        $.ajax({
                            type: "POST",
                            url: "pew-status-orcamento.php",
                            data: {id_orcamento: idOrcamento, acao: acao, status: status},
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
                                    if(respota != "false"){
                                        var url = acao != "excluir" ? "pew-edita-orcamento.php?id_orcamento="+idOrcamento : "pew-orcamentos.php";
                                        mensagemAlerta(msgSucesso, "", "limegreen", url);
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
        <style>
            .display-produtos{
                width: 100%;
            }
            .display-produtos thead{
                background-color: #ccc;
                color: #111;
            }
            .display-produtos thead td{
                padding: 5px;
            }
            .display-produtos tbody td{
                background-color: #fff;
                padding: 5px;
                text-align: center;
            }
            .display-produtos tbody td:hover{
                background-color: #f1f1f1;   
            }
            .display-produtos tbody .titulo{
                text-align: left;
            }
            .display-produtos tbody .total{
                text-align: right;
            }
            .display-produtos tfoot td{
                background-color: #f3f3f3;
                padding: 5px;
            }
        </style>
    </head>
    <body>
        <?php
            // STANDARD REQUIRE
            require_once "@include-body.php";
            require_once "@classe-orcamentos.php";
            if(isset($block_level) && $block_level == true){
                $pew_session->block_level();
            }
        ?>
        <!--PAGE CONTENT-->
        <h1 class="titulos"><?php echo $page_title; ?><a href="pew-orcamentos.php" class="btn-voltar"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</a></h1>
        <section class="conteudo-painel">
        <?php
            $tabela_orcamentos = $pew_custom_db->tabela_orcamentos;
            $tabela_carrinhos = $pew_custom_db->tabela_carrinhos;
            
            $idOrcamento = isset($_GET["id_orcamento"]) ? $_GET["id_orcamento"] : 0;
            $total = $pew_functions->contar_resultados($tabela_orcamentos, "id = '$idOrcamento'");

            $cls_orcamentos = new Orcamentos();
            if($total > 0){
                echo "<table class='table-padrao'>";
                echo "<thead>";
                    echo "<td>Data</td>";
                    echo "<td>Nome</td>";
                    echo "<td>E-mail</td>";
                    echo "<td>Telefone</td>";
                    echo "<td>CPF</td>";
                    echo "<td>Total Orçamento</td>";
                    echo "<td>Desconto</td>";
                    echo "<td>Status</td>";
                echo "</thead>";
                echo "<tbody>";
                $queryOrcamentos = mysqli_query($conexao, "select * from $tabela_orcamentos where id = '$idOrcamento'");
                while($orcamentos = mysqli_fetch_array($queryOrcamentos)){
                    $tokenCarrinho = $orcamentos["token_carrinho"];
                    $nome = $orcamentos["nome_cliente"];
                    $email = $orcamentos["email_cliente"];
                    $telefone = $orcamentos["telefone_cliente"];
                    $cpf = $pew_functions->mask($orcamentos["cpf_cliente"], "###.###.###-##");
                    $totalDesconto = $orcamentos["porcentagem_desconto"];
                    $totalOrcamento = $cls_orcamentos->get_total_orcamento($idOrcamento);
                    $dataOrcamento = $orcamentos["data_controle"];
                    $dataOrcamento = $pew_functions->inverter_data(substr($dataOrcamento, 0, 10));
                    if($totalOrcamento == 0){
                        $strOrcamento = "ORÇAR";
                    }else{
                        $strOrcamento = "R$ ". $pew_functions->custom_number_format($totalOrcamento);
                    }
                    $status = $cls_orcamentos->get_string_status($orcamentos["status_orcamento"]);

                    echo "<tr><td>$dataOrcamento</td>";
                    echo "<td>$nome</td>";
                    echo "<td>$email</td>";
                    echo "<td>$telefone</td>";
                    echo "<td>$cpf</td>";
                    echo "<td>$strOrcamento</td>";
                    echo "<td>$totalDesconto%</td>";
                    echo "<td>$status</td>";
                }
                echo "</tbody></table>";
                echo "<div class='small'>";
                    echo "<h5 class='label-title'>Alterar status</h5>";
                    echo "<select name='status' id='statusOrcamento' class='label-input'>";
                        echo "<option value='0'>Enviado pelo cliente</option>";
                        echo "<option value='1'>Configurado pelo vendedor</option>";
                        echo "<option value='2'>Enviado ao cliente</option>";
                        echo "<option value='3'>Confirmado</option>";
                        echo "<option value='4'>Cancelado</option>";
                    echo "</select>";
                echo "</div>";
                echo "<div class='xsmall' style='margin: 25px 0px 0px 0px;'>";
                    echo "<input type='button' value='Alterar' class='botao-alterar-status botao-acao label-input' style='cursor: pointer;' data-acao='atualizar' data-id-orcamento='$idOrcamento'>";
                echo "</div>";
                echo "<br class='clear'>";
                echo "<h4>Produtos do orçamento</h4>";
                echo "<table class='display-produtos clear'>";
                    echo "<thead>";
                        echo "<td align=center>Quantidade</td>";
                        echo "<td>Produto</td>";
                        echo "<td align=center>Preço</td>";
                        echo "<td align=center>Subtotal</td>";
                    echo "</thead>";
                $queryCarrinho = mysqli_query($conexao, "select * from $tabela_carrinhos where token_carrinho = '$tokenCarrinho'");
                while($infoCarrinho = mysqli_fetch_array($queryCarrinho)){
                    
                    $subtotal = $infoCarrinho["preco_produto"] * $infoCarrinho["quantidade_produto"];
                    $subtotal = $pew_functions->custom_number_format($subtotal);
                    
                    $urlBase = "https://www.efectusdigital.com.br/reidasfechaduras/";
                    
                    $urlProduto = "pew-edita-produto.php?id_produto={$infoCarrinho["id_produto"]}";
                    
                    echo "<tbody>";
                        echo "<td class='quantidade'>{$infoCarrinho["quantidade_produto"]}x</td>";
                        echo "<td class='titulo'><a href='$urlProduto' class='link-padrao' target='_blank'>{$infoCarrinho["nome_produto"]}</a></td>";
                        echo "<td class='preco'>R$ {$infoCarrinho["preco_produto"]}</td>";
                        echo "<td class='total'>R$ $subtotal</td>";
                    echo "</tbody>";
                }
                    echo "<tfoot>";
                        echo "<td colspan=3 align=center>Total</td>";
                        echo "<td align=right>$strOrcamento</td>";
                    echo "</tfoot>";
                echo "</table>";
                echo "<div class='group clear'>";
                    echo "<div class='small'>";
                        echo "<a class='btn-excluir botao-acao label-input' style='display: block; font-size: 18px; line-height: 40px; height: 36px;' data-acao='excluir' data-id-orcamento='$idOrcamento'><i class='fas fa-trash'></i> Excluir orçamento</a>";
                    echo "</div>";
                    echo "<div class='small'>";
                        echo "<a href='pew-cadastra-orcamento.php?id_orcamento=$idOrcamento' class='btn-submit label-input' style='display: block; font-size: 18px; line-height: 40px; height: 36px;'><i class='fas fa-plus'></i> Clonar orçamento</a>";
                    echo "</div>";
                    echo "<div class='small'>";
                        echo "<a class='btn-submit label-input botao-acao' data-acao='enviar_email' data-id-orcamento='$idOrcamento' style='display: block; font-size: 18px; line-height: 40px; height: 36px;'><i class='far fa-envelope'></i> Enviar no email</a>";
                    echo "</div>";
                    echo "<div class='small'>";
                        echo "<a href='{$urlBase}finalizar-compra.php?token_carrinho=$tokenCarrinho' target='_blank' class='btn-submit label-input' style='display: block; font-size: 18px; line-height: 40px; height: 36px;'><i class='fas fa-shopping-cart'></i> Visualizar carrinho</a>";
                    echo "</div>";
                echo "</div>";
            }else{
                $msg = "Nenhum resultado encontrado. <a href='pew-orcamentos.php' class='link-padrao'><b>Voltar<b></a>";
                echo "<br><br><br><br><br><h3 align='center'>$msg</h3></td>";
            } 
        ?>
        </section>
    </body>
</html>