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
        require_once "@classe-system-functions.php";
        
        $tabela_categoria_destaque = $pew_custom_db->tabela_categoria_destaque;
        
        $imagem = $_FILES["imagem"]["name"];
        $status = (int)$_POST["status"] == 1 ? 1 : 0;
        $infoCategoria = $_POST["info_categoria"];
        $splitInfo = explode("||", $infoCategoria);
        $idCategoria = (int)$splitInfo[0];
        $tituloCategoria = addslashes(trim($splitInfo[1]));
        $data = date("Y-m-d h:i:s");
        $dirImagens = "../imagens/categorias/destaques/";
        
        $nomeImagem = $pew_functions->url_format($tituloCategoria);
        
        if($imagem != ""){
            $refImg = substr(md5(uniqid()), 0, 4);
            $ext = pathinfo($imagem, PATHINFO_EXTENSION);
            $nomeImagem = $nomeImagem."-categoria-destaque-ref$refImg.".$ext;
            move_uploaded_file($_FILES["imagem"]["tmp_name"], $dirImagens.$nomeImagem);
        }

        $refCategoria = $pew_functions->url_format($tituloCategoria);

        mysqli_query($conexao, "insert into $tabela_categoria_destaque (id_categoria, titulo, ref, imagem, data_controle, status) values ('$idCategoria', '$tituloCategoria', '$refCategoria', '$nomeImagem', '$data', '$status')");
        
        echo "true";
    }else{
        echo "false";
    }
?>
