<?php
    session_start();
    
    require_once "@classe-paginas.php";

    $cls_paginas->set_titulo("Finalizar compra");
    $cls_paginas->set_descricao("DESCRIÇÃO MODELO ATUALIZAR...");

    if(isset($_GET["clear"])){
        if($_GET["clear"] == "true" || $_GET["clear"] == true){
            unset($_SESSION["carrinho"]);
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <meta name="HandheldFriendly" content="true">
        <meta name="description" content="<?php echo $cls_paginas->descricao;?>">
        <meta name="author" content="Efectus Web">
        <title><?php echo $cls_paginas->titulo;?></title>
        <link type="image/png" rel="icon" href="imagens/identidadeVisual/logo-icon.png">
        <!--DEFAULT LINKS-->
        <?php
            require_once "@link-standard-styles.php";
            require_once "@link-standard-scripts.php";
            require_once "@link-important-functions.php";
        ?>
        <!--END DEFAULT LINKS-->
        <!--PAGE CSS-->
        <style>
            .main-content{
                width: 80%;
                margin: 0 auto;
                min-height: 300px;
                background-color: #fff;
                margin: 80px auto 80px auto;
                -webkit-box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);
                -moz-box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);
                box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);
            }
            .main-content .titulo{
                font-size: 24px;
                padding: 20px 15px 20px 15px;
                margin: 0px;
            }
            .main-content article{
                margin: 15px 15px 35px 15px;  
            }
            .main-content .display-carrinho{
                width: calc(100% - 30px);
                margin: 15px;
                padding: 0px 0px 20px 0px;
                display: flex;
                flex-flow: row wrap;
                align-items: flex-end;
            }
            .main-content .display-carrinho .item-carrinho{
                position: relative;
                width: 100%;
                display: flex;
                height: 150px;
                margin: 10px 0px 10px 0px;
                flex-flow: row wrap;
                border-bottom: 1px solid #eee;
            }
            .main-content .display-carrinho .item-carrinho .box-imagem{
                width: 180px;
                height: 150px;
            }
            .main-content .display-carrinho .item-carrinho .box-imagem .imagem{
                height: 100%;
            }
            .main-content .display-carrinho .item-carrinho .information{
                width: calc(60% - 180px);
                height: 40px;
                line-height: 40px;
                margin: 0px;
                display: flex;
            }
            .main-content .display-carrinho .item-carrinho .information .titulo{
                font-size: 18px;
                width: 100%;
                white-space: nowrap;
                text-overflow: ellipsis;
            }
            .main-content .display-carrinho .item-carrinho .price-field{
                width: calc(50% - 180px);
                display: flex;
                height: 40px;
                margin: 15px 0px 0px 0px;
                justify-content: flex-end;
            }
            .main-content .display-carrinho .item-carrinho .price-field .controller-preco{
                width: 60%;
                display: flex;
                color: #999;
                height: 40px;
                line-height: 40px;
                align-items: center;
            }
            .main-content .display-carrinho .item-carrinho .price-field .controller-preco .price{
                height: 40px;
                margin: 0px 10px 0px 10px;
            }
            .main-content .display-carrinho .item-carrinho .price-field .controller-preco .quantidade-produto{
                width: 38px;
                height: 38px;
                border: 1px solid #999;
                color: #999;
                text-align: center;
                line-height: 38px;
                outline: none;
            }
            .main-content .display-carrinho .item-carrinho .price-field .view-subtotal-produto{
                height: 40px;
                line-height: 40px; 
            }
            .main-content .display-carrinho .item-carrinho .price-field .view-subtotal-produto .subtotal{
                margin: 0px;
            }
            .main-content .display-carrinho .item-carrinho .price-field .view-subtotal-produto .link-padrao{
                padding: 0px;
                font-size: 12px;
                line-height: 12px;
                cursor: pointer;
                text-align: right;
            }
            .main-content .display-carrinho .endereco-alternativo{
                display: none;
            }
            .main-content .display-carrinho .msg-endereco{
                margin: 0px 0px 10px 15px;
                font-weight: normal;
            }
            .main-content .display-carrinho .label-edita-endereco{
                margin: 15px;
                height: 20px;
                display: block;
                font-size: 14px;
                line-height: 20px;
                cursor: pointer;
            }
            .main-content .display-carrinho .label-frete{
                cursor: pointer;
            }
            .main-content .display-carrinho .label-frete:hover{
                background-color: #eee;   
            }
            .main-content .display-carrinho .display-resultados-frete{
                width: calc(40% - 20px);
            }
            .main-content .display-carrinho .display-resultados-frete .titulo{
                font-size: 18px;
            }
            .main-content .display-carrinho .display-resultados-frete .span-frete{
                margin: 0px 20px 0px 20px;
                font-size: 14px;
            }
            .main-content .display-carrinho .bottom-info{
                position: relative;
                padding-bottom: 40px;
                width: calc(60% - 20px);
                justify-content: flex-end;
                text-align: right;
                align-items: flex-end;
            }
            .main-content .display-carrinho .bottom-info .display-prices{
                text-align: right;
            }
            .main-content .display-carrinho .bottom-info .info{
                color: #888;
                display: block;
                font-weight: normal;
            }
            .main-content .display-carrinho .bottom-info .info .title{
                margin: 0px 40px 0px 0px;
            }
            .main-content .display-carrinho .bottom-info .info .title-bold{
                font-weight: bold;
            }
            .main-content .display-carrinho .bottom-info .display-total{
                text-align: right;
            }
            .main-content .display-carrinho .bottom-info .display-total .view-total .title{
                margin: 0px 25px 0px 0px;
            }
            .main-content .display-carrinho .bottom-info .botao-continuar{
                position: absolute;
                width: auto;
                background-color: #6abd45;
                border: none;
                padding: 0px 40px 0px 15px;
                font-size: 14px;
                font-weight: bold;
                color: #fff;
                height: 30px;
                outline: none;
                cursor: pointer;
                bottom: 0px;
                right: 0px;
            }
            .main-content .display-carrinho .bottom-info .botao-continuar .icon-button{
                position: absolute;
                right: 15px;
                top: 0px;
                height: 30px;
                transition: .2s;
            }
            .main-content .display-carrinho .bottom-info .botao-continuar:hover{
                background-color: #518d36;   
            }
            .main-content .display-carrinho .bottom-info .botao-continuar:hover .icon-button{
                right: 8px;
            }
            @media only all and (max-width: 1200px){
                .main-content .display-carrinho .item-carrinho{
                    flex-direction: column;
                }
                .main-content .display-carrinho .item-carrinho .information{
                    width: calc(100% - 180px);  
                    line-height: normal;
                }
                .main-content .display-carrinho .item-carrinho .information .titulo{
                    white-space: normal;
                    font-size: 1.3vw;
                }
                .main-content .display-carrinho .item-carrinho .price-field{
                    font-size: 1.5vw;
                    width: calc(100% - 180px);  
                }
                @media only all and (max-width: 480px){
                    .main-content{
                        margin: 0px auto 0px auto;
                        width: 90%;
                    }
                    .main-content article{
                        margin: 15px;  
                    }
                    .main-content .titulo{
                        font-size: 18px;
                    }
                    .display-formulario .small{
                        width: 100%;
                    }
                    .main-content .display-carrinho .item-carrinho{
                        padding: 10px;
                        height: auto;
                        flex-direction: row;
                    }
                    .main-content .display-carrinho .item-carrinho .box-imagem{
                        width: 25%;
                        height: auto;
                    }
                    .main-content .display-carrinho .item-carrinho .box-imagem .imagem{
                        width: 100%;
                        height: auto;
                    }
                    .main-content .display-carrinho .item-carrinho .information{
                        width: calc(75% - 20px);
                        padding: 10px;
                        height: auto;
                    }
                    .main-content .display-carrinho .item-carrinho .information .titulo{
                        font-size: 16px;
                        margin: 0px;
                        padding: 0px;
                    }
                    .main-content .display-carrinho .item-carrinho .price-field{
                        font-size: 100%;
                        width: 100%;
                        margin: 0px;
                        justify-content: center;
                    }
                    .main-content .display-carrinho .item-carrinho .price-field .controller-preco .quantidade-produto{
                        width: 25px;
                        height: 25px;
                    }
                    .main-content .display-carrinho .item-carrinho .price-field .botao-remover{
                        position: relative;
                        top: -22px;
                    }
                    .main-content .display-carrinho .display-resultados-frete{
                        width: 100%;
                        padding: 0px;
                    }
                    .main-content .display-carrinho .display-resultados-frete .titulo{
                        margin: 0px;   
                    }
                    .main-content .display-carrinho .display-resultados-frete .label-edita-endereco{
                        margin: 0px;   
                    }
                    .main-content .display-carrinho .display-resultados-frete .span-frete{
                        margin: 0px;   
                    }
                    .main-content .display-carrinho .display-resultados-frete .msg-endereco{
                        margin: 10px 0px 10px 0px;   
                    }
                    .main-content .display-carrinho .bottom-info{
                        width: 100%;
                        padding: 0px 0px 40px 0px;
                    }
                    .main-content .display-carrinho .bottom-info .botao-continuar{
                        font-weight: normal;
                    }
                }
            }
            .botao-salvar{
                background: #999;
                color: #fff;
                border: none;
                padding: 5px 10px 5px 10px;
                margin: 10px 0px 10px 0px;
                cursor: pointer;
            }
            .botao-salvar:hover{
                background-color: #777;   
            }
            .before-checkout-area{
                transition: .4s linear;
            }
            .finish-checkout-box{
                width: 100%;
                margin: 20px 0px 20px 0px;
                display: none;
                opacity: 0;
            }
            .finish-checkout-display{
                display: block;
                opacity: 1;
            }
        </style>
        <!--END PAGE CSS-->
        <!--PAGE JS-->
        <script>
            $(document).ready(function(){
                console.log("Página carregada");
                
                input_mask(".mascara-cep-finaliza", "99999-999");
                
                /*CALCULO DE FRETE*/
                var displayResultadoFrete = $(".display-resultados-frete .span-frete");
                var iconLoading = "<i class='fas fa-spinner fa-spin icone-loading icon-button'></i>";
                var calculandoFrete = false;
                var infoCalculoFrete = $(".info-frete");
                var totalCarrinho = $("#totalCarrinho").val();
                var viewTotalCompra = $(".final-value");
                var viewCarrinhoFrete = $(".view-frete");
                
                // DADOS COMPRA
                var displayDados = $(".dados-compra");
                var tokenCarrinho = displayDados.children("#tokenCarrinho").val();
                var idCliente = displayDados.children("#idCliente").val();
                var nomeCliente = displayDados.children("#nomeCliente").val();
                var cpfCliente = displayDados.children("#cpfCliente").val();
                var emailCliente = displayDados.children("#emailCliente").val();
                
                // DADOS DA ENTREGA
                var cepPadrao = $("#cepDestino").val() != "undefined" ? $("#cepDestino").val() : 0;
                var ruaPadrao = $("#ruaDestino").val() != "undefined" ? $("#ruaDestino").val() : 0;
                var numeroPadrao = $("#numeroDestino").val() != "undefined" ? $("#numeroDestino").val() : 0;
                var complementoPadrao = $("#complementoDestino").val() != "undefined" ? $("#complementoDestino").val() : 0;
                var bairroPadrao = $("#bairroDestino").val() != "undefined" ? $("#bairroDestino").val() : 0;
                var cidadePadrao = $("#cidadeDestino").val() != "undefined" ? $("#cidadeDestino").val() : 0;
                var estadoPadrao = $("#estadoDestino").val() != "undefined" ? $("#estadoDestino").val() : 0;
                var cepAlternativo = false;
                
                // INFORMAÇÕES DO PRODUTO
                var jsonProduto = new Array();
                var ctrl_array = 0;
                infoCalculoFrete.each(function(){
                    var idProduto = $(this).children("#freteIdProduto").val();
                    var tituloProduto = $(this).children("#freteTituloProduto").val();
                    var precoProduto = $(this).children("#fretePrecoProduto").val();
                    var comprimentoProduto = $(this).children("#freteComprimentoProduto").val();
                    var larguraProduto = $(this).children("#freteLarguraProduto").val();
                    var alturaProduto = $(this).children("#freteAlturaProduto").val();
                    var pesoProduto = $(this).children("#fretePesoProduto").val();
                    var quantidadeProduto = $(this).children("#freteQuantidadeProduto").val();
                    jsonProduto[ctrl_array] = {"id": idProduto, "titulo": tituloProduto, "preco": precoProduto, "comprimento": comprimentoProduto, "largura": larguraProduto, "altura": alturaProduto, "peso": pesoProduto, "quantidade": quantidadeProduto};
                    ctrl_array++;
                });
                
                
                /*MAIN FUNCTIONS*/
                function guardar_compra(cd_validacao, cd_transacao, cd_transporte, vlr_frete, referencia){
                    var dados_compra = {
                        token_carrinho: tokenCarrinho,
                        itens_carrinho: jsonProduto,
                        codigo_confirmacao: cd_validacao,
                        codigo_transacao: cd_transacao,
                        codigo_transporte: cd_transporte,
                        referencia: referencia,
                        id_cliente: idCliente,
                        nome_cliente: nomeCliente,
                        cpf_cliente: cpfCliente,
                        email_cliente: emailCliente,
                        cep: $("#cepDestino").val(),
                        rua: $("#ruaDestino").val(),
                        numero: $("#numeroDestino").val(),
                        complemento: $("#complementoDestino").val(),
                        bairro: $("#bairroDestino").val(),
                        cidade: $("#cidadeDestino").val(),
                        estado: $("#estadoDestino").val(),
                        vlr_frete: vlr_frete
                    }
                    
                    $.ajax({
                        type: "POST",
                        url: "@grava-pedido.php",
                        data: JSON.stringify(dados_compra),
                        contentType: "application/json",
                        error: function(){
                            mensagemAlerta("Ocorreu um erro ao finalizar seu pedido. Recarregue a página e tente novamente.");
                        },
                        success: function(resposta){
                            //console.log(resposta);
                        }
                    });
                }
                
                var metodosEnvio = [];
                var ctrlMetodosEnvio = 0;
                function calcular_frete(){
                    if(!calculandoFrete){
                        set_view_preco(totalCarrinho, "0.00");
                        var urlFrete = "@calcular-transporte.php";
                        var cepDestino = typeof $("#cepDestino").val() != "undefined" ? $("#cepDestino").val() : 0;
                        var codigosServico = ["7777", "8888", "41106", "40010", "40215", "40290"];
                        displayResultadoFrete.html(iconLoading + " Calculando frete");
                        
                        cepDestino = cepDestino.length == 9 ? cepDestino.replace("-", "") : cepDestino;
                        
                        if(cepDestino.length == 8){
                            
                            calculandoFrete = true;
                            var mensagemFinal = [];
                            var ctrlExec = 0;
                            
                            function get_titulo_servico(cod){
                                switch(cod){
                                    case "7777":
                                        var titulo = "Retirada na Loja";
                                        break;
                                    case "8888":
                                        var titulo = "Motoboy";
                                        break;
                                    case "40010":
                                        var titulo = "SEDEX";
                                        break;
                                    case "40215":
                                        var titulo = "SEDEX 10";
                                        break;
                                    case "40290":
                                        var titulo = "SEDEX Hoje";
                                        break;
                                    default:
                                        var titulo = "PAC";
                                }
                                return titulo;
                            }
                            codigosServico.forEach(function(codigo){
                                var dados = {
                                    cep_destino: cepDestino,
                                    codigo_transporte: codigo,
                                    produtos: jsonProduto,
                                }
                                $.ajax({
                                    type: "POST",
                                    url: urlFrete,
                                    data: JSON.stringify(dados),
                                    contentType: "application/json",
                                    error: function(){
                                        displayResultadoFrete.html("Ocorreu um erro ao calcular o frete. Recarregue a página e tente novamente.");
                                    },
                                    success: function(resultado){
                                        //console.log(resultado)
                                        var tituloServico = get_titulo_servico(codigo);
                                        
                                        if(resultado != false){
                                            if(isJson(resultado) == true && JSON.parse(resultado) != false){
                                                var jsonData = JSON.parse(resultado);
                                                var valor = jsonData.valor.toFixed(2);
                                                var prazo = jsonData.prazo;
                                                var strValor = valor > 0 ? "R$ " + valor : "Grátis";
                                                valor = strValor == "Grátis" ? "0.00" : valor;
                                                var strPrazo = prazo != 0 ? " em até <b>"+ prazo +"</b>" : "";
                                                
                                                var msgPadrao = "<label class='label-frete'><input type='checkbox' name='metodo_envio[]' class='opcao-frete' value='" + codigo + "' price-frete='" + valor + "'>" + tituloServico + ": <b>" + strValor + "</b>" + strPrazo + "</label>";
                                                mensagemFinal[ctrlExec] = "<br>" + msgPadrao + "<br>";
                                                metodosEnvio[ctrlMetodosEnvio] = new Object();
                                                metodosEnvio[ctrlMetodosEnvio]["codigo"] = codigo;
                                                metodosEnvio[ctrlMetodosEnvio]["valor"] = valor;
                                                ctrlMetodosEnvio++;
                                            }else{
                                                //mensagemFinal[ctrlExec] = "<br>" + tituloServico + ": Localidade insdisponível<br>";
                                            }
                                        }else{
                                            notificacaoPadrao("Ocorreu um erro ao calcular o frete. Recarregue a página e tente novamente.");
                                        }
                                        ctrlExec++;
                                        
                                        if(ctrlExec == codigosServico.length && mensagemFinal.length > 0){
                                            calculandoFrete = false;
                                            var mensagem = "";
                                            mensagemFinal.forEach(function(msg){
                                                //if(msg == "") msg = "<br>" + get_titulo_servico(codigo) + ": Localidade indisponível<br>";
                                                mensagem += msg;
                                            });
                                            displayResultadoFrete.html(mensagem);
                                        }else if(mensagemFinal.length == 0){
                                            var msg = "<br>" + get_titulo_servico(codigo) + ": Localidade indisponível<br>";
                                            displayResultadoFrete.html(msg);
                                        }
                                    }
                                });
                                
                            });
                            
                        }else{
                            displayResultadoFrete.html("O campo CEP precisa ser preenchido corretamente.");
                        }
                    }
                }
                
                function set_destino(cep, rua, numero, complemento, bairro, cidade, estado){
                    $("#cepDestino").val(cep);
                    $("#ruaDestino").val(rua);
                    $("#numeroDestino").val(numero);
                    $("#complementoDestino").val(complemento);
                    $("#bairroDestino").val(bairro);
                    $("#cidadeDestino").val(cidade);
                    $("#estadoDestino").val(estado);
                    $(".msg-endereco").html("Enviando para: <b>" + rua + ", " + numero + ", " + complemento +"</b>");
                }
                
                var carrinho = $("#carrinhoFinalizar").val();
                var finalizandoCompra = false;
                function finalizarCompra(){
                    
                    if(!finalizandoCompra){
                        finalizandoCompra = true;
                        var botaoFinalizar = $("#botaoFinalizarCompra");
                        var opcaoFrete = $(".opcao-frete");
                        var viewCarrinhoFrete = $(".view-frete");
                        var transportCode = false;
                        
                        
                        opcaoFrete.each(function(){
                            var input = $(this);
                            var value = input.val();
                            var frete = input.attr("price-frete");
                            var checked = input.prop("checked");
                            if(checked){
                                transportCode = value;
                            }
                        });

                        if(transportCode != false){

                            botaoFinalizar.html("Validando " + iconLoading);
                            var dados = {
                                cep_destino: $("#cepDestino").val(),
                                rua_destino: $("#ruaDestino").val(),
                                numero_destino: $("#numeroDestino").val(),
                                complemento_destino: $("#complementoDestino").val(),
                                bairro_destino: $("#bairroDestino").val(),
                                estado_destino: $("#estadoDestino").val(),
                                cidade_destino: $("#cepDestino").val(),
                                produtos: carrinho,
                                codigo_transporte: transportCode,
                            }
                            
                            function changeCheckout(){
                                
                                $(".before-checkout-area").css({
                                    opacity: "0",
                                });
                                setTimeout(function(){
                                    $(".before-checkout-area").css({
                                        display: "none",
                                    });
                                    $(".finish-checkout-box").addClass("finish-checkout-display");
                                }, 400);

                            }
                            
                            $(".finish-checkout-box").load(
                                "checkout/@controller-checkout.php", 

                                {valor_final: totalCarrinho, metodos_envio: metodosEnvio, codigo_transporte: transportCode, acao: "get_view_checkout"}, 

                                function(){
                                    changeCheckout();
                                }
                            );
                            
                            
                            

                            /*$.ajax({
                                type: "POST",
                                url: "@valida-finaliza-compra.php",
                                data: JSON.stringify(dados),
                                contentType: "application/json",
                                error: function(){
                                    mensagemAlerta("Ocorreu um erro ao finalizar sua compra");
                                    botaoFinalizar.html("Recarregar página");
                                    botaoFinalizar.off().on("click", function(){
                                        window.location.reload();
                                    });
                                },
                                success: function(resposta){
                                    console.log(resposta);
                                    if(resposta != "false" && resposta != "Unauthorized" && isJson(resposta)){
                                        resposta = JSON.parse(resposta);
                                        var confirmationCode = resposta.code;
                                        var reference = resposta.reference;
                                        var vlrFrete = resposta.vlr_frete;
                                        var transactionCode = "0";
                                        
                                        guardar_compra(confirmationCode, transactionCode, transportCode, vlrFrete, reference);
                                        
                                        PagSeguroLightbox({
                                            code: confirmationCode
                                            }, {
                                            success: function(transactionCode){
                                                mensagemAlerta("Sua compra foi finalizada com sucesso", false, "limegreen", "finalizar-compra.php?clear=true");
                                            },
                                            abort: function() {
                                                mensagemAlerta("Ocorreu um erro ao finalizar a compra. Tente novamente.", false, false);
                                                botaoFinalizar.html("<i class='fas fa-sync icon-button'></i> Recarregar página");
                                                botaoFinalizar.off().on("click", function(){
                                                    window.location.reload();
                                                });
                                            }
                                        });
                                    }else{
                                        mensagemAlerta("Ocorreu um erro ao finalizar sua compra");
                                        botaoFinalizar.html("<i class='fas fa-sync icon-button'></i> Recarregar página");
                                        botaoFinalizar.off().on("click", function(){
                                            window.location.reload();
                                        });
                                    }
                                }
                            });*/
                        }else{
                            finalizandoCompra = false;
                            mensagemAlerta("Selecione uma opção de frete");
                        }
                    }
                    
                }
                
                function set_view_preco(total, frete){
                    if(typeof total != "undefined"){
                        viewTotalCompra.html(total);
                    }
                    if(typeof frete != "undefined"){
                        viewCarrinhoFrete.html("R$ " + frete);
                    }
                }
                
                /*END MAIN FUNCTIONS*/
                calcular_frete(); // Primeiro calculo de frete
                
                
                // FUNCAO SELECT DA OPCAO FRETE
                setInterval(function(){
                    var opcaoFrete = $(".opcao-frete");
                    var viewCarrinhoFrete = $(".view-frete");
                    opcaoFrete.each(function(){
                        var input = $(this);
                        var value = input.val();
                        var frete = input.attr("price-frete");
                        input.on("change", function(){
                            opcaoFrete.each(function(){
                                $(this).prop("checked", false); 
                            });
                            input.prop("checked", true);
                            var total = parseFloat(totalCarrinho) + parseFloat(frete);
                            total = total.toFixed(2);
                            set_view_preco(total, frete);
                        });
                    });
                }, 500);
                
                // FUNCAO RECALCULA FRETE ENDERECO ALTERNATIVO
                var objEnderecoAlternativo = $(".endereco-alternativo");
                var objCheckboxEndereco = $("#enderecoDiferente");
                var botaoSalvar = $(".salvar-new-endereco");
                objCheckboxEndereco.off().on("change", function(){
                    var checkbox = $(this);
                    var checked = checkbox.prop("checked");
                    if(checked){
                        objEnderecoAlternativo.css({
                            display: "block", 
                        });
                        
                        $("#newCep").on("blur", function(){
                            var cep = $("#newCep").val();
                            var objRua = $("#newRua");
                            var objBairro = $("#newBairro");
                            var objEstado = $("#newEstado");
                            var objCidade = $("#newCidade");
                            if(cep.length == 9){
                                var cepF = cep.replace("-", "");
                                buscarCEP(cepF, objRua, objEstado, objCidade, objBairro);
                            }else{
                                objRua.val("");
                                objBairro.val("");
                                objEstado.val("");
                                objCidade.val("");
                            }
                        });
                        
                        botaoSalvar.off().on("click", function(){
                            var cep = $("#newCep").val();
                            var rua = $("#newRua").val();
                            var numero = $("#newNumero").val();
                            var complemento = $("#newComplemento").val();
                            var bairro = $("#newBairro").val();
                            var cidade = $("#newCidade").val();
                            var estado = $("#newEstado").val();
                            
                            
                            if(IsCEP(cep) == false){
                                mensagemAlerta("O campo CEP deve ser preenchido corretamente");
                                return false;
                            }

                            if(rua.length == 0){
                                mensagemAlerta("Certifique-se de que o CEP esteja preenchido corretamente");
                                return false;
                            }

                            if(numero.length == 0){
                                mensagemAlerta("O campo número deve conter no mínimo 1 caracter");
                                return false;
                            }
                            
                            cepAlternativo = true;
                            $("#cepDestino").val(cep);
                            $("#ruaDestino").val(rua);
                            $("#numeroDestino").val(numero);
                            $("#complementoDestino").val(complemento);
                            $("#bairroDestino").val(bairro);
                            $("#cidadeDestino").val(cidade);
                            $("#estadoDestino").val(estado);
                            set_destino(cep, rua, numero, complemento, bairro, cidade, estado);
                            calcular_frete();
                        });
                    }else{
                        cepAlternativo = false;
                        set_destino(cepPadrao, ruaPadrao, numeroPadrao, complementoPadrao, bairroPadrao, cidadePadrao, estadoPadrao);
                        calcular_frete();
                        objEnderecoAlternativo.css({
                            display: "none", 
                        });
                    }
                });
                
                /*END CALCULO DE FRETE*/
                
                /*FUNCOES DO CARRINHO*/
                var cartItem = $(".view-subtotal-produto");
                cartItem.each(function(){
                    var item = $(this);
                    var botaoRemover = item.children(".botao-remover")
                    botaoRemover.off().on("click", function(){
                        var idProduto = botaoRemover.attr("carrinho-id-produto");
                        function remover(){
                            var dados = {
                                acao_carrinho: "remover_produto",
                                id_produto: idProduto,
                            }
                            $.ajax({
                                type: "POST",
                                url: "@classe-carrinho-compras.php",
                                data: dados,
                                error: function(){
                                    notificacaoPadrao("Ocorreu um erro ao remover o produto");
                                    adicionandoCarrinho = false;
                                },
                                success: function(resposta){
                                    if(resposta == "true"){
                                        notificacaoPadrao("<i class='fas fa-times'></i> Produto removido", "success");
                                        window.location.reload();
                                    }else{
                                        notificacaoPadrao("Ocorreu um erro ao remover o produto");
                                    }
                                }

                            });
                        }

                        mensagemConfirma("Tem certeza que deseja remover este produto?", remover);
                    });
                });
                
                var controllerPreco = $(".controller-preco");
                var inputQuantidade = controllerPreco.children(".quantidade-produto");
                inputQuantidade.each(function(){
                    var input = $(this);
                    var idProduto = input.attr("carrinho-id-produto");
                    var quantidade = 1;
                    input.off().on("change", function(){
                        quantidade = input.val();
                        if(quantidade == 0 || quantidade == "" || typeof quantidade == "undefined"){
                            quantidade = 1;
                        }
                        if(idProduto != "undefined" && idProduto > 0){
                            adicionandoCarrinho = true;
                            var quantidade = quantidade;
                            $.ajax({
                                type: "POST",
                                url: "@classe-carrinho-compras.php",
                                data: {acao_carrinho: "adicionar_produto", id_produto: idProduto, quantidade: quantidade},
                                error: function(){
                                    notificacaoPadrao("Ocorreu um erro ao adicionar o produto ao carrinho");
                                    adicionandoCarrinho = false;
                                },
                                success: function(resposta){
                                    if(resposta == "true"){
                                        notificacaoPadrao("<i class='fas fa-plus'></i> Produto atualizado", "success");
                                        setTimeout(function(){
                                            window.location.reload();
                                        }, 300);
                                    }else if(resposta == "sem_estoque"){
                                        notificacaoPadrao("<i class='fas fa-exclamation-circle'></i> Produto sem estoque");
                                    }else{
                                        notificacaoPadrao("Ocorreu um erro ao adicionar o produto ao carrinho");
                                    }
                                }

                            });
                        }else{
                            notificacaoPadrao("Ocorreu um erro ao adicionar o produto ao carrinho");
                        }
                    });
                });
                /*END FUNCOES DO CARRINHO*/
                
                if(document.getElementById("botaoLoginCompra") != null){
                    document.getElementById("botaoLoginCompra").addEventListener("click", function(){
                        toggleLogin();
                    });
                }
                
                if(document.getElementById("botaoFinalizarCompra") != null){
                    document.getElementById("botaoFinalizarCompra").addEventListener("click", function(){
                        finalizarCompra();
                    });
                }
            });
            
        </script>
        <!--END PAGE JS-->
    </head>
    <body>
        <!--REQUIRES PADRAO-->
        <?php
            require_once "@link-body-scripts.php";
            require_once "@classe-system-functions.php";
            require_once "@include-header-principal.php";
            require_once "@include-interatividade.php";
        ?>
        <!--THIS PAGE CONTENT-->
        <div class="main-content">
            <h1 class="titulo">Finalize sua compra</h1>
            <article>Ao contrário do que se acredita, Lorem Ipsum não é simplesmente um texto randômico. Com mais de 2000 anos, suas raízes podem ser encontradas em uma obra de literatura latina clássica datada de 45 AC.</article>
            
            <!--DISPLAY ITENS-->
            <div class="display-carrinho">
                <?php
                    require_once "@classe-carrinho-compras.php";
                    $cls_carrinho = new Carrinho();
                    $tabela_imagens_produtos = $pew_custom_db->tabela_imagens_produtos;
                
                    if(isset($_GET["token_carrinho"]) && $_GET["token_carrinho"] != ""){
                        $carrinho_finalizar = $cls_carrinho->rebuild_carrinho($_GET["token_carrinho"]);
                    }else{
                        $carrinho_finalizar = $cls_carrinho->get_carrinho();
                    }
                
                    $carrinho_json = json_encode($carrinho_finalizar);
                    echo "<input type='hidden' value='$carrinho_json' id='carrinhoFinalizar'>";
                
                    $dirImagens = "imagens/produtos";
                    if(count($carrinho_finalizar["itens"]) > 0){
                        $totalItens = 0;
                        foreach($carrinho_finalizar["itens"] as $indice => $item_carrinho){
                            $idProduto = $item_carrinho["id"];
                            $nome = $item_carrinho["nome"];
                            $preco = $item_carrinho["preco"];
                            $preco = $pew_functions->custom_number_format($preco);
                            $quantidade = $item_carrinho["quantidade"];
                            $subtotal = $preco * $quantidade;
                            $subtotal = $pew_functions->custom_number_format($subtotal);
                            $totalItens += $subtotal;
                            $condicao = "id_produto = '$idProduto'";
                            $queryImagem = mysqli_query($conexao, "select * from $tabela_imagens_produtos where $condicao order by posicao asc");
                            $infoImagem = mysqli_fetch_array($queryImagem);
                            $imagem = $infoImagem["imagem"];
                            if(!file_exists($dirImagens."/".$imagem) || $imagem == ""){
                                $imagem = "produto-padrao.png";
                            }
                            // FRETE INFO
                            $precoFrete = $preco;
                            $comprimento = $item_carrinho["comprimento"];
                            $largura = $item_carrinho["largura"];
                            $altura = $item_carrinho["altura"];
                            $peso = $item_carrinho["peso"];
                            $porcentDesconto = isset($item_carrinho["desconto"]) ? ($item_carrinho["desconto"] * 100) / 100 : 0;
                            echo "<div class='item-carrinho'>";
                                if(isset($item_carrinho["desconto"]) && $item_carrinho["desconto"] > 0){
                                    echo "<div class='promo-tag'>-$porcentDesconto%</div>";
                                }
                                echo "<div class='box-imagem'><img class='imagem' src='$dirImagens/$imagem'></div>";
                                echo "<div class='information'>";
                                    echo "<h2 class='titulo'>$nome</h2>";
                                echo "</div>";
                                echo "<div class='price-field'>";
                                    echo "<div class='controller-preco'>";
                                        echo "<h5 class='price'>R$ $preco</h5>";
                                        echo "<input type='text' class='quantidade-produto' placeholder='Qtd' value='$quantidade' carrinho-id-produto='$idProduto'>";
                                    echo "</div>";
                                    echo "<div class='view-subtotal-produto'>";
                                        echo "<h4 class='subtotal'>R$ <span class='view-price'>$subtotal</span></h4>";
                                        echo "<a class='link-padrao botao-remover' carrinho-id-produto='$idProduto'>Remover</a>";
                                    echo "</div>";
                                echo "</div>";
                                echo "<span class='info-frete'>";
                                    echo "<input type='hidden' id='freteIdProduto' value='$idProduto'>";
                                    echo "<input type='hidden' id='freteTituloProduto' value='$nome'>";
                                    echo "<input type='hidden' id='fretePrecoProduto' value='$precoFrete'>";
                                    echo "<input type='hidden' id='freteComprimentoProduto' value='$comprimento'>";
                                    echo "<input type='hidden' id='freteLarguraProduto' value='$largura'>";
                                    echo "<input type='hidden' id='freteAlturaProduto' value='$altura'>";
                                    echo "<input type='hidden' id='fretePesoProduto' value='$peso'>";
                                    echo "<input type='hidden' id='freteQuantidadeProduto' value='$quantidade'>";
                                echo "</span>";
                            echo "</div>";
                        }
                            echo "<div class='display-resultados-frete before-checkout-area'>";
                                echo "<h5 class='titulo'>Método de envio</h5>";
                                $totalItens = $pew_functions->custom_number_format($totalItens);
                                if(isset($_SESSION["minha_conta"])){
                                    $sessaoConta = $_SESSION["minha_conta"];
                                    $emailConta = isset($sessaoConta["email"]) ? $sessaoConta["email"] : null;
                                    $senhaConta = isset($sessaoConta["senha"]) ? $sessaoConta["senha"] : null;
                                    if($loginConta->auth($emailConta, $senhaConta) == true){
                                        $idConta = $loginConta->query_minha_conta("md5(email) = '$emailConta' and senha = '$senhaConta'");
                                        $loginConta->montar_minha_conta($idConta);
                                        $infoConta = $loginConta->montar_array();
                                        $enderecos = $infoConta["enderecos"];
                                        $idEndereco = $enderecos["id"];
                                        $cepConta = $enderecos["cep"];
                                        $rua = $enderecos["rua"];
                                        $numero = $enderecos["numero"];
                                        $complemento = $enderecos["complemento"] != "" ? $enderecos["complemento"] : "";
                                        $bairro = $enderecos["bairro"];
                                        $cidade = $enderecos["cidade"];
                                        $estado = $enderecos["estado"];
                                        echo "<label class='label-edita-endereco'>";
                                            echo "<input type='checkbox' name='endereco_diferente' id='enderecoDiferente'> Enviar para outro endereço";
                                        echo "</label>";
                                        echo "<div class='endereco-alternativo'>";
                                        ?>
                                            <div class='label medium'>
                                                <h4 class='input-title'>CEP</h4>
                                                <input type='text' placeholder='00000-000' name='cep' id='newCep' tabindex='1' class='mascara-cep-finaliza input-standard'>
                                                <h6 class='msg-input'></h6>
                                            </div>
                                            <div class='label large'>
                                                <h4 class='input-title'>Rua</h4>
                                                <input type='text' placeholder='Rua' name='rua' id='newRua' class='input-nochange input-standard' readonly>
                                                <h6 class='msg-input'></h6>
                                            </div>
                                            <br style='clear: both'>
                                            <div class='label medium'>
                                                <h4 class='input-title'>Número</h4>
                                                <input type='text' placeholder='Numero' name='numero' id='newNumero' tabindex='2' class='input-standard'>
                                                <h6 class='msg-input'></h6>
                                            </div>
                                            <div class='label medium'>
                                                <h4 class='input-title'>Complemento</h4>
                                                <input type='text' placeholder='Complemento' name='complemento' id='newComplemento' tabindex='3' class='input-standard'>
                                                <h6 class='msg-input'></h6>
                                            </div>
                                            <div class='label medium'>
                                                <h4 class='input-title'>Bairro</h4>
                                                <input type='text' placeholder='Bairro' name='bairro' id='newBairro' class='input-nochange input-standard' readonly>
                                            </div>
                                            <div class='group'>
                                                <div class='label medium'>
                                                    <h4 class='input-title'>Estado</h4>
                                                    <input type='text' placeholder='Estado' name='estado' id='newEstado' class='input-nochange input-standard' readonly>
                                                </div>
                                                <div class='label medium'>
                                                    <h4 class='input-title'>Cidade</h4>
                                                    <input type='text' placeholder='Cidade' name='cidade' id='newCidade' class='input-nochange input-standard' readonly>
                                                </div>
                                            </div>
                                            <div class='label full clear'>
                                                <button class='botao-salvar salvar-new-endereco' type='button'>SALVAR</button>
                                            </div>
                                        <?php
                                        echo "</div>";
                                        echo "<h5 class='msg-endereco'>Enviando para: <b>$rua, $numero $complemento</b></h5>";
                                        echo "<div class='span-frete'></div>";
                                        echo "<input type='hidden' id='cepDestino' value='$cepConta'>";
                                        echo "<input type='hidden' id='ruaDestino' value='$rua'>";
                                        echo "<input type='hidden' id='numeroDestino' value='$numero'>";
                                        echo "<input type='hidden' id='complementoDestino' value='$complemento'>";
                                        echo "<input type='hidden' id='bairroDestino' value='$bairro'>";
                                        echo "<input type='hidden' id='estadoDestino' value='$estado'>";
                                        echo "<input type='hidden' id='cidadeDestino' value='$cidade'>";
                                    }else{
                                        echo "<h6 style='margin: 0px 0px 0px 15px; font-weight: normal;'>Entre com sua conta para calcular</h6>";
                                    }
                                }else{
                                    echo "<h6 style='margin: 0px 0px 0px 15px; font-weight: normal;'>Entre com sua conta para calcular</h6>";
                                }
                            echo "</div>";
                            echo "<div class='bottom-info before-checkout-area'>";
                                echo "<input type='hidden' id='totalCarrinho' value='$totalItens'>";
                                echo "<div class='display-prices'>";
                                    echo "<h5 class='info'><span class='title'>Subtotal</span><span class='value view-subtotal'>R$ $totalItens</span></h5>";
                                    echo "<h5 class='info'><span class='title title-bold'>Frete</span><span class='value view-frete'>R$ 0.00</span></h5>";
                                echo "</div>";
                                echo "<div class='display-total'>";
                                    echo "<h4 class='view-total'><span class='title title-bold'>Total</span> R$ <span class='final-value view-total'>$totalItens</span></h4>";
                                echo "</div>";
                                if(isset($_SESSION["minha_conta"])){
                                    if($loginConta->auth($emailConta, $senhaConta) == true){
                                        $idCliente = $loginConta->query_minha_conta("md5(email) = '$emailConta' and senha = '$senhaConta'");
                                        $loginConta->montar_minha_conta($idCliente);
                                        $infoCliente = $loginConta->montar_array();
                                        echo "<span class='dados-compra'>";
                                            echo "<input type='hidden' id='tokenCarrinho' value='{$carrinho_finalizar["token"]}'>";
                                            echo "<input type='hidden' id='idCliente' value='{$infoCliente["id"]}'>";
                                            echo "<input type='hidden' id='nomeCliente' value='{$infoCliente["usuario"]}'>";
                                            echo "<input type='hidden' id='cpfCliente' value='{$infoCliente["cpf"]}'>";
                                            echo "<input type='hidden' id='emailCliente' value='{$infoCliente["email"]}'>";
                                        echo "</span>";
                                        echo "<button type='button' class='botao-continuar botao-finalizar-compra' id='botaoFinalizarCompra'>Continuar <i class='fas fa-angle-double-right icon-button'></i></button>";
                                    }else{
                                        echo "<button type='button' class='botao-continuar botao-login-compra' id='botaoLoginCompra'><i class='fas fa-lock icon-button'></i> Faça login para continuar</button>";
                                    }
                                }else{
                                    echo "<button type='button' class='botao-continuar botao-login-compra' id='botaoLoginCompra'><i class='fas fa-lock icon-button'></i> Faça login para continuar</button>";
                                }

                            echo "</div>";
                        
                        // CHECKOUT TRANSPARENTE
                            
                        $checkoutFolder = "checkout";
                        echo "<link type='text/css' rel='stylesheet' href='$checkoutFolder/css/checkout-style.css?v=" . uniqid() . "'>";
                        echo "<script type='text/javascript' src='$checkoutFolder/js/checkout-functions.js?v=" . uniqid() . "'></script>";
                        echo "<div class='finish-checkout-box'>";
                        //require_once "$checkoutFolder/@controller-checkout.php";
                        echo "</div>";
                            
                        // END CHECKOUT TRANSPARENTE
                    }else{
                        echo "<h5 align=center style='width: 100%;'><br>Seu carrinho está vazio</h5>";
                        echo "<h5 align=center style='width: 100%;'><br><a href='index.php' class='link-padrao'>Voltar as compras</a></h5>";
                    }
                ?>
            </div>
            <!--END DISPLAY ITENS-->
        </div>
        <!--END THIS PAGE CONTENT-->
        <?php
            require_once "@include-footer-principal.php";
        ?>
        <!--END REQUIRES PADRAO-->
    </body>
</html>