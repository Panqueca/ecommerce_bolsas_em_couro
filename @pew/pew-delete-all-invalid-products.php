<pre>
<?php

    ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    require_once "pew-system-config.php";
    $tabela_produtos = $pew_custom_db->tabela_produtos;
    $tabela_imagens_produtos = $pew_custom_db->tabela_imagens_produtos;
    $tabela_cores_produtos = $pew_custom_db->tabela_cores_produtos;
    $tabela_departamentos_produtos = $pew_custom_db->tabela_departamentos_produtos;
    $tabela_categorias_produtos = $pew_custom_db->tabela_categorias_produtos;
    $tabela_subcategorias_produtos = $pew_custom_db->tabela_subcategorias_produtos;

    function contarProduto($id){
        global $conexao, $tabela_produtos;
        $contar = mysqli_query($conexao, "select count(id) as total from $tabela_produtos where id = '$id'");
        $contagem = mysqli_fetch_assoc($contar);
        $total = $contagem["total"];
        return $total;
    }

    $queryImagensProdutos = mysqli_query($conexao, "select * from $tabela_imagens_produtos");
    while($imagens = mysqli_fetch_array($queryImagensProdutos)){
        $idImagem = $imagens["id"];
        $nomeImagem = $imagens["imagem"];
        $idProduto = $imagens["id_vestido"];
        $dirImagens = "../imagens/produtos/vestidos/";
        if(contarProduto($idProduto) == 0){
            mysqli_query($conexao, "delete from $tabela_imagens_produtos where id = '$idImagem'");
            if(file_exists($dirImagens.$nomeImagem)){
                unlink($dirImagens.$nomeImagem);
            }
            echo "Excluindo imagem: $nomeImagem; id: $idProduto<br><br>";
        }
    }
    $queryCoresProdutos = mysqli_query($conexao, "select * from $tabela_cores_produtos");
    while($cores = mysqli_fetch_array($queryCoresProdutos)){
        $idCor = $cores["id"];
        $nomeCor = $cores["cor"];
        $idProduto = $cores["id_vestido"];
        if(contarProduto($idProduto) == 0){
            mysqli_query($conexao, "delete from $tabela_cores_produtos where id = '$idCor'");
            echo "Excluindo cor produto: $nomeCor; id: $idProduto<br><br>";
        }
    }
    $queryDepartamentosProdutos = mysqli_query($conexao, "select * from $tabela_departamentos_produtos");
    while($departamentos = mysqli_fetch_array($queryDepartamentosProdutos)){
        $idDepart = $departamentos["id"];
        $nomeDepart = $departamentos["titulo_departamento"];
        $idProduto = $departamentos["id_produto"];
        if(contarProduto($idProduto) == 0){
            mysqli_query($conexao, "delete from $tabela_departamentos_produtos where id = '$idDepart'");
            echo "Excluindo departamento produto: $nomeDepart; id: $idProduto<br><br>";
        }
    }
    $queryCategorias = mysqli_query($conexao, "select * from $tabela_categorias_produtos");
    while($categorias = mysqli_fetch_array($queryCategorias)){
        $idCategoria = $categorias["id"];
        $nomeCategoria = $categorias["titulo_categoria"];
        $idProduto = $categorias["id_produto"];
        if(contarProduto($idProduto) == 0){
            mysqli_query($conexao, "delete from $tabela_categorias_produtos where id = '$idCategoria'");
            echo "Excluindo categoria produto: $nomeCategoria; id: $idProduto<br><br>";
        }
    }
    $querySubcategorias = mysqli_query($conexao, "select * from $tabela_subcategorias_produtos");
    while($subcategorias = mysqli_fetch_array($querySubcategorias)){
        $idSubcategoria = $subcategorias["id"];
        $nomeSubcategoria = $subcategorias["titulo_subcategoria"];
        $idProduto = $subcategorias["id_produto"];
        if(contarProduto($idProduto) == 0){
            mysqli_query($conexao, "delete from $tabela_subcategorias_produtos where id = '$idSubcategoria'");
            echo "Excluindo subcategoria produto: $nomeSubcategoria; id: $idProduto<br><br>";
        }
    }
?>
</pre>
