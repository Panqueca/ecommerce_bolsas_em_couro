<?php

    ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

    session_start();
    
    require_once "@classe-system-functions.php";
    require_once "@classe-produtos.php";
    require_once "@classe-paginas.php";

    /*SET TABLES*/
    $tabela_produtos = $pew_custom_db->tabela_produtos;
    $tabela_produtos_relacionados = $pew_custom_db->tabela_produtos_relacionados;
    /*END SET TABLES*/

    /*DEFAULT VARS*/
    $dirImagensProduto = "imagens/produtos";
    /*END DEFAULT VARS*/

    $idInternaProduto = isset($_GET["id_produto"]) ? (int)$_GET["id_produto"] : 0;
    $totalProduto = $pew_functions->contar_resultados($tabela_produtos, "id = '$idInternaProduto'");
    $produto = new Produtos();
    $produto->montar_produto($idInternaProduto);
    $infoProduto = $produto->montar_array();

    if($totalProduto > 0){
        $cls_paginas->set_titulo($infoProduto["nome"]);
        $cls_paginas->set_descricao($infoProduto["descricao_curta"]);
    }else{
        $cls_paginas->set_titulo("Produto não encontrado");
        $infoProduto = null;
    }
    
    $infoDepartamentos = $produto->get_departamentos_produto();
    $totalDepartamentos = is_array($infoDepartamentos) ? count($infoDepartamentos) : 0;
    if($totalDepartamentos){
        $breadCrumbDepartamento = mb_convert_case($infoDepartamentos[0]["titulo"], MB_CASE_TITLE, "UTF-8");
        $breadCrumbRefDepartamento = $infoDepartamentos[0]["ref"];
    }

    $infoCategorias = $produto->get_categorias_produto();
    $totalCategorias = is_array($infoCategorias) ? count($infoCategorias) : 0;
    if($totalCategorias){
        $breadCrumbCategoria = mb_convert_case($infoCategorias[0]["titulo"], MB_CASE_TITLE, "UTF-8");
        $breadCrumbRefCategoria = $infoCategorias[0]["ref"];
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <base href="<?= $cls_paginas->http.$cls_paginas->base_path."/"; ?>">
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
                margin: 40px auto;
                min-height: 300px;
            }
            .main-content .navigation-tree{
                width: 100%;
                margin-bottom: 20px;
            }
            .section-produto{
                width: 100%;
                display: flex;
                flex-flow: row wrap;
                margin: 0px 0px 20px 0px;
            }
            .section-produto .display-miniaturas{
                width: 20%;
            }
            .section-produto .display-miniaturas .box-miniaturas{
                width: 50%;
                margin: 0px 0px 10px 0px;
            }
            .section-produto .display-miniaturas .box-miniaturas .miniatura{
                width: 100%;
                cursor: pointer;
            }
            .section-produto .display-miniaturas .box-miniaturas .miniatura:hover{
                opacity: .8;
            }
            .section-produto .display-miniaturas .box-play{
                width: 100px;
                height: 60px;
                display: flex;
                justify-content: center;
                align-items: center;
                font-size: 12px;
                flex-direction: column;
                text-align: center;
                margin: 10px 0px 10px 0px;
                cursor: pointer;
                color: #999;
            }
            .section-produto .display-miniaturas .box-play:hover{
                color: #333;   
            }
            .section-produto .display-miniaturas .box-play .icon-play{
                font-size: 52px;
                width: 100%;
                color: #ccc;
                cursor: pointer;
            }
            .section-produto .display-miniaturas .box-play:hover .icon-play{
                color: #333;
            }
            .section-produto .display-miniaturas .display-video{
                position: fixed;
                top: 130px;
                width: 100%;
                height: 100%;
                top: 0px;
                left: 0px;
                margin: 0 auto;
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 200;
                background-color: rgba(0, 0, 0, .5);
                visibility: hidden;
                opacity: 0;
                transition: .3s;
            }
            .section-produto .display-miniaturas .display-video iframe{
                width: 800px;
                height: 500px;
            }
            .section-produto .display-miniaturas .display-video .botao-voltar{
                position: absolute;
                bottom: 40px;
                margin: 0 auto;
                left: 0;
                right: 0;
                width: 100px;
                text-align: center;
                font-size: 16px;
                color: #fff;
                background-color: transparent;
                border: none;
                cursor: pointer;
                border-bottom: 2px solid transparent;
                padding: 5px 0px 5px 0px;
            }
            .section-produto .display-miniaturas .display-video .botao-voltar:hover{
                border-color: #fff;   
            }
            .section-produto .display-imagem-principal{
                width: 50%;
                text-align: center;
            }
            .section-produto .display-imagem-principal .imagem-principal{
                width: 90%;
            }
            .section-produto .display-info-produto{
                width: 30%;
                text-align: right;
            }
            .section-produto .display-info-produto .titulo-produto{
                font-size: 28px;
                margin: 10px 0px 10px 0px;
            }
            .section-produto .display-info-produto .preco-produto{
                font-size: 18px;
                color: #666;
                font-weight: normal;
            }
            .section-produto .display-info-produto .preco-produto .promo-price{
                text-decoration: line-through;
            }
            .section-produto .display-info-produto .preco-produto .final-price{
                font-size: 28px;
                white-space: nowrap;
                color: #6abd45;
            }
            .section-produto .display-info-produto .price-info{
                font-weight: normal;
                color: #666;
            }
            .section-produto .display-info-produto .view-disponibilidade{
                font-size: 16px;
                margin-bottom: 15px;
            }
            .section-produto .display-info-produto .icone-disponibilidade{
                font-size: 18px;
            }
            .section-produto .display-info-produto .disponivel{
                color: #6abd45;
            }
            .section-produto .display-info-produto .indisponivel{
                color: #d11a1a;
            }
            .section-produto .display-info-produto .display-cores{
                width: 100%;
                display: flex;
                height: 35px;
                margin: 25px 0px 25px 0px;
                padding: 0px 10px 10px 0px;
                overflow: auto;
                justify-content: flex-end;
            }
            .section-produto .display-info-produto .display-cores img{
                border-radius: 50%;
            }
            .display-cores::-webkit-scrollbar-button:hover{
                background-color: #AAA;
            }
