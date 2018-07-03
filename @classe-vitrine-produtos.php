<?php
    require_once "@include-global-vars.php";
    require_once "@classe-produtos.php";

    class VitrineProdutos{
        private $tipo;
        private $limite_produtos;
        private $titulo_vitrine;
        private $descricao_vitrine;
        private $quantidade_produtos;
        private $global_vars;
        private $pew_functions;
        private $exceptions = array();

        function __construct($tipo = "standard", $limiteProdutos = 4, $tituloVitrine = "", $descricaoVitrine = ""){
            $this->tipo = $tipo;
            $this->limite_produtos = $limiteProdutos;
            $this->titulo_vitrine = $tituloVitrine;
            $this->descricao_vitrine = $descricaoVitrine;
            $this->quantidade_produtos = 0;
            global $globalVars, $pew_functions;
            $this->global_vars = $globalVars;
            $this->pew_functions = $pew_functions;
        }

        private function conexao(){
            return $this->global_vars["conexao"];
        }
        
        public function create_box_produto($info = null){
            $tabela_cores = $this->global_vars["tabela_cores"];
            $cls_paginas = new Paginas();
            $cls_produto = new Produtos();
            if(is_array($info) && count($info) > 0){
                
                /*STANDARD VARS*/
                $nomeLoja = $cls_paginas->empresa;
                $dirImagensProdutos = "imagens/produtos";
                /*END STANDARD VARS*/
                
                /*VARIAVEIS DO PRODUTO*/
                $idProduto = $info["id_produto"];
                $infoCoresRelacionadas = isset($info["info_cores"]) ? $info["info_cores"] : null;
                $imagens = $info["imagens"];
                $qtdImagens = count($imagens);
                if($qtdImagens > 0){
                    $imagemPrincipal = $imagens[0];
                    $srcImagem = $imagemPrincipal["src"];
                    if(!file_exists($dirImagensProdutos."/".$srcImagem) || $srcImagem == ""){
                        $srcImagem = "produto-padrao.png";
                    }
                }else{
                    $srcImagem = "produto-padrao.png";
                }
                $nome = $info["nome"];
                $nomeURL = $this->pew_functions->url_format($nome);
                $maxCaracteres = 31;
                $nomeEllipses = strlen(str_replace(" ", "", $nome)) > $maxCaracteres ? trim(substr($nome, 0, $maxCaracteres))."..." : $nome;
                $qtdParcelas = 6;
                $txtParcelas = $qtdParcelas."x";
                $preco = $info["preco"];
                $precoPromocao = $info["preco_promocao"];
                $promoAtiva = $precoPromocao > 0 && $precoPromocao < $preco ? true : false;
                $precoParcela = $promoAtiva == true ? $precoPromocao / $qtdParcelas : $preco / $qtdParcelas;
                $priceField = $promoAtiva == true ? "<span class='view-preco'>De <span class='promo-price'>R$".number_format($preco, 2, ",", ".")."</span></span> por <span class='view-preco'><span class='price'>R$".number_format($precoPromocao, 2, ",", ".")."</span></span>" : "<span class='view-preco'><span class='price'>R$ ". number_format($preco, 2, ",", ".")."</span></span>";
                $urlProduto = "$nomeURL/$idProduto/";
                /*END VARIAVEIS DO PRODUTO*/

                /*DISPLAY DO PRODUTO*/
                $boxProduto = "";
                $boxProduto .= "<div class='box-produto'>";
                    $boxProduto .= "<a href='$urlProduto'><img src='$dirImagensProdutos/$srcImagem' title='$nome' alt='$nome - $nomeLoja'></a>";
                    $boxProduto .= "<a href='$urlProduto' class='title-link'><h3 class='titulo-produto' title='$nome'>$nomeEllipses</h3></a>";
                    $boxProduto .= "<h4 class='preco-produto'>$priceField ou <span class='view-parcelas'>$txtParcelas R$". number_format($precoParcela, 2, ",", ".") ."   </span></h4>";
                    $boxProduto .= "<a href='$urlProduto' class='call-to-action'>COMPRAR</a>";
                    $boxProduto .= "<div class='display-cores'>";
                        if(is_array($infoCoresRelacionadas) and count($infoCoresRelacionadas) > 0){
                            foreach($infoCoresRelacionadas as $id => $info){
                                $idRelacao = $info["id_relacao"];
                                $produtoRelacao = new Produtos();
                                $produtoRelacao->montar_produto($idRelacao);
                                $info = $produtoRelacao->montar_array();
                                $idCor = $info["id_cor"];
                                $nomeProduto = $info["nome"];
                                $nomeURL = $this->pew_functions->url_format($nomeProduto);
                                $queryCor = mysqli_query($this->conexao(), "SELECT * FROM $tabela_cores where id = '$idCor' and status = 1");
                                $functions = new systemFunctions();
                                $totalCores = $functions->contar_resultados($tabela_cores, "id = '$idCor' and status = 1");
                                $urlProdutoRelacao = "$nomeURL/$idRelacao/";
                                $dirImagens = "imagens/cores";
                                if($totalCores > 0){
                                    while($infoCor = mysqli_fetch_assoc($queryCor)){
                                        $nomeCor = $infoCor["cor"];
                                        $imagemCor = $infoCor["imagem"];
                                        if(!file_exists($dirImagens."/".$imagemCor) || $imagemCor == ""){
                                            $imagemCor = "cor-padrao.png";
                                        }
                                        $boxProduto .= "<a href='$urlProdutoRelacao'><img class='cor' title='$nomeCor' src='$dirImagens/$imagemCor'></a>";
                                    }
                                }
                            }
                        }
                    $boxProduto .= "</div>";
                $boxProduto .= "</div>";
                return $boxProduto;
                /*END DISPLAY DO PRODUTO*/
            }else{
                return false;
            }
        }
        
        function get_exceptions(){
            return $this->exceptions;
        }

        private function vitrine_standard($arrayProdutos = null){
            $tabela_cores = $this->global_vars["tabela_cores"];
            $conexao = $this->global_vars["conexao"];
            $functions = $this->pew_functions;
            
            if(!function_exists("listar_produto")){
                function listar_produto($idProduto){
                    global $conexao, $tabela_cores, $functions;

                    $produto = new Produtos();
                    $produto->montar_produto($idProduto);
                    $infoProduto = $produto->montar_array();
                    $infoCoresRelacionadas = $produto->get_cores_relacionadas();
                    $infoProduto["id_produto"] = $idProduto;
                    $infoProduto["info_cores"] = $infoCoresRelacionadas;
                    
                    $cls_vitrine = new VitrineProdutos();
                    
                    echo $cls_vitrine->create_box_produto($infoProduto);
                }
            }
            
            /*DISPLAY TODOS PRODUTO DA VITRINE*/
            echo "<section class='vitrine-standard'>";
                $tituloVitrine = $this->titulo_vitrine;
                $substrTitulo = substr($tituloVitrine, 0, 2);
                $updatedTitulo = null;
                switch($substrTitulo){
                    case "<h": // Verifica se é H2, H3. H4 etc
                        $updatedTitulo = true;
                        break;
                }
                if($updatedTitulo != null){
                    echo $tituloVitrine;
                }else{
                    echo "<h2 class='titulo-vitrine'>".$this->titulo_vitrine."</h2>";
                }
                if($this->descricao_vitrine != "" && $this->descricao_vitrine != false){
                    echo "<article class='descricao-vitrine'>".$this->descricao_vitrine."</article>";
                }
                echo "<div class='display-produtos'>";
                $ctrlProdutos = 0;
                if(is_array($arrayProdutos) && count($arrayProdutos) > 0){
                    foreach($arrayProdutos as $idProduto){
                        if($ctrlProdutos < $this->limite_produtos){
                            $produto = new Produtos();
                            $this->exceptions[count($this->exceptions)] = $idProduto;
                            
                            $idProduto = $produto->query_produto("status = 1 and id = '$idProduto'");
                            if($idProduto != false){
                                listar_produto($idProduto);
                                $ctrlProdutos++;
                            }
                        }
                    }
                }
                if($ctrlProdutos == 0){
                    echo "<h3 class='mensagem-no-result'><i class='fas fa-search'></i> Nenhum produto foi encontrado</h3>";
                }
                echo "</div>";
            echo "</section>";
            /*END DISPLAY TODOS PRODUTO DA VITRINE*/
        }

        private function vitrine_categorias($condicao = ""){
            /*SET */
            $tabela_categorias = $this->global_vars["tabela_categorias"];
            $tabela_categorias_vitrine = $this->global_vars["tabela_categoria_destaque"];
            $condicao = "status = 1";
            $totalMain = $this->pew_functions->contar_resultados($tabela_categorias_vitrine, $condicao);
            $ctrlCategorias = 0;
            $limitCategorias = 4;
            
            if($totalMain > 0){
                echo "<section class='vitrine-categorias'>";
                    if($this->titulo_vitrine != null){
                        echo "<div class='titulo-vitrine'>".$this->titulo_vitrine."</div>";
                    }
                
                    function listar_categoria($titulo, $desc, $img, $ref, $type){
                        $dirImagens = "imagens/categorias/destaques";
                        $urlRedirect = "categoria/$ref/";
                        switch($type){
                            case "normal":
                                echo "<div class='box-categoria box'>";
                                    echo "<div class='informacoes'>";
                                    echo "<a href='$urlRedirect'><img src='$dirImagens/$img'></a>";
                                    echo "<h2 class='titulo'>$titulo</h2>";
                                    echo "<h3 class='descricao'>$desc</h3>";
                                    echo "<a href='$urlRedirect' class='call-to-action'>CONFIRA</a>";
                                    echo "</div>";
                                echo "</div>";
                                break;
                            case "normal_alter":
                                echo "<span class='alter-spacing'></span>";
                                    echo "<div class='box-categoria box'>";
                                    echo "<div class='informacoes'>";
                                    echo "<a href='$urlRedirect'><img src='$dirImagens/$img'></a>";
                                    echo "<h2 class='titulo'>$titulo</h2>";
                                    echo "<h3 class='descricao'>$desc</h3>";
                                    echo "<a href='$urlRedirect' class='call-to-action'>CONFIRA</a>";
                                    echo "</div>";
                                echo "</div>";
                                break;
                            case "double_1":
                                echo "<div class='box-categoria-dupla'>";
                                echo "<div class='box'>";
                                    echo "<div class='informacoes'>";
                                    echo "<a href='$urlRedirect'><img src='$dirImagens/$img'></a>";
                                    echo "<h2 class='titulo'>$titulo</h2>";
                                    echo "<h3 class='descricao'>$desc</h3>";
                                    echo "<a href='$urlRedirect' class='call-to-action'>CONFIRA</a>";
                                    echo "</div>";
                                echo "</div>";
                                break;
                            case "double_2":
                                echo "<div class='box'>";
                                    echo "<div class='informacoes'>";
                                    echo "<a href='$urlRedirect'><img src='$dirImagens/$img'></a>";
                                    echo "<h2 class='titulo'>$titulo</h2>";
                                    echo "<h3 class='descricao'>$desc</h3>";
                                    echo "<a href='$urlRedirect' class='call-to-action'>CONFIRA</a></div>";
                                    echo "</div>";
                                echo "</div>";
                                break;
                        }
                    }
                
                    $queryCatDestaque = mysqli_query($this->conexao(), "select * from $tabela_categorias_vitrine where $condicao limit $limitCategorias");
                    while($infoCatDestaque = mysqli_fetch_array($queryCatDestaque)){
                        $idCategoriaMain = $infoCatDestaque["id_categoria"];
                        $imagemCatDestaque = $infoCatDestaque["imagem"];
                        $condicaoCat = "id = '$idCategoriaMain'";
                        $totalCat = $this->pew_functions->contar_resultados($tabela_categorias, $condicaoCat);
                        if($totalCat > 0){
                            $queryInfoCategoria = mysqli_query($this->conexao(), "select categoria, ref, descricao from $tabela_categorias where $condicaoCat");
                            $infoCategoria = mysqli_fetch_array($queryInfoCategoria);
                            $tituloCat = $infoCategoria["categoria"];
                            $refCat = $infoCategoria["ref"];
                            $descricaoCat = $infoCategoria["descricao"];
                            $refDouble = $totalMain < $limitCategorias ? "normal" : "double_$ctrlCategorias";
                            $refNormal = $totalMain < $limitCategorias && $ctrlCategorias == 0 ? "normal_alter" : "normal";
                            switch($ctrlCategorias){
                                case 1:
                                    $type = $refDouble;
                                    break;
                                case 2:
                                    $type = $refDouble;
                                    break;
                                default:
                                    $type = $refNormal;
                            }
                            listar_categoria($tituloCat, $descricaoCat, $imagemCatDestaque, $refCat, $type);
                            $ctrlCategorias++;
                        }
                    }
                echo "</section>";
            }
        }

        public function vitrine_carrossel($arrayProdutos = array()){
            $tabela_cores = $this->global_vars["tabela_cores"];
            $conexao = $this->global_vars["conexao"];
            $functions = $this->pew_functions;
            $cls_paginas = new Paginas();
            
            
            $ctrlProdutos = 0;
            
            if(!function_exists("listar_produto")){
                function listar_produto($idProduto, $tb_cores = "pew_cores"){
                    global $conexao, $functions, $ctrlProdutos, $cls_paginas;
                    $pew_functions = new systemFunctions();
                    /*STANDARD VARS*/
                    $nomeLoja = $cls_paginas->empresa;
                    $dirImagensProdutos = "imagens/produtos";
                    /*END STANDARD VARS*/

                    $produto = new Produtos();
                    $produto->montar_produto($idProduto);
                    $infoProduto = $produto->montar_array();
                    $infoCoresRelacionadas = $produto->get_cores_relacionadas();
                    /*VARIAVEIS DO PRODUTO*/
                    $imagens = $infoProduto["imagens"];
                    $qtdImagens = count($imagens);
                    if($qtdImagens > 0){
                        $imagemPrincipal = $imagens[0];
                        $srcImagem = $imagemPrincipal["src"];
                        if(!file_exists($dirImagensProdutos."/".$srcImagem) || $srcImagem == ""){
                            $srcImagem = "produto-padrao.png";
                        }
                    }else{
                        $srcImagem = "produto-padrao.png";
                    }
                    $nome = $infoProduto["nome"];
                    $nomeURL = $pew_functions->url_format($nome);
                    $maxCaracteres = 31;
                    $nomeEllipses = strlen(str_replace(" ", "", $nome)) > $maxCaracteres ? trim(substr($nome, 0, $maxCaracteres))."..." : $nome;
                    $qtdParcelas = 6;
                    $txtParcelas = $qtdParcelas."x";
                    
                    $infoCompreJunto = $produto->get_preco_relacionado($idProduto);
                    $intPorcentoDesconto = ($infoCompreJunto["desconto"] * 100) / 100;
                    $multiplicador = $intPorcentoDesconto * 0.01;
                    $preco = $infoProduto["preco"];
                    $precoPromocao = $infoProduto["preco_promocao"];
                    $promocaoAtiva = $infoProduto["promocao_ativa"] == 1 ? true : false;
                    
                    $promoAtiva = $precoPromocao > 0 && $precoPromocao < $preco && $promocaoAtiva == true ? true : false;
                    
                    $precoFinal = $promocaoAtiva == true ? $precoPromocao : $preco;
                    
                    $precoParcela = $precoFinal / $qtdParcelas;
                    
                    $desconto = $precoFinal * $multiplicador;
                    $precoCompreJunto = $precoFinal - $desconto;
                        
                    $urlProduto = "$nomeURL/$idProduto/";
                    /*END VARIAVEIS DO PRODUTO*/
                    
                    /*DISPLAY DO PRODUTO*/
                    echo "<div class='box-produto'>";
                        if($intPorcentoDesconto > 0){
                            echo "<div class='promo-tag'>-$intPorcentoDesconto%</div>";
                            $promoAtiva = true;
                            $precoParcela = $precoCompreJunto / $qtdParcelas;
                        }
                    
                        switch($promoAtiva){
                            case true:
                                $priceField = "<span class='view-preco'>De <span class='promo-price'>R$".number_format($preco, 2, ",", ".")."</span></span> por <span class='view-preco'><span class='price'>R$".number_format($precoCompreJunto, 2, ",", ".")."</span></span>";
                                break;
                            default:
                                $priceField = "<span class='view-preco'><span class='price'>R$".number_format($precoCompreJunto, 2, ",", ".")."</span></span>";
                        }
                        echo "<a href='$urlProduto'><img src='$dirImagensProdutos/$srcImagem' title='$nome' alt='$nome - $nomeLoja'></a>";
                        echo "<a href='$urlProduto' class='title-link'><h3 class='titulo-produto' title='$nome'>$nomeEllipses</h3></a>";
                            echo "<h4 class='preco-produto'>$priceField ou <span class='view-parcelas'>$txtParcelas R$". number_format($precoParcela, 2, ",", ".") ."   </span></h4>";
                        echo "<a class='call-to-action botao-add-compre-junto' carrinho-id-produto='$idProduto'>Adicionar</a>";
                        echo "<div class='display-cores'>";
                            if(is_array($infoCoresRelacionadas) and count($infoCoresRelacionadas) > 0){
                                foreach($infoCoresRelacionadas as $id => $info){
                                    $idRelacao = $info["id_relacao"];
                                    $produtoRelacao = new Produtos();
                                    $produtoRelacao->montar_produto($idRelacao);
                                    $infoProduto = $produtoRelacao->montar_array();
                                    $nomeProduto = $infoProduto["nome"];
                                    $nomeURL = $pew_functions->url_format($nomeProduto);
                                    $idCor = $infoProduto["id_cor"];
                                    $functions = new systemFunctions();
                                    $totalCores = $functions->contar_resultados($tb_cores, "id = '$idCor' and status = 1");
                                    $urlProdutoRelacao = "$nomeURL/$idRelacao/";
                                    $dirImagens = "imagens/cores";
                                    if($totalCores > 0){
                                        $queryCor = mysqli_query($conexao, "SELECT * FROM $tb_cores where id = '$idCor' and status = 1");
                                        while($infoCor = mysqli_fetch_assoc($queryCor)){
                                            $nomeCor = $infoCor["cor"];
                                            $imagemCor = $infoCor["imagem"];
                                            if(!file_exists($dirImagens."/".$imagemCor) || $imagemCor == ""){
                                                $imagemCor = "cor-padrao.png";
                                            }
                                            echo "<a href='$urlProdutoRelacao'><img class='cor' title='$nomeCor' src='$dirImagens/$imagemCor'></a>";
                                        }
                                    }
                                }
                            }
                        echo "</div>";
                    echo "</div>";
                    /*END DISPLAY DO PRODUTO*/
                    $ctrlProdutos++;
                }
            }

            /*DISPLAY TODOS PRODUTO DA VITRINE*/
            echo "<section class='vitrine-carrossel'>";
                echo "<h2 class='titulo-vitrine'>".$this->titulo_vitrine."</h2>";
                if($this->descricao_vitrine != "" && $this->descricao_vitrine != false){
                    echo "<article class='descricao-vitrine'>".$this->descricao_vitrine."</article>";
                }
                echo "<div class='display-produtos'>";
                
                if(count($arrayProdutos) > 0){
                    foreach($arrayProdutos as $idProduto){
                        listar_produto($idProduto, $tabela_cores);
                    }
                }
                    
            
                if($ctrlProdutos == 0){
                    echo "<h3 class='mensagem-no-result'><i class='fas fa-search'></i> Nenhum produto foi encontrado</h3>";
                }
                echo "</div>";
                echo "<div class='controller-carrossel'>";
                    echo "<div class='arrows right-arrow'><i class='fas fa-angle-left'></i></div>";
                    echo "<div class='arrows left-arrow'><i class='fas fa-angle-right'></i></div>";
                echo "</div>";
            echo "</section>";
            /*END DISPLAY TODOS PRODUTO DA VITRINE*/
        }

        public function montar_vitrine($arrayProdutos = ""){
            $tipoVitrine = $this->tipo;
            switch($tipoVitrine){
                case "categorias":
                    $this->vitrine_categorias($arrayProdutos);
                    break;
                case "carrossel":
                    $this->vitrine_carrossel($arrayProdutos);
                    break;
                case "interna-produto":
                    $this->vitrine_interna($arrayProdutos);
                    break;
                case "standard":
                    $this->vitrine_standard($arrayProdutos);
                    break;
                default:
                    $this->tipo = "INDEFINIDO";
                    echo "Tipo de vitrine inválido";
            }
        }
    }

    if(isset($_POST["acao_vitrine"])){
        $acao = $_POST["acao_vitrine"];
        
        switch($acao){
            case "get_box_produto":
                $cls_produto_acao = new Produtos();
                $cls_vitrine_acao = new VitrineProdutos();
                
                if(isset($_POST["produtos"])){
                    $produtos = $_POST["produtos"];
                    
                    foreach($produtos as $idProduto){
                        $cls_produto_acao->montar_produto($idProduto);
                        $infoProduto = $cls_produto_acao->montar_array();
                        $infoCoresRelacionadas = $cls_produto_acao->get_cores_relacionadas();
                        $infoProduto["id_produto"] = $idProduto;
                        $infoProduto["info_cores"] = $infoCoresRelacionadas;

                        echo $cls_vitrine_acao->create_box_produto($infoProduto);
                    }
                    
                }
                
        }
    }