<?php
    $post_fileds = array("id_especificacao", "titulo", "status");
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
        echo "<h3 align=center>Atualizando especificação...</h3>";
        
        require_once "pew-system-config.php";
        require_once "@classe-system-functions.php";
        
        $tabela_especificacoes = $pew_custom_db->tabela_especificacoes;
        
        $idEspecificacao = (int)$_POST["id_especificacao"];
        $titulo = addslashes(trim($_POST["titulo"]));
        $status = (int)$_POST["status"];
        $data = date("Y-m-d h:i:s");

        mysqli_query($conexao, "update $tabela_especificacoes set titulo = '$titulo', data_controle = '$data', status = '$status' where id = '$idEspecificacao'");
        echo "<script>window.location.href='pew-especificacoes.php?focus=$titulo&msg=A especificação foi atualizada com sucesso!&msgType=success'</script>";
    }else{
        echo "<script>window.location.href='pew-especificacoes.php?msg=Ocorreu um erro ao atualizar a especificação'</script>";
    }
?>
