<?php
    $post_fileds = array("id_categoria", "titulo", "descricao", "status");
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
        
        $idCategoria = $_POST["id_categoria"];
        $titulo = addslashes($_POST["titulo"]);
        $descricao = addslashes($_POST["descricao"]);
        $status = (int)$_POST["status"] == 1 ? 1 : 0;
        $data = date("Y-m-d h:i:s");
        
        function valida_ref($str){
            global $tabela_categorias, $pew_functions, $idCategoria, $conexao;
            $total = $pew_functions->contar_resultados($tabela_categorias, "ref = '$str'");
            $return = $total == 0 ? true : false;
            if($total == 1){
                $queryID = mysqli_query($conexao, "select id from $tabela_categorias where ref = '$str'");
                $infoID = mysqli_fetch_array($queryID);
                $getID = $infoID["id"];
                $return = $getID == $idCategoria ? true : false;
            }
            return $return;
        }
        
        $ref = $pew_functions->url_format($titulo);
        $finalRef = $ref;
        
        $i = 1;
        while(valida_ref($finalRef) == false){
            $finalRef = "$ref-$i";
            $i++;
        }
        
        mysqli_query($conexao, "update $tabela_categorias set categoria = '$titulo', descricao = '$descricao', ref = '$finalRef', data_controle = '$data', status = '$status' where id = '$idCategoria'");
        
        echo "true";
    }else{
        echo "false";
    }
?>