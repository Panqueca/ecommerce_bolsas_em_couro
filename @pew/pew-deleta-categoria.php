<?php
    if(isset($_POST["id_categoria"]) && isset($_POST["acao"])){
        require_once "pew-system-config.php";
        require_once "@classe-system-functions.php";
        
        $tabela_categorias = $pew_db->tabela_categorias;
        $tabela_subcategorias = $pew_db->tabela_subcategorias;
        
        $idCategoria = $_POST["id_categoria"];
        $acao = $_POST["acao"];
        
        if($acao == "deletar"){
            $total = $pew_functions->contar_resultados($tabela_categorias, "id = '$idCategoria'");
            if($total > 0){
                mysqli_query($conexao, "delete from $tabela_categorias where id = '$idCategoria'");
                $totalSub = $pew_functions->contar_resultados($tabela_subcategorias, "id_categoria = '$idCategoria'");
                if($totalSub > 0){
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
