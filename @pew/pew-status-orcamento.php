<?php
if(isset($_POST["id_orcamento"]) && isset($_POST["acao"]) && isset($_POST["status"])){
    require_once "pew-system-config.php";
    $tabela_orcamentos = $pew_custom_db->tabela_orcamentos;
    $idOrcamento = $_POST["id_orcamento"];
    $acao = $_POST["acao"];
    $contarOrcamento = mysqli_query($conexao, "select count(id) as total_orcamento from $tabela_orcamentos where id = '$idOrcamento'");
    $contagem = mysqli_fetch_assoc($contarOrcamento);
    if($contagem["total_orcamento"] > 0){
        if($acao == "excluir"){
            mysqli_query($conexao, "delete from $tabela_orcamentos where id = '$idOrcamento'");
        }else{
            $status = $_POST["status"];
            mysqli_query($conexao, "update $tabela_orcamentos set status = $status where id = '$idOrcamento'");
        }
        echo "true";
    }else{
        echo "false";
    }
    mysqli_close($conexao);
}else{
    echo "false";
}
?>
