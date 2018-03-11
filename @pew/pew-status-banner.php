<?php
if(isset($_POST["id_banner"]) && isset($_POST["acao"])){
    require_once "pew-system-config.php";
    $tabela_banners = $pew_db->tabela_banners;
    $idBanner = $_POST["id_banner"];
    $acao = $_POST["acao"];
    $contarBanner = mysqli_query($conexao, "select count(id) as total_banner from $tabela_banners where id = '$idBanner'");
    $contagem = mysqli_fetch_assoc($contarBanner);
    if($contagem["total_banner"] > 0){
        $status = $acao == "ativar" ? 1 : 0;
        mysqli_query($conexao, "update $tabela_banners set status = $status where id = '$idBanner'");
        echo "true";
    }else{
        echo "false";
    }
    mysqli_close($conexao);
}else{
    echo "false";
}
?>
