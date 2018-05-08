<?php

    $post_fields = array("id_produto", "sku", "codigo_barras", "nome", "marca", "id_cor", "preco", "preco_promocao", "promocao_ativa", "desconto_relacionado","estoque", "estoque_baixo", "tempo_fabricacao", "descricao_curta", "descricao_longa", "url_video", "peso", "comprimento", "largura", "altura", "status");
    $file_fields = array();
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
        
        $dataAtual = date("Y-m-d h:i:s");
        /*POST DATA*/
        $idProduto = addslashes($_POST["id_produto"]);
        $skuProduto = addslashes($_POST["sku"]);
        $codigoBarrasProduto = addslashes($_POST["codigo_barras"]);
        $nomeProduto = addslashes($_POST["nome"]);
        $marcaProduto = addslashes($_POST["marca"]);
        $idCor = (int)$_POST["id_cor"];
        $precoProduto = $_POST["preco"];
        $precoProduto = $pew_functions->custom_number_format($precoProduto);
        $precoPromocaoProduto = $_POST["preco_promocao"];
        $precoPromocaoProduto = $pew_functions->custom_number_format($precoPromocaoProduto);
        $descontoRelacionado = isset($_POST["desconto_relacionado"]) && $_POST["desconto_relacionado"] ? $_POST["desconto_relacionado"] : 0;
        $descontoRelacionado = $pew_functions->custom_number_format($descontoRelacionado);
        $promocaoAtiva = intval($_POST["promocao_ativa"]) == 1 ? 1 : 0;
        $estoqueProduto = (int)$_POST["estoque"] != "" ? (int)$_POST["estoque"] : 0;
        $estoqueBaixoProduto = (int)$_POST["estoque_baixo"] != "" ? (int)$_POST["estoque_baixo"] : 1;
        $tempoFabricacaoProduto = (int)$_POST["tempo_fabricacao"] != "" ? (int)$_POST["tempo_fabricacao"] : 1;;
        $descricaoCurtaProduto = addslashes($_POST["descricao_curta"]);
        $descricaoLongaProduto = addslashes($_POST["descricao_longa"]);
        $pesoProduto = floatval($_POST["peso"]);
        $comprimentoProduto = floatval($_POST["comprimento"]);
        $larguraProduto = floatval($_POST["largura"]);
        $alturaProduto = floatval($_POST["altura"]);
        $departamentosProduto = isset($_POST["departamentos"]) ? $_POST["departamentos"] : "";
        $categoriasProduto = isset($_POST["categorias"]) ? $_POST["categorias"] : "";
        $especificacoes = isset($_POST["especicacao_produto"]) ? $_POST["especicacao_produto"] : "";
        $produtosRelacionados = isset($_POST["produtos_relacionados"]) ? $_POST["produtos_relacionados"] : "";
        $coresRelacionadas = isset($_POST["cores_relacionadas"]) ? $_POST["cores_relacionadas"] : "";
        $subcategoriasProduto = isset($_POST["subcategorias"]) ? $_POST["subcategorias"] : "";
        $statusProduto = intval($_POST["status"]) == 1 ? 1 : 0;
        $urlVideoProduto = addslashes($_POST["url_video"]);
        
        
        $http = substr($urlVideoProduto, 0, 5);
        if($http != "http:" && $http != "https" && $urlVideoProduto != ""){
            $urlVideoProduto = "http://".$urlVideoProduto;
        }
        /*END POST DATA*/
        
        /*DIR VARS*/
        $dirImagensProdutos = "../imagens/produtos/";
        /*END DIR VARS*/

        /*SET TABLES*/
        $tabela_produtos = $pew_custom_db->tabela_produtos;
        $tabela_imagens = $pew_custom_db->tabela_imagens_produtos;
        $tabela_cores = $pew_custom_db->tabela_cores;
        $tabela_categorias = $pew_db->tabela_categorias;
        $tabela_subcategorias = $pew_db->tabela_subcategorias;
        $tabela_departamentos = $pew_custom_db->tabela_departamentos;
        $tabela_departamentos_produtos = $pew_custom_db->tabela_departamentos_produtos;
        $tabela_categorias_produtos = $pew_custom_db->tabela_categorias_produtos;
        $tabela_subcategorias_produtos = $pew_custom_db->tabela_subcategorias_produtos;
        $tabela_produtos_relacionados = $pew_custom_db->tabela_produtos_relacionados;
        $tabela_cores_relacionadas = $pew_custom_db->tabela_cores_relacionadas;
        $tabela_especificacoes_produtos = $pew_custom_db->tabela_especificacoes_produtos;
        /*END SET TABLES*/

        $querySku = mysqli_query($conexao, "select sku from $tabela_produtos where id = '$idProduto'");
        $infoSku = mysqli_fetch_array($querySku);
        $skuAntigo = $infoSku["sku"];
        
        if($nomeProduto != ""){
            echo "<h3 align=center>Gravando dados...</h3>";
            
            $condicaoCor = "id = '$idCor'";
            $idCor = $pew_functions->contar_resultados($tabela_cores, $condicaoCor) > 0 ? $idCor : null;
            
            mysqli_query($conexao, "update $tabela_produtos set sku = '$skuProduto', codigo_barras = '$codigoBarrasProduto', nome = '$nomeProduto', marca = '$marcaProduto', id_cor = '$idCor', preco = '$precoProduto', preco_promocao = '$precoPromocaoProduto', promocao_ativa = '$promocaoAtiva', desconto_relacionado = '$descontoRelacionado', estoque = '$estoqueProduto', estoque_baixo = '$estoqueBaixoProduto', tempo_fabricacao = '$tempoFabricacaoProduto', descricao_curta = '$descricaoCurtaProduto', descricao_longa = '$descricaoLongaProduto', url_video = '$urlVideoProduto', peso = '$pesoProduto', comprimento = '$comprimentoProduto', largura = '$larguraProduto', altura = '$alturaProduto', data = '$dataAtual', status = '$statusProduto' where id = '$idProduto'");

            /*ATUALIZA DEPARTAMENTOS*/
            if($departamentosProduto != ""){
                mysqli_query($conexao, "delete from $tabela_departamentos_produtos where id_produto = '$idProduto'");
                foreach($departamentosProduto as $idDepartamento){
                    mysqli_query($conexao, "insert into $tabela_departamentos_produtos (id_produto, id_departamento) values ('$idProduto', '$idDepartamento')");
                }
            }
            /*ATUALIZA CATEGORIAS DO PRODUTO*/
            if($categoriasProduto != ""){
                $queryCategoriasAtuais = mysqli_query($conexao, "select id_categoria from $tabela_categorias_produtos where id_produto = '$idProduto'");
                while($categoriasA = mysqli_fetch_array($queryCategoriasAtuais)){
                    $idCat = $categoriasA["id_categoria"];
                    $removeCategoria = true;
                    foreach($categoriasProduto as $checkedCategoria){
                        if($checkedCategoria == $idCat){
                            $removeCategoria = false;
                        }
                    }
                    if($removeCategoria){/*Se o POST não foi enviado, desvincular categoria com produto*/
                        mysqli_query($conexao, "delete from $tabela_categorias_produtos where id_produto = '$idProduto' and id_categoria = '$idCat'");
                    }
                }
                foreach($categoriasProduto as $idCategoria){
                    $queryCategoria = mysqli_query($conexao, "select categoria from $tabela_categorias where id = '$idCategoria'");
                    $arrayCategoria = mysqli_fetch_array($queryCategoria);
                    $tituloCategoria = $arrayCategoria["categoria"];
                    $contarCategoria = mysqli_query($conexao, "select count(id) as total_categorias from $tabela_categorias_produtos where id_categoria = '$idCategoria' and id_produto = '$idProduto'");
                    $contagem = mysqli_fetch_assoc($contarCategoria);
                    if($contagem["total_categorias"] == 0){
                        mysqli_query($conexao, "insert into $tabela_categorias_produtos (id_produto, id_categoria) values ('$idProduto', '$idCategoria')");
                    }
                }
            }else{
                mysqli_query($conexao, "delete from $tabela_categorias_produtos where id_produto = '$idProduto'");
            }
            /*FIM ATUALIZA CATEGORIAS DO PRODUTO*/

            /*ATUALIZA SUBCATEGORIAS DO PRODUTO*/
            if($subcategoriasProduto != ""){
                
                mysqli_query($conexao, "delete from $tabela_subcategorias_produtos where id_produto = '$idProduto'");
                
                foreach($subcategoriasProduto as $infoSubcategoria){
                    $info = explode("||", $infoSubcategoria);
                    $refSubcategoria = $info[0];
                    $idCategoriaPrincipal = $info[1];
                    
                    $querySubcategoria = mysqli_query($conexao, "select id from $tabela_subcategorias where ref = '$refSubcategoria'");
                    $arraySubcategoria = mysqli_fetch_array($querySubcategoria);
                    $idSubcategoria = $arraySubcategoria["id"];
                    
                    $contarSubcategoria = mysqli_query($conexao, "select count(id) as total_subcategorias from $tabela_subcategorias_produtos where id_subcategoria = '$idSubcategoria' and id_produto = '$idProduto'");
                    $contagem = mysqli_fetch_assoc($contarSubcategoria);
                    
                    if($contagem["total_subcategorias"] == 0){
                        mysqli_query($conexao, "insert into $tabela_subcategorias_produtos (id_produto, id_categoria, id_subcategoria) values ('$idProduto', '$idCategoriaPrincipal', '$idSubcategoria')");
                    }
                }
            }else{
                mysqli_query($conexao, "delete from $tabela_subcategorias_produtos where id_produto = '$idProduto'");
            }
            /*FIM ATUALIZA SUBCATEGORIAS DO PRODUTO*/

            /*ATUALIZA IMAGENS DO PRODUTO*/
            $selectedImagens = array();
            $ctrlImagens = 0;
            $maxImagens = isset($_POST["maximo_imagens"]) && (int)$_POST["maximo_imagens"] ? (int)$_POST["maximo_imagens"] : 4;
            for($i = 1; $i <= $maxImagens; $i++){
                $posicao = $i;
                
                if(isset($_FILES["imagem$i"])){
                    $condicaoPosImagem = "id_produto = '$idProduto' and posicao = '$posicao'";
                    
                    $totalImgPosicao = $pew_functions->contar_resultados($tabela_imagens, $condicaoPosImagem);
                    $nomeIMG = $_FILES["imagem$i"]["name"];
                    if($nomeIMG != ""){
                        
                        $ext = pathinfo($_FILES["imagem$i"]["name"], PATHINFO_EXTENSION);
                        $ref = substr(md5($nomeProduto.$posicao), 0, 4);
                        $urlTitulo = $pew_functions->url_format($nomeProduto);
                        $nomeFinalImagem = $urlTitulo."-".$ref.".".$ext;
                        
                        if($totalImgPosicao > 0){
                            $queryImagem = mysqli_query($conexao, "select imagem from $tabela_imagens where $condicaoPosImagem");
                            $arrayImagem = mysqli_fetch_array($queryImagem);
                            $imagem = $arrayImagem["imagem"];
                            
                            if(file_exists($dirImagensProdutos.$imagem) && $imagem != ""){
                                unlink($dirImagensProdutos.$imagem);
                            }
                            
                            mysqli_query($conexao, "update $tabela_imagens set imagem = '$nomeFinalImagem', status = 1 where id_produto = '$idProduto' and posicao = '$posicao'");
                            
                            $selectedImagens[$ctrlImagens] = $nomeFinalImagem;
                            $ctrlImagens++;
                        }else{
                            mysqli_query($conexao, "insert into $tabela_imagens (id_produto, imagem, posicao, status) values ('$idProduto', '$nomeFinalImagem', '$posicao', 1)");
                        }
                        
                        move_uploaded_file($_FILES["imagem$i"]["tmp_name"], $dirImagensProdutos.$nomeFinalImagem);
                    }
                }
            }
            /*FIM ATUALIZA IMAGENS DO PRODUTO*/

            /*INSERE ESPECIFICAÇÕES PRODUTO*/
            if($especificacoes != ""){
                mysqli_query($conexao, "delete from $tabela_especificacoes_produtos where id_produto = '$idProduto'");
                foreach($especificacoes as $infoEspecificacao){
                    $explodeInfo = explode("|-|", $infoEspecificacao);
                    $idEspecificacao = $explodeInfo[0];
                    $descricaoEspecificacao = $explodeInfo[1];
                    mysqli_query($conexao, "insert into $tabela_especificacoes_produtos (id_especificacao, id_produto, descricao) values ('$idEspecificacao', '$idProduto', '$descricaoEspecificacao')");
                }
            }

            /*ATUALIZA PRODUTOS RELACIONADOS*/
            if($produtosRelacionados != ""){
                $queryProdutosRelacionados = mysqli_query($conexao, "select * from $tabela_produtos_relacionados where id_produto = '$idProduto' group by id_relacionado");
                while($infoRelacionados = mysqli_fetch_array($queryProdutosRelacionados)){
                    $idSelectedRelacionado = $infoRelacionados["id_relacionado"];
                    $excluirRelacionado = true;
                    foreach($produtosRelacionados as $idProdutoRelacionado){
                        if($idProdutoRelacionado == $idSelectedRelacionado){
                            $excluirRelacionado = false;
                        }
                    }
                    if($excluirRelacionado){
                        $condicao_relacionados = "id_produto = '$idProduto' and id_relacionado = '$idSelectedRelacionado'";
                        mysqli_query($conexao, "delete from $tabela_produtos_relacionados where $condicao_relacionados");
                    }
                }
                foreach($produtosRelacionados as $idProdutoRelacionado){
                    $condicao_relacionados = "id_produto = '$idProduto' and id_relacionado = '$idProdutoRelacionado'";
                    $contar = mysqli_query($conexao, "select count(id) as total from $tabela_produtos_relacionados where $condicao_relacionados");
                    $contagem = mysqli_fetch_assoc($contar);
                    $totalContagem = $contagem["total"];
                    if($totalContagem == 0){
                        mysqli_query($conexao, "insert into $tabela_produtos_relacionados (id_produto, id_relacionado) values ('$idProduto', '$idProdutoRelacionado')");
                    }
                }
            }else{
                mysqli_query($conexao, "delete from $tabela_produtos_relacionados where id_produto = '$idProduto'");
            }
            /*FIM ATUALIZA PRODUTOS RELACIONADOS*/
            
            /*ATUALIZA CORES DE PRODUTOS RELACIONADOS*/
            
            $totalCoresRelacionadas = $pew_functions->contar_resultados($tabela_cores_relacionadas, "id_produto = '$idProduto'");
            if($totalCoresRelacionadas > 0){
                $queryRelacionado = mysqli_query($conexao, "select id_relacao from $tabela_cores_relacionadas where id_produto = '$idProduto'");
                while($infoCorRelacionada = mysqli_fetch_array($queryRelacionado)){
                    $idProdRel = $infoCorRelacionada["id_relacao"];
                    mysqli_query($conexao, "delete from $tabela_cores_relacionadas where id_produto = '$idProduto' and id_relacao = '$idProdRel'");
                    mysqli_query($conexao, "delete from $tabela_cores_relacionadas where id_produto = '$idProdRel' and id_relacao = '$idProduto'");
                }
                
            }
            
            if($coresRelacionadas != ""){
                foreach($coresRelacionadas as $idProdutoRelacionado){
                    mysqli_query($conexao, "insert into $tabela_cores_relacionadas (id_produto, id_relacao, data_controle, status) values ('$idProduto', '$idProdutoRelacionado', '$dataAtual', 1)");
                    
                    mysqli_query($conexao, "insert into $tabela_cores_relacionadas (id_produto, id_relacao, data_controle, status) values ('$idProdutoRelacionado', '$idProduto', '$dataAtual', 1)");
                }
            }   
            
            /*END ATUALIZA CORES DE PRODUTOS RELACIONADOS*/
            
            // ATUALIZAR NO BLING
            $urlUpdate = "https://bling.com.br/Api/v2/produto/$skuAntigo/";
            
            $apikey = "a0d67ab3925a9df897d78510a6ccf847dfdfb78dfd78641cb1504e8de0a311eab831c42b";
            
            function executeUpdateProduct($url, $data){
                
                $curl_handle = curl_init();
                
                curl_setopt($curl_handle, CURLOPT_ENCODING, '');
                curl_setopt($curl_handle, CURLOPT_URL, $url);
                curl_setopt($curl_handle, CURLOPT_POST, count($data));
                curl_setopt($curl_handle, CURLOPT_POSTFIELDS, $data);
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
                
                $response = curl_exec($curl_handle);
                curl_close($curl_handle);
                
                return $response;
            }
            
            function contar_result_bling($sku, $apikey){
                $url = 'https://bling.com.br/Api/v2/produto/' . $sku . '/xml';
                
                $curl_handle = curl_init();
                curl_setopt($curl_handle, CURLOPT_URL, $url . '&apikey=' . $apikey);
                curl_setopt($curl_handle, CURLOPT_RETURNTRANSFER, TRUE);
                $retorno = curl_exec($curl_handle);

                curl_close($curl_handle);
                
                $xmlRetorno = simplexml_load_string($retorno);
                
                $total = isset($xmlRetorno->produtos) && count($xmlRetorno->produtos) > 0 ? count($xmlRetorno->produtos) : 0;
                
                return $total;
            }
            
            $precoFinal = $promocaoAtiva == 1 && $precoPromocaoProduto < $precoProduto && $precoPromocaoProduto > 0 ? $precoPromocaoProduto : $precoProduto;
            
            $infoProduto = "
            <codigo>$skuProduto</codigo>
            <gtin>$codigoBarrasProduto</gtin>
            <peso_bruto>$pesoProduto</peso_bruto>
            <peso_liq>$pesoProduto</peso_liq>
            <descricao><![CDATA[" . html_entity_decode($nomeProduto) . "]]></descricao>
            <descricaoCurta><![CDATA[" . html_entity_decode($descricaoCurtaProduto) . "]]></descricaoCurta>
            <descricaoComplementar><![CDATA[" . html_entity_decode($descricaoLongaProduto) . "]]></descricaoComplementar>
            <vlr_unit>$precoFinal</vlr_unit>
            <estoque>$estoqueProduto</estoque>
            <largura>$larguraProduto</largura>
            <altura>$alturaProduto</altura>
            <un>un</un>
            <profundidade>$comprimentoProduto</profundidade>";
            
            if(count($selectedImagens) > 0){
                $infoProduto .= "<imagens>";
                $base = "https://www.efectusdigital.com.br/bolsas/imagens";
                foreach($selectedImagens as $nomeIMG){
                    $infoProduto .= "<url>$base/$nomeIMG</url>";
                }
                $infoProduto .= "</imagens>";
            }
            
            $xmlProduto = "<produto>$infoProduto</produto>";
            
            if($xmlProduto != null){
                
                
                $posts = array (
                    "apikey" => $apikey,
                    "xml" => rawurlencode($xmlProduto)
                );
                
                
                if(contar_result_bling($skuAntigo, $apikey) == 0){
                    $urlUpdate = 'https://bling.com.br/Api/v2/produto/json/';
                }
                
                $retorno = executeUpdateProduct($urlUpdate, $posts);
                echo $retorno;
                // END GRAVAR NO BLING
            }
            // END ATUALIZAR NO BLING
            
            //echo "<script>window.location.href='pew-edita-produto.php?msg=Produto atualizado com sucesso&msgType=success&id_produto=$idProduto';</script>";
        }else{
            echo "<script>window.location.href='pew-edita-produto.php?erro=validacao_do_produto&msg=Não foi possível atualizar o produto&msgType=error&id_produto=$idProduto';</script>";
        }
    }else{
        //print_r($invalid_fields); //Caso ocorra erro de envio de dados
        echo "<script>window.location.href='pew-produtos.php?erro=dados_enviados_insuficientes&msg=Não foi possível atualizar o produto&msgType=error&';</script>";
    }
?>
