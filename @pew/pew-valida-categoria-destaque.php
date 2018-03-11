<?php
    if(isset($_POST["id_categoria"])){
        $idCategoria = $_POST["id_categoria"];
        require_once "pew-system-config.php";
        $tabela_categoria_destaque = $pew_custom_db->tabela_categoria_destaque;
        $contar = mysqli_query($conexao, "select count(id) as total from $tabela_categoria_destaque where id_categoria = '$idCategoria'");
        $contagem = mysqli_fetch_assoc($contar);
        if($contagem["total"] > 0){
            echo "false";
        }else{
            echo "true";
        }
    }else{
        echo "false";
    }
?>
