<?php
    $post_fileds = array("id_subcategoria", "titulo", "descricao", "status");
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
        $tabela_subcategorias = $pew_db->tabela_subcategorias;
        $idSubcategoria = $_POST["id_subcategoria"];
        $titulo = addslashes($_POST["titulo"]);
        $descricao = addslashes($_POST["descricao"]);
        $status = $_POST["status"];
        $data = date("Y-m-d h:i:s");
        
        function url_format($string){
            $string = str_replace("Ç", "c", $string);
            $string = str_replace("ç", "c", $string);
            $string = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"), $string);
            $string = strtolower($string);
            $string = str_replace("/", "-", $string);
            $string = str_replace("|", "-", $string);
            $string = str_replace(" ", "-", $string);
            $string = str_replace(",", "", $string);
            return $string;
        }
        
        function valida_ref($str){
            global $tabela_subcategorias, $pew_functions, $idSubcategoria, $conexao;
            $total = $pew_functions->contar_resultados($tabela_subcategorias, "ref = '$str'");
            $return = $total == 0 ? true : false;
            if($total == 1){
                $queryID = mysqli_query($conexao, "select id from $tabela_subcategorias where ref = '$str'");
                $infoID = mysqli_fetch_array($queryID);
                $getID = $infoID["id"];
                $return = $getID == $idSubcategoria ? true : false;
            }
            return $return;
        }
        
        $ref = url_format($titulo);
        $finalRef = $ref;
        
        $i = 1;
        while(valida_ref($finalRef) == false){
            $finalRef = "$ref-$i";
            $i++;
        }
        
        mysqli_query($conexao, "update $tabela_subcategorias set subcategoria = '$titulo', descricao = '$descricao', ref = '$finalRef', data_controle = '$data', status = '$status' where id = '$idSubcategoria'");
        echo "true";
    }else{
        echo "false";
    }
?>