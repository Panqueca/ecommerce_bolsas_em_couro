<?php
    $post_fields = array("titulo", "link");
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
        $titulo = addslashes($_POST["titulo"]);
        $descricao = addslashes($_POST["descricao"]);
        $link = $_POST["link"] != "" ? addslashes($_POST["link"]) : false;
        $imagemBanner = $_FILES["imagem"]["name"];
        /*END SET VARS*/
        
        $http = substr($link, 0, 5);
        if($http != "http:" && $http != "https" && $link != false){
            $link = "http://".$link;
        }else{
            $link = null;
        }
        
        $nomeFoto = $pew_functions->url_format($titulo);

        if($imagemBanner != ""){
            $refId = substr(md5(uniqid()), 0, 5);
            $ext = pathinfo($imagemBanner, PATHINFO_EXTENSION);
            $nomeFoto = $nomeFoto."-banner-home-$refId.".$ext;
            $dir = "../imagens/banners/";
            move_uploaded_file($_FILES["imagem"]["tmp_name"], $dir.$nomeFoto);
        }
        
        $totalBanners = $pew_functions->contar_resultados($tabela_banners, "true");
        if($totalBanners > 0){
            $queryBanners = mysqli_query($conexao, "select id, posicao from $tabela_banners order by posicao");
            while($banners = mysqli_fetch_array($queryBanners)){
                $idBanner = $banners["id"];
                $posicao = $banners["posicao"];
                $posicao++;
                mysqli_query($conexao, "update $tabela_banners set posicao = '$posicao' where id = '$idBanner'");
            }
        }
        
        mysqli_query($conexao, "insert into $tabela_banners (titulo, descricao, imagem, link, posicao, status) values ('$titulo', '$descricao', '$nomeFoto', '$link', 1, 1)");
        echo "<script>window.location.href = 'pew-banners.php?msg=O banner foi cadastrado com sucesso!&msgType=success';</script>";
    }else{
        //print_r($invalid_fields);
        echo "<script>window.location.href = 'pew-cadastra-banner.php?msg=Ocorreu um erro ao cadastrar o banner&msgType=error';</script>";
    }
?>
