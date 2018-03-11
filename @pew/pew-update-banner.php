<?php
    echo "<h3 align='center'>Fazendo upload do banner...</h3>";
    if(isset($_POST["id_banner"]) && isset($_POST["titulo"]) && isset($_POST["descricao"]) && isset($_POST["link"]) && isset($_POST["imagem_antiga"])){
        require_once "pew-system-config.php";
        $tabela_banners = $pew_db->tabela_banners;
        $idBanner = $_POST["id_banner"];
        $titulo = addslashes($_POST["titulo"]);
        $descricao = addslashes($_POST["descricao"]);
        $link = $_POST["link"];
        $imagemAntiga = $_POST["imagem_antiga"];
        if(isset($_FILES["imagem"])){
            $img = $_FILES["imagem"]["name"];
        }else{
            $img = "";
        }
        $http = substr($link, 0, 5);
        if($http != "http:" && $http != "https"){
            $link = "http://".$link;
        }

        $nomeFoto = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"), $titulo);
        $nomeFoto = trim($nomeFoto);
        $nomeFoto = str_replace("ç", "c", $nomeFoto);
        $nomeFoto = str_replace("Ç", "C", $nomeFoto);
        $nomeFoto = str_replace(" ", "-", $nomeFoto);
        $nomeFoto = strtolower($nomeFoto);

        if($img != ""){
            $refId = substr(md5(uniqid()), 0, 5);
            $ext = pathinfo($img, PATHINFO_EXTENSION);
            $nomeFoto = $nomeFoto."-banner-home-$refId.".$ext;
            $dir = "../imagens/banners/";
            unlink($dir.$imagemAntiga);
            move_uploaded_file($_FILES["imagem"]["tmp_name"], $dir.$nomeFoto);
            mysqli_query($conexao, "update $tabela_banners set imagem = '$nomeFoto' where id = '$idBanner'");
        }

        mysqli_query($conexao, "update $tabela_banners set titulo = '$titulo', descricao = '$descricao', link = '$link' where id = '$idBanner'");
        header("location: pew-banners.php?msg=O banner foi atualizado com sucesso!&msgType=success");
        mysqli_close($conexao);
    }else{
        if(isset($_POST["id_banner"])){
            $idBanner = $_POST["id_banner"];
            header("location: pew-edita-banner.php?id_banner=$idBanner&msg=Ocorreu um erro ao atualizar o banner&msgType=error");
        }else{
            header("location: pew-banners.php?msg=Ocorreu um erro ao atualizar o banner&msgType=error");
        }
    }
?>
