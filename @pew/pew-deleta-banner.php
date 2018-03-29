<?php
    function voltar(){
        echo "<script>window.location.href= 'pew-banners.php?msg=O Banner foi excluido&msgType=success';</script>";
    }
    function error($obs){
        echo "<script>window.location.href= 'pew-banners.php?msg=Ocorreu um erro ao excluir o banner&msgType=error&obs=$obs';</script>";
    }

    if(isset($_GET["id_banner"]) && isset($_GET["acao"])){
        require_once "pew-system-config.php";
        require_once "@classe-system-functions.php";
        
        $tabela_banners = $pew_db->tabela_banners;
        
        $idBanner = $_GET["id_banner"];
        $acao = $_GET["acao"];
        $dirImagens = "../imagens/banners/";
        
        if($acao == "deletar"){
            $total = $pew_functions->contar_resultados($tabela_banners, "id = '$idBanner'");
            if($total > 0){
                $queryImagem = mysqli_query($conexao, "select imagem from $tabela_banners where id = '$idBanner'");
                $array = mysqli_fetch_array($queryImagem);
                $imagem = $array["imagem"];
                if(file_exists($dirImagens.$imagem) && $imagem != ""){
                    unlink($dirImagens.$imagem);
                }
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
