<?php
    if(isset($_POST["email"])){
        require_once "@pew/pew-system-config.php";
        $tabela_newsletter = $pew_custom_db->tabela_newsletter;
        $nome = isset($_POST["nome"]) ? $_POST["nome"] : "";
        $email = $_POST["email"];
        $data = date("Y-m-d H:i:s");
        if($email != ""){
            $contar = mysqli_query($conexao, "select count(id) as total_cadastro from $tabela_newsletter where email = '$email'");
            $contagem = mysqli_fetch_assoc($contar);
            $totalCadastro = $contagem["total_cadastro"];
            if($totalCadastro > 0){
                echo "already";
            }else{
                $save = mysqli_query($conexao, "insert into $tabela_newsletter (nome, email, data) values ('$nome', '$email', '$data')");
                echo "true";
            }
        }
    }else{
        echo "false";
    }
?>
