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
    $navigation_title = "Orçamentos - $efectus_empresa_administrativo";
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
        <!--LINKS e JS PADRAO-->
        <link type="image/png" rel="icon" href="imagens/sistema/identidadeVisual/icone-efectus-web.png">
        <link type="text/css" rel="stylesheet" href="css/estilo.css">
        <script type="text/javascript" src="../js/jquery.min.js"></script>
        <script type="text/javascript" src="js/standard.js"></script>
        <!--FIM LINKS e JS PADRAO-->
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
            <a href="pew-cadastra-orcamento.php" class="btn-padrao" title="Cadastre um novo produto">Cadastrar novo</a>
            <br><br><br>
            <form class="form-busca" method="get" action="pew-orcamentos.php">
                <label class="field-busca">
                    <h3 class="titulo-busca">Buscar pedidos</h3>
                    <input type="search" name="busca" placeholder="Busque por nome, email, telefone, RG ou CPF" class="barra-busca" autocomplete="off">
                    <input type="submit" value="Buscar" class="btn-buscar">
                </label>
            </form>
            <table class="table-padrao" cellspacing="0">
            <?php
                $tabela_orcamentos = $pew_custom_db->tabela_orcamentos;
                if(isset($_GET["busca"]) && $_GET["busca"] != ""){
                    $busca = pew_string_format($_GET["busca"]);
                    $strBusca = "where nome_cliente like '%".$busca."%' or telefone_cliente like '%".$busca."%' or email_cliente like '%".$busca."%' or rg_cliente like '%".$busca."%' or cpf_cliente like '%".$busca."%'";
                    echo "<h3>Exibindo resultados para: $busca</h3>";
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
                        echo "<td><a href='pew-edita-orcamento.php?id_orcamento=$id' class='btn-editar'><i class='fa fa-eye' aria-hidden='true'></i></a></td></tr>";
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
<?php
    mysqli_close($conexao);
}else{
    header("location: index.php?msg=Área Restrita. É necessário fazer login para continuar.");
}
?>
