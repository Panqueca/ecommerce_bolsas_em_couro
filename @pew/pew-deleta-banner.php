<?php
    function voltar(){
        header("location: pew-banners.php?msg=O Banner foi excluido&msgType=success");
    }
    function error($obs){
        header("location: pew-banners.php?msg=Ocorreu um erro ao excluir o banner&msgType=error&obs=$obs");
    }

    if(isset($_GET["id_banner"]) && isset($_GET["acao"])){
        require_once "pew-system-config.php";
        $tabela_banners = $pew_db->tabela_banners;
        $idBanner = $_GET["id_banner"];
        $acao = $_GET["acao"];
        if($acao == "deletar"){
            $contarBanner = mysqli_query($conexao, "select count(id) as total_banner from $tabela_banners where id = '$idBanner'");
            $contagem = mysqli_fetch_assoc($contarBanner);
            if($contagem["total_banner"] > 0){
                $queryImagem = mysqli_query($conexao, "select imagem from $tabela_banners where id = '$id'");
                $array = mysqli_fetch_array($queryImagem);
                $imagem = $array["imagem"];
                $dirImagem = "../imagens/banners/";
                unlink($dirImagem.$imagem);
                mysqli_query($conexao, "delete from $tabela_banners where id = '$idBanner'");
                voltar();
            }else{
                error("BANNER INVÁLIDO");
            }
        }else{
            error("FUNCAO INVÁLIDA");
        }
        mysqli_close($conexao);
    }else{
        error("DADOS INVÁLIDOS");
    }
?>
