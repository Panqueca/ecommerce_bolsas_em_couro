<?php
    session_start();
    $nomeEmpresa = "Bolsas em Couro";
    $descricaoPagina = "DESCRIÇÃO MODELO ATUALIZAR...";
    $tituloPagina = "Finalizar compra - $nomeEmpresa";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">
        <meta name="HandheldFriendly" content="true">
        <meta name="description" content="<?php echo $descricaoPagina;?>">
        <meta name="author" content="Efectus Web">
        <title><?php echo $tituloPagina;?></title>
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
                width: calc(55% - 180px);
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
            .main-content .display-carrinho .bottom-info .botao-finalizar-compra{
                background-color: #6abd45;
                border: none;
                padding: 0px 20px 0px 20px;
                font-size: 14px;
                font-weight: bold;
                color: #fff;
                height: 30px;
                outline: none;
                cursor: pointer;
            }
            .main-content .display-carrinho .bottom-info .botao-finalizar-compra:hover{
                background-color: #518d36;   
            }
        </style>
        <!--END PAGE CSS-->
        <!--PAGE JS-->
        <script>
            $(document).ready(function(){
                console.log("Página carregada");
                
                /*CALCULO DE FRETE*/
                var inputFrete = $(".input-frete");
                var botaoCalculoFrete = $(".botao-calculo-frete");
                var displayResultadoFrete = $(".display-resultados-frete .span-frete");
                var iconFrete = "<i class='fas fa-truck'></i>";
                var iconLoading = "<i class='fas fa-spinner fa-spin icone-loading'></i>";
                var calculandoFrete = false;
                var infoCalculoFrete = $(".info-frete");
                
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
                    jsonProduto[ctrl_array] = {"id": idProduto, "titulo": tituloProduto, "preco": precoProduto, "comprimento": comprimentoProduto, "largura": larguraProduto, "altura": alturaProduto, "peso": pesoProduto};
                    ctrl_array++;
                });                
                                
                input_mask(".input-frete", "99999-999");
                
                function calcular_frete(){
                    if(!calculandoFrete){
                        var urlFrete = "frete-correios/@trigger-calculo.php";
                        var cepDestino = "80230-040";
                        var codigosServico = ["41106", "40010", "40215", "40290"];
                        displayResultadoFrete.html(iconLoading + " Calculando frete");
                        
                        if(cepDestino.length == 9){
                            
                            botaoCalculoFrete.html(iconLoading);
                            calculandoFrete = true;
                            var mensagemFinal = [];
                            var ctrlExec = 0;
                            
                            function get_titulo_servico(cod){
                                switch(cod){
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
                                    codigo_correios: codigo,
                                    produtos: jsonProduto,
                                }
                                $.ajax({
                                    type: "POST",
                                    url: urlFrete,
                                    data: JSON.stringify(dados),
                                    contentType: "application/json",
                                    error: function(){
                                        botaoCalculoFrete.html(iconFrete);
                                        displayResultadoFrete.html("Ocorreu um erro ao calcular o frete. Recarregue a página e tente novamente.");
                                    },
                                    success: function(resultado){
                                        
                                        var tituloServico = get_titulo_servico(codigo);
                                        
                                        if(resultado != false){
                                            if(isJson(resultado) == true && JSON.parse(resultado) != false){
                                                var jsonData = JSON.parse(resultado);
                                                var valor = jsonData.valor.toFixed(2);
                                                var prazo = jsonData.prazo;
                                                var msgPadrao = "<input type='checkbox' name='metodo_envio[]' class='opcao-frete' value='" + codigo + "' price-frete='" + valor + "'>" + tituloServico + ": <b>R$" + valor + "</b> em até <b>" + prazo + "</b>";
                                                mensagemFinal[ctrlExec] = "<br>" + msgPadrao + "<br>";
                                            }else{
                                                mensagemFinal[ctrlExec] = "<br>" + tituloServico + ": Localidade insdisponível<br>";
                                            }
                                        }else{
                                            notificacaoPadrao("Ocorreu um erro ao calcular o frete. Recarregue a página e tente novamente.");
                                        }
                                        ctrlExec++;
                                        
                                        if(ctrlExec == codigosServico.length && mensagemFinal.length > 0){
                                            botaoCalculoFrete.html(iconFrete);
                                            calculandoFrete = false;
                                            var mensagem = "";
                                            mensagemFinal.forEach(function(msg){
                                                if(msg == "") msg = "<br>" + get_titulo_servico(codigo) + ": Localidade indisponível<br>";
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
                
                calcular_frete();
                
                var totalCarrinho = $("#totalCarrinho").val();
                var viewTotalCompra = $(".final-value");
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
                            viewCarrinhoFrete.html("R$ " + frete);
                            var total = parseFloat(totalCarrinho) + parseFloat(frete);
                            total = total.toFixed(2);
                            viewTotalCompra.html("R$ " + total);
                        });
                    });
                }, 500);
                /*END CALCULO DE FRETE*/
                
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
                    $carrinho_finalizar = $cls_carrinho->get_carrinho();
                    $tabela_imagens_produtos = $pew_custom_db->tabela_imagens_produtos;
                
                    $dirImagens = "imagens/produtos";
                    if(count($carrinho_finalizar) > 0){
                        $totalItens = 0;
                        foreach($carrinho_finalizar as $indice => $item_carrinho){
                            $idProduto = $item_carrinho["id"];
                            $nome = $item_carrinho["nome"];
                            $preco = $item_carrinho["preco"];
                            $preco = $pew_functions->custom_number_format($preco);
                            $quantidade = $item_carrinho["quantidade"];
                            $subtotal = $preco * $quantidade;
                            $subtotal = $pew_functions->custom_number_format($subtotal);
                            $totalItens += $subtotal;
                            $condicao = "id_produto = '$idProduto'";
                            $queryImagem = mysqli_query($conexao, "select * from $tabela_imagens_produtos where $condicao order by posicao desc");
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
                            echo "<div class='item-carrinho'>";
                                echo "<div class='box-imagem'><img class='imagem' src='$dirImagens/$imagem'></div>";
                                echo "<div class='information'>";
                                    echo "<h2 class='titulo'>$nome</h2>";
                                echo "</div>";
                                echo "<div class='price-field'>";
                                    echo "<div class='controller-preco'>";
                                        echo "<h5 class='price'>R$ $preco</h5>";
                                        echo "<input type='number' class='quantidade-produto' placeholder='Qtd' value='$quantidade'>";
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
                                echo "</span>";
                            echo "</div>";
                        }
                        $totalItens = $pew_functions->custom_number_format($totalItens);
                        echo "<div class='display-resultados-frete'>";
                            echo "<h5 class='titulo'>Método de envio</h5>";
                            echo "<div class='span-frete'></div>";
                        echo "</div>";
                        echo "<div class='bottom-info'>";
                            echo "<input type='hidden' id='totalCarrinho' value='$totalItens'>";
                            echo "<div class='display-prices'>";
                                echo "<h5 class='info'><span class='title'>Subtotal</span><span class='value view-subtotal'>R$ $totalItens</span></h5>";
                                echo "<h5 class='info'><span class='title title-bold'>Frete</span><span class='value view-frete'>R$ 0.00</span></h5>";
                            echo "</div>";
                            echo "<div class='display-total'>";
                                echo "<h4 class='view-total'><span class='title title-bold'>Total</span> R$ <span class='final-value view-total'>$totalItens</span></h4>";
                            echo "</div>";
                            echo "<button type='button' class='botao-finalizar-compra'>Finalizar <i class='fas fa-check'></i></button>";
                        echo "</div>";
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