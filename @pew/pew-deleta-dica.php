<?php
    if(isset($_GET["id_dica"])){

        require_once "pew-system-config.php";
        require_once "@classe-system-functions.php";

        $tabela_dicas = $pew_custom_db->tabela_dicas;

        $idDica = $_GET["id_dica"];
        $dirImagens = "../imagens/dicas/";

        $total = $pew_functions->contar_resultados($tabela_dicas, "id = '$idDica'");
        if($total > 0){
            $queryImagem = mysqli_query($conexao, "select imagem, thumb from $tabela_dicas where id = '$idDica'");
            $imagem = mysqli_fetch_array($queryImagem);
            $nomeImagem = $imagem["imagem"];
            $nomeThumb = $imagem["thumb"];
            
            if(file_exists($dirImagens.$nomeImagem) && $nomeImagem != ""){
                unlink($dirImagens.$nomeImagem);
            }
            if(file_exists($dirImagens.$nomeThumb) && $nomeThumb != ""){
                unlink($dirImagens.$nomeThumb);
            }
            
            mysqli_query($conexao, "delete from $tabela_dicas where id = '$idDica'");
            
            header("location: pew-dicas.php");
            echo "true";
        }else{
            header("location: pew-dicas.php");
            echo "false";
        }
    }else{
        header("location: pew-dicas.php");
        echo "false";
    }
?>
