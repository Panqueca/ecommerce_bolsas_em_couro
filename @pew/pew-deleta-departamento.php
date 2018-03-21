<?php
    if(isset($_POST["id_departamento"]) && isset($_POST["acao"])){
        require_once "pew-system-config.php";
        $tabela_departamentos = $pew_custom_db->tabela_departamentos;
        $idDepartamento = $_POST["id_departamento"];
        $acao = $_POST["acao"];
        if($acao == "deletar"){
            $contarDepart = mysqli_query($conexao, "select count(id) as total_departamento from $tabela_departamentos where id = '$idDepartamento'");
            $contagem = mysqli_fetch_assoc($contarDepart);
            if($contagem["total_departamento"] > 0){
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