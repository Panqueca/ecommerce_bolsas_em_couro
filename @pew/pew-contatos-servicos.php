<?php
    session_start();
    
    $thisPageURL = substr($_SERVER["REQUEST_URI"], strpos($_SERVER["REQUEST_URI"], '@pew'));
    $_POST["next_page"] = str_replace("@pew/", "", $thisPageURL);
    $_POST["invalid_levels"] = array(1);
    
    require_once "@link-important-functions.php";
    require_once "@valida-sessao.php";

    $navigation_title = "Mensagens contato de serviço - " . $pew_session->empresa;
    $page_title = "Gerenciamento de mensagens contato de serviço";
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
            <form action="pew-contatos-servicos.php" method="get" class="label half clear">
                <label class="group">
                    <div class="group">
                        <h3 class="label-title">Busca de contatos</h3>
                    </div>
                    <div class="group">
                        <div class="xlarge" style="margin-left: -5px; margin-right: 0px;">
                            <input type="search" name="busca" placeholder="Busque por nome, email, assunto, telefone, mensagens ou tipo" class="label-input" title="Buscar">
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
                $tabela_contatos_servicos = $pew_custom_db->tabela_contatos_servicos;
                if(isset($_GET["busca"]) && $_GET["busca"] != ""){
                    $busca = addslashes($_GET["busca"]);
                    $strBusca = "where nome like '%".$busca."%' or telefone like '%".$busca."%' or email like '%".$busca."%' or mensagem like '%".$busca."%' or tipo like '%".$busca."%'";
                    echo "<h3>Exibindo resultados para: $busca</h3>";
                }else{
                    $strBusca = "";
                }
                $contarContatos = mysqli_query($conexao, "select count(id) as total_contatos from $tabela_contatos_servicos $strBusca");
                $contagemContatos = mysqli_fetch_assoc($contarContatos);
                $totalContatos = $contagemContatos["total_contatos"];
                if($totalContatos > 0){
                    echo "<thead>";
                        echo "<td>Nome</td>";
                        echo "<td>E-mail</td>";
                        echo "<td>Telefone</td>";
                        echo "<td>Tipo</td>";
                        echo "<td>Status</td>";
                        echo "<td>Informações</td>";
                    echo "</thead>";
                    echo "<tbody>";
                    $queryContatos = mysqli_query($conexao, "select * from $tabela_contatos_servicos $strBusca order by data desc");
                    while($contatos = mysqli_fetch_array($queryContatos)){
                        $id = $contatos["id"];
                        $nome = $contatos["nome"];
                        $email = $contatos["email"];
                        $telefone = $contatos["telefone"];
						$tipo = $contatos["tipo"];
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
                        echo "<tr><td>$nome</td>";
                        echo "<td>$email</td>";
                        echo "<td>$telefone</td>";
                        echo "<td>$tipo</td>";
                        echo "<td>$status</td>";
                        echo "<td align=center><a href='pew-edita-contato-servico.php?id_contato=$id' class='btn-editar'><i class='fa fa-eye' aria-hidden='true'></i></a></td></tr>";
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