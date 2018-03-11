<?php
    $post_fileds = array("id_marca", "titulo", "descricao", "status");
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
        echo "<h3 align=center>Atualizando marca...</h3>";
        require_once "pew-system-config.php";
        $tabela_marcas = $pew_custom_db->tabela_marcas;
        $idMarca = (int)$_POST["id_marca"];
        $titulo = addslashes(trim($_POST["titulo"]));
        $descricao = addslashes(trim($_POST["descricao"]));
        $status = (int)$_POST["status"];
        $data = date("Y-m-d h:i:s");
        $dirImagens = "../imagens/marcas/";

        if(!function_exists("stringFormat")){
            function stringFormat($string){
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
        }

        $refMarca = stringFormat($titulo);

        $queryImagem = mysqli_query($conexao, "select imagem from $tabela_marcas where id = '$idMarca'");
        $infoImagem = mysqli_fetch_array($queryImagem);
        $imagemAtual = $infoImagem["imagem"];

        if($_FILES["imagem"]["name"] != ""){
            $ref = substr(md5(uniqid(time())), 0, 4);
            $nomeImgMarca = $refMarca."-ref".$ref;
            $ext = pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION);
            $nomeImgMarca = $nomeImgMarca.".".$ext;
            move_uploaded_file($_FILES["imagem"]["tmp_name"], $dirImagens.$nomeImgMarca);
            if(file_exists($dirImagens.$imagemAtual)){
                unlink($dirImagens.$imagemAtual);
            }
        }else{
            $nomeImgMarca = $imagemAtual;
        }

        mysqli_query($conexao, "update $tabela_marcas set marca = '$titulo', descricao = '$descricao', ref = '$refMarca', imagem = '$nomeImgMarca', data_controle = '$data', status = '$status' where id = '$idMarca'");
        echo "<script>window.location.href='pew-marcas.php?focus=$titulo&msg=A marca foi atualizada com sucesso!&msgType=success'</script>";
    }else{
        echo "<script>window.location.href='pew-marcas.php?msg=Ocorreu um erro ao atualizar a marca'</script>";
    }
?>
