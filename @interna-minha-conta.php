<?php

require_once "@classe-minha-conta.php";

$cls_conta = new MinhaConta();

$listar = true;

$cls_conta->verify_session_start();

if(isset($_SESSION["minha_conta"])){
    $sessao_conta = $_SESSION["minha_conta"];
    $email = $sessao_conta["email"];
    $senha = $sessao_conta["senha"];

    if($cls_conta->auth($email, $senha) == false){
        $listar = false;
    }else{
        $idConta = $cls_conta->query_minha_conta("md5(email) = '$email' and senha = '$senha'");
        $cls_conta->montar_minha_conta($idConta);
        $infoConta = $cls_conta->montar_array();
    }

}else{
    $listar = false;
}


if($listar){
?>
<div class="display-buttons">
    <button class="top-buttons selected-button" id="Painel1"><i class="fas fa-shopping-cart"></i> PEDIDOS</button>
    <button class="top-buttons" id="Painel2"><i class="far fa-address-card"></i> MEUS DADOS</button>
    <button class="top-buttons" id="Painel3"><i class="fas fa-truck"></i> ENDEREÇO DE ENTREGA</button>
</div>
<div class="painel painel-active" id="displayPainel1">
    <?php
    
        $_POST["diretorio"] = "";
        $_POST["diretorio_db"] = "@pew/";
        require_once "@pew/@classe-pedidos.php";
    
    
        $cls_pedidos = new Pedidos();
        $getPedidos = $cls_pedidos->get_pedidos_conta($idConta);
        $totalPedidos = is_array($getPedidos) ? count($getPedidos) : 0;
    
        if($totalPedidos > 0){
            foreach($getPedidos as $idPedido){
                $cls_pedidos->montar($idPedido);
                $infoPedido = $cls_pedidos->montar_array();
                $produtosPedido = $cls_pedidos->get_produtos_pedido($idPedido);

                $referencia = $infoPedido["referencia"];
                $token = $infoPedido["token_carrinho"];
                $totalPedido = $pew_functions->custom_number_format($infoPedido["valor_total"]);
                $codigoPagamento = $infoPedido["codigo_pagamento"];
                $status = $infoPedido["status"];
                $strStatus = $cls_pedidos->get_status_string($status);
                $strPagamento = $cls_pedidos->get_pagamento_string($codigoPagamento);
                $strComplemento = $infoPedido["complemento"] == "" ? "" : ", " . $infoPedido["complemento"];
                $enderecoCompleto = $infoPedido["rua"] . ", " . $infoPedido["numero"] . $strComplemento . " - " . $infoPedido["cep"];
                $dataPedido = $pew_functions->inverter_data(substr($infoPedido["data_controle"], 0, 10));
                $horaPedido = substr($infoPedido["data_controle"], 10);

                echo "<div class='box-pedido'>";
                    echo "<div class='right'>";
                        echo "<h3 class='titulo'>Pedido: $referencia</h3>";
                        echo "<h5 class='descricao'>Endereço de envio: $enderecoCompleto</h5>";
                    echo "</div>";
                    echo "<div class='middle'>";
                        echo "<h5 class='descricao'>Método de pagamento: $strPagamento</h3>";
                        echo "<h5 class='descricao'>Total: <b>R$ $totalPedido</b></h3>";
                        echo "<a class='link-padrao btn-mais-info'>Ver mais informações</a>";
                    echo "</div>";
                    echo "<div class='left'>";
                        echo "<h5 class='descricao'><i class='far fa-calendar-alt'></i> $dataPedido</h3>";
                        echo "<h5 class='descricao'><i class='far fa-clock'></i> $horaPedido</h3>";
                        echo "<h5 class='status'>Status: $strStatus</h3>";
                    echo "</div>";
                echo "</div>";
            }
        }else{
            echo "Você não finalizou nenhuma compra ainda.";
        }
    
    ?>
</div>
<div class="painel" id="displayPainel2">
    <?php
    $nome = $infoConta["usuario"];
    $email = $infoConta["email"];
    $celular = $infoConta["celular"];
    $telefone = $infoConta["telefone"];
    $cpf = $infoConta["cpf"];
    $sexo = $infoConta["sexo"];
    $dataNascimento = $infoConta["data_nascimento"];

    if($infoConta["status"] == 0){
        echo "<div class='label full'>";
        echo "<font class='text warning'>Sua conta ainda não foi confirmada. Para ter mais segurança confirme seu e-mail. <a href='@envia-link-confirmacao.php' class='link-padrao'>Reenviar link de confirmação</a></font>";
        echo "</div>";
    }
    ?>
    <form class="formulario-atualiza-conta">
        <div class="half label">
            <input type="hidden" name="id_conta" id="idConta" value="<?php echo $idConta; ?>">
            <input type="hidden" name="acao_conta" value="update_conta">
            <h4 class="input-title">Nome Completo</h4>
            <input type="text" class='input-standard' placeholder="Nome Completo" name="nome" id="nome" value="<?php echo $nome; ?>">
            <h6 class="msg-input"></h6>
        </div>
        <div class="small label">
            <h4 class="input-title">E-mail</h4>
            <input type="text" class='input-standard' placeholder="contato@bolsasemcouro.com.br" name="email" id="email" value="<?php echo $email; ?>">
            <h6 class="msg-input"></h6>
        </div>
        <div class="small label">
            <h4 class="input-title">CPF</h4>
            <input type="text" class='input-standard mascara-cpf-conta' placeholder="000.000.000.00" name="cpf" id="cpf" value="<?php echo $cpf; ?>">
            <h6 class="msg-input"></h6>
        </div>
        <div class="small label">
            <h4 class="input-title">Celular</h4>
            <input type="text" class='input-standard mascara-numero-conta' placeholder="(41) 9999-9999" name="celular" id="celular" value="<?php echo $celular; ?>">
            <h6 class="msg-input"></h6>
        </div>
        <div class="small label">
            <h4 class="input-title">Telefone</h4>
            <input type="text" class='input-standard mascara-numero-conta' placeholder="(41) 3030-3030" name="telefone" id="telefone" value="<?php echo $telefone; ?>">
            <h6 class="msg-input"></h6>
        </div>
        <div class="small label">
            <h4 class="input-title">Sexo</h4>
            <select name="sexo" id="sexo" class="input-standard">
                <option value="">- Selecione -</option>
                <option value="masculino" <?php if($sexo == "masculino") echo "selected"; ?>>Masculino</option>
                <option value="feminino" <?php if($sexo == "feminino") echo "selected"; ?>>Feminino</option>
            </select>
            <h6 class="msg-input msg-input-sexo"></h6>
        </div>
        <div class="small label">
            <h4 class="input-title">Data de nascimento</h4>
            <input type="date" name="data_nascimento" id="dataNascimento" class="input-standard" value="<?php echo $dataNascimento; ?>">
            <h6 class="msg-input"></h6>
        </div>
        <br class='clear'>
        <div class="small label">
            <h4 class="input-title">Senha atual</h4>
            <input type="password" class='input-standard' placeholder="Senha" name="senha_atual" id="senhaAtual">
            <h6 class="msg-input"></h6>
        </div>
        <div class="small label">
            <h4 class="input-title">Nova senha</h4>
            <input type="password" class='input-standard' placeholder="Senha" name="senha_nova" id="senhaNova">
            <h6 class="msg-input"></h6>
        </div>
        <div class="small label">
            <h4 class="input-title">Confirmar nova senha</h4>
            <input type="password" class='input-standard' placeholder="Senha" name="confirma_senha_nova" id="confirmaSenhaNova">
            <h6 class="msg-input"></h6>
        </div>
        <div class="small label">
            <button class="botao-continuar" type="button" id="botaoAtualizarConta">ATUALIZAR <i class="fas fa-check icone"></i></button>
        </div>
    </form>
</div>
<div class="painel" id="displayPainel3">
    <form class="formulario-atualiza-endereco">
        <?php
            $infoEndeco = $infoConta["enderecos"];
    
            $idEndereco = $infoEndeco["id"];
            $cep = $infoEndeco["cep"];
            $rua = $infoEndeco["rua"];
            $numero = $infoEndeco["numero"];
            $complemento = $infoEndeco["complemento"];
            $bairro = $infoEndeco["bairro"];
            $cidade = $infoEndeco["cidade"];
            $estado = $infoEndeco["estado"];
            $cidade = $infoEndeco["cidade"];
        ?>
        <input type="hidden" name="id_endereco" value="<?php echo $idEndereco; ?>" id="idEnderecoConta">
        <input type="hidden" name="id_relacionado" value="<?php echo $idConta; ?>">
        <div class="small label">
            <h4 class="input-title">CEP</h4>
            <input class='input-standard mascara-cep-conta' type="text" placeholder="00000-000" name="cep" id="cepConta" tabindex="1" value="<?php echo $cep; ?>">
            <h6 class="msg-input"></h6>
        </div>
        <div class="xlarge label">
            <h4 class="input-title">Rua</h4>
            <input class='input-standard input-nochange' type="text" placeholder="Rua" name="rua" id="ruaConta" value="<?php echo $rua; ?>" readonly>
            <h6 class="msg-input"></h6>
        </div>
        <div class="xsmall label">
            <h4 class="input-title">Número</h4>
            <input class='input-standard' type="text" placeholder="Numero" name="numero" id="numeroConta" value="<?php echo $numero; ?>" tabindex="2">
            <h6 class="msg-input"></h6>
        </div>
        <div class="medium label">
            <h4 class="input-title">Complemento</h4>
            <input class='input-standard' type="text" placeholder="Complemento" name="complemento" id="complementoConta" value="<?php echo $complemento; ?>" tabindex="3">
            <h6 class="msg-input"></h6>
        </div>
        <div class="xsmall label">
            <h4 class="input-title">Bairro</h4>
            <input class='input-standard input-nochange' type="text" placeholder="Bairro" name="bairro" id="bairroConta" value="<?php echo $bairro; ?>" readonly>
        </div>
        <div class="xsmall label">
            <h4 class="input-title">Estado</h4>
            <input class='input-standard input-nochange' type="text" placeholder="Estado" name="estado" id="estadoConta" value="<?php echo $estado; ?>" readonly>
        </div>
        <div class="xsmall label">
            <h4 class="input-title">Cidade</h4>
            <input class='input-standard input-nochange' type="text" placeholder="Cidade" name="cidade" id="cidadeConta" value="<?php echo $cidade; ?>" readonly>
        </div>
        <div class="clear full label">
            <button class="botao-continuar" id="botaoAtualizarEndereco" type="button">ATUALIZAR <i class="fas fa-check icone"></i></button>
        </div>
    </form>
</div>
<?php
}else{
    echo "<h3 align=center>Faça login para continuar...</h3>";
}
?>