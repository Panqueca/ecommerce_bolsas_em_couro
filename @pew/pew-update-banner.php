<?php
    $post_fields = array("id_banner", "titulo", "descricao", "link", "imagem_antiga");
    $file_fields = array("imagem");
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
        echo "<h3 align='center'>Fazendo upload do banner...</h3>";
        
        /*STANDARD REQUIRES*/
        require_once "pew-system-config.php";
        require_once "@classe-system-functions.php";
        /*END STANDARD REQUIRES*/
        
        /*SET TABLES*/
        $tabela_banners = $pew_db->tabela_banners;
        /*END SET TABLES*/
        
        /*SET VARS*/
        $idBanner = $_POST["id_banner"];
        $titulo = addslashes($_POST["titulo"]);
        $descricao = addslashes($_POST["descricao"]);
        $link = $_POST["link"] != "" ? addslashes($_POST["link"]) : false;
        $imagemBanner = $_FILES["imagem"]["name"];
        $imagemAntiga = addslashes($_POST["imagem_antiga"]);
        $dirImagens = "../imagens/banners/";
        /*END SET VARS*/
        
        $http = substr($link, 0, 5);
        if($http != "http:" && $http != "https" && $link != false){
            $link = "http://".$link;
        }
        

        $nomeFoto = $pew_functions->url_format($titulo);
        if($imagemBanner != ""){
            $refId = substr(md5(uniqid()), 0, 5);
            $ext = pathinfo($imagemBanner, PATHINFO_EXTENSION);
            $nomeFoto = $nomeFoto."-banner-home-$refId.".$ext;
            if(file_exists($dirImagens.$imagemAntiga) && $imagemAntiga != ""){
                unlink($dirImagens.$imagemAntiga);
            }
            move_uploaded_file($_FILES["imagem"]["tmp_name"], $dirImagens.$nomeFoto);
            mysqli_query($conexao, "update $tabela_banners set imagem = '$nomeFoto' where id = '$idBanner'");
        }

        mysqli_query($conexao, "update $tabela_banners set titulo = '$titulo', descricao = '$descricao', link = '$link' where id = '$idBanner'");
        echo "<script>window.location.href = 'pew-banners.php?msg=O banner foi atualizado com sucesso!&msgType=success';</script>";
    }else{
        if(isset($_POST["id_banner"])){
            $idBanner = $_POST["id_banner"];
            echo "<script>window.location.href = 'pew-edita-banner.php?id_banner=$idBanner&msg=Ocorreu um erro ao atualizar o banner&msgType=error';</script>";
        }else{
            echo "<script>window.location.href = 'pew-banners.php?msg=Ocorreu um erro ao atualizar o banner&msgType=error';</script>";
        }
        //print_r($invalid_fields);
    }
?>