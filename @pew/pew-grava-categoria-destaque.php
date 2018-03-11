<?php
    $post_fields = array("info_categoria", "status");
    $file_fields = array("imagem");
    $invalid_fileds = array();
    $gravar = true;
    $i = 0;
    foreach($post_fields as $post_name){
        /*Validação se todos campos foram enviados*/
        if(!isset($_POST[$post_name])){
            $gravar = false;
            $i++;
            $invalid_fileds[$i] = $post_name;
        }
    }
    foreach($file_fields as $file_name){
        /*Validação se todos campos foram enviados*/
        if(!isset($_FILES[$file_name])){
            $gravar = false;
            $i++;
            $invalid_fileds[$i] = $file_name;
        }
    }
    if($gravar){
        require_once "pew-system-config.php";
        $tabela_categoria_destaque = $pew_custom_db->tabela_categoria_destaque;
        $imagem = $_FILES["imagem"]["name"];
        $status = $_POST["status"];
        $data = date("Y-m-d h:i:s");
        $infoCategoria = $_POST["info_categoria"];
        $splitInfo = explode("||", $infoCategoria);
        $idCategoria = (int)$splitInfo[0];
        $tituloCategoria = addslashes(trim($splitInfo[1]));

        function url_format($string){
            $string = str_replace("Ç", "C", $string);
            $string = str_replace("ç", "c", $string);
            $string = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"), $string);
            $string = strtolower($string);
            $string = str_replace(" ", "-", $string);
            return $string;
        }
        $nomeImagem = url_format($tituloCategoria);
        if($imagem != ""){
            $refImg = substr(md5(uniqid()), 0, 4);
            $ext = pathinfo($imagem, PATHINFO_EXTENSION);
            $nomeImagem = $nomeImagem."-categoria-destaque-ref$refImg.".$ext;
            $dirImagens = "../imagens/categorias/";
            move_uploaded_file($_FILES["imagem"]["tmp_name"], $dirImagens.$nomeImagem);
        }

        $refCategoria = url_format($tituloCategoria);

        mysqli_query($conexao, "insert into $tabela_categoria_destaque (id_categoria, titulo, ref, imagem, data_controle, status) values ('$idCategoria', '$tituloCategoria', '$refCategoria', '$nomeImagem', '$data', '$status')");
        echo "true";
    }else{
        echo "false";
    }
?>
