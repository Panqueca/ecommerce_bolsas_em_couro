<?php
    $post_fileds = array("id_departamento", "titulo", "descricao", "posicao", "status");
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
        
        $tabela_departamentos = $pew_custom_db->tabela_departamentos;
        $tabela_links_menu = $pew_custom_db->tabela_links_menu;
        
        $idDepartamento = $_POST["id_departamento"];
        $titulo = addslashes($_POST["titulo"]);
        $categoriasMenu = isset($_POST["categorias_menu"]) && $_POST["categorias_menu"] != null ? $_POST["categorias_menu"] : null;
        $descricao = addslashes($_POST["descricao"]);
        $posicao = (int)$_POST["posicao"];
        $status = $_POST["status"];
        $data = date("Y-m-d h:i:s");
        
        function valida_ref($str){
            global $tabela_departamentos, $pew_functions, $idDepartamento, $conexao;
            $total = $pew_functions->contar_resultados($tabela_departamentos, "ref = '$str'");
            $return = $total == 0 ? true : false;
            if($total == 1){
                $queryID = mysqli_query($conexao, "select id from $tabela_departamentos where ref = '$str'");
                $infoID = mysqli_fetch_array($queryID);
                $getID = $infoID["id"];
                $return = $getID == $idCategoria ? true : false;
            }
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
        
        
        $query = mysqli_query($conexao, "select imagem from $tabela_departamentos where id = '$idDepartamento'");
        $infoImagemAtual = mysqli_fetch_array($query);
        $imagemAtual = $infoImagemAtual["imagem"];
        
        if($imagem != ""){
            
            if(file_exists($dirImagens.$imagemAtual) && $imagemAtual != ""){
                unlink($dirImagens.$imagemAtual);
            }
            
            $nomeImagem = $finalRef;
            $ext = pathinfo($imagem, PATHINFO_EXTENSION);
            $nomeImagem = $nomeImagem."-departamento.".$ext;
            move_uploaded_file($_FILES["imagem"]["tmp_name"], $dirImagens.$nomeImagem);
            
        }else{
            $nomeImagem = $imagemAtual;
        }

        mysqli_query($conexao, "update $tabela_departamentos set departamento = '$titulo', descricao = '$descricao', imagem = '$nomeImagem', posicao = '$posicao', ref = '$ref', data_controle = '$data', status = '$status' where id = '$idDepartamento'");
        
        
        mysqli_query($conexao, "delete from $tabela_links_menu where id_departamento = '$idDepartamento'");
        
        if(is_array($categoriasMenu) && count($categoriasMenu) > 0){
            foreach($categoriasMenu as $idCategoria){
                mysqli_query($conexao, "insert into $tabela_links_menu (id_departamento, id_categoria) values ('$idDepartamento', '$idCategoria')");
            }
        }
        
        echo "<script>window.location.href = 'pew-departamentos.php?msg=O departamento foi atualizado&msgType=success&focus=$titulo';</script>";
    }else{
        //print_r($invalid_fileds);
        echo "<script>window.location.href = 'pew-departamentos.php??msg=O departamento não foi atualizado';</script>";
    }
?>
