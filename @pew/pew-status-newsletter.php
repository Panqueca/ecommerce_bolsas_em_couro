<?php
if(isset($_POST["id_newsletter"]) && isset($_POST["acao"])){
    require_once "pew-system-config.php";
    $tabela_newsletter = $pew_custom_db->tabela_newsletter;
    $idNewsletter = $_POST["id_newsletter"];
    $acao = $_POST["acao"];
    $status = isset($_POST["status"]) ? $_POST["status"] : "";
    $contarNewsletter = mysqli_query($conexao, "select count(id) as total_newsletter from $tabela_newsletter where id = '$idNewsletter'");
    $contagem = mysqli_fetch_assoc($contarNewsletter);
    if($contagem["total_newsletter"] > 0){
        if($acao == "excluir"){
            mysqli_query($conexao, "delete from $tabela_newsletter where id = '$idNewsletter'");
        }else if($status != ""){
            $status = $_POST["status"];
            mysqli_query($conexao, "update $tabela_newsletter set status = $status where id = '$idNewsletter'");
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
