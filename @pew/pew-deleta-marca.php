<?php
    if(isset($_POST["id_marca"]) && isset($_POST["acao"])){
        require_once "pew-system-config.php";
        require_once "@classe-system-functions.php";
        
        $tabela_marcas = $pew_custom_db->tabela_marcas;
        $idMarca = $_POST["id_marca"];
        $acao = $_POST["acao"];
        $dirImagens = "../imagens/marcas/";
        
        if($acao == "deletar"){
            $total = $pew_functions->contar_resultados($tabela_marcas, "id = '$idMarca'");
            if($total > 0){
                $queryImagem = mysqli_query($conexao, "select imagem from $tabela_marcas where id = '$idMarca'");
                $infoImagem = mysqli_fetch_array($queryImagem);
                $imagemAtual = $infoImagem["imagem"];
                
                if(file_exists($dirImagens.$imagemAtual) && $imagemAtual != ""){
                    unlink($dirImagens.$imagemAtual);
                }
                
                mysqli_query($conexao, "delete from $tabela_marcas where id = '$idMarca'");
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
