<?php
    if(isset($_POST["acao"]) && isset($_POST["id_usuario"])){
        $acao = $_POST["acao"];
        $idUsuario = (int)$_POST["id_usuario"];
        require_once "pew-system-config.php";
        $tabela_usuarios = $pew_db->tabela_usuarios_administrativos;
        if($acao == "excluir" && $idUsuario > 0){
            mysqli_query($conexao, "delete from $tabela_usuarios where id = '$idUsuario'");
            echo "true";
        }else{
            echo "false";
        }
        mysqli_close($conexao);
    }else{
        echo "false";
    }
?>
