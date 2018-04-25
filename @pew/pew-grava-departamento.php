<?php
    $post_fileds = array("titulo", "descricao", "posicao");
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
        
        require_once "pew-system-config.php";
        require_once "@classe-system-functions.php";
        
        echo "<h3 align=center>Enviando dados ...</h3>";
        
        $tabela_departamentos = $pew_custom_db->tabela_departamentos;
        
        $titulo = addslashes(trim($_POST["titulo"]));
        $descricao = addslashes(trim($_POST["descricao"]));
        $posicao = (int)$_POST["posicao"];
        $data = date("Y-m-d h:i:s");
        
        function valida_ref($str){
            global $tabela_departamentos, $pew_functions;
            $total = $pew_functions->contar_resultados($tabela_departamentos, "ref = '$str'");
            $return = $total == 0 ? true : false;
            return $return;
        }
        
        $ref = $pew_functions->url_format($titulo);
        $finalRef = $ref;
        
        $i = 1;
        while(valida_ref($finalRef) == false){
            $finalRef = "$ref-$i";
            $i++;
        }
        
        $dirImagens = "../imagens/departamentos/";
        
        $imagem = isset($_FILES["imagem"]) ? $_FILES["imagem"]["name"] : "";
        if($imagem != ""){
            $nomeImagem = $finalRef;
            $ext = pathinfo($imagem, PATHINFO_EXTENSION);
            $nomeImagem = $nomeImagem."-departamento.".$ext;
            move_uploaded_file($_FILES["imagem"]["tmp_name"], $dirImagens.$nomeImagem);
        }else{
            $nomeImagem = "";
        }

        mysqli_query($conexao, "insert into $tabela_departamentos (departamento, descricao, ref, imagem, posicao, data_controle, status) values ('$titulo', '$descricao', '$finalRef', '$nomeImagem', '$posicao', '$data', 1)");
        
        echo "<script>window.location.href = 'pew-departamentos.php?msg=O departamento foi cadastrado&msgType=success&focus=$titulo';</script>";
    }else{
        //print_r($invalid_fileds);
        echo "<script>window.location.href = 'pew-departamentos.php??msg=O departamento não foi cadastrado';</script>";
    }
?>
