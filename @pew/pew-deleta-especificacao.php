<?php
    if(isset($_POST["id_especificacao"]) && isset($_POST["acao"])){
        require_once "pew-system-config.php";
        require_once "@classe-system-functions.php";
        
        $tabela_especificacoes = $pew_custom_db->tabela_especificacoes;
        
        $idEspecificacao = $_POST["id_especificacao"];
        $acao = $_POST["acao"];
        
        if($acao == "deletar"){
            $total = $pew_functions->contar_resultados($tabela_especificacoes, "id = '$idEspecificacao'");
            if($total > 0){
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
