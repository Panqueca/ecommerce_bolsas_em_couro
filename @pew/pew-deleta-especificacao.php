<?php
    if(isset($_POST["id_especificacao"]) && isset($_POST["acao"])){
        require_once "pew-system-config.php";
        $tabela_especificacoes = $pew_custom_db->tabela_especificacoes;
        $idEspecificacao = $_POST["id_especificacao"];
        $acao = $_POST["acao"];
        if($acao == "deletar"){
            $contar = mysqli_query($conexao, "select count(id) as total from $tabela_especificacoes where id = '$idEspecificacao'");
            $contagem = mysqli_fetch_assoc($contar);
            if($contagem["total"] > 0){
                mysqli_query($conexao, "delete from $tabela_especificacoes where id = '$idEspecificacao'");
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
