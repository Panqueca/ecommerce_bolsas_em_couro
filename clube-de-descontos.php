<?php
    session_start();
    
    require_once "@classe-paginas.php";

    $cls_paginas->set_titulo("Clube de Descontos");
    $cls_paginas->set_descricao("DESCRIÇÃO MODELO ATUALIZAR...");
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
			.flex-direction{
				flex-direction: row-reverse;
			}
			.content-descontos{
				width: 70%;
				margin: 0 auto 100px auto;
			}
			.content-descontos .box-title{
				margin: 0 auto;
                text-align: center;
			}
			.content-descontos .display-desconto{
				display: flex;
				margin: 50px 0 0 0;
			}
			.content-descontos .display-desconto .box-imagem{
				width: calc(50% - 40px);
                margin: 0px 20px 0px 20px;
			}
			.content-descontos .display-desconto .box-imagem img{
                width: 100%;   
            }
			.content-descontos .display-desconto .box-info{
                width: calc(50% - 40px);
                margin: 0px 20px 0px 20px;
				display: flex;
				flex-direction: column;
				justify-content: center;
			}
			.content-descontos .display-desconto .box-info ul{
                padding: 0px 0px 0px 20px;
            }
			.content-descontos .display-desconto .box-info ul li{
                margin: 0px 0px 15px 0px;   
            }
			.content-descontos .display-desconto .box-info .link-padrao{
                font-size: 18px;
                cursor: pointer;
            }
			.content-descontos .display-desconto .box-info .text{
				color: #333;
				font-size: 18px;
                font-weight: 700;
			}
			.content-descontos .display-desconto .box-info .destaque{
				color: #FF0C33;
				font-size: 18px;
			}
            @media screen and (max-width: 720px){
                .content-descontos{
                    width: 90%;
                    margin: 0 auto 60px auto;
                }
                .content-descontos .display-desconto{
                    flex-flow: row wrap;
                    text-align: center;
                }
                .content-descontos .display-desconto .box-imagem{
                    width: 90%;
                    margin: 0 auto 10px auto;
                }
                .content-descontos .display-desconto .box-info{
                    width: 95%;
                    margin: 0 auto;
                }
            }
        </style>
        <!--END PAGE CSS-->
        <!--PAGE JS-->
        <script>
            $(document).ready(function(){
                console.log("Página carregada");
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
<section class="content-descontos">
	<div class="box-title">
		<h1 class="titulo-principal">Como funciona o<br/>Clube de Descontos</h1>
	</div>
	<div class="display-desconto">
		<div class="box-imagem">
			<img src="imagens/estrutura/clubeDescontos/desconto-50.PNG">
		</div>
		<div class="box-info">
			<span class="text">Todos os dias novos Cupons e Ofertas imperdíveis</span><br><br>
            <span class="destaque">Indique seus amigos e ganhe <b>500 pontos</b> a cada <b>R$10,00</b> em compras no site.</span>
		</div>
	</div>
    <div class="display-desconto flex-direction">
		<div class="box-imagem">
			<img src="imagens/estrutura/clubeDescontos/formas-de-pagamento-clube.PNG">
		</div>
		<div class="box-info">
            <span class="text">Use os pontos como Forma de Pagamento</span><br><br>
            <span class="destaque">Você pode cortar até <b>60% da compra</b> com os pontos do Clube.</span>
		</div>
	</div>
	<div class="display-desconto">
		<div class="box-imagem">
			<img src="imagens/estrutura/clubeDescontos/meta-cluber.PNG">
		</div>
		<div class="box-info">
			<span class="text">Ofertas limitadas e exclusivas</span><br><br>
			<span class="destaque">Além das vantagens com as indicações, sempre têm promoções que apenas os participantes podem aproveitar!</span>
		</div>
	</div>
    <div class="display-desconto flex-direction">
		<div class="box-imagem">
			<img src="imagens/estrutura/clubeDescontos/cadastrese-clube.PNG">
		</div>
		<div class="box-info">
			<span class="text">
                Para participar você precisa:
            </span>
			<span class="destaque">
                <ul>
                    <li>Estar cadastrado no site. <br>Ainda não tem conta? <a class="link-padrao btn-trigger-cadastra-conta">Cadastre-se</a></li>
                    <li>Indicar 3 amigos com seu <a href='#linkUnico' class="link-padrao">Link Único</a> para fazer parte do Clube de Descontos</li>
                    <li>Quando o primeiro amigo indicado finalizar o cadastro você já estará participando</li>
                </ul>
            </span>
		</div>
	</div>
	<div class="display-desconto" id="linkUnico">
		<div class="box-imagem">
			<img src="imagens/estrutura/clubeDescontos/links-social-clube.PNG">
		</div>
		<div class="box-info">
			<span class="text">Divulgue nas suas redes sociais</span><br><br>
			<span class="destaque">
                <ul>
                    <li>Faça login na sua conta. <a class="link-padrao btn-trigger-entrar">Entrar</a></li>
                    <li>Acesse o menu <a class="link-padrao btn-trigger-minha-conta">Minha Conta</a></li>
                    <li>Entre na aba <b>Clube de Descontos</b></li>
                    <li>Procure por Indicar amigos</li>
                    <li>Selecione suas redes sociais preferidas e compartilhe com todo mundo</li>
                </ul>
            </span>
		</div>
	</div>
</section>
        <!--END THIS PAGE CONTENT-->
        <?php
            require_once "@include-footer-principal.php";
        ?>
        <!--END REQUIRES PADRAO-->
    </body>
</html>