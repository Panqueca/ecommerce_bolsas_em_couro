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
			.flex-reverse{
				flex-direction: row-reverse;
			}
            .main-content{
                width: 100%;
            }
			.display-lojas{
				width: 80%;
				margin: 0 auto;
			}
			.box-loja{
				display: flex;
				justify-content: center;
				margin: 100px 0 100px 0;
                flex-flow: row wrap;
			}
			.box-loja .item-contato{
				width: calc(50% - 40px);
                padding: 0px 20px 0px 20px;
				height: 300px;
			}
			.box-loja .item-contato .border{
				width: 200px;
				height: 1px;
				background-color: #002586;
			}
			.box-loja .item-contato .border1{
				width: 100px;
				height: 1px;
				background-color: #002586;
			}
			.box-loja .item-contato h1{
				margin: 0;
				padding: 0;
			}
			.box-loja .item-contato h2{
				margin: 0;
				padding: 0;
			}
			.box-loja .item-mapa{
				width: calc(50% - 40px);
				height: 300px;
                padding: 0px 20px 0px 20px;
			}
			.box-loja .item-mapa iframe{
				width: 100%;
				height: 300px;
			}
			.display-form{
				display: flex;
				flex-direction: column;	
				align-items: center;
				width: 340px;
				margin: 0 auto;
				background-color: #eee;
				margin-bottom: 60px;
			}
			.display-form .form{
				width: 300px;
				display: flex;
				flex-direction: column;
				margin: 0 10px 0 10px;
			}
			.display-form .form input,
			.display-form .form select{
				border-radius: 3px;
				border: none;
				height: 25px;
				outline: none;
				padding: 5px;
			}
			.display-form .form textarea{
				border-radius: 3px;
				border: none;
				height: 100px;
				resize: none;
				outline: none;
				padding: 5px;
			}
			.display-form .form .btn-contato{
				align-self: center;
				margin: 10px 0 10px 0;
				width: 80px;
				height: 30px;
				font-size: 16px;
				background-color: #6abd45;
				color: #fff;
				transition: .2s;
				cursor: pointer;
			}
			.display-form .form .btn-contato:hover{
				background-color: #4c9b29;
			}
			.display-form .box-titulo{
				display: flex;
				justify-content: center;
				align-items: center;
				width: 100%;
				height: 60px;
				background-color: #6abd45;
			}
			.display-form .box-titulo h1{
				color: #FFF;
				font-size: 25px;
			}
			.display-form .label-title{
                margin: 14px 0px 5px 0px;
                font-weight: normal;
            }
			.display-form .formulario-contato{
                padding-top: 5px;   
            }
            @media screen and (max-width: 720px){
                .display-lojas{
                    width: 90%; 
                }
                .box-loja{
                    margin: 25px 0px 80px 0px;  
                }
                .box-loja .item-contato{
                    width: 100%;
                    height: auto;
                }
                .box-loja .item-mapa{
                    width: 100%;
                    margin-top: 15px;
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
				var objNome = objFormulario.children("#nomeContato");
				var objEmail = objFormulario.children("#emailContato");
				var objTelefone = objFormulario.children("#telefoneContato");
				var objAssunto = objFormulario.children("#assuntoContato");
				var objMensagem = objFormulario.children("#mensagemContato");
				var objEnviaContato = objFormulario.children("#btnEnviaContato");
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
				
				objFormulario.off().on("submit", function(event){
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
        <div class="main-content">
			<div class="display-lojas">
				<div class="box-loja">
					<div class="item-contato">
						<h1>LOJA FÍSICA 1</h1>
						<div class="border"></div>
						<p>Endereço : Av. Nossa Sra. de Lourdes, 63 - Jd. das Américas | Loja 48 e 49B 1° Piso | <font style='white-space: nowrap;'>81530-020</font></p>
						<p>Curitiba, PR</p>
						<p>Fone : (41) 3085-1500</p>
						<h2>Horário</h2>
						<div class="border1"></div>
						<p>Segunda a Sábado das 10:00 às 22:00h</p>
						<p>Domingo das 14:00 às 20:00h</p>
					</div>
					<div class="item-mapa">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3602.6081168173905!2d-49.230669584985314!3d-25.451361983778625!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94dce516a4cec955%3A0x647221d62239bf94!2sShopping+Jardim+das+Am%C3%A9ricas!5e0!3m2!1spt-BR!2sbr!4v1525976864612" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
					</div>
				</div>
			</div>
       		<div class="display-lojas">
				<div class="box-loja flex-reverse">
					<div class="item-contato">
						<h1>LOJA FÍSICA 2</h1>
						<div class="border"></div>
						<p>Endereço : R. João Doetzer, 415 - Jd. das Américas | <font style='white-space: nowrap;'>81540-190</font></p>
						<p>Curitiba, PR</p>
						<p>Fone : (41) 3365-9357</p>
						<h2>Horário</h2>
						<div class="border1"></div>
						<p>Segunda a Sexta das 08:30 às 18:00</p>
						<p>Sábado das 08:00 às 12:00</p>
					</div>
					<div class="item-mapa">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3602.2779032115122!2d-49.22511218498524!3d-25.4623942837735!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94dce547f391e07b%3A0x360944e26f7c473d!2sR.+Prof.+Jo%C3%A3o+Doetzer%2C+415+-+Jardim+das+Americas%2C+Curitiba+-+PR%2C+81540-190!5e0!3m2!1spt-BR!2sbr!4v1525976826150" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
					</div>
				</div>
			</div>
       		<div class="display-form">
       			<div class="box-titulo">
       				<h1>Entre em Contato</h1>
       			</div>
       			<form class="form formulario-contato" method="post" action="@grava-contato.php">
       				<h4 class='label-title'>Nome</h4>
       				<input type="text" name="nome" id="nomeContato">
       				<h4 class='label-title'>E-mail</h4>
       				<input type="text" name="email" id="emailContato">
       				<h4 class='label-title'>Telefone</h4>
       				<input class="telefone-contato" type="text" name="telefone" id="telefoneContato">
       				<h4 class='label-title'>Assunto</h4>
       				<select name="assunto" id="assuntoContato">
       					<option value="">- Selecione -</option>
       					<option>Sugestões</option>
       					<option>Problemas</option>
       					<option>Dúvidas</option>
       					<option>Produto</option>
       				</select>
       				<h4 class='label-title'>Mensagem</h4>
       				<textarea name="mensagem" id="mensagemContato"></textarea>
       				<input class="btn-contato" id="btnEnviaContato" type="submit" name="btn_enviar" value="Enviar">
       			</form>
       		</div>
        </div>
        <!--END THIS PAGE CONTENT-->
        <?php
            require_once "@include-footer-principal.php";
        ?>
        <!--END REQUIRES PADRAO-->
    </body>
</html>