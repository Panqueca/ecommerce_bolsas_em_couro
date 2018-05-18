<?php
    require_once "@include-global-vars.php";
    require_once "@classe-system-functions.php";
    require_once "../@classe-minha-conta.php";
    require_once "../@classe-carrinho-compras.php";
    require_once "../@classe-produtos.php";

    class Orcamentos{
        private $id; 
        private $nome_cliente; 
        private $telefone_cliente; 
        private $email_cliente; 
        private $cpf_cliente; 
        private $token_carrinho; 
        private $porcentagem_desconto;
        private $id_vendedor; 
        private $data_pedido;
        private $data_vencimento; 
        private $data_controle; 
        private $modify_controle; 
        private $status;
        private $produtos = array();
        public $global_vars;
        public $pew_functions;
        
        function __construct(){
            global $globalVars, $pew_functions;
            $this->global_vars = $globalVars;
            $this->pew_functions = $pew_functions;
        }
        
        function conexao(){
            return $this->global_vars["conexao"];
        }
        
        function montar($idOrcamento){
            $tabela_orcamentos = $this->global_vars["tabela_orcamentos"];
            $tabela_carrinhos = $this->global_vars["tabela_carrinhos"];
            
            $total = $this->pew_functions->contar_resultados($tabela_orcamentos, "id = '$idOrcamento'");
            if($total > 0){
                $query = mysqli_query($this->conexao(), "select * from $tabela_carrinhos where id = '$idOrcamento'");
                $info = mysqli_fetch_array($query);
                return true;
            }else{
                return false;
            }
        }
        
        function montar_carrinho($arrayProdutos = array(), $desconto = 0){
            if(is_array($arrayProdutos) && count($arrayProdutos) > 0){
                
                $cls_carrinho = new Carrinho();
                $cls_produtos = new Produtos();
                $tokenCarrinho = $cls_carrinho->rand_token();
                
                
                $carrinho = array();
                
                $carrinho["itens"] = array();
                $carrinho["token"] = $tokenCarrinho;
                
                $ctrlProdutos = 0;
                
                foreach($arrayProdutos as $infoProduto){
                    $idProduto = $infoProduto["id"];
                    $quantidade = $infoProduto["quantidade"];
                    
                    $cls_produtos->montar_produto($idProduto);
                    $infoProduto = $cls_produtos->montar_array();
                    
                    $quantidade = $infoProduto["estoque"] > $quantidade ? $quantidade : $infoProduto["estoque"];
                    
                    $preco = $infoProduto["preco_promocao"] > 0 && $infoProduto["preco_promocao"] < $infoProduto["preco"] && $infoProduto["promocao_ativa"] == 1 ? $infoProduto["preco_promocao"] : $infoProduto["preco"];
                    
                    $carrinho["itens"][$ctrlProdutos] = array();
                    $carrinho["itens"][$ctrlProdutos]["id"] = $infoProduto["id"];
                    $carrinho["itens"][$ctrlProdutos]["nome"] = $infoProduto["nome"];
                    $carrinho["itens"][$ctrlProdutos]["estoque"] = $infoProduto["estoque"];
                    $carrinho["itens"][$ctrlProdutos]["quantidade"] = $quantidade;
                    $carrinho["itens"][$ctrlProdutos]["comprimento"] = $infoProduto["comprimento"];
                    $carrinho["itens"][$ctrlProdutos]["largura"] = $infoProduto["largura"];
                    $carrinho["itens"][$ctrlProdutos]["altura"] = $infoProduto["altura"];
                    $carrinho["itens"][$ctrlProdutos]["peso"] = $infoProduto["peso"];
                    if($desconto > 0){
                        $multiplicador = $desconto * 0.01;
                        
                        $totalDesconto = $infoProduto["preco"] * $multiplicador;
                        
                        $carrinho["itens"][$ctrlProdutos]["desconto"] = $desconto;
                        $carrinho["itens"][$ctrlProdutos]["preco"] = $infoProduto["preco"] - $totalDesconto;
                    }else{
                        $carrinho["itens"][$ctrlProdutos]["preco"] = $infoProduto["preco"];
                    }
                    
                    $ctrlProdutos++;
                }
                
                return $carrinho;
                
            }else{
                return false;
            }
        }
        
        function get_total_orcamento($id){
            $tabela_orcamentos = $this->global_vars["tabela_orcamentos"];
            $tabela_carrinhos = $this->global_vars["tabela_carrinhos"];
            
            $query = mysqli_query($this->conexao(), "select token_carrinho from $tabela_orcamentos where id = '$id'");
            $info = mysqli_fetch_array($query);
            
            $tokenCarrinho = $info["token_carrinho"];
            
            $totalOrcamento = 0;
            $queryProdutos = mysqli_query($this->conexao(), "select preco_produto, quantidade_produto from $tabela_carrinhos where token_carrinho = '$tokenCarrinho'");
            while($infoCarrinho = mysqli_fetch_array($queryProdutos)){
                $subtotalProduto = $infoCarrinho["preco_produto"] * $infoCarrinho["quantidade_produto"];
                $totalOrcamento += $subtotalProduto;
            }
            
            return $totalOrcamento;
        }
        
        function montar_email($nome, $produtos, $desconto, $tokenCarrinho){
            $baseSite = "https://efectusdigital.com.br/bolsas";
            $dirImagens = "imagens/identidadeVisual";
            $logo = "logo-bolsa-em-couro.png";
            
            $nomeEmpresa = "Bolsas em Couro";
            
            $body = "";
            
            $strDesconto = $desconto > 0 ? ", você <b>ganhou {$desconto}% de desconto</b> em seu orçamento. " : "";
            
            $body .= "<style type='text/css'>@import url('https://fonts.googleapis.com/css?family=Montserrat');</style>";
            $body .= "<body style='background-color: #eee; font-family: Montserrat, sans-serif;'>";
            $body .= "<div style='width: 380px; margin: 20px auto 20px auto; padding: 20px; background-color: #fff;'>";
                $body .= "<div style='width: 100%; height: 100px; line-height: 80px;'>";
                    $body .= "<img src='$baseSite/$dirImagens/$logo' style='width: 150px; margin-top: 20px; float: left;'>";
                    $body .= "<h1 style='margin: 0px 0px 0px 180px; font-size: 18px; width: 200px; white-space: nowrap; text-align: right;'>Pedido de orçamento</h1>";
                $body .= "</div>";
                $body .= "<div class='body'>";
                    $body .= "<article>Olá {$nome}{$strDesconto}. Veja abaixo os itens de que foram orçados e clique no botão de finalizar compra para acessar seu carrinho no site. $nomeEmpresa agradece!</article>";
                    $body .= "<table style='margin: 30px 0px 20px 0px;'>";
                    $totalOrcamento = 0;
                    foreach($produtos as $infoProduto){
                        $subtotalProduto = $infoProduto["preco"] * $infoProduto["quantidade"];
                        
                        $totalOrcamento += $subtotalProduto;
                        
                        $subtotalProduto = number_format($subtotalProduto, 2, ".", ",");
                        
                        $body .= "<tr>";
                            $body .= "<td style='text-align: center; width: 80px; border-bottom: 1px solid #e2e2e2; padding: 10px 0px 10px 0px;'>{$infoProduto["quantidade"]}x</td>";
                            $body .= "<td style='text-align: center; width: 170px; border-bottom: 1px solid #e2e2e2; padding: 10px 0px 10px 0px;'>{$infoProduto["nome"]}</td>";
                            $body .= "<td style='text-align: right; width: 130px; border-bottom: 1px solid #e2e2e2; padding: 10px 0px 10px 0px;'>R$ $subtotalProduto</td>";
                        $body .= "</tr>";
                    }
            
                    $totalOrcamento = number_format($totalOrcamento, 2, ",", ".");
            
                    $body .= "<tr>";
                        $body .= "<td colspan=3 align=right><br>TOTAL &nbsp;&nbsp;&nbsp;&nbsp; <font style='color: limegreen;'>R$ $totalOrcamento</font></td>";
                    $body .= "</tr>";
                    $body .= "</table>";
                    $body .= "<div class='bottom' align=right>";
                        $body .= "<a href='$baseSite/finalizar-compra.php?token_carrinho=$tokenCarrinho' style='color: #fff; background-color: #6abd45; display: inline-block; padding: 8px 15px 8px 15px; text-decoration: none;' target='_blank'>Finalizar compra</a>";
                    $body .= "</div>";
                $body .= "</div>";
            $body .= "</div>";
            $body .= "</body>";
            
            return $body;
        }
        
        function get_string_status($status){
            switch($status){
                case 1:
                    $retorno = "Configurado pelo vendedor";
                    break;
                case 2:
                    $retorno = "Enviado ao cliente";
                    break;
                case 3:
                    $retorno = "Confirmado";
                    break;
                case 4:
                    $retorno = "Cancelado";
                    break;
                default:
                    $retorno = "Enviado pelo cliente";
            }
            return $retorno;
        }
    }