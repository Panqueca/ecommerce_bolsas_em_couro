<?php

    require_once "pew-system-config.php";
    require_once "@classe-system-functions.php";
    
    echo "<pre>";
    $query = mysqli_query($conexao, "select * from produtos");

    $dataAtual = date("Y-m-d h:i:s");


    while($info = mysqli_fetch_array($query)){
        
        $idProduto = $info["id"];
        $skuProduto = $info["sku"];
        $nomeProduto = $info["nome"];
        $descricaoLongaProduto = $info["descricao"];
        $descricaoCurtaProduto = $info["descricao"];
        $precoProduto = $info["preco"];
        $precoPromocaoProduto = $info["promocao"];
        $marcaProduto = $info["marca"];
        $estoqueProduto = $info["estoque"];
        $pesoProduto = $info["peso"];
        $comprimentoProduto = $info["comprimento"];
        $larguraProduto = $info["largura"];
        $alturaProduto = $info["altura"];
        $statusProduto = $info["status"];
        $categoriaProduto = $info["categoria"];
        
        $departamento = $info["departamento"];
        
        $promocaoAtiva = $precoPromocaoProduto > 0 ? 1 : 0;
        
        //mysqli_query($conexao, "insert into pew_produtos (id, sku, nome, marca, id_cor, preco, preco_promocao, promocao_ativa, desconto_relacionado, estoque, estoque_baixo, tempo_fabricacao, descricao_curta, descricao_longa, url_video, peso, comprimento, largura, altura, data, status) values ('$idProduto', '$skuProduto', '$nomeProduto', '$marcaProduto', '0', '$precoProduto','$precoPromocaoProduto', '$promocaoAtiva', '0', '$estoqueProduto', '5', '0', '$descricaoCurtaProduto', '$descricaoLongaProduto', '0', '$pesoProduto', '$comprimentoProduto', '$larguraProduto', '$alturaProduto', '$dataAtual', '$statusProduto')");
        
        $queryImagens = mysqli_query($conexao, "select * from produtos_imagens where id_produto = '$idProduto' order by posicao asc");
        while($infoImagem = mysqli_fetch_array($queryImagens)){
            $idImagem = $infoImagem["id"];
            $imagem = $infoImagem["imagem"];
            $posicao = $infoImagem["posicao"];
            
            //mysqli_query($conexao, "insert into pew_imagens_produtos (id_produto, imagem, posicao, status) values ('$idProduto', '$imagem', '$posicao', 1)");
        }
        
        $totalMarca = $pew_functions->contar_resultados("pew_marcas", "marca = '$marcaProduto'");
        if($totalMarca == 0){
            
            $refMarca = $pew_functions->url_format($marcaProduto);

            //mysqli_query($conexao, "insert into pew_marcas (marca, descricao, ref, imagem, data_controle, status) values ('$marcaProduto', '', '$refMarca', '', '$dataAtual', 1)");
            
        }
        
        switch($departamento){
            case "Lar":
                $idDepartamento = 26;
                break;
            case "Obra":
                $idDepartamento = 27;
                break;
        }
        if(isset($idDepartamento)){
            //mysqli_query($conexao, "insert into pew_departamentos_produtos (id_produto, id_departamento) values ('$idProduto', '$idDepartamento')");
        }
        
        $totalCategoria = $pew_functions->contar_resultados("pew_categorias", "categoria = '$categoriaProduto'");
        
        if($totalCategoria == 0){
            $finalRef = $pew_functions->url_format($categoriaProduto);
            //mysqli_query($conexao, "insert into pew_categorias (categoria, descricao, ref, data_controle, status) values ('$categoriaProduto', '', '$finalRef', '$dataAtual', 1)");
        }
        if($categoriaProduto != ""){
            $queryCategoria = mysqli_query($conexao, "select id from pew_categorias where categoria = '$categoriaProduto'");
            $infoCategoria = mysqli_fetch_array($queryCategoria);
            $idCategoria = $infoCategoria["id"];
            
            //mysqli_query($conexao, "insert into pew_categorias_produtos (id_produto, id_categoria) values ('$idProduto', '$idCategoria')");
        }
        
        echo "<br><br>";
    }