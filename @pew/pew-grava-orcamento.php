<?php
    session_start();
    $post_fields = array("nome_cliente", "telefone_cliente", "email_cliente", "cpf_cliente", "total_desconto", "total_orcamento");
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
        require_once "@classe-orcamentos.php";
        
        $dataAtual = date("Y-m-d h:i:s");
        /*POST DATA*/
        $nomeCliente = addslashes($_POST["nome_cliente"]);
        $telefoneCliente = addslashes($_POST["telefone_cliente"]);
        $emailCliente = addslashes($_POST["email_cliente"]);
        $cpfCliente = addslashes($_POST["cpf_cliente"]);
        $totalPorcentagemDesconto = floatval($_POST["total_desconto"]);
        $totalOrcamento = floatval($_POST["total_orcamento"]);
        $produtosOrcamento = isset($_POST["produtos_orcamento"]) ? $_POST["produtos_orcamento"] : "";
        /*END POST DATA*/

        /*DIR VARS*/
        $dirImagensProdutos = "../imagens/produtos/";
        /*END DIR VARS*/

        /*SET TABLES*/
        $tabela_orcamentos = $pew_custom_db->tabela_orcamentos;
        $tabela_carrinhos = $pew_custom_db->tabela_carrinhos;
        $tabela_usuarios = $pew_db->tabela_usuarios_administrativos;
        /*END SET TABLES*/

        if(isset($_SESSION["pew_session"])){
            $sessionUsuario = $_SESSION["pew_session"]["usuario"];
            $sessionSenha = $_SESSION["pew_session"]["senha"];
            $contarVendedor = mysqli_query($conexao, "select count(id) as total_vendedor from $tabela_usuarios where usuario = '$sessionUsuario' and senha = '$sessionSenha'");
            $contagem = mysqli_fetch_assoc($contarVendedor);
            $totalVendedor = $contagem["total_vendedor"];
            if($totalVendedor > 0){
                $queryInfoVendedor = mysqli_query($conexao, "select id from $tabela_usuarios where usuario = '$sessionUsuario' and senha = '$sessionSenha'");
                $infoVendedor = mysqli_fetch_array($queryInfoVendedor);
            }
        }else{
            die();
        }

        /*DEFAULT FUNCTIONS*/
        function limpaNumberString($str){
            return preg_replace("/[^0-9]/", "", $str);
        }
        /*END DEFAULT FUNCTIONS*/

        /*VALIDACOES E SQL FUNCTIONS*/
        if($nomeCliente != ""){
            echo "<h3 align=center>Gravando dados...</h3>";

            $tempoEntrega = 30; //FAZER INTEGRAÇÃO CORREIOS
            $idVendedor = $totalVendedor > 0 ? $infoVendedor["id"] : 0;
            $dataVencimento = date("Y-m-d", strtotime($dataAtual . "+30 days"));
            $statusOrcamento = 1;

            /*STANDARD FORMAT CLIENT DATA*/
            $cpfCliente = limpaNumberString($cpfCliente);

            //$refOrcamento = substr(md5($dataAtual.$cpfCliente), 0, 16);
            
            $selectedProdutos = array();
            $ctrlProdutos = 0;

            /*MONTAR PRODUTOS SELECIONADOS*/
            if($produtosOrcamento != ""){
                foreach($produtosOrcamento as $infoProduto){
                    $explodeInfo = explode("||", $infoProduto);
                    $idProduto = $explodeInfo[0];
                    $quantidade = $explodeInfo[1];
                    $selectedProdutos[$ctrlProdutos] = array();
                    $selectedProdutos[$ctrlProdutos]["id"] = $idProduto;
                    $selectedProdutos[$ctrlProdutos]["quantidade"] = $quantidade;
                    $ctrlProdutos++;
                }
            }
            
            $cls_orcamentos = new Orcamentos();
            
            $carrinhoOrcamento = $cls_orcamentos->montar_carrinho($selectedProdutos, $totalPorcentagemDesconto);
            
            $gravar = false;
            
            if(is_array($carrinhoOrcamento) && count($carrinhoOrcamento) > 0){
                $gravar = true;
                
                $tokenCarrinho = $carrinhoOrcamento["token"];
                $itensCarrinho = $carrinhoOrcamento["itens"];
                
                foreach($itensCarrinho as $infoProduto){
                    $idProduto = $infoProduto["id"];
                    $tituloProduto = $infoProduto["nome"];
                    $quantidadeProduto = $infoProduto["quantidade"];
                    $precoProduto = $infoProduto["preco"];
                    
                    mysqli_query($conexao, "insert into $tabela_carrinhos (token_carrinho, id_produto, nome_produto, quantidade_produto, preco_produto, data_controle, status) values ('$tokenCarrinho', '$idProduto', '$tituloProduto', '$quantidadeProduto', '$precoProduto', '$dataAtual', 2)");
                }
                
                $bodyEmail = $cls_orcamentos->montar_email($nomeCliente, $itensCarrinho, $totalPorcentagemDesconto, $tokenCarrinho);
                
                //echo $bodyEmail;
            }
            
            if($gravar){
                /*INSERE DADOS ORCAMENTO*/
                mysqli_query($conexao, "insert into $tabela_orcamentos (nome_cliente, telefone_cliente, email_cliente, cpf_cliente, token_carrinho, porcentagem_desconto, id_vendedor, data_pedido, data_vencimento, data_controle, modify_controle, status_orcamento) values ('$nomeCliente', '$telefoneCliente', '$emailCliente', '$cpfCliente', '$tokenCarrinho', '$totalPorcentagemDesconto', '$idVendedor', '$dataAtual', '$dataVencimento', '$dataAtual', '$idVendedor', '$statusOrcamento')");
                
                echo "<script>window.location.href='pew-orcamentos.php?msg=Orçamento cadastrado com sucesso&msgType=success';</script>";
            }else{
                echo "<script>window.location.href='pew-orcamentos.php?erro=validação_do_orcamento&msg=Ocorreu um erro ao cadastrar o orçamento&msgType=error';</script>";
            }

        }else{
            //Erro de validação = Nome do cliente vazio
            echo "<script>window.location.href='pew-orcamentos.php?erro=validação_do_orcamento&msg=Ocorreu um erro ao cadastrar o orçamento&msgType=error';</script>";
        }
        /*END VALIDACOES E SQL FUNCTIONS*/
    }else{
        print_r($invalid_fields); //Caso ocorra erro de envio de dados
        echo "<script>window.location.href='pew-orcamentos.php?erro=dados_enviados_insuficientes&msg=Ocorreu um erro ao cadastrar o orçamento&msgType=error';</script>";
    }
?>
