<?php
    $post_fileds = array("titulo");
    $invalid_fileds = array();
    $gravar = true;
    $i = 0;
    foreach($post_fileds as $post_name){
        /*Validação se todos campos foram enviados*/
        if(!isset($_POST[$post_name])){
            $gravar = false;
            $i++;
            $invalid_fileds[$i] = $post_name;
        }
    }

    if($gravar){
        echo "<h3 align=center>Gravando especificação...</h3>";
        
        require_once "pew-system-config.php";
        require_once "@classe-system-functions.php";
        
        $tabela_especificacoes = $pew_custom_db->tabela_especificacoes;
        
        $titulo = addslashes(trim($_POST["titulo"]));
        $dataAtual = date("Y-m-d h:i:s");

        mysqli_query($conexao, "insert into $tabela_especificacoes (titulo, data_controle, status) values ('$titulo', '$dataAtual', 1)");
        echo "<script>window.location.href='pew-especificacoes.php?focus=$titulo&msg=A especificação foi cadastrada com sucesso!&msgType=success'</script>";
    }else{
        echo "<script>window.location.href='pew-especificacoes.php?msg=Ocorreu um erro ao cadastrar a especificação'</script>";
    }
?>
