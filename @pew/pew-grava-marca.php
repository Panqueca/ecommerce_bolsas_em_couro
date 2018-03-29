<?php
    $post_fileds = array("titulo", "descricao");
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
        echo "<h3 align=center>Gravando marca...</h3>";
        
        require_once "pew-system-config.php";
        require_once "@classe-system-functions.php";
        
        $tabela_marcas = $pew_custom_db->tabela_marcas;
        
        $titulo = addslashes(trim($_POST["titulo"]));
        $descricao = addslashes(trim($_POST["descricao"]));
        $data = date("Y-m-d h:i:s");
        $dirImagens = "../imagens/marcas/";

        $refMarca = $pew_functions->url_format($titulo);

        if($_FILES["imagem"]["name"] != ""){
            $ref = substr(md5(uniqid(time())), 0, 4);
            $nomeImgMarca = $refMarca."-ref".$ref;
            $ext = pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION);
            $nomeImgMarca = $nomeImgMarca.".".$ext;
            move_uploaded_file($_FILES["imagem"]["tmp_name"], $dirImagens.$nomeImgMarca);
        }else{
            $nomeImgMarca = "marca-padrao.png";
        }

        mysqli_query($conexao, "insert into $tabela_marcas (marca, descricao, ref, imagem, data_controle, status) values ('$titulo', '$descricao', '$refMarca', '$nomeImgMarca', '$data', 1)");
        
        echo "<script>window.location.href='pew-marcas.php?focus=$titulo&msg=A marca foi cadastrada com sucesso!&msgType=success'</script>";
    }else{
        echo "<script>window.location.href='pew-marcas.php?msg=Ocorreu um erro ao cadastrar a marca'</script>";
    }
?>
