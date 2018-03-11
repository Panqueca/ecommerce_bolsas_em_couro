<?php
    if(isset($_POST["id_categoria_vitrine"]) && isset($_POST["acao"])){
        require_once "pew-system-config.php";
        $tabela_categorias_vitrine = $pew_custom_db->tabela_categorias_vitrine;
        $idCategoriaVitrine = $_POST["id_categoria_vitrine"];
        $acao = $_POST["acao"];
        if($acao == "deletar"){
            $contar = mysqli_query($conexao, "select count(id) as total from $tabela_categorias_vitrine where id = '$idCategoriaVitrine'");
            $contagem = mysqli_fetch_assoc($contar);
            if($contagem["total"] > 0){
                $queryImagem = mysqli_query($conexao, "select imagem from $tabela_categorias_vitrine where id = '$idCategoriaVitrine'");
                $imagem = mysqli_fetch_array($queryImagem);
                $nomeImagem = $imagem["imagem"];
                $dir = "../imagens/categorias/";
                unlink($dir.$nomeImagem);
                mysqli_query($conexao, "delete from $tabela_categorias_vitrine where id = '$idCategoriaVitrine'");
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
