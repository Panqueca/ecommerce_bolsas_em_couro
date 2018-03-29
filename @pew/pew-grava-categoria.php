<?php
    $post_fileds = array("titulo", "descricao");
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
        
        $tabela_categorias = $pew_db->tabela_categorias;
        
        $titulo = addslashes(trim($_POST["titulo"]));
        $descricao = addslashes(trim($_POST["descricao"]));
        $data = date("Y-m-d h:i:s");
        
        function valida_ref($str){
            global $tabela_categorias, $pew_functions;
            $total = $pew_functions->contar_resultados($tabela_categorias, "ref = '$str'");
            $return = $total == 0 ? true : false;
            return $return;
        }
        
        $ref = $pew_functions->url_format($titulo);
        $finalRef = $ref;
        
        $i = 1;
        while(valida_ref($finalRef) == false){
            $finalRef = "$ref-$i";
            $i++;
        }
        
        mysqli_query($conexao, "insert into $tabela_categorias (categoria, descricao, ref, data_controle, status) values ('$titulo', '$descricao', '$finalRef', '$data', 1)");
        
        echo "true";
    }else{
        echo "false";
    }
?>