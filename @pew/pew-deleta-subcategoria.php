<?php
    if(isset($_POST["id_subcategoria"]) && isset($_POST["acao"])){
        require_once "pew-system-config.php";
        $tabela_subcategorias = $pew_db->tabela_subcategorias;
        $idSubcategoria = $_POST["id_subcategoria"];
        $acao = $_POST["acao"];
        if($acao == "deletar"){
            $contarSubcategoria = mysqli_query($conexao, "select count(id) as total_subcategorias from $tabela_subcategorias where id = '$idSubcategoria'");
            $contagem = mysqli_fetch_assoc($contarSubcategoria);
            if($contagem["total_subcategorias"] > 0){
                mysqli_query($conexao, "delete from $tabela_subcategorias where id = '$idSubcategoria'");
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
