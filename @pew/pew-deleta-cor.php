<?php
    if(isset($_POST["id_cor"]) && isset($_POST["acao"])){
        require_once "pew-system-config.php";
        require_once "@classe-system-functions.php";
        
        $tabela_cores = $pew_custom_db->tabela_cores;
        
        $idCor = $_POST["id_cor"];
        $acao = $_POST["acao"];
        $dirImagens = "../imagens/cores/";
        
        if($acao == "deletar"){
            $total = $pew_functions->contar_resultados($tabela_cores, "id = '$idCor'");
            if($total > 0){
                $queryImagem = mysqli_query($conexao, "select imagem from $tabela_cores where id = '$idCor'");
                $infoImagem = mysqli_fetch_array($queryImagem);
                $imagemAtual = $infoImagem["imagem"];
                
                if(file_exists($dirImagens.$imagemAtual) && $imagemAtual != ""){
                    unlink($dirImagens.$imagemAtual);
                }
                
                mysqli_query($conexao, "delete from $tabela_cores where id = '$idCor'");
                echo "true";
            }else{
                echo "false";
            }
        }else{
            echo "false";
        }
    }else{
        echo "false";
    }
?>