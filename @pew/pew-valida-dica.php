<?php
    if(isset($_POST["id_dica"])){
        $idDica = $_POST["id_dica"];
        require_once "pew-system-config.php";
        $tabela_dicas = $pew_custom_db->tabela_dicas;
        $contar = mysqli_query($conexao, "select count(id) as total from $tabela_dicas where id_categoria = '$idDica'");
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
