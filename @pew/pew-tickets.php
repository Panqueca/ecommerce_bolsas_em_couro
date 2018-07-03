<?php
    session_start();
    
    $thisPageURL = substr($_SERVER["REQUEST_URI"], strpos($_SERVER["REQUEST_URI"], '@pew'));
    $_POST["next_page"] = str_replace("@pew/", "", $thisPageURL);
    $_POST["invalid_levels"] = array(1);
    
    require_once "@link-important-functions.php";
    require_once "@valida-sessao.php";

    $navigation_title = "Tickets de atendimento - " . $pew_session->empresa;
    $page_title = "Gerenciamento de tickets de atendimento";
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
            <form action="pew-tickets.php" method="get" class="label half clear">
                <label class="group">
                    <div class="group">
                        <h3 class="label-title">Busca</h3>
                    </div>
                    <div class="group">
                        <div class="xlarge" style="margin-left: -5px; margin-right: 0px;">
                            <input type="search" name="busca" placeholder="Busque por referência" class="label-input" title="Buscar">
                        </div>
                        <div class="xsmall" style="margin-left: 0px;">
                            <button type="submit" class="btn-submit label-input btn-flat" style="margin: 10px;">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </label>
            </form>
            <table class="table-padrao" cellspacing="0">
            <?php
                $tabela_tickets = "tickets_register";
                if(isset($_GET["busca"]) && $_GET["busca"] != ""){
                    $busca = addslashes($_GET["busca"]);
                    $strBusca = "where ref like '%".$busca."%'";
                    echo "<h3>Exibindo resultados para: $busca</h3>";
                }else{
                    $strBusca = "";
                }
                $contar = mysqli_query($conexao, "select count(id) as total from $tabela_tickets $strBusca");
                $contagem = mysqli_fetch_assoc($contar);
                $total = $contagem["total"];
                if($total > 0){
                    echo "<thead>";
                        echo "<td>Referência</td>";
                        echo "<td>Assunto</td>";
                        echo "<td>Departamento</td>";
                        echo "<td>Enviado</td>";
                        echo "<td>Prioridade</td>";
                        echo "<td>Status</td>";
                        echo "<td>Ver</td>";
                    echo "</thead>";
                    echo "<tbody>";
                    $query = mysqli_query($conexao, "select * from $tabela_tickets $strBusca order by id desc");
                    while($infoTicket = mysqli_fetch_array($query)){
                        $ticketID = $infoTicket["id"];
                        $ticketREF = $infoTicket["ref"];
                        $clienteID = $infoTicket["id_cliente"];
                        $assunto = $infoTicket["topic"];
                        $departamento = $infoTicket["department"];
                        
                        $dataCompleta = $infoTicket["data_controle"];
                        $dataAno = substr($dataCompleta, 0, 10);
                        $dataAno = $pew_functions->inverter_data($dataAno);
                        $dataHorario = substr($dataCompleta, 11);
                        
                        switch($infoTicket["priority"]){
                            case 1:
                                $prioridade = "Média";
                                break;
                            case 2:
                                $prioridade = "Urgente";
                                break;
                            default:
                                $prioridade = "Normal";
                        }

                        switch($infoTicket["status"]){
                            case 0:
                                $status = "Fechado";
                                break;
                            case 2:
                                $status = "Aguardando resposta do cliente";
                                break;
                            default:
                                $status = "Aguardando resposta do atendente";
                                break;
                        }
                        echo "<tr><td>$ticketREF</td>";
                        echo "<td>$assunto</td>";
                        echo "<td>$departamento</td>";
                        echo "<td>$dataAno</td>";
                        echo "<td>$prioridade</td>";
                        echo "<td>$status</td>";
                        echo "<td align=center><a href='pew-edita-ticket.php?id_ticket=$ticketID' class='btn-editar'><i class='fa fa-eye' aria-hidden='true'></i></a></td></tr>";
                    }
                    echo "</tbody></table>";
                }else{
                    $msg = $strBusca != "" ? "Nenhum resultado encontrado. <a href='pew-contatos.php' class='link-padrao'><b>Voltar<b></a>" : "Nenhuma mensagem foi enviada ainda.";
                    echo "<br><br><br><br><br><h3 align='center'>$msg</h3></td>";
                }
            ?>
            </table>
        </section>
    </body>
</html>