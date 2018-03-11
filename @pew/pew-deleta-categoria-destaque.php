<?php
    if(isset($_POST["id_categoria_destaque"]) && isset($_POST["acao"])){
        require_once "pew-system-config.php";
        $tabela_categoria_destaque = $pew_custom_db->tabela_categoria_destaque;
        $idCategoriaDestaque = $_POST["id_categoria_destaque"];
        $acao = $_POST["acao"];
        if($acao == "deletar"){
            $contar = mysqli_query($conexao, "select count(id) as total from $tabela_categoria_destaque where id = '$idCategoriaDestaque'");
            $contagem = mysqli_fetch_assoc($contar);
            if($contagem["total"] > 0){
                $queryImagem = mysqli_query($conexao, "select imagem from $tabela_categoria_destaque where id = '$idCategoriaDestaque'");
                $imagem = mysqli_fetch_array($queryImagem);
                $nomeImagem = $imagem["imagem"];
                $dir = "../imagens/categorias/";
                unlink($dir.$nomeImagem);
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
