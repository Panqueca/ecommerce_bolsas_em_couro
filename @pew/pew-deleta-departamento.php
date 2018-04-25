<?php
    if(isset($_POST["id_departamento"]) && isset($_POST["acao"])){
        require_once "pew-system-config.php";
        require_once "@classe-system-functions.php";
        
        $tabela_departamentos = $pew_custom_db->tabela_departamentos;
        $tabela_links_menu = $pew_custom_db->tabela_links_menu;
        $idDepartamento = $_POST["id_departamento"];
        $acao = $_POST["acao"];
        
        $dirImagens = "../imagens/departamentos/";
        
        if($acao == "deletar"){
            $total = $pew_functions->contar_resultados($tabela_departamentos, "id = '$idDepartamento'");
            if($total > 0){
                $query = mysqli_query($conexao, "select imagem from $tabela_departamentos where id = '$idDepartamento'");
                $infoImagemAtual = mysqli_fetch_array($query);
                $imagemAtual = $infoImagemAtual["imagem"];
                
                if(file_exists($dirImagens.$imagemAtual) && $imagemAtual != ""){
                    unlink($dirImagens.$imagemAtual);
                }
                
                mysqli_query($conexao, "delete from $tabela_departamentos where id = '$idDepartamento'");
                
                mysqli_query($conexao, "delete from $tabela_links_menu where id_departamento = '$idDepartamento'");
                
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