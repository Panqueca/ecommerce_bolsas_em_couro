<?php
if(isset($_POST["id_produto"]) && isset($_POST["acao"])){
    require_once "pew-system-config.php";
    /*SET TABLES*/
    $tabela_produtos = $pew_custom_db->tabela_produtos;
    $tabela_imagens_produtos = $pew_custom_db->tabela_imagens_produtos;
    $tabela_categorias_produtos = $pew_custom_db->tabela_categorias_produtos;
    $tabela_subcategorias_produtos = $pew_custom_db->tabela_subcategorias_produtos;
    $tabela_produtos_relacionados = $pew_custom_db->tabela_produtos_relacionados;
    $tabela_especificacoes_produtos = $pew_custom_db->tabela_especificacoes_produtos;
    /*END SET TABLES*/

    /*POST VARS*/
    $idProduto = $_POST["id_produto"];
    $acao = $_POST["acao"];
    /*END POST VARS*/

    /*DEFAULT VARS*/
    $dirImagens = "../imagens/produtos/";
    /*END DEFAULT VARS*/

    $contarProduto = mysqli_query($conexao, "select count(id) as total_produto from $tabela_produtos where id = '$idProduto'");
    $contagem = mysqli_fetch_assoc($contarProduto);
    if($contagem["total_produto"] > 0 && $acao != "excluir_imagem"){
        if($acao == "excluir"){
            /*EXCLUIR TODOS OS DADOS DO PRODUTO DE TODAS AS TABELAS RELACIONADAS*/
            $queryImagens = mysqli_query($conexao, "select * from $tabela_imagens_produtos where id_produto = '$idProduto'");
            /*TABELAS RELACIONADAS PRODUTO*/
            while($imagens = mysqli_fetch_array($queryImagens)){
                $idImagem = $imagens["id"];
                $imagem = $imagens["imagem"];
                if(file_exists($dirImagens.$imagem) && $imagem != ""){
                    unlink($dirImagens.$imagem);
                }
                mysqli_query($conexao, "delete from $tabela_imagens_produtos where id = '$idImagem'");
            }
            mysqli_query($conexao, "delete from $tabela_categorias_produtos where id_produto = '$idProduto'");
            mysqli_query($conexao, "delete from $tabela_subcategorias_produtos where id_produto = '$idProduto'");
            mysqli_query($conexao, "delete from $tabela_produtos_relacionados where id_produto = '$idProduto'");
            mysqli_query($conexao, "delete from $tabela_especificacoes_produtos where id_produto = '$idProduto'");
            /*END TABELAS RELACIONADAS PRODUTO*/
            // DELETAR NO BLING
            
            function executeDeleteProduct($url, $data) {
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, $url);
                curl_setopt($curl_handle, CURLOPT_CUSTOMREQUEST, 'DELETE');
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data);
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
                $response = curl_exec($curl_handle);
                curl_close($curl_handle);
                return $response;
            }
            
            $querySku = mysqli_query($conexao, "select sku from $tabela_produtos where id = '$idProduto'");
            $infoSku = mysqli_fetch_array($querySku);
            $skuAntigo = $infoSku["sku"];
            
            $url = 'https://bling.com.br/Api/v2/produto/' . $skuAntigo . '/json';
            $data = array (
                "apikey" => "a0d67ab3925a9df897d78510a6ccf847dfdfb78dfd78641cb1504e8de0a311eab831c42b"
            );
            
            $retorno = executeDeleteProduct($url, $data);
            
            //echo $retorno;
            
            // END DELETAR NO BLING
            
            mysqli_query($conexao, "delete from $tabela_produtos where id = '$idProduto'"); /*TABELA PRINCIPAL PRODUTO*/
            
        }else{
            $status = $acao == "ativar" ? 1 : 0;
            mysqli_query($conexao, "update $tabela_produtos set status = $status where id = '$idProduto'");
        }
        echo "true";
    }else if($acao == "excluir_imagem"){
        $idImagem = $idProduto;
        $queryImagens = mysqli_query($conexao, "select imagem from $tabela_imagens_produtos where id = '$idImagem'");
        while($imagens = mysqli_fetch_array($queryImagens)){
            $imagem = $imagens["imagem"];
            if(file_exists($dirImagens.$imagem) && $imagem != ""){
                unlink($dirImagens.$imagem);
            }
        }
        mysqli_query($conexao, "delete from $tabela_imagens_produtos where id = '$idImagem'");
        echo "imagem_excluida";
    }else{
        echo "false";
    }
    mysqli_close($conexao);
}else{
    echo "false";
}
?>
