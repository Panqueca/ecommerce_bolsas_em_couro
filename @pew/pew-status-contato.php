<?php
if(isset($_POST["id_contato"]) && isset($_POST["acao"]) && isset($_POST["status"])){
    require_once "pew-system-config.php";
    $tabela_contato = $pew_db->tabela_contatos;
    $idContato = $_POST["id_contato"];
    $acao = $_POST["acao"];
    $contarContato = mysqli_query($conexao, "select count(id) as total_contato from $tabela_contato where id = '$idContato'");
    $contagem = mysqli_fetch_assoc($contarContato);
    if($contagem["total_contato"] > 0){
        if($acao == "excluir"){
            mysqli_query($conexao, "delete from $tabela_contato where id = '$idContato'");
        }else{
            $status = $_POST["status"];
            mysqli_query($conexao, "update $tabela_contato set status = $status where id = '$idContato'");
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
