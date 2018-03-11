<?php
    $post_fileds = array("id_noticia", "titulo", "texto");
    $file_fields = array("imagem");
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
    foreach($file_fields as $file_name){
        /*Validação se todos campos foram enviados*/
        if(!isset($_FILES[$file_name])){
            $gravar = false;
            $i++;
            $invalid_fileds[$i] = $file_name;
        }
    }
    function voltar(){
        /*Se algo deu errado essa função é executada*/
        header("location: pew-noticias.php?msg=Ocorreu um erro ao atualizar a notícia. Tente novamente.");
    }

    function sucesso(){
        /*Se tudo deu certo essa função é executada*/
        header("location: pew-noticias.php?msg=A notícia foi atualizada com sucesso!&msgType=success");
    }
    if($gravar){
        require_once "pew-system-config.php";
        $tabela_noticias = $pew_custom_db->tabela_noticias;
        $idNoticia = $_POST["id_noticia"];
        $titulo = addslashes($_POST["titulo"]);
        $texto = addslashes($_POST["texto"]);
        $imagem = $_FILES["imagem"]["name"];
        $dirImagens = "../imagens/news/";
        $data = date("Y-m-d h:i:s");

        function url_format($string){
            $string = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"), $string);
            $string = strtolower($string);
            $string = str_replace(" ", "-", $string);
            return $string;
        }
        if($imagem != ""){
            $queryImagens = mysqli_query($conexao, "select imagem from $tabela_noticias where id = '$idNoticia'");
            $imagens = mysqli_fetch_array($queryImagens);
            $imagemAntiga = $imagens["imagem"];
            unlink($dirImagens.$imagemAntiga);
            $ext = pathinfo($imagem, PATHINFO_EXTENSION);
            $nomeImagem = url_format($titulo)."-noticia.".$ext;
            move_uploaded_file($_FILES['imagem']['tmp_name'], $dirImagens.$nomeImagem);
            mysqli_query($conexao, "update $tabela_noticias set imagem = '$nomeImagem' where id = '$idNoticia'");
        }
        mysqli_query($conexao, "update $tabela_noticias set titulo = '$titulo', texto = '$texto' where id = '$idNoticia'");
        sucesso();
    }else{
        voltar();
    }
?>
