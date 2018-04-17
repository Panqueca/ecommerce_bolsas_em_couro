<?php
    session_start();
    $nomeEmpresa = "Bolsas em Couro";
    $descricaoPagina = "DESCRIÇÃO MODELO ATUALIZAR...";
    $tituloPagina = "Contato - $nomeEmpresa";
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
			form{
				display: flex;
				flex-direction: column;
				width: 50%;
				margin-top: 100px;
			}
			form .box-input{
				display: flex;
				justify-content: space-between;
				width: 100%;
			}
			form .box-input input{
				width: 48%;
				height: 35px;
				border: none;
				background-color: #ccc;
				padding-left: 5px;
				outline: none;
				font-size: inherit;
				font-family: inherit;
			}
			form .box-input input::placeholder{
				color: #000;
			}
			form .box-input2{
				display: flex;
				flex-direction: column;
				width: 100%;
			}
			form .box-input2 input{
				margin: 20px 0 20px 0;
				height: 35px;
				border: none;
				background-color: #ccc;
				padding-left: 5px;
				outline: none;
				font-size: inherit;
				font-family: inherit;
			}
			form .box-input2 input::placeholder{
				color: #000;
			}
			form .box-input2 textarea{
				resize: none;
				height: 150px;
				border: none;
				background-color: #ccc;
				padding-left: 5px;
				outline: none;
				font-size: inherit;
				font-family: inherit;
			}
			form .box-input2 textarea::placeholder{
				color: #000;
				font-weight: normal;
			}
			form .btn{
				display: flex;
				justify-content: flex-end;
				width: 100%;
			}
			form .btn .btn-enviar{
				margin: 10px 0 10px 0;
				height: 35px;
				border: none;
				background-color: #ccc;
				padding: 6px 20px 6px;
				background-color: #555;
				color: #fff;
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
        <div class="banner">
        	<img src="imagens/departamentos/banner-contato.png">
        </div>
        <div class="main-content">
      		<div class="box-title">
            	<h1>CONTATO</h1>
            </div>
            <article>Ao contrário do que se acredita, Lorem Ipsum não é simplesmente um texto randômico. Com mais de 2000 anos, suas raízes podem ser encontradas em uma obra de literatura latina. Lorem Ipsum não é simplesmente um texto randômico. Com mais de 2000 anos, suas raízes podem ser encontradas em uma obra de literatura latina.</article>
            <form method="post">
            	<div class="box-input">
					<input type="text" name="nome" placeholder="Nome">
					<input type="text" name="email" placeholder="Email">
				</div>
				<div class="box-input2">
					<input type="text" name="telefone" placeholder="Telefone">
					<textarea placeholder="Mensagem"></textarea>
				</div>
				<div class="btn">
					<input class="btn-enviar" type="submit" value="Enviar">
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