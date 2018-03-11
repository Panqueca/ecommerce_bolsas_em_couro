<?php
    if(isset($_POST["id_categoria"]) && isset($_POST["acao"])){
        require_once "pew-system-config.php";
        $tabela_categorias = $pew_db->tabela_categorias;
        $tabela_subcategorias = $pew_db->tabela_subcategorias;
        $idCategoria = $_POST["id_categoria"];
        $acao = $_POST["acao"];
        if($acao == "deletar"){
            $contarCategoria = mysqli_query($conexao, "select count(id) as total_categoria from $tabela_categorias where id = '$idCategoria'");
            $contagem = mysqli_fetch_assoc($contarCategoria);
            if($contagem["total_categoria"] > 0){
                mysqli_query($conexao, "delete from $tabela_categorias where id = '$idCategoria'");
                $contarSubcategoria = mysqli_query($conexao, "select count(id) as total_subcategorias from $tabela_subcategorias where id_categoria = '$idCategoria'");
                $contagem = mysqli_fetch_assoc($contarSubcategoria);
                if($contagem["total_subcategorias"] > 0){
                    mysqli_query($conexao, "delete from $tabela_subcategorias where id_categoria = '$idCategoria'");
                }
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
