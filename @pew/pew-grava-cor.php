<?php
    $post_fileds = array("titulo");
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
        echo "<h3 align=center>Gravando cor...</h3>";
        
        require_once "pew-system-config.php";
        require_once "@classe-system-functions.php";
        
        $tabela_cores = $pew_custom_db->tabela_cores;
        
        $titulo = addslashes(trim($_POST["titulo"]));
        $data = date("Y-m-d h:i:s");
        $dirImagens = "../imagens/cores/";

        $ref = $pew_functions->url_format($titulo);

        if($_FILES["imagem"]["name"] != ""){
            $ref = substr(md5(uniqid(time())), 0, 4);
            $nomeImg = $ref."-ref".$ref;
            $ext = pathinfo($_FILES["imagem"]["name"], PATHINFO_EXTENSION);
            $nomeImg = $nomeImg.".".$ext;
            move_uploaded_file($_FILES["imagem"]["tmp_name"], $dirImagens.$nomeImg);
        }else{
            $nomeImg = "cor-padrao.png";
        }

        mysqli_query($conexao, "insert into $tabela_cores (cor, imagem, data_controle, status) values ('$titulo', '$nomeImg', '$data', 1)");
        
        echo "<script>window.location.href='pew-cores.php?focus=$titulo&msg=A cor foi cadastrada com sucesso!&msgType=success'</script>";
    }else{
        echo "<script>window.location.href='pew-cores.php?msg=Ocorreu um erro ao cadastrar a cor'</script>";
    }
?>