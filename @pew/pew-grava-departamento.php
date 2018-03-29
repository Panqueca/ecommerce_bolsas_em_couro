<?php
    $post_fileds = array("titulo", "descricao", "posicao");
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
        
        require_once "pew-system-config.php";
        require_once "@classe-system-functions.php";
        
        $tabela_departamentos = $pew_custom_db->tabela_departamentos;
        
        $titulo = addslashes(trim($_POST["titulo"]));
        $descricao = addslashes(trim($_POST["descricao"]));
        $posicao = (int)$_POST["posicao"];
        $data = date("Y-m-d h:i:s");

        $ref = $pew_functions->url_format($titulo);

        mysqli_query($conexao, "insert into $tabela_departamentos (departamento, descricao, ref, posicao, data_controle, status) values ('$titulo', '$descricao', '$ref', '$posicao', '$data', 1)");
        
        echo "true";
    }else{
        echo "false";
    }
?>
