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

        private function vitrine_standard($condicao = 1){
            if(!function_exists("listar_produto")){
                function listar_produto($idProduto){
                    /*STANDARD VARS*/
                    $nomeLoja = "BOLSAS EM COURO";
                    $dirImagensProdutos = "imagens/produtos";
                    /*END STANDARD VARS*/

                    $produto = new Produtos();
                    $produto->montar_produto($idProduto);
                    $infoProduto = $produto->montar_array();

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
                    $maxCaracteres = 31;
                    $nomeEllipses = strlen(str_replace(" ", "", $nome)) > $maxCaracteres ? trim(substr($nome, 0, $maxCaracteres))."..." : $nome;
                    $qtdParcelas = 6;
                    $txtParcelas = $qtdParcelas."x";
                    $preco = $infoProduto["preco"];
                    $precoPromocao = $infoProduto["preco_promocao"];
                    $promoAtiva = $precoPromocao > 0 && $precoPromocao < $preco ? true : false;
                    $precoParcela = $promoAtiva == true ? $precoPromocao / $qtdParcelas : $preco / $qtdParcelas;
                    $priceField = $promoAtiva == true ? "<span class='view-preco'>De <span class='promo-price'>R$".number_format($preco, 2, ",", ".")."</span></span> por <span class='view-preco'><span class='price'>R$".number_format($precoPromocao, 2, ",", ".")."</span></span>" : "<span class='view-preco'><span class='price'>R$ ". number_format($preco, 2, ",", ".")."</span></span>";
                    $urlProduto = "interna-produto.php?id_produto=$idProduto";
                    /*END VARIAVEIS DO PRODUTO*/

                    /*DISPLAY DO PRODUTO*/
                    echo "<div class='box-produto'>";
                        echo "<a href='$urlProduto'><img src='$dirImagensProdutos/$srcImagem' title='$nome' alt='$nome - $nomeLoja'></a>";
                        echo "<a href='$urlProduto' class='title-link'><h3 class='titulo-produto' title='$nome'>$nomeEllipses</h3></a>";
                        echo "<h4 class='preco-produto'>$priceField ou <span class='view-parcelas'>$txtParcelas R$". number_format($precoParcela, 2, ",", ".") ."</span></h4>";
                        echo "<a href='$urlProduto' class='call-to-action'>COMPRAR</a>";
                        echo "<div class='display-cores'>";
                            echo "<div class='cor' title='Titulo da cor'></div>";
                            echo "<div class='cor' title='Titulo da cor'></div>";
                        echo "</div>";
                    echo "</div>";
                    /*END DISPLAY DO PRODUTO*/
                }
            }

            /*DISPLAY TODOS PRODUTO DA VITRINE*/
            echo "<section class='vitrine-standard'>";
                $tituloVitrine = $this->titulo_vitrine;
                $substrTitulo = substr($tituloVitrine, 0, 3);
                $updatedTitulo = null;
                switch($substrTitulo){
                    case "<h1":
                        $updatedTitulo = "<h1 class='titulo-vitrine'>".$this->titulo_vitrine."</h1>";
                        break;
                    case "<h3":
                        $updatedTitulo = "<h3 class='titulo-vitrine'>".$this->titulo_vitrine."</h3>";
                        break;
                }
                if($updatedTitulo != null){
                    echo $updatedTitulo;
                }else{
                    echo "<h2 class='titulo-vitrine'>".$this->titulo_vitrine."</h2>";
                }
                if($this->descricao_vitrine != "" && $this->descricao_vitrine != false){
                    echo "<article class='descricao-vitrine'>".$this->descricao_vitrine."</article>";
                }
                echo "<div class='display-produtos'>";
                $except_ids = "";
                $ctrlProdutos = 0;
                for($i = 1; $i <= $this->limite_produtos; $i++){
                    $produto = new Produtos();
                    $idProduto = $produto->query_produto("status = 1 $except_ids");
                    if($idProduto != false){
                        //$except_ids .= " and id != '$idProduto'"; # Exeto os produtos já selecionados #
                        listar_produto($idProduto);
                        $ctrlProdutos++;
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
                
                    function listar_categoria($img, $ref, $type){
                        $dirImagens = "imagens/categorias/destaques";
                        $urlRedirect = "loja.php?categoria=$ref";
                        switch($type){
                            case "normal":
                                echo "<div class='box-categoria'><a href='$urlRedirect'><img src='$dirImagens/$img'></a><a href='$urlRedirect' class='call-to-action'>CONFIRA</a></div>";
                                break;
                            case "normal_alter":
                                echo "<span class='alter-spacing'></span>";
                                echo "<div class='box-categoria'><a href='$urlRedirect'><img src='$dirImagens/$img'></a><a href='$urlRedirect' class='call-to-action'>CONFIRA</a></div>";
                                break;
                            case "double_1":
                                echo "<div class='box-categoria-dupla'>";
                                echo "<div class='box'><a href='$urlRedirect'><img src='$dirImagens/$img'></a><a href='$urlRedirect' class='call-to-action'>CONFIRA</a></div>";
                                break;
                            case "double_2":
                                echo "<div class='box'><a href='$urlRedirect'><img src='$dirImagens/$img'></a><a href='$urlRedirect' class='call-to-action'>CONFIRA</a></div>";
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
                            $queryInfoCategoria = mysqli_query($this->conexao(), "select categoria, ref from $tabela_categorias where $condicaoCat");
                            $infoCategoria = mysqli_fetch_array($queryInfoCategoria);
                            $tituloCat = $infoCategoria["categoria"];
                            $refCat = $infoCategoria["ref"];
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
                            listar_categoria($imagemCatDestaque, $refCat, $type);
                            $ctrlCategorias++;
                        }
                    }
                echo "</section>";
            }
        }

        public function vitrine_carrossel(){
            if(!function_exists("listar_produto")){
                function listar_produto($idProduto){
                    /*STANDARD VARS*/
                    $nomeLoja = "BOLSAS EM COURO";
                    $dirImagensProdutos = "imagens/produtos";
                    /*END STANDARD VARS*/

                    $produto = new Produtos();
                    $produto->montar_produto($idProduto);
                    $infoProduto = $produto->montar_array();

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
                    $maxCaracteres = 31;
                    $nomeEllipses = strlen(str_replace(" ", "", $nome)) > $maxCaracteres ? trim(substr($nome, 0, $maxCaracteres))."..." : $nome;
                    $qtdParcelas = 6;
                    $txtParcelas = $qtdParcelas."x";
                    $preco = $infoProduto["preco"];
                    $precoPromocao = $infoProduto["preco_promocao"];
                    $promoAtiva = $precoPromocao > 0 && $precoPromocao < $preco ? true : false;
                    $precoParcela = $promoAtiva == true ? $precoPromocao / $qtdParcelas : $preco / $qtdParcelas;
                    $priceField = $promoAtiva == true ? "<span class='view-preco'>De <span class='promo-price'>R$".number_format($preco, 2, ",", ".")."</span></span> por <span class='view-preco'><span class='price'>R$".number_format($precoPromocao, 2, ",", ".")."</span></span>" : "<span class='view-preco'><span class='price'>R$ ". number_format($preco, 2, ",", ".")."</span></span>";
                    $urlProduto = "interna-produto.php?id_produto=$idProduto";
                    /*END VARIAVEIS DO PRODUTO*/

                    /*DISPLAY DO PRODUTO*/
                    echo "<div class='box-produto'>";
                        echo "<a href='$urlProduto'><img src='$dirImagensProdutos/$srcImagem' title='$nome' alt='$nome - $nomeLoja'></a>";
                        echo "<a href='$urlProduto' class='title-link'><h3 class='titulo-produto' title='$nome'>$nomeEllipses</h3></a>";
                        echo "<h4 class='preco-produto'>$priceField ou <span class='view-parcelas'>$txtParcelas R$". number_format($precoParcela, 2, ",", ".") ."</span></h4>";
                        echo "<a href='$urlProduto' class='call-to-action'>COMPRAR</a>";
                        echo "<div class='display-cores'>";
                            echo "<div class='cor' title='Titulo da cor'></div>";
                            echo "<div class='cor' title='Titulo da cor'></div>";
                        echo "</div>";
                    echo "</div>";
                    /*END DISPLAY DO PRODUTO*/
                }
            }

            /*DISPLAY TODOS PRODUTO DA VITRINE*/
            echo "<section class='vitrine-carrossel'>";
                echo "<h2 class='titulo-vitrine'>".$this->titulo_vitrine."</h2>";
                if($this->descricao_vitrine != "" && $this->descricao_vitrine != false){
                    echo "<article class='descricao-vitrine'>".$this->descricao_vitrine."</article>";
                }
                echo "<div class='display-produtos'>";
                $except_ids = "";
                $ctrlProdutos = 0;
                for($i = 1; $i <= $this->limite_produtos; $i++){
                    $produto = new Produtos();
                    $idProduto = $produto->query_produto("status = 1 $except_ids");
                    if($idProduto != false){
                        //$except_ids .= " and id != '$idProduto'"; # Exeto os produtos já selecionados #
                        listar_produto($idProduto);
                        $ctrlProdutos++;
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

        public function montar_vitrine($condicao = ""){
            $tipoVitrine = $this->tipo;
            switch($tipoVitrine){
                case "categorias":
                    $this->vitrine_categorias($condicao);
                    break;
                case "carrossel":
                    $this->vitrine_carrossel($condicao);
                    break;
                case "interna-produto":
                    $this->vitrine_interna($condicao);
                    break;
                case "standard":
                    $this->vitrine_standard($condicao);
                    break;
                default:
                    $this->tipo = "INDEFINIDO";
                    echo "Tipo de vitrine inválido";
            }
        }
    }
?>
