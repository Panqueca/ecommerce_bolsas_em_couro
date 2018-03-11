<?php
    $post_fields = array("id_produto", "sku", "nome", "marca", "preco", "preco_promocao", "promocao_ativa", "estoque", "estoque_baixo", "tempo_fabricacao", "descricao_curta", "descricao_longa", "url_video", "peso", "comprimento", "largura", "altura", "status");
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
        $dataAtual = date("Y-m-d h:i:s");
        /*POST DATA*/
        $idProduto = addslashes($_POST["id_produto"]);
        $skuProduto = addslashes($_POST["sku"]);
        $nomeProduto = addslashes($_POST["nome"]);
        $marcaProduto = addslashes($_POST["marca"]);
        $precoProduto = $_POST["preco"];
        $precoProduto = pew_number_format($precoProduto);
        $precoPromocaoProduto = $_POST["preco_promocao"];
        $precoPromocaoProduto = pew_number_format($precoPromocaoProduto);
        $promocaoAtiva = intval($_POST["promocao_ativa"]) == 1 ? 1 : 0;
        $estoqueProduto = (int)$_POST["estoque"] != "" ? (int)$_POST["estoque"] : 0;
        $estoqueBaixoProduto = (int)$_POST["estoque_baixo"] != "" ? (int)$_POST["estoque_baixo"] : 1;
        $tempoFabricacaoProduto = (int)$_POST["tempo_fabricacao"] != "" ? (int)$_POST["tempo_fabricacao"] : 1;;
        $descricaoCurtaProduto = addslashes($_POST["descricao_curta"]);
        $descricaoLongaProduto = addslashes($_POST["descricao_longa"]);
        $urlVideoProduto = addslashes($_POST["url_video"]);
        $pesoProduto = floatval($_POST["peso"]);
        $comprimentoProduto = floatval($_POST["comprimento"]);
        $larguraProduto = floatval($_POST["largura"]);
        $alturaProduto = floatval($_POST["altura"]);
        $categoriasProduto = isset($_POST["categorias"]) ? $_POST["categorias"] : "";
        $especificacoes = isset($_POST["especicacao_produto"]) ? $_POST["especicacao_produto"] : "";
        $produtosRelacionados = isset($_POST["produtos_relacionados"]) ? $_POST["produtos_relacionados"] : "";
        $subcategoriasProduto = isset($_POST["subcategorias"]) ? $_POST["subcategorias"] : "";
        $statusProduto = intval($_POST["status"]) == 1 ? 1 : 0;
        /*END POST DATA*/

        /*DIR VARS*/
        $dirImagensProdutos = "../imagens/produtos/";
        /*END DIR VARS*/

        /*SET TABLES*/
        $tabela_produtos = $pew_custom_db->tabela_produtos;
        $tabela_imagens = $pew_custom_db->tabela_imagens_produtos;
        $tabela_categorias = $pew_db->tabela_categorias;
        $tabela_subcategorias = $pew_db->tabela_subcategorias;
        $tabela_categorias_produtos = $pew_custom_db->tabela_categorias_produtos;
        $tabela_subcategorias_produtos = $pew_custom_db->tabela_subcategorias_produtos;
        $tabela_produtos_relacionados = $pew_custom_db->tabela_produtos_relacionados;
        $tabela_especificacoes_produtos = $pew_custom_db->tabela_especificacoes_produtos;
        /*END SET TABLES*/

        if(!function_exists("stringFormat")){
            function stringFormat($string){
                $string = str_replace("Ç", "c", $string);
                $string = str_replace("ç", "c", $string);
                $string = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"), $string);
                $string = strtolower($string);
                $string = str_replace("/", "-", $string);
                $string = str_replace("|", "-", $string);
                $string = str_replace(" ", "-", $string);
                $string = str_replace(",", "", $string);
                return $string;
            }
        }

        if($nomeProduto != ""){
            echo "<h3 align=center>Gravando dados...</h3>";
            mysqli_query($conexao, "update $tabela_produtos set sku = '$skuProduto', nome = '$nomeProduto', marca = '$marcaProduto', preco = '$precoProduto', preco_promocao = '$precoPromocaoProduto', promocao_ativa = '$promocaoAtiva', estoque = '$estoqueProduto', estoque_baixo = '$estoqueBaixoProduto', tempo_fabricacao = '$tempoFabricacaoProduto', descricao_curta = '$descricaoCurtaProduto', descricao_longa = '$descricaoLongaProduto', url_video = '$urlVideoProduto', peso = '$pesoProduto', comprimento = '$comprimentoProduto', largura = '$larguraProduto', altura = '$alturaProduto', data = '$dataAtual', status = '$statusProduto' where id = '$idProduto'");

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
                        mysqli_query($conexao, "insert into $tabela_categorias_produtos (id_produto, id_categoria, titulo_categoria) values ('$idProduto', '$idCategoria', '$tituloCategoria')");
                    }
                }
            }else{
                mysqli_query($conexao, "delete from $tabela_categorias_produtos where id_produto = '$idProduto'");
            }
            /*FIM ATUALIZA CATEGORIAS DO PRODUTO*/

            /*ATUALIZA SUBCATEGORIAS DO PRODUTO*/
            if($subcategoriasProduto != ""){
                $querySubcategoriasAtuais = mysqli_query($conexao, "select id_subcategoria, titulo_subcategoria from $tabela_subcategorias_produtos where id_produto = '$idProduto'");
                while($subcategoriasA = mysqli_fetch_array($querySubcategoriasAtuais)){
                    $idSubcat = $subcategoriasA["id_subcategoria"];
                    $tituloSubcat = $subcategoriasA["titulo_subcategoria"];
                    $removeSubcategoria = true;
                    foreach($subcategoriasProduto as $infoSubcategoria){
                        $info = explode("||", $infoSubcategoria);
                        $tituloCheckedSub = $info[0];
                        if($tituloCheckedSub == $tituloSubcat){
                            $removeSubcategoria = false;
                        }
                    }
                    if($removeSubcategoria){/*Se o POST não foi enviado, desvincular categoria com produto*/
                        mysqli_query($conexao, "delete from $tabela_subcategorias_produtos where id_produto = '$idProduto' and id_subcategoria = '$idSubcat'");
                    }
                }
                foreach($subcategoriasProduto as $infoSubcategoria){
                    $info = explode("||", $infoSubcategoria);
                    $tituloSubcategoria = $info[0];
                    $idCategoriaPrincipal = $info[1];
                    $querySubcategoria = mysqli_query($conexao, "select id from $tabela_subcategorias where subcategoria = '$tituloSubcategoria'");
                    $arraySubcategoria = mysqli_fetch_array($querySubcategoria);
                    $idSubcategoria = $arraySubcategoria["id"];
                    $contarSubcategoria = mysqli_query($conexao, "select count(id) as total_subcategorias from $tabela_subcategorias_produtos where id_subcategoria = '$idSubcategoria' and id_produto = '$idProduto'");
                    $contagem = mysqli_fetch_assoc($contarSubcategoria);
                    if($contagem["total_subcategorias"] == 0){
                        mysqli_query($conexao, "insert into $tabela_subcategorias_produtos (id_produto, id_categoria, id_subcategoria, titulo_subcategoria) values ('$idProduto', '$idCategoriaPrincipal', '$idSubcategoria', '$tituloSubcategoria')");
                    }
                }
            }else{
                mysqli_query($conexao, "delete from $tabela_subcategorias_produtos where id_produto = '$idProduto'");
            }
            /*FIM ATUALIZA SUBCATEGORIAS DO PRODUTO*/

            /*ATUALIZA IMAGENS DO PRODUTO*/
            $maxImagens = isset($_POST["maximo_imagens"]) && (int)$_POST["maximo_imagens"] ? (int)$_POST["maximo_imagens"] : 4;
            for($i = 1; $i <= $maxImagens; $i++){
                $posicaoAnterior = $i - 1;
                $contarImagem = mysqli_query($conexao, "select count(id) as total_imagem from $tabela_imagens where posicao = '$posicaoAnterior' and id_produto = '$idProduto'");
                $contagem = mysqli_fetch_assoc($contarImagem);
                if($contagem["total_imagem"] == 0 && $posicaoAnterior > 0){
                    $posicao = $posicaoAnterior;
                }else{
                    $posicao = $i;
                }
                if(isset($_FILES["imagem$i"])){
                    $contarImagem = mysqli_query($conexao, "select count(id) as total_imagem from $tabela_imagens where id_produto = '$idProduto' and posicao = '$posicao'");
                    $contagem = mysqli_fetch_assoc($contarImagem);
                    $totalImgPosicao = $contagem["total_imagem"];
                    $nomeIMG = $_FILES["imagem$i"]["name"];
                    if($nomeIMG != ""){
                        $ref = substr(md5(uniqid(time())), 0, 4);
                        $ref = $ref.$posicao;
                        $nomeFoto = stringFormat($nome);
                        $ext = pathinfo($_FILES["imagem$i"]["name"], PATHINFO_EXTENSION);
                        $nomeFoto = $nomeFoto."-product-image-".$ref.".".$ext;
                        move_uploaded_file($_FILES["imagem$i"]["tmp_name"], $dirImagensProdutos.$nomeFoto);
                        if($totalImgPosicao > 0){
                            $queryImagem = mysqli_query($conexao, "select imagem from $tabela_imagens where id_produto = '$idProduto' and posicao = '$posicao'");
                            $arrayImagem = mysqli_fetch_array($queryImagem);
                            $imagem = $arrayImagem["imagem"];
                            unlink($dirImagensProdutos.$imagem);
                            mysqli_query($conexao, "update $tabela_imagens set imagem = '$nomeFoto', status = 1 where id_produto = '$idProduto' and posicao = '$posicao'");
                        }else{
                            mysqli_query($conexao, "insert into $tabela_imagens (id_produto, imagem, posicao, status) values ('$idProduto', '$nomeFoto', '$posicao', 1)");
                        }
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

            echo "<script>window.location.href='pew-edita-produto.php?msg=Produto atualizado com sucesso&msgType=success&id_produto=$idProduto';</script>";
        }else{
            echo "<script>window.location.href='pew-edita-produto.php?erro=validacao_do_produto&msg=Não foi possível atualizar o produto&msgType=error&id_produto=$idProduto';</script>";
        }
    }else{
        //print_r($invalid_fields); //Caso ocorra erro de envio de dados
        echo "<script>window.location.href='pew-produtos.php?erro=dados_enviados_insuficientes&msg=Não foi possível atualizar o produto&msgType=error&';</script>";
    }
?>
