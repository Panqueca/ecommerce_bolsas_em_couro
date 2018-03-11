<?php
    session_start();
    $post_fields = array("nome_cliente", "telefone_cliente", "email_cliente", "rg_cliente", "cpf_cliente", "cep_cliente", "numero_rua_cliente", "complemento_rua_cliente", "total_desconto", "total_orcamento");
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
        $nomeCliente = addslashes($_POST["nome_cliente"]);
        $telefoneCliente = addslashes($_POST["telefone_cliente"]);
        $emailCliente = addslashes($_POST["email_cliente"]);
        $rgCliente = addslashes($_POST["rg_cliente"]);
        $cpfCliente = addslashes($_POST["cpf_cliente"]);
        $cepCliente = addslashes($_POST["cep_cliente"]);
        $numeroRuaCliente = addslashes($_POST["numero_rua_cliente"]);
        $complementoRuaCliente = addslashes($_POST["complemento_rua_cliente"]);
        $totalPorcentagemDesconto = floatval($_POST["total_desconto"]);
        $totalOrcamento = floatval($_POST["total_orcamento"]);
        $produtosOrcamento = isset($_POST["produtos_orcamento"]) ? $_POST["produtos_orcamento"] : "";
        /*END POST DATA*/

        /*DIR VARS*/
        $dirImagensProdutos = "../imagens/produtos/";
        /*END DIR VARS*/

        /*SET TABLES*/
        $tabela_orcamentos = $pew_custom_db->tabela_orcamentos;
        $tabela_usuarios = $pew_db->tabela_usuarios_administrativos;
        /*END SET TABLES*/

        /*SESSION VALIDATION*/
        $name_session_user = $pew_session->name_user;
        $name_session_pass = $pew_session->name_pass;
        $name_session_nivel = $pew_session->name_nivel;
        $name_session_empresa = $pew_session->name_empresa;
        if(isset($_SESSION[$name_session_user]) && isset($_SESSION[$name_session_pass]) && isset($_SESSION[$name_session_nivel]) && isset($_SESSION[$name_session_empresa])){
            $usuarioAdm = $_SESSION[$name_session_user];
            $senhaAdm = $_SESSION[$name_session_pass];
            $contarVendedor = mysqli_query($conexao, "select count(id) as total_vendedor from $tabela_usuarios where usuario = '$usuarioAdm' and senha = '$senhaAdm'");
            $contagem = mysqli_fetch_assoc($contarVendedor);
            $totalVendedor = $contagem["total_vendedor"];
            if($totalVendedor > 0){
                $queryInfoVendedor = mysqli_query($conexao, "select id from $tabela_usuarios where usuario = '$usuarioAdm' and senha = '$senhaAdm'");
                $infoVendedor = mysqli_fetch_array($queryInfoVendedor);
            }
        }else{
            echo "<h3 align=center>A SESSÃO ESTÁ INATIVA. FAÇA LOGIN PARA ACESSAR ESTA PÁGINA<br><br><a href='index.php'>Fazer login</a></h3>";
            die();
        }
        /*END SESSION VALIDATION*/

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
            $statusOrcamento = 0;

            /*STANDARD FORMAT CLIENT DATA*/
            $rgCliente = limpaNumberString($rgCliente);
            $cpfCliente = limpaNumberString($cpfCliente);
            $cepCliente = limpaNumberString($cpfCliente);
            $enderecoEnvio = $cepCliente."||".$numeroRuaCliente."||".$complementoRuaCliente;

            $refOrcamento = substr(md5($dataAtual.$cpfCliente), 0, 16);

            /*MONTAR PRODUTOS SELECIONADOS*/
            if($produtosOrcamento != ""){
                $montagemInfoTodosProdutos = "";
                $ctrlProdutos = 0;
                foreach($produtosOrcamento as $infoProduto){
                    $separacao = $ctrlProdutos > 0 ? "|#|" : "";
                    $montagemInfoTodosProdutos .= $separacao.$infoProduto;
                    $ctrlProdutos++;
                }
            }else{
                $montagemInfoTodosProdutos = "";
            }

            /*INSERE DADOS ORCAMENTO*/
            mysqli_query($conexao, "insert into $tabela_orcamentos (ref_orcamento, nome_cliente, telefone_cliente, email_cliente, rg_cliente, cpf_cliente, endereco_envio, produtos, porcentagem_desconto, preco_total, tempo_entrega, id_vendedor, data_pedido, data_vencimento, data_controle, modify_controle, status_orcamento) values ('$refOrcamento', '$nomeCliente', '$telefoneCliente', '$emailCliente', '$rgCliente', '$cpfCliente', '$enderecoEnvio', '$montagemInfoTodosProdutos', '$totalPorcentagemDesconto', '$totalOrcamento', '$tempoEntrega', '$idVendedor', '$dataAtual', '$dataVencimento', '$dataAtual', '$idVendedor', '$statusOrcamento')");

            echo "<script>window.location.href='pew-orcamentos.php?msg=Orçamento cadastrado com sucesso&msgType=success';</script>";
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
