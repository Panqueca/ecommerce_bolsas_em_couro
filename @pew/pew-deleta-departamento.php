<?php
    if(isset($_POST["id_departamento"]) && isset($_POST["acao"])){
        require_once "pew-system-config.php";
        require_once "@classe-system-functions.php";
        
        $tabela_departamentos = $pew_custom_db->tabela_departamentos;
        $idDepartamento = $_POST["id_departamento"];
        $acao = $_POST["acao"];
        
        if($acao == "deletar"){
            $total = $pew_functions->contar_resultados($tabela_departamentos, "id = '$idDepartamento'");
            if($total > 0){
                mysqli_query($conexao, "delete from $tabela_departamentos where id = '$idDepartamento'");
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