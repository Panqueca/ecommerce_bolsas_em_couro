<?php
    session_start();
    
    $thisPageURL = substr($_SERVER["REQUEST_URI"], strpos($_SERVER["REQUEST_URI"], '@pew'));
    $_POST["next_page"] = str_replace("@pew/", "", $thisPageURL);
    $_POST["invalid_levels"] = array(1);
    
    require_once "@link-important-functions.php";
    require_once "@valida-sessao.php";

    $navigation_title = "Orçamentos - " . $pew_session->empresa;
    $page_title = "Gerenciamento de pedidos de orçamento";
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
        <h1 class="titulos"><?php echo $page_title; ?></h1>
        <section class="conteudo-painel">
            <div class="group clear">
                <form action="pew-orcamentos.php" method="get" class="label half clear">
                    <label class="group">
                        <div class="group">
                            <h3 class="label-title">Busca de orçamentos</h3>
                        </div>
                        <div class="group">
                            <div class="xlarge" style="margin-left: -5px; margin-right: 0px;">
                                <input type="search" name="busca" placeholder="Nome, email, telefone, RG ou CPF" class="label-input" title="Buscar">
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
                        <a href="pew-cadastra-orcamento.php" class="btn-padrao btn-flat" title="Cadastre um novo orçamento"><i class="fas fa-plus"></i> Cadastrar orçamento</a>
                    </div>
                </div>
            </div>
            <table class="table-padrao group clear" cellspacing="0">
            <?php
                $tabela_orcamentos = $pew_custom_db->tabela_orcamentos;
                if(isset($_GET["busca"]) && $_GET["busca"] != ""){
                    $busca = pew_string_format($_GET["busca"]);
                    $strBusca = "where nome_cliente like '%".$busca."%' or telefone_cliente like '%".$busca."%' or email_cliente like '%".$busca."%' or rg_cliente like '%".$busca."%' or cpf_cliente like '%".$busca."%'";
                    echo "<div class='full clear'><h3>Exibindo resultados para: $busca</h3></div>";
                }else{
                    $strBusca = "";
                }
                $contarOrcamentos = mysqli_query($conexao, "select count(id) as total from $tabela_orcamentos s");
                $contagemContatos = mysqli_fetch_assoc($contarOrcamentos);
                $totalOrcamentos = $contagemContatos["total"];
                if($totalOrcamentos > 0){
                    echo "<thead>";
                        echo "<td>Nome</td>";
                        echo "<td>E-mail</td>";
                        echo "<td>Telefone</td>";
                        echo "<td>CPF</td>";
                        echo "<td>Total Orçamento</td>";
                        echo "<td>Status</td>";
                        echo "<td>Informações</td>";
                    echo "</thead>";
                    echo "<tbody>";
                    $queryOrcamentos = mysqli_query($conexao, "select * from $tabela_orcamentos $strBusca order by data_pedido desc");
                    while($orcamentos = mysqli_fetch_array($queryOrcamentos)){
                        $id = $orcamentos["id"];
                        $nome = $orcamentos["nome_cliente"];
                        $email = $orcamentos["email_cliente"];
                        $telefone = $orcamentos["telefone_cliente"];
                        $cpf = $orcamentos["cpf_cliente"];
                        $totalOrcamento = $orcamentos["preco_total"];
                        $status = $orcamentos["status_orcamento"];
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
                        echo "<tr><td>$nome</td>";
                        echo "<td>$email</td>";
                        echo "<td>$telefone</td>";
                        echo "<td>$cpf</td>";
                        echo "<td>R$ $totalOrcamento</td>";
                        echo "<td>$status</td>";
                        echo "<td align=center><a href='pew-edita-orcamento.php?id_orcamento=$id' class='btn-editar'><i class='fa fa-eye' aria-hidden='true'></i></a></td></tr>";
                    }
                    echo "</tbody></table>";
                }else{
                    $msg = $strBusca != "" ? "Nenhum resultado encontrado. <a href='pew-orcamentos.php' class='link-padrao'><b>Voltar<b></a>" : "Nenhum pedido foi enviado ainda.";
                    echo "<br><br><br><br><br><h3 align='center'>$msg</h3></td>";
                }
            ?>
            </table>
        </section>
    </body>
</html>
