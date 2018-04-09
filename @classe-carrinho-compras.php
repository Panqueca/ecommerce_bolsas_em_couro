<?php
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
            $this->ctrl_produtos = count($_SESSION["carrinho"]) > 0 ? count($_SESSION["carrinho"]) : 0;
            
            global $pew_functions, $globalVars;
            $this->classe_produtos = new Produtos();
            $this->pew_functions = $pew_functions;
            $this->global_vars = $globalVars;
        }
        
        function verify_session(){
            if(!isset($_SESSION)) session_start();
            
            if(!isset($_SESSION["carrinho"])) $_SESSION["carrinho"] = array();
        }
        
        function atualizar_carrinho(){
            $this->verify_session();
            $carrinho = $_SESSION["carrinho"];
            $totalCarrinho = 0;
            foreach($carrinho as $infoProdutos){
                $totalCarrinho += $infoProduto["preco"];
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
                    $_SESSION["carrinho"][$count]["id"] = $id;
                    $_SESSION["carrinho"][$count]["nome"] = $nome;
                    $_SESSION["carrinho"][$count]["preco"] = $preco;
                    $_SESSION["carrinho"][$count]["estoque"] = $estoque;
                    $_SESSION["carrinho"][$count]["quantidade"] = $quantidade;
                    $_SESSION["carrinho"][$count]["comprimento"] = $comprimento;
                    $_SESSION["carrinho"][$count]["largura"] = $largura;
                    $_SESSION["carrinho"][$count]["altura"] = $altura;
                    $_SESSION["carrinho"][$count]["peso"] = $peso;
                }
                
                $is_adicionado = false;
                $indice_item = null;
                foreach($_SESSION["carrinho"] as $indice => $item){
                    $idItem = $item["id"];
                    if($idItem == $idProduto){
                        $is_adicionado = true;
                        $indice_item = $indice;
                    }
                }
                
                if($infoProduto["estoque"] > 0 && $infoProduto["estoque"] >= $quantidade && $is_adicionado == false){
                    
                    set_produto($infoProduto["id"], $infoProduto["nome"], $precoFinal, $infoProduto["estoque"], $quantidade, $infoProduto["comprimento"], $infoProduto["largura"], $infoProduto["altura"], $infoProduto["peso"], $this->ctrl_produtos);
                    $this->ctrl_produtos++;
                    return true;
                    
                }else if($is_adicionado == true){
                    
                    set_produto($infoProduto["id"], $infoProduto["nome"], $precoFinal, $infoProduto["estoque"], $quantidade, $infoProduto["comprimento"], $infoProduto["largura"], $infoProduto["altura"], $infoProduto["peso"], $indice_item);
                    return true;
                    
                }else{
                    return "sem_estoque";
                }
            }else{
                return false;
            }
        }
        
        function get_carrinho(){
            $this->verify_session();
            return $_SESSION["carrinho"];
        }
        
        function reset_carrinho(){
            $this->verify_session();
            unset($_SESSION["carrinho"]);
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
                        case true:
                            $retorno = "true";
                            break;
                        case "sem_estoque":
                            $retorno = "sem_estoque";
                            break;
                        default:
                            $retorno = "false";
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
            echo "<h4 class='cart-title'>Sua Bolsa</h4>";
                echo "<div class='display-itens'>";
                $cls_carrinho = new Carrinho();
                $carrinho = $cls_carrinho->get_carrinho();
                $totalCarrinho = 0;
                if(count($carrinho) > 0){
                    foreach($carrinho as $item){
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
                    echo "<div align=center>Bolsa vazia</div>";
                }
                echo "</div>";
                echo "<div class='cart-bottom'>";
                    echo "<span class='total-price'>TOTAL: <span class='price-view'>R$ {$pew_functions->custom_number_format($totalCarrinho)}</span></span><br>";
                    echo "<a href='finalizar-compra.php' class='finalize-button'>Finalizar compra</a>";
                echo "</div>";
        }else if($acao == "remover_produto"){
            $idProduto = isset($_POST["id_produto"]) ? (int)$_POST["id_produto"] : 0;
            if($idProduto > 0){
                $carrinho = $cls_carrinho->get_carrinho();
                foreach($carrinho as $indice => $item){
                    $id = $item["id"];
                    if($idProduto == $id){
                        unset($_SESSION["carrinho"][$indice]);
                    }
                }
                echo "true";
            }else{
                echo "false";
            }
        }
    }

    // session_destroy();