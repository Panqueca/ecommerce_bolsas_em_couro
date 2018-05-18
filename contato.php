<?php
    session_start();
    
    require_once "@classe-paginas.php";

    $cls_paginas->set_titulo("Contato");
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
				align-items: center;
				flex-direction: column;
                position: relative;
                top: -200px;
                width: 90%;
                margin: 0 auto;
                margin-bottom: -150px;
                min-height: 300px;
                background-color: #fff;
                overflow: hidden;
            }
			.banner img{
				width: 100%;
			}
			.main-content article{
				width: 50%;
				margin-top: 50px;
				text-align: justify;
			}
			.form{
				width: 40%;
				height: 300px;
				margin: 100px auto 50px auto;
			}
			.form .box-input{
				display: flex;
				justify-content: space-between;
				flex-wrap: wrap;
				align-items: flex-end;
			}
			.form .box-input input{
				flex: 1;
				margin: 8px;
				height: 30px;
				border: none;
				background-color: #ccc;
				outline: none;
				padding: 0 5px 0;
			}
			.form .box-input select{
				flex: 1;
				height: 30px;
				border: none;
				background-color: #ccc;
				outline: none;
				padding: 0 5px;
				margin: 8px;
			}
			.form .box-input textarea{
				width: 100%;
				margin: 8px;
				height: 150px;
				resize: none;
				border: none;
				background-color: #ccc;
				outline: none;
				padding: 0 5px 0;
			}
			.form .box-btn{
				display: flex;
				justify-content: flex-end;
			}
			.form .box-btn .btn{
				width: 30%;
				margin: 8px;
				height: 30px;
				border: none;
				background-color: #ccc;
				outline: none;
				padding: 0 5px 0;
				cursor: pointer;
			}
			.form .box-btn .btn:hover{
				background-color: #b5b5b5;
			}
			@media screen and (max-width: 1124px){
				.form{
					width: 60%;
				}
			}
			@media screen and (max-width: 1100px){
                .main-content{
                    top: -150px;
                    margin-bottom: -100px;
				}
            }
			@media screen and (max-width: 720px){
				.main-content{
					top: -100px;
					margin-bottom: -50px;
				}
			}
			@media screen and (max-width: 640px){
				.box-msg h2{
					font-size: 35px;
				}
			}
			@media screen and (max-width: 480px){
				 .main-content{
					width: 100%;
					padding: 0px;
					top: 0px;
					margin: 0 auto;
				}
			}
		</style>
        <!--END PAGE CSS-->
        <!--PAGE JS-->
        <script>
            $(document).ready(function(){
                console.log("Página carregada");
				
				phone_mask(".telefone-contato");
				
				var objFormulario = $(".formulario-contato");
				var objNome = $("#nomeFormContato");
				var objEmail = $("#emailFormContato");
				var objTelefone = $("#telefoneFormContato");
				var objAssunto = $("#assuntoFormContato");
				var objMensagem = $("#mensagemFormContato");
				var objEnviaContato = $("#btnEnviaFormContato");
				var enviandoContato = false;
				
				function validar_dados(){
					var nome = objNome.val();
					var email = objEmail.val();
					var telefone = objTelefone.val();
					var assunto = objAssunto.val();
					var mensagem = objMensagem.val();
					
					if(nome.length < 3){
						mensagemAlerta("O campo Nome deve conter no mínimo 3 caracteres.", objNome);
						return false;
					}
					
					if(validarEmail(email) == false){
						mensagemAlerta("O campo E-mail deve ser preenchido corretamente.", objEmail);
						return false;
					}
					
					if(telefone.length < 14){
						mensagemAlerta("O campo Telefone deve conter no mínimo 14 caracteres.", objTelefone);
						return false;
					}
					
					if(assunto.length == 0){
						mensagemAlerta("Selecione uma opção de assunto.", objAssunto);
						return false;
					}
					
					if(mensagem.length < 10){
						mensagemAlerta("Sua mensagem deve conter no mínimo 10 caracteres.", objMensagem);
						return false;
					}
					
					return true;
				}
				
				objFormulario.off().on("submit", function(){
					event.preventDefault();
					
					if(!enviandoContato){
						enviandoContato = true;
						
						if(validar_dados()){
							objFormulario.submit();
						}else{
							enviandoContato = false;
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
        <div class="banner">
        	<img src="imagens/estrutura/banner-contato.png">
        </div>
        <div class="main-content">
      		<div class="box-title">
            	<h1>CONTATO</h1>
            </div>
            <article>Ao contrário do que se acredita, Lorem Ipsum não é simplesmente um texto randômico. Com mais de 2000 anos, suas raízes podem ser encontradas em uma obra de literatura latina. Lorem Ipsum não é simplesmente um texto randômico. Com mais de 2000 anos, suas raízes podem ser encontradas em uma obra de literatura latina.</article>
            <form class="form formulario-contato" method="post" action="@grava-contato.php">
            	<div class="box-input">
            		<input id="nomeFormContato" type="text" name="nome" placeholder="Nome">
            		<input id="emailFormContato" type="text" name="email" placeholder="E-mail">
				</div>
           		<div class="box-input">
            		<input class="telefone-contato" id="telefoneFormContato" type="text" name="telefone" placeholder="Telefone">
            		<select id="assuntoFormContato" name="assunto">
            			<option>- Selecione -</option>
            			<option value="Orçamento">Orçamento</option>
            			<option value="Dúvida">Dúvida</option>
            			<option value="Reclamação">Reclamação</option>
            			<option value="Sugestão">Sugestão</option>
            			<option value="Outros">Outros</option>
            		</select>
            	</div>
            	<div class="box-input">
            		<textarea id="mensagemFormContato" name="mensagem" placeholder="Mensagem"></textarea>
            	</div>
            	<div class="box-btn">
            		<input id="btnEnviaFormContato" class="btn" type="submit" value="Enviar">
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