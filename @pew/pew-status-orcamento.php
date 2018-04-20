<?php
$nomeLoja = "Rei das Fechaduras";

if(isset($_POST["id_orcamento"]) && isset($_POST["acao"])){
    
    require_once "@classe-system-functions.php";
    require_once "@classe-orcamentos.php";
    require_once "pew-system-config.php";
    
    $tabela_orcamentos = $pew_custom_db->tabela_orcamentos;
    $tabela_carrinhos = $pew_custom_db->tabela_carrinhos;
    
    $idOrcamento = $_POST["id_orcamento"];
    $acao = $_POST["acao"];
    $totalOrcamento = $pew_functions->contar_resultados($tabela_orcamentos, "id = '$idOrcamento'");
    
    if($totalOrcamento > 0){
        if($acao == "excluir"){
            $queryToken = mysqli_query($conexao, "select token_carrinho from $tabela_orcamentos where id = '$idOrcamento'");
            $info = mysqli_fetch_array($queryToken);
            $tokenCarrinho = $info["token_carrinho"];
            
            $queryCarrinho = mysqli_query($conexao, "delete from $tabela_carrinhos where token_carrinho = '$tokenCarrinho'");
            
            mysqli_query($conexao, "delete from $tabela_orcamentos where id = '$idOrcamento'");
            
            echo "true";
            
        }else if($acao == "atualizar"){
            
            $status = isset($_POST["status"]) ? $_POST["status"] : 0;
            
            mysqli_query($conexao, "update $tabela_orcamentos set status_orcamento = '$status' where id = '$idOrcamento'");
            
            echo "true";
            
        }else if($acao == "enviar_email"){
            
            $cls_orcamentos = new Orcamentos();
            
            $queryOrcamentos = mysqli_query($conexao, "select * from $tabela_orcamentos where id = '$idOrcamento'");
            $info = mysqli_fetch_array($queryOrcamentos);
            $tokenCarrinho = $info["token_carrinho"];
            $nome = $info["nome_cliente"];
            $email = $info["email_cliente"];
            $desconto = $info["porcentagem_desconto"];
            
            $produtos = array();
            $ctrlProdutos = 0;
            
            $queryCarrinho = mysqli_query($conexao, "select * from $tabela_carrinhos where token_carrinho = '$tokenCarrinho'");
            while($infoCarrinho = mysqli_fetch_array($queryCarrinho)){
                $produtos[$ctrlProdutos] = array();
                $produtos[$ctrlProdutos]["preco"] = $infoCarrinho["preco_produto"];
                $produtos[$ctrlProdutos]["quantidade"] = $infoCarrinho["quantidade_produto"];
                $produtos[$ctrlProdutos]["nome"] = $infoCarrinho["nome_produto"];
                $ctrlProdutos++;
            }
            
            $body = $cls_orcamentos->montar_email($nome, $produtos, $desconto, $tokenCarrinho);
            
            $destinatarios = array();
            $destinatarios[0] = array();
            $destinatarios[0]["nome"] = $nome;
            $destinatarios[0]["email"] = $email;
            
            if($pew_functions->enviar_email("Pedido de orçamento - $nomeLoja", $body, $destinatarios) == true){
                echo "true";
            }else{
                echo "false";
            }
        }
        
    }else{
        echo "false";
    }
    mysqli_close($conexao);
}else{
    echo "false";
}