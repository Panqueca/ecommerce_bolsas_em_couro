<?php
    echo "<h3 align='center'>Fazendo upload do banner...</h3>";
    if(isset($_POST["titulo"]) && isset($_POST["descricao"]) && isset($_POST["link"]) && isset($_FILES["imagem"])){
        require_once "pew-system-config.php";
        $tabela_banners = $pew_db->tabela_banners;
        $titulo = addslashes($_POST["titulo"]);
        $descricao = addslashes($_POST["descricao"]);
        $link = addslashes($_POST["link"]);
        $img = $_FILES["imagem"]["name"];
        $http = substr($link, 0, 5);
        if($http != "http:" && $http != "https"){
            $link = "http://".$link;
        }
        /*Formatando o nome da foto*/
        $nomeFoto = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"), $titulo);
        $nomeFoto = trim($nomeFoto);
        $nomeFoto = str_replace("ç", "c", $nomeFoto);
        $nomeFoto = str_replace("Ç", "C", $nomeFoto);
        $nomeFoto = str_replace(" ", "-", $nomeFoto);
        $nomeFoto = strtolower($nomeFoto);
        $nomeFoto = pew_string_format($nomeFoto);
        /*Formatando o nome da foto*/

        if($img != ""){
            $refId = substr(md5(uniqid()), 0, 5);
            $ext = pathinfo($img, PATHINFO_EXTENSION);
            $nomeFoto = $nomeFoto."-banner-home-$refId.".$ext;
            $dir = "../imagens/banners/";
            move_uploaded_file($_FILES["imagem"]["tmp_name"], $dir.$nomeFoto);
        }//MOVE A FOTO DO BANNER PARA O DIRETORIO -> Se for alterada
        $contarBanners = mysqli_query($conexao, "select count(id) as total_banners from $tabela_banners");
        $contagemBanners = mysqli_fetch_array($contarBanners);
        if($contagemBanners["total_banners"] > 0){
            $queryBanners = mysqli_query($conexao, "select id, posicao from $tabela_banners order by posicao");
            while($banners = mysqli_fetch_array($queryBanners)){
                $idBanner = $banners["id"];
                $posicao = $banners["posicao"];
                $posicao++;
                mysqli_query($conexao, "update $tabela_banners set posicao = '$posicao' where id = '$idBanner'");
            }
        }
        mysqli_query($conexao, "insert into $tabela_banners (titulo, descricao, imagem, link, posicao, status) values ('$titulo', '$descricao', '$nomeFoto', '$link', 1, 1)");
        mysqli_close($conexao);
        header("location: pew-banners.php?msg=O banner foi cadastrado com sucesso!&msgType=success");
    }else{
        header("location: pew-cadastra-banner.php?msg=Ocorreu um erro ao cadastrar o banner&msgType=error");
    }
?>
