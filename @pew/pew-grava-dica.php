<?php

    $post_fields = array("titulo", "subtitulo", "status", "descricao_curta", "descricao_longa", "url_video");
    $file_fields = array("imagem", "thumbnail");
    $invalid_fields = array();
    $gravar = true;
    $i = 0;

    foreach($post_fields as $post_name){
        /*Validação se todos campos foram enviados*/
        if(!isset($_POST[$post_name])){
            $gravar = false;
            $i++;
            $invalid_fields[$i] = $post_name;
        }
    }
    foreach($file_fields as $file_name){
        /*Validação se todos campos foram enviados*/
        if(!isset($_FILES[$file_name])){
            $gravar = false;
            $i++;
            $invalid_fields[$i] = $file_name;
        }
    }

    if($gravar){
        require_once "pew-system-config.php";
        require_once "@classe-system-functions.php";
        
        $tabela_dica = $pew_custom_db->tabela_dicas;
        
        $titulo = addslashes($_POST["titulo"]);
        $subtitulo = addslashes($_POST["subtitulo"]);
        $descricaoCurta = addslashes($_POST["descricao_curta"]);
        $descricaoLonga = addslashes($_POST["descricao_longa"]);
        $imagem = $_FILES["imagem"]["name"];
        $thumb = $_FILES["thumbnail"]["name"];
        $video = addslashes($_POST["url_video"]);
        
        $refDicas = $pew_functions->url_format($titulo);
        $status = (int)$_POST["status"] == 1 ? 1 : 0;
        
        $nomeImagem = $pew_functions->url_format($titulo);
        $data = date("Y-m-d h:i:s");
        $dirImagens = "../imagens/dicas/";
         
        if($imagem != ""){
            $refImg = substr(md5(uniqid()), 0, 4);
            $ext = pathinfo($imagem, PATHINFO_EXTENSION);
            $imagem = $nomeImagem."-dica-ref$refImg.".$ext;
            move_uploaded_file($_FILES["imagem"]["tmp_name"], $dirImagens.$imagem);
        }
        if($thumb != ""){
            $refImg = substr(md5(uniqid()), 0, 4);
            $ext = pathinfo($thumb, PATHINFO_EXTENSION);
            $thumb = $nomeImagem."-dicathumb-ref$refImg.".$ext;
            move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $dirImagens.$thumb);
        }

        mysqli_query($conexao, "insert into $tabela_dica (titulo, subtitulo, ref, descricao_curta, descricao_longa, imagem, thumb, video, data_controle, status) values ('$titulo', '$subtitulo', '$refDicas', '$descricaoCurta', '$descricaoLonga','$imagem', '$thumb', '$video','$data', '$status')");
        
        echo "<script>window.location.href = 'pew-dicas.php?msg=Dica cadastrada com sucesso&msgType=success'; </script>";
    }else{
        //print_r($invalid_fields);
        echo "<script>window.location.href = 'pew-dicas.php?msg=Dica não foi cadastrada&msgType=error'; </script>";
    }
?>
