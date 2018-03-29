<?php
    if(isset($_POST["id_categoria_vitrine"]) && isset($_POST["acao"])){
        require_once "pew-system-config.php";
        require_once "@classe-system-functions.php";
        
        $tabela_categorias_vitrine = $pew_custom_db->tabela_categorias_vitrine;
        
        $idCategoriaVitrine = $_POST["id_categoria_vitrine"];
        $acao = $_POST["acao"];
        $dirImagens = "../imagens/categorias/";
        
        if($acao == "deletar"){
            $total = $pew_functions->contar_resultados($tabela_categorias_vitrine, "id = '$idCategoriaVitrine'");
            if($total > 0){
                $queryImagem = mysqli_query($conexao, "select imagem from $tabela_categorias_vitrine where id = '$idCategoriaVitrine'");
                $imagem = mysqli_fetch_array($queryImagem);
                $nomeImagem = $imagem["imagem"];
                if(file_exists($dirImagens.$nomeImagem) && $nomeImagem != ""){
                    unlink($dirImagens.$nomeImagem);
                }
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
