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
        require_once "@classe-system-functions.php";
        
        $tabela_marcas = $pew_custom_db->tabela_marcas;
        
        $idMarca = (int)$_POST["id_marca"];
        $titulo = addslashes(trim($_POST["titulo"]));
        $descricao = addslashes(trim($_POST["descricao"]));
        $status = (int)$_POST["status"];
        $data = date("Y-m-d h:i:s");
        $dirImagens = "../imagens/marcas/";

        $refMarca = $pew_functions->url_format($titulo);

        $queryImagem = mysqli_query($conexao, "select imagem from $tabela_marcas where id = '$idMarca'");
        $infoImagem = mysqli_fetch_array($queryImagem);
        $imagemAtual = $infoImagem["imagem"];

        if($_FILES["imagem"]["name"] != ""){
            $ref = substr(md5(uniqid(time())), 0, 4);
            $nomeImgMarca = $refMarca."-ref".$ref;
            $ext = pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION);
            $nomeImgMarca = $nomeImgMarca.".".$ext;
            move_uploaded_file($_FILES["imagem"]["tmp_name"], $dirImagens.$nomeImgMarca);
            
            if(file_exists($dirImagens.$imagemAtual) && $imagemAtual != ""){
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
