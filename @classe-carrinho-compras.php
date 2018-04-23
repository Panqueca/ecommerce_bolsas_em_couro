<?php
    ini_set('memory_limit', '-1');

    require_once "@include-global-vars.php";
    require_once "@classe-system-functions.php";
    require_once "@classe-produtos.php";
    class Carrinho{
        private $produtos = array();
        private $ctrl_produtos = 0;
        private $info_frete = array();
        private $valor_total;
        private $status;
        private $classe_produtos;
        public $pew_functions;
        public $global_vars;
        
        function __construct(){
            $this->verify_session();
            $this->valor_total = 0;
            $this->status = "vazio";
            $this->ctrl_produtos = count($_SESSION["carrinho_orcamento"]["itens"]) > 0 ? count($_SESSION["carrinho_orcamento"]["itens"]) : 0;
            
            global $pew_functions, $globalVars;
            $this->classe_produtos = new Produtos();
            $this->pew_functions = $pew_functions;
            $this->global_vars = $globalVars;
            $this->set_token();
        }
        
        function conexao(){
            return $this->global_vars["conexao"];
        }
        
        function rand_token(){
            return "CTK" . substr(md5(time()), 0, 10);
        }
        
        function set_token(){
            if(!isset($_SESSION["carrinho_orcamento"]["token"]) || $_SESSION["carrinho_orcamento"]["token"] == null){
                $_SESSION["carrinho_orcamento"]["token"] = $this->rand_token();
            }
        }
        
        function verify_session(){
            if(!isset($_SESSION)) session_start();
            
            if(!isset($_SESSION["carrinho_orcamento"])){
                $_SESSION["carrinho_orcamento"] = array();   
                $_SESSION["carrinho_orcamento"]["itens"] = array();
            }
            
            if(!isset($_SESSION["carrinho_orcamento"]["token"]) || $_SESSION["carrinho_orcamento"]["token"] == null){
                $this->set_token();
            }
        }
        
        function add_produto($idProduto, $quantidade = 1){
            $tabela_produtos = $this->global_vars["tabela_produtos"];
            $total = $this->pew_functions->contar_resultados($tabela_produtos, "id = '$idProduto'");
            $quantidade = $quantidade == 0 ? 1 : $quantidade;
            
            if($total > 0){
                $this->classe_produtos->montar_produto($idProduto);
                $infoProduto = $this->classe_produtos->montar_array();
                
                $precoBruto = $infoProduto["preco"];
                $precoPromocao = $infoProduto["preco_promocao"];
                $promocaoAtiva = $infoProduto["promocao_ativa"];
                
                $precoFinal = $promocaoAtiva == 1 && $precoPromocao < $precoBruto && $precoPromocao > 0 ? $precoPromocao : $precoBruto;
                $this->verify_session();
                
                function set_produto($id, $nome, $preco, $estoque, $quantidade, $comprimento, $largura, $altura, $peso, $count){
                    $_SESSION["carrinho_orcamento"]["itens"][$count]["id"] = $id;
                    $_SESSION["carrinho_orcamento"]["itens"][$count]["nome"] = $nome;
                    $_SESSION["carrinho_orcamento"]["itens"][$count]["preco"] = $preco;
                    $_SESSION["carrinho_orcamento"]["itens"][$count]["estoque"] = $estoque;
                    $_SESSION["carrinho_orcamento"]["itens"][$count]["quantidade"] = $quantidade;
                    $_SESSION["carrinho_orcamento"]["itens"][$count]["comprimento"] = $comprimento;
                    $_SESSION["carrinho_orcamento"]["itens"][$count]["largura"] = $largura;
                    $_SESSION["carrinho_orcamento"]["itens"][$count]["altura"] = $altura;
                    $_SESSION["carrinho_orcamento"]["itens"][$count]["peso"] = $peso;
                }
                
                $is_adicionado = false;
                $indice_item = null;
                foreach($_SESSION["carrinho_orcamento"]["itens"] as $indice => $item){
                    $idItem = $item["id"];
                    if($idItem == $idProduto){
                        $is_adicionado = true;
                        $indice_item = $indice;
                    }
                }
                
                
                if($infoProduto["estoque"] > 0 && $quantidade <= $infoProduto["estoque"] && $is_adicionado == false){
                    set_produto($infoProduto["id"], $infoProduto["nome"], $precoFinal, $infoProduto["estoque"], $quantidade, $infoProduto["comprimento"], $infoProduto["largura"], $infoProduto["altura"], $infoProduto["peso"], $this->ctrl_produtos);
                    $this->ctrl_produtos++;
                    return "true";
                    
                }else if($is_adicionado == true && $quantidade <= $infoProduto["estoque"]){
                    set_produto($infoProduto["id"], $infoProduto["nome"], $precoFinal, $infoProduto["estoque"], $quantidade, $infoProduto["comprimento"], $infoProduto["largura"], $infoProduto["altura"], $infoProduto["peso"], $indice_item);
                    return "true";
                    
                }else if($infoProduto["estoque"] > 0){
                    set_produto($infoProduto["id"], $infoProduto["nome"], $precoFinal, $infoProduto["estoque"], $infoProduto["estoque"], $infoProduto["comprimento"], $infoProduto["largura"], $infoProduto["altura"], $infoProduto["peso"], $indice_item);
                    return $infoProduto["estoque"];
                }else{
                    return "sem_estoque";
                }
            }else{
                return "false";
            }
            
            $this->reordenar_carrinho();
        }
        
        function remover_produto($idRemover){
            $this->verify_session();
            
            foreach($_SESSION["carrinho_orcamento"]["itens"] as $indice => $item){
                $id = $item["id"];
                if($idRemover == $id){
                    unset($_SESSION["carrinho_orcamento"]["itens"][$indice]);
                    $this->reordenar_carrinho();
                }
            }
        }
        
        function get_token_carrinho(){
            $this->verify_session();
            return $_SESSION["token"];
        }
        
        function get_carrinho(){
            $this->verify_session();
            $carrinho = array();
            $carrinho["itens"] = array();
            $carrinho["token"] = $_SESSION["carrinho_orcamento"]["token"];
            
            
            $ctrl = 0;
            
            foreach($_SESSION["carrinho_orcamento"]["itens"] as $itens){
                $idProduto = $itens["id"];
                $selectedRelacionados = $this->classe_produtos->get_relacionados_produto($idProduto, "id_relacionado = '$idProduto'");
                $is_compre_junto = false;
                
                
                $carrinho["itens"][$ctrl] = $itens;
                
                if(is_array($selectedRelacionados)){
                    $selected = array();
                    $ctrlInterno = 0;
                    
                    foreach($selectedRelacionados as $idRelacionado){
                        $selected[$ctrlInterno] = $idRelacionado;
                        $ctrlInterno++;
                    }
                    
                    foreach($_SESSION["carrinho_orcamento"]["itens"] as $index => $valor){
                        foreach($selected as $index => $infoRel){
                            if($valor["id"] == $infoRel["id_produto"]){
                                $is_compre_junto = true;
                            }
                        }
                    }
                }
                
                if($is_compre_junto){
                    $infoPrecoRelacionado = $this->classe_produtos->get_preco_relacionado($idProduto);
                    $carrinho["itens"][$ctrlInterno]["preco"] = $this->pew_functions->custom_number_format($infoPrecoRelacionado["valor"]);
                    $carrinho["itens"][$ctrlInterno]["desconto"] = $infoPrecoRelacionado["desconto"];
                }
                    
                $ctrl++;
            }
            
            return $carrinho;
        }
        
        function reset_carrinho(){
            $this->verify_session();
            unset($_SESSION["carrinho_orcamento"]);
        }
        
        function reordenar_carrinho(){
            $this->verify_session();
            $carrinho = $_SESSION["carrinho_orcamento"]["itens"];
            
            $reorderedCarrinho = array();
            $ctrl = 0;
            
            foreach($carrinho as $item){
                $reorderedCarrinho[$ctrl] = $item;
                $ctrl++;
            }
            
            $_SESSION["carrinho_orcamento"]["itens"] = $reorderedCarrinho;
            
            return true;
        }
        
        function rebuild_carrinho($token){
            $tabela_carrinhos = $this->global_vars["tabela_carrinhos"];
            $tabela_orcamentos = $this->global_vars["tabela_orcamentos"];
            $this->verify_session();
            
            $total = $this->pew_functions->contar_resultados($tabela_carrinhos, "token_carrinho = '$token'");
            if($total > 0){
                $carrinho = array();
                $carrinho["token"] = $this->rand_token();
                $carrinho["itens"] = array();
                $ctrlProdutos = 0;
                
                $is_orcamento = $this->pew_functions->contar_resultados($tabela_orcamentos, "token_carrinho = '$token'") > 0 ? true : false;
                
                $cls_produtos = new Produtos();
                
                
                $query = mysqli_query($this->conexao(), "select * from $tabela_carrinhos where token_carrinho = '$token'");
                
                while($array = mysqli_fetch_array($query)){
                    if($cls_produtos->montar_produto($array["id_produto"])){
                        $infoProduto = $cls_produtos->montar_array();
                        
                        $carrinho["itens"][$ctrlProdutos] = array();
                        $carrinho["itens"][$ctrlProdutos]["id"] = $array["id_produto"];
                        $carrinho["itens"][$ctrlProdutos]["nome"] = $array["nome_produto"];
                        $carrinho["itens"][$ctrlProdutos]["preco"] = $array["preco_produto"];
                        $carrinho["itens"][$ctrlProdutos]["estoque"] = $infoProduto["estoque"];
                        $carrinho["itens"][$ctrlProdutos]["quantidade"] = $array["quantidade_produto"];
                        $carrinho["itens"][$ctrlProdutos]["comprimento"] = $infoProduto["comprimento"];
                        $carrinho["itens"][$ctrlProdutos]["largura"] = $infoProduto["largura"];
                        $carrinho["itens"][$ctrlProdutos]["altura"] = $infoProduto["altura"];
                        $carrinho["itens"][$ctrlProdutos]["peso"] = $infoProduto["peso"];
                        $ctrlProdutos++;
                    }
                }
                
                return $carrinho;
                
            }else{
                return false;
            }
        }
    }

    if(isset($_POST["acao_carrinho"])){
        $acao = $_POST["acao_carrinho"];
        $cls_carrinho = new Carrinho();
        
        if($acao == "adicionar_produto"){
            $idProduto = isset($_POST["id_produto"]) ? (int)$_POST["id_produto"] : 0;
            $tabela_produtos = $cls_carrinho->global_vars["tabela_produtos"];
            if($idProduto > 0){
                $quantidade = isset($_POST["quantidade"]) && (int)$_POST["quantidade"] > 0 ? (int)$_POST["quantidade"] : 1;
                $total = $cls_carrinho->pew_functions->contar_resultados($tabela_produtos, "id = '$idProduto'");
                if($total > 0){
                    $addProduto = $cls_carrinho->add_produto($idProduto, $quantidade);
                    switch($addProduto){
                        case "true":
                            $retorno = "true";
                            break;
                        case "sem_estoque":
                            $retorno = "sem_estoque";
                            break;
                        default:
                            $retorno = $addProduto;
                    }
                    echo $retorno;
                }else{
                    echo "false";
                }
            }else{
                echo "false";
            }
        }else if($acao == "get_header_carrinho"){
            require_once "@classe-system-functions.php";
            echo "<h4 class='cart-title'>Seu carrinho</h4>";
                echo "<div class='display-itens'>";
                $cls_carrinho = new Carrinho();
                $carrinho = $cls_carrinho->get_carrinho();
                $totalCarrinho = 0;
                if(count($carrinho["itens"]) > 0){
                    foreach($carrinho["itens"] as $item){
                        $id = $item["id"];
                        $titulo = $item["nome"];
                        $preco = $item["preco"];
                        $quantidade = $item["quantidade"];
                        $total = $preco * $quantidade;
                        $total = $pew_functions->custom_number_format($total);
                        $totalCarrinho += $total;
                        $url = "interna-produto.php?id_produto=$id";
                        echo "<div class='cart-item'>";
                            echo "<span class='item-quantity'>{$quantidade}x</span>";
                            echo "<a href='$url' class='item-name'>$titulo</a>";
                            echo "<span class='item-price'>R$ $total</span>";
                            echo "<button class='remove-button' title='Remover este item' carrinho-id-produto='$id'><i class='fas fa-times'></i></button>";
                        echo "</div>";
                    }
                }else{
                    echo "<div align=center>Carrinho vazio</div>";
                }
                echo "</div>";
                echo "<div class='cart-bottom'>";
                    echo "<span class='total-price'>TOTAL: <span class='price-view'>R$ {$pew_functions->custom_number_format($totalCarrinho)}</span></span><br>";
                    echo "<a href='finalizar-orcamento.php' class='finalize-button'>Solicitar Orçamento</a>";
                echo "</div>";
        }else if($acao == "remover_produto"){
            $idProduto = isset($_POST["id_produto"]) ? (int)$_POST["id_produto"] : 0;
            if($idProduto > 0){
                
                $cls_carrinho->remover_produto($idProduto);
                
                echo "true";
            }else{
                echo "false";
            }
        }else if($acao == "get_quantidade"){
            $carrinho = $cls_carrinho->get_carrinho();
            $itens = $carrinho["itens"];
            $total = 0;
            foreach($itens as $produto){
                $total += $produto["quantidade"];
            }
            echo $total;
        }
    }

    // session_destroy();