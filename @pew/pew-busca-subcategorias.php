<?php
if(isset($_POST["id_categoria"])){
    require_once "pew-system-config.php";
    $tabela_categorias = $pew_db->tabela_categorias;
    $tabela_subcategorias = $pew_db->tabela_subcategorias;
    $idCategoria = $_POST["id_categoria"];
    $contarCategorias = mysqli_query($conexao, "select count(id) as total_categorias from $tabela_categorias where id = '$idCategoria'");
    $contagem = mysqli_fetch_assoc($contarCategorias);
    if($contagem["total_categorias"] > 0){
        $contarSubCategorias = mysqli_query($conexao, "select count(id) as total_subcategorias from $tabela_subcategorias where id_categoria  = '$idCategoria' and status = 1");
        $contagem = mysqli_fetch_assoc($contarSubCategorias);
        if($contagem["total_subcategorias"] > 0){
            $querySubCategorias = mysqli_query($conexao, "select subcategoria, id from $tabela_subcategorias where id_categoria = '$idCategoria' and status = 1");
            $subcategorias = array();
            $i = 0;
            while($sub = mysqli_fetch_array($querySubCategorias)){
                $subcategorias[$i] = $sub["subcategoria"]."##".$sub["id"];
                $i++;
            }
            $resultado = implode($subcategorias, "||");
            echo $resultado;
        }else{
            echo "false";
        }
    }else{
        echo "false";
    }
}else{
    echo "false";
}
?>
