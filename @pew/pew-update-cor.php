<?php
    $post_fileds = array("id_cor", "titulo", "status");
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
        
        $tabela_cores = $pew_custom_db->tabela_cores;
        
        $idCor = (int)$_POST["id_cor"];
        $titulo = addslashes(trim($_POST["titulo"]));
        $status = (int)$_POST["status"];
        $data = date("Y-m-d h:i:s");
        $dirImagens = "../imagens/cores/";

        $refMarca = $pew_functions->url_format($titulo);

        $queryImagem = mysqli_query($conexao, "select imagem from $tabela_cores where id = '$idCor'");
        $infoImagem = mysqli_fetch_array($queryImagem);
        $imagemAtual = $infoImagem["imagem"];

        if($_FILES["imagem"]["name"] != ""){
            $ref = substr(md5(uniqid(time())), 0, 4);
            $nomeImg = $refMarca."-ref".$ref;
            $ext = pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION);
            $nomeImg = $nomeImg.".".$ext;
            move_uploaded_file($_FILES["imagem"]["tmp_name"], $dirImagens.$nomeImg);
            
            if(file_exists($dirImagens.$imagemAtual) && $imagemAtual != ""){
                unlink($dirImagens.$imagemAtual);
            }
        }else{
            $nomeImg = $imagemAtual;
        }

        mysqli_query($conexao, "update $tabela_cores set cor = '$titulo', imagem = '$nomeImg', data_controle = '$data', status = '$status' where id = '$idCor'");
        
        echo "<script>window.location.href='pew-cores.php?focus=$titulo&msg=A cor foi atualizada com sucesso!&msgType=success'</script>";
    }else{
        echo "<script>window.location.href='pew-cores.php?msg=Ocorreu um erro ao atualizar a cor'</script>";
    }
?>