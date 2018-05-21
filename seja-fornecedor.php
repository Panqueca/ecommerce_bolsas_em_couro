<?php
    session_start();
    
    require_once "@classe-paginas.php";

    $cls_paginas->set_titulo("Seja Fornecedor");
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
        <link rel="stylesheet" href="css/estilo.css">
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
				display: flex;
                width: 80%;
                margin: 50px auto;
                min-height: 300px;
            }
			.flex{
				display: flex;
				justify-content: space-between;
			}
			.display-info{
				flex: 1 1 50%;
				margin: 0 5% 0 0;
			}
			.display-info .box-title .titulo-principal{
				margin: 0px 0px 15px 0px;
				padding: 0;
				font-size: 65px;
				color: #00BE36;
			}
			.display-info .box-title .sub-titulo{
				margin: 0;
				padding: 0;
				color: #999;
			}
			.display-info .box-text{
				display: flex;
				flex-direction: column;
			}
			.display-info .box-text p{
				margin: 50px 0 50px 0;
				color: #888;
				text-align: justify;
			}
			.display-info .box-text .contato-email{
				color: #FF3851;
				font-weight: 800;
				font-size: 20px;
				margin: 0 0 20px 0;
			}
			.display-form .btn{
				width: 100px;
				height: 30px;
				border: none;
				margin: 0 0 50px 0;
				background-color: #00BE36;
				cursor: pointer;
				color: #fff;
			}
			.display-form .btn:hover{
				background-color: #009e2c;	
			}
			@media screen and (max-width: 1440px){
				.display-info .box-title .titulo-principal{
					font-size: 50px;
				}
			}
			@media screen and (max-width: 1366px){
				.display-info .box-title .titulo-principal{
					font-size: 45px;
				}
			}
			@media screen and (max-width: 640px){
				.main-content{
					flex-direction: column;
				}
			}
        </style>
        <!--END PAGE CSS-->
        <!--PAGE JS-->
        <script>
            $(document).ready(function(){
                console.log("Página carregada");
				
				var formulario = $("#sfFormulario");
				var objNome = $("#sfNome");
				var objEmail = $("#sfEmail");
				var objTelefone = $("#sfTelefone");
				var objMensagem = $("#sfMensagem");
				
				phone_mask(objTelefone);
				
				var enviandoFormulario = false;
				
				formulario.off().on("submit", function(){
					event.preventDefault();
					if(!enviandoFormulario){
						enviandoFormulario = true;
						
						var nome = objNome.val();
						var email = objEmail.val();
						var telefone = objTelefone.val();
						var mensagem = objMensagem.val();
						
						function validar(){
							if(nome.length < 3){
								mensagemAlerta("O campo NOME deve conter no mínimo 4 caracteres", objNome);
								return false;
							}
							if(validarEmail(email) == false){
								mensagemAlerta("O campo E-MAIL deve ser preenchido corretamente", objEmail);
								return false;
							}
							if(telefone.length < 14){
								mensagemAlerta("O campo TELEFONE deve conter 14 caracteres", objNome);
								return false;
							}
							if(mensagem.length < 10){
								mensagemAlerta("O campo MENSAGEM deve conter no mínimo 10 caracteres", objMensagem);
								return false;
							}
							return true;
						}
						
						if(validar() == true){
							formulario.submit();
						}else{
							enviandoFormulario = false;
						}
					}
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
            <div class="display-info">
            	<div class="box-title">
            		<h1 class="titulo-principal">Seja Fornecedor</h1>
            	</div>
            	<div class="box-text">
            		<p>Se você é fabricante ou possui algum produto com preço justo, qualidade, e comercializa respeitando as leis de nosso país e o meio ambiente entre em contato através do nosso email comercial abaixo:</p>
            		<span class="contato-email">comercial@lareobra.com.br</span>
            	</div>
				<a href="trabalhe-conosco.php" class="link-padrao">Trabalhe Conosco</a>
            </div>
            <form class="display-form" method="post" action="@grava-contato-servicos.php" id="sfFormulario">
				<input type="hidden" name="tipo" value="Seja Fornecedor">
            	<div class="full">
            		<span class="box-title">Nome</span>
            		<input class="input-standard" type="text" name="nome" id="sfNome">
            	</div>
            	<div class="half">
            		<span class="box-title">E-mail</span>
            		<input class="input-standard" type="text" name="email" id="sfEmail">
            	</div>
            	<div class="half">
					<span class="box-title">Telefone</span>
					<input class="input-standard" type="text" name="telefone" id="sfTelefone">
            	</div>
            	<div class="full">
					<span class="box-title">Mensagem</span>
					<textarea class="input-standard" name="mensagem" id="sfMensagem" style="resize: none; height: 150px;"></textarea>
            	</div>
            	<div class="full" align="right">
           			<input class="btn" type="submit" value="Enviar">
           		</div>
            </form>
        </div>
        <!--END THIS PAGE CONTENT-->
        <?php
            require_once "@include-footer-principal.php";
        ?>
        <!--END REQUIRES PADRAO-->
    </body>
</html>