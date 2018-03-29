<?php
    if(isset($_POST["id_categoria_destaque"]) && isset($_POST["acao"])){
        
        require_once "pew-system-config.php";
        require_once "@classe-system-functions.php";
        
        $tabela_categoria_destaque = $pew_custom_db->tabela_categoria_destaque;
        
        $idCategoriaDestaque = $_POST["id_categoria_destaque"];
        $acao = $_POST["acao"];
        $dirImagens = "../imagens/categorias/";
        
        if($acao == "deletar"){
            $total = $pew_functions->contar_resultados($tabela_categoria_destaque, "id = '$idCategoriaDestaque'");
            if($total > 0){
                $queryImagem = mysqli_query($conexao, "select imagem from $tabela_categoria_destaque where id = '$idCategoriaDestaque'");
                $imagem = mysqli_fetch_array($queryImagem);
                $nomeImagem = $imagem["imagem"];
                if(file_exists($dirImagens.$nomeImagem) && $nomeImagem != ""){
                    unlink($dirImagens.$nomeImagem);
                }
                mysqli_query($conexao, "delete from $tabela_categoria_destaque where id = '$idCategoriaDestaque'");
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
