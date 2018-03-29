<?php
    $post_fields = array("id_categoria_destaque", "info_categoria", "imagem_antiga", "status");
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
        
        require_once "pew-system-config.php";
        require_once "@classe-system-functions.php";
        
        $tabela_categoria_destaque = $pew_custom_db->tabela_categoria_destaque;
        
        $idCategoriaDestaque = $_POST["id_categoria_destaque"];
        $imagemAntiga = $_POST["imagem_antiga"];
        $imagem = $_FILES["imagem"]["name"];
        $status = (int)$_POST["status"] == 1 ? 1 : 0;
        $infoCategoria = $_POST["info_categoria"];
        $splitInfo = explode("||", $infoCategoria);
        $idCategoria = (int)$splitInfo[0];
        $tituloCategoria = addslashes(trim($splitInfo[1]));
        $data = date("Y-m-d h:i:s");
        $dirImagens = "../imagens/categorias/destaques/";

        $refCategoria = $pew_functions->url_format($tituloCategoria);
        
        $nomeImagem = $refCategoria;
        if($imagem != ""){
            $refImg = substr(md5(uniqid()), 0, 4);
            $ext = pathinfo($imagem, PATHINFO_EXTENSION);
            $nomeImagem = $nomeImagem."-categoria-destaque-ref$refImg.".$ext;
            move_uploaded_file($_FILES["imagem"]["tmp_name"], $dirImagens.$nomeImagem);
            
            if(file_exists($dirImagens.$imagemAntiga) && $imagemAntiga != ""){
                unlink($dirImagens.$imagemAntiga);
            }
        }else{
            $nomeImagem = $imagemAntiga;
        }

        mysqli_query($conexao, "update $tabela_categoria_destaque set id_categoria = '$idCategoria', titulo = '$tituloCategoria', imagem = '$nomeImagem', data_controle = '$data', status = '$status' where id = '$idCategoriaDestaque'");
        
        echo "true";
    }else{
        echo "false";
        print_r($invalid_fields);
    }
?>