/*            .display-cores::-webkit-scrollbar-thumb{
                background-color: #ccc;
            }
            .display-cores::-webkit-scrollbar-thumb:hover{
                background-color: #999;
            }
            .display-cores::-webkit-scrollbar-track{
                background-color: #efefef;
            }
            .display-cores::-webkit-scrollbar-track:hover{
                background-color: #efefef;
            }*/
            .display-cores::-webkit-scrollbar{
                width: 5px;
                height: 5px;
            }
            .section-produto .display-info-produto .display-cores .box-cor{
                width: 30px;
                height: 30px;
                flex: 0 0 30px;
                background-color: #eee;
                margin: 0px 0px 0px 10px;
                border-radius: 50%;
            }
            .section-produto .display-info-produto .display-cores .box-cor:hover{
                opacity: .7;   
            }
            .section-produto .display-info-produto .display-cores .box-cor img{
                width: 100%;   
            }
            .section-produto .display-info-produto .display-comprar{
                display: flex;
                justify-content: flex-end;
                flex-flow: row wrap;
            }
            .section-produto .display-info-produto .display-comprar .quantidade-produto{
                height: 36px;
                width: 40px;
                padding: 0px;
                border: 2px solid #ddd;
                margin-right: 5px;
                text-align: center;
                color: #666;
                font-size: 18px;
                line-height: 36px;
                outline: none;
            }
            .section-produto .display-info-produto .display-comprar .quantidade-produto:focus{
                border-color: #888;   
            }
            .section-produto .display-info-produto .display-comprar .botao-comprar{
                border: none;
                color: #fff;
                background-color: #408122;
                font-size: 24px;
                width: 170px;
                height: 40px;
                transition: .2s;
                cursor: pointer;
                outline: none;
            }
            .section-produto .display-info-produto .display-comprar .botao-comprar:hover{
                background-color: #2f6117;
            }
            .section-produto .display-info-produto .display-comprar .botao-comprar:active{
                background-color: #333;
            }
            .section-produto .display-info-produto .calculo-frete{
                width: 100%;
                margin: 40px 20px 0px auto;
                color: #888;
            }
            .section-produto .display-info-produto .calculo-frete .titulo-frete{
                width: 225px;
                font-size: 14px;
                font-weight: normal;
                margin: 0px 0px 5px auto;
                text-align: left;
            }
            .section-produto .display-info-produto .calculo-frete .input-frete{
                width: 160px;
                height: 30px;
                padding: 0px 10px 0px 10px;
                margin: 0px;
                outline: none;
                color: #666;
                font-size: 16px;
                border: 1px solid #999;
            }
            .section-produto .display-info-produto .calculo-frete .botao-calculo-frete{
                width: 40px;
                height: 33px;
                margin: 0px;
                background-color: #eee;
                color: #333;
                border: 1px solid #999;
                position: relative;
                font-size: 16px;
                line-height: 30px;
                cursor: pointer;
                outline: none;
            }
            .section-produto .display-info-produto .calculo-frete .botao-calculo-frete:hover{
                color: #111;
                background-color: #dedede;
            }
            .section-produto .display-info-produto .resultado-frete{
                font-size: 12px;
                margin: 10px 0px 10px 0px;
                color: #333;
            }
            .section-produto .display-info-produto .sem-estoque{
                pointer-events: none;
                background-color: #ccc;
            }
            @media screen and (max-width: 860px){
                .main-content{
                    width: 95%;
                }
                .section-produto .display-miniaturas{
                    width: 10%;
                }
                .section-produto .display-miniaturas .box-miniaturas{
                    width: 100%;
                }
                .section-produto .display-info-produto{
                    width: 40%;
                }
                @media screen and (max-width: 720px){
                    .section-produto{
                        margin-bottom: 60px;
                    }
                    .section-produto .display-miniaturas{
                        width: 20%;
                    }
                    .section-produto .display-miniaturas .box-miniaturas{
                        width: 80%;
                    }
                    .section-produto .display-imagem-principal{
                        width: 80%;
                    }
                    .section-produto .display-info-produto{
                        width: 100%;
                        text-align: left;
                    }
                    .section-produto .display-info-produto .display-cores{
                        justify-content: flex-start;
                    }
                    .section-produto .display-info-produto .display-comprar{
                        width: 100%;
                        float: none;
                        justify-content: flex-start;
                    }
                    .section-produto .display-info-produto .calculo-frete{
                        position: relative;
                        width: 100%;
                        margin: 0px;
                        margin: 40px 0px 10px 0px;
                        top: -10px;
                    }
                    .section-produto .display-info-produto .calculo-frete .input-frete{
                        width: 100px;   
                    }
                    .section-produto .display-info-produto .calculo-frete .titulo-frete{
                        margin: 0px;
                    }
                }
            }
        </style>
        <!--END PAGE CSS-->
        <!--PAGE JS-->
        <script>
            $(document).ready(function(){
                console.log("Página carregada");

                var divImagemPrincipal = $(".display-imagem-principal");
                var imagemPrincipal = divImagemPrincipal.children(".imagem-principal");
                var displayMiniaturas = $(".display-miniaturas");
                var boxMiniaturas = displayMiniaturas.children(".box-miniaturas");
                function changeImagem(src){
                    imagemPrincipal.prop("src", src);
                }
                /*TRIGGERS CHANGE IMAGE*/
                boxMiniaturas.each(function(){
                    var imgMiniatura = $(this).children(".miniatura");
                    var srcMiniatura = imgMiniatura.prop("src");
                    imgMiniatura.off().on("click", function(){
                        changeImagem(srcMiniatura);
                    });
                });
                /*END TRIGGERS CHANGE IMAGE*/
                
                var displayVideo = $(".display-video");
                var botaoVoltar = displayVideo.children(".botao-voltar");
                $(".box-play").off().on("click", function(){
                    displayVideo.css({
                        visibility: "visible",
                        opacity: "1"
                    });
                })
                botaoVoltar.off().on("click", function(){
                    displayVideo.css({
                        visibility: "hidden",
                        opacity: "0"
                    });
                });
                
                /*CALCULO DE FRETE*/
                var inputFrete = $(".input-frete");
                var botaoCalculoFrete = $(".botao-calculo-frete");
                var displayResultadoFrete = $(".resultado-frete");
                var iconFrete = "<i class='fas fa-truck'></i>";
                var iconLoading = "<i class='fas fa-spinner fa-spin icone-loading'></i>";
                var calculandoFrete = false;
                var infoCalculoFrete = $(".display-info-calculo-frete");
                
                var jsonProduto = new Array();
                
                var idProduto = infoCalculoFrete.children("#freteIdProduto").val();
                var tituloProduto = infoCalculoFrete.children("#freteTituloProduto").val();
                var precoProduto = infoCalculoFrete.children("#fretePrecoProduto").val();
                var comprimentoProduto = infoCalculoFrete.children("#freteComprimentoProduto").val();
                var larguraProduto = infoCalculoFrete.children("#freteLarguraProduto").val();
                var alturaProduto = infoCalculoFrete.children("#freteAlturaProduto").val();
                var pesoProduto = infoCalculoFrete.children("#fretePesoProduto").val();
                jsonProduto[0] = {"id": idProduto, "titulo": tituloProduto, "preco": precoProduto, "comprimento": comprimentoProduto, "largura": larguraProduto, "altura": alturaProduto, "peso": pesoProduto};
                                
                input_mask(".input-frete", "99999-999");
                
                botaoCalculoFrete.off().on("click", function(){
                    if(!calculandoFrete){
                        var urlFrete = "@calcular-transporte.php";
                        var cepDestino = inputFrete.val();
                        var codigosServico = ["41106", "40010", "40215", "40290"];
                        if(cepDestino.length == 9){
                            
                            botaoCalculoFrete.html(iconLoading);
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
                                                var strValor = valor > 0 ? "R$ " + valor : "Grátis";
                                                valor = strValor == "Grátis" ? "0.01" : valor;
                                                var strPrazo = prazo != 0 ? " em até <b>"+ prazo +"</b>" : "";
                                                
                                                var msgPadrao = tituloServico + ": <b>" + strValor + "</b>" + strPrazo + "</b>";
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
                });
                /*END CALCULO DE FRETE*/
            });
        </script>
        <!--END PAGE JS-->
    </head>
    <body>
        <!--REQUIRES PADRAO-->
        <?php
            require_once "@link-body-scripts.php";
            /*require_once "@classe-system-functions.php";
            require_once "@classe-produtos.php";*/
            require_once "@classe-vitrine-produtos.php";
            require_once "@include-header-principal.php";
            require_once "@include-interatividade.php";
        ?>
        <!--THIS PAGE CONTENT-->
        <div class="main-content">
            <?php

            if($infoProduto != null){
                
            /*INFO PRODUTO*/
            $nomeProduto = $infoProduto["nome"];
            $precoProduto = $infoProduto["preco"];
            $precoPromocaoProduto = $infoProduto["preco_promocao"];
            $promocaoAtiva = $infoProduto["promocao_ativa"] == 1 && $precoPromocaoProduto > 0 && $precoPromocaoProduto < $precoProduto ? true : false;
            $precoFinal = $promocaoAtiva == true ? $precoPromocaoProduto : $precoProduto;
            $precoBoleto = $precoFinal - ($precoFinal * 0.05);
            $qtdParcelas = 6;
            $precoParcelas = $precoFinal / $qtdParcelas;
            $estoqueProduto = $infoProduto["estoque"];
            $imagensProduto = $infoProduto["imagens"];
            $urlVideo = $infoProduto["url_video"];
                
            $descricaoProduto = $infoProduto["descricao_longa"];
            /*INFO PRODUTO*/
                
            /*FRETE VARS*/
            $precoFrete = $precoFinal;
            $comprimentoProduto = $infoProduto["comprimento"];
            $larguraProduto = $infoProduto["largura"];
            $alturaProduto = $infoProduto["altura"];
            $pesoProduto = $infoProduto["peso"];
            /*END FRETE VARS*/
                

            /*HTML VIEW*/
            $viewPriceField = null;
            if($promocaoAtiva){
                $viewPriceField = "<h3 class='preco-produto'>De <span class='promo-price'>R$".number_format($precoProduto, 2, ",", ".")."</span> por <span class='final-price'>R$".number_format($precoFinal, 2, ",", ".")."</span></h3>";
            }else{
                $viewPriceField = "<h3 class='preco-produto'><span class='final-price'>R$".number_format($precoFinal, 2, ",", ".")."</span></h3>";
            }

            $viewParcelasField = null;
            if($qtdParcelas > 0){
                $viewParcelasField = "<h4 class='price-info'>".$qtdParcelas."x de R$".number_format($precoParcelas, 2, ',', '.')." ou a vista R$".number_format($precoBoleto, 2, ",", ".")."<br> (5% de desconto no boleto)</h4>";
            }else{
                $viewParcelasField = "<h4 class='price-info'>ou à vista R$".number_format($precoBoleto, 2, ",", ".")."<br> (5% de desconto no boleto)</h4>";
            }

            $viewDisponibilidadadeField = $estoqueProduto == 0 ? "<div class='view-disponibilidade indisponivel'><span class='icone-disponibilidade'><i class='fas fa-times'></i></span> SEM ESTOQUE</div>" : "<div class='view-disponibilidade disponivel'><span class='icone-disponibilidade'><i class='fas fa-check'></i></span> EM ESTOQUE</div>";

            $viewBotaoComprar = $estoqueProduto == 0 ? "<button class='botao-comprar sem-estoque'>COMPRAR</button>" : "<input type='text' class='quantidade-produto' value=1 placeholder='Qtd'><button  class='botao-comprar' id='addProdutoCarrinho' carrinho-id-produto='$idInternaProduto'>COMPRAR</button>";
            /*END HTML VIEW*/
                
            $iconArrow = "<i class='fas fa-angle-right icon'></i>";
				
            $navigationTree = "<div class='navigation-tree'><a href='index.php'>Página inicial</a>";
			if(isset($breadCrumbDepartamento)){
				$navigationTree .= "$iconArrow <a href='loja/$breadCrumbRefDepartamento/'>$breadCrumbDepartamento</a>"; 
			}
			if(isset($breadCrumbCategoria)){
				$navigationTree .= "$iconArrow <a href='loja/$breadCrumbRefDepartamento/$breadCrumbRefCategoria/'>$breadCrumbCategoria</a>";
			}
			$navigationTree .= "$iconArrow <a href='#'>$nomeProduto</a></div>";
				
            echo $navigationTree;
                
            ?>
            <section class="section-produto">
                <div class="display-miniaturas">
                    <?php
                        $ctrlImagens = 0;
                        $imagemPrincipal = null;
                        if(is_array($imagensProduto) && count($imagensProduto) > 0){
                            foreach($imagensProduto as $infoImagem){
                                $srcImagem = $infoImagem["src"];
                                $ctrlImagens++;
                                $imagemPrincipal = $ctrlImagens == 1 ? $srcImagem : $imagemPrincipal;
                                if(!file_exists($dirImagensProduto."/".$srcImagem) || $srcImagem == ""){
                                    $imagemPrincipal = "produto-padrao.png";
                                }
                                echo "<div class='box-miniaturas'><img src='$dirImagensProduto/$srcImagem' alt='{$cls_paginas->empresa} - $nomeProduto - Imagem $ctrlImagens' class='miniatura'></div>";
                            }
                        }else{
                            echo "<div class='box-miniaturas'><img src='$dirImagensProduto/produto-padrao.png' alt='{$cls_paginas->empresa} - $nomeProduto - Imagem $ctrlImagens' class='miniatura'></div>";
                        }
                
                        if($urlVideo != null && $urlVideo != 0){
                            echo "<div class='box-play'><i class='fas fa-play-circle icon-play'></i>Veja o vídeo</div>";
                            echo "<div class='display-video'>$urlVideo <button class='botao-voltar'><i class='fas fa-times'></i> VOLTAR</button></div>";
                        }
                    ?>
                </div>
                <div class="display-imagem-principal">
                    <?php
                        if($imagemPrincipal == ""){
                            $imagemPrincipal = "produto-padrao.png";
                        }
                        echo "<img src='$dirImagensProduto/$imagemPrincipal' alt='{$cls_paginas->empresa} - $nomeProduto - Imagem principal' class='imagem-principal'>";
                        
                    ?>
                </div>
                <div class="display-info-produto">
                    <h1 class="titulo-produto"><?php echo $nomeProduto; ?></h1>
                    <?php
                        echo $viewPriceField;
                        echo $viewParcelasField;
                        echo $viewDisponibilidadadeField;
                
                        $infoCoresRelacionadas = $produto->get_cores_relacionadas();
                        $totalCores = is_array($infoCoresRelacionadas) ? count($infoCoresRelacionadas) : 0;
                        if($totalCores > 0){
                            echo "<h6 style='margin: 5px 0px -15px 0px; font-weight: normal;'>Outras cores</h6>";
                            echo "<div class='display-cores'>";
                            foreach($infoCoresRelacionadas as $id => $info){
                                $idRelacao = $info["id_relacao"];
                                $produtoRelacao = new Produtos();
                                $produtoRelacao->montar_produto($idRelacao);
                                $infoProduto = $produtoRelacao->montar_array();
                                $tituloProduto = $infoProduto["nome"];
                                $tituloURL = $pew_functions->url_format($tituloProduto);
                                $idCor = $infoProduto["id_cor"];
                                $queryCor = mysqli_query($conexao, "SELECT * FROM pew_cores where id = '$idCor' and status = 1");
                                $functions = new systemFunctions();
                                $totalCores = $functions->contar_resultados("pew_cores", "id = '$idCor' and status = 1");
                                $urlProdutoRelacao = "$tituloURL/$idRelacao/";
                                $dirImagens = "imagens/cores";
                                if($totalCores > 0){
                                    while($infoCor = mysqli_fetch_assoc($queryCor)){
                                        $nomeCor = $infoCor["cor"];
                                        $imagemCor = $infoCor["imagem"];
                                        if(!file_exists($dirImagens."/".$imagemCor) || $imagemCor == ""){
                                            $imagemCor = "cor-padrao.png";
                                        }
                                        echo "<div class='box-cor'><a href='$urlProdutoRelacao'><img title='$nomeCor' src='$dirImagens/$imagemCor'></a></div>";
                                    }
                                }
                            }
                            echo "</div>";
                        }
                    ?>
                    <div class="display-comprar">
                        <?php echo $viewBotaoComprar; ?>
                    </div>
                    <div class="calculo-frete">
                        <h5 class="titulo-frete">CALCULAR FRETE</h5>
                        <input type="text" class="input-frete">
                        <button class="botao-calculo-frete"><i class="fas fa-truck"></i></button>
                        <div class='resultado-frete'></div>
                        <div class="display-info-calculo-frete">
                            <input type="hidden" id="freteIdProduto" value="<?php echo $idInternaProduto; ?>">
                            <input type="hidden" id="freteTituloProduto" value="<?php echo $nomeProduto; ?>">
                            <input type="hidden" id="fretePrecoProduto" value="<?php echo $precoFrete; ?>">
                            <input type="hidden" id="freteComprimentoProduto" value="<?php echo $comprimentoProduto; ?>">
                            <input type="hidden" id="freteLarguraProduto" value="<?php echo $larguraProduto; ?>">
                            <input type="hidden" id="freteAlturaProduto" value="<?php echo $alturaProduto; ?>">
                            <input type="hidden" id="fretePesoProduto" value="<?php echo $pesoProduto; ?>">
                        </div>
                    </div>
                </div>
            </section>
        </div>
        <section class="produtos-relacionados">
            <?php
                
                require_once "@pew/pew-system-config.php";
                
                function get_relacionados($id_produto){
                    global $tabela_produtos_relacionados, $conexao;
                    $condicao = "id_produto = '$id_produto'";
                    $selected = array();
                    $i = 0;
                    $return = false;
                    
                    $query = mysqli_query($conexao, "select id_relacionado from $tabela_produtos_relacionados where $condicao");
                    while($array = mysqli_fetch_array($query)){
                        $selected[$i] = $array["id_relacionado"];
                        $i++;
                    }
                    
                    $return = is_array($selected) && count($selected) > 0 ? $selected : false;
                    
                    return $return;
                }
                
                $selectedProdutosRelacionados = get_relacionados($idInternaProduto);
                
                if($selectedProdutosRelacionados != false){
                    $vitrineProdutos[0] = new VitrineProdutos("carrossel", 15, "COMPRE JUNTO COM DESCONTO");
                    $vitrineProdutos[0]->montar_vitrine($selectedProdutosRelacionados);
                }
                
            ?>
        </section>
        <style>
            .section-bottom{
                margin-bottom: 40px;   
            }
            .section-bottom .display-paineis{
                position: relative;
                width: 90%;
                margin: 0 auto;
                -webkit-box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);
                -moz-box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);
                box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);
                transition: .2s;
                align-items: center;
                overflow: hidden;
                overflow-y: auto;
            }
            .display-paineis::-webkit-scrollbar-button:hover{
                background-color: #AAA;
            }
            .display-paineis::-webkit-scrollbar-thumb{
                background-color: #ccc;
            }
            .display-paineis::-webkit-scrollbar-thumb:hover{
                background-color: #999;
            }
            .display-paineis::-webkit-scrollbar-track{
                background-color: #efefef;
            }
            .display-paineis::-webkit-scrollbar-track:hover{
                background-color: #efefef;
            }
            .display-paineis::-webkit-scrollbar{
                width: 3px;
                height: 3px;
            }
            .section-bottom .display-paineis .descricao{
                text-align: justify;
                color: #6d6d6d;
            }
            .section-bottom .display-paineis .background-loading{
                position: absolute;
                width: 100%;
                height: 55vh;
                background-color: rgba(255, 255, 255, .5);
                top: 0px;
                margin: 0px;
                opacity: 0;
                transition: .3s;
                visibility: hidden;
                z-index: 80;
                text-align: center;
                display: flex;
                overflow: hidden;
            }
            .section-bottom .display-paineis .background-loading .icone-loading{
                position: absolute;
                font-size: 46px;
                color: #6abd45;
                top: 20vh;
                align-self: center;
                width: 100%;
            }
            .section-bottom .display-paineis .display-buttons{
                position: sticky;
                width: 100%;
                top: 0px;
                left: 0px;
                margin-top: 0px;
                display: flex;
                z-index: 80;
            }
            .section-bottom .display-paineis .top-buttons{
                height: 5vh;
                background-color: #fff;
                border: none;
                cursor: pointer;
                outline: none;
                width: 50%;
                color: #999;
                border-bottom: 2px solid #f6f6f6;
            }
            .section-bottom .display-paineis .top-buttons:hover{
                background-color: #f1f1f1;
            }
            .section-bottom .display-paineis .selected-button{   
                border-bottom: 2px solid green;
                color: green;
            }
            .section-bottom .display-paineis .painel{
                position: absolute;
                width: calc(100% - 80px);
                height: calc(50vh - 80px);
                padding: 40px;
                z-index: 0;
                text-align: left;
                top: 100%;
                left: 0;
                transition: .5s;
                background-color: #fff;
                opacity: 0;
                visibility: hidden;
                display: none;
                transition: 1s all, display 0s;
            }
            .section-bottom .display-paineis .painel-active{
                position: relative;
                opacity: 1;
                top: 0px;
                left: 0px;
                display: block;
                visibility: visible;
                opacity: 1;
            }
            .section-bottom .tabela-especificacoes{
                width: 60%;
                margin: 0px;
            }
            .section-bottom .tabela-especificacoes tbody td{
                background-color: #fafafa;
                padding: 8px;
                transition: .2s;
                color: #555;
            }
            .section-bottom .tabela-especificacoes tbody td:hover{
                background-color: #eee;
                color: #333;
                font-weight: bold;
            }
        </style>
        <script>
            $(document).ready(function(){
                var displayPaineis = $(".section-bottom .display-paineis");
                var botoes = $(".section-bottom .top-buttons");
                var paineis = displayPaineis.children(".painel");

                function mudarPainel(obj){
                    paineis.each(function(){
                        $(this).removeClass("painel-active");
                    });
                    obj.addClass("painel-active");
                }

                botoes.each(function(){
                    var botao = $(this);
                    var idBotao = botao.prop("id");
                    var objPainel = $("#infoProduto"+idBotao);
                    botao.off().on("click", function(){
                        botoes.each(function(){
                            $(this).removeClass("selected-button"); 
                        });
                        botao.addClass("selected-button");
                        mudarPainel(objPainel); 
                    });
                });
            });
        </script>
        <section class="section-bottom">
            <div class="display-paineis">
                <div class="display-buttons">
                    <button class="top-buttons selected-button" id="Div1"><i class="far fa-file-alt"></i> DETALHES</button>
                    <button class="top-buttons" id="Div2"><i class="far fa-list-alt"></i> INFORMAÇÕES TÉNICAS</button>
                </div>
                <div class="painel painel-active" id="infoProdutoDiv1">
                     <?php
                        echo "<article class='descricao'>$descricaoProduto</article>";
                    ?>
                </div>
                <div class="painel" id="infoProdutoDiv2">
                    <h3 class="info-titulo">Mais informações</h3>
                    <?php
                        $infoEspecificacoesTecnicas = $produto->get_especificacoes_produto();
                        if(is_array($infoEspecificacoesTecnicas) && count($infoEspecificacoesTecnicas) > 0){
                            echo "<table class='tabela-especificacoes'>";
                                echo "<tbody>";
                                foreach($infoEspecificacoesTecnicas as $id => $info){
                                    $titulo = $info["titulo"];
                                    $decricao = $info["descricao"];
                                    echo "<tr>";
                                        echo "<td>$titulo</td>";
                                        echo "<td>$decricao</td>";
                                    echo "</tr>";
                                }
                                echo "</tbody>";
                            echo "</table>";
                        }else{
                            echo "Nenhuma especificação foi encontrada";
                        }
                    ?>
                </div>
            </div>
        </section>
        <?php
        }else{
            echo "<h3 class='mensagem-no-result'><i class='fas fa-search'></i> Nenhum produto foi encontrado</h3>";
            echo "<br><center><a href='index.php' class='link-padrao' align=center>Voltar a página inicial</a></center>";
            echo "</div>";
        }
        ?>
        <!--END THIS PAGE CONTENT-->
        <?php
            require_once "@include-footer-principal.php";
        ?>
        <!--END REQUIRES PADRAO-->
    </body>
</html>