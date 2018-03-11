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
        $tabela_categorias = $pew_db->tabela_categorias;
        $idCategoria = $_POST["id_categoria"];
        $titulo = addslashes($_POST["titulo"]);
        $descricao = addslashes($_POST["descricao"]);
        $status = $_POST["status"];
        $data = date("Y-m-d h:i:s");

        function url_format($string){
            $string = str_replace("Ç", "C", $string);
            $string = str_replace("ç", "c", $string);
            $string = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"), $string);
            $string = strtolower($string);
            $string = str_replace(" ", "-", $string);
            return $string;
        }
        $ref = url_format($titulo);

        mysqli_query($conexao, "update $tabela_categorias set categoria = '$titulo', descricao = '$descricao', ref = '$ref', data_controle = '$data', status = '$status' where id = '$idCategoria'");
        echo "true";
    }else{
        echo "false";
    }
?>
