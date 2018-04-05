<?php
    session_start();
    $nomeEmpresa = "Bolsas em Couro";
    $descricaoPagina = "DESCRIÇÃO MODELO ATUALIZAR...";
    $tituloPagina = "Dicas - $nomeEmpresa";
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
            .background-loja{
                width: 100%;
            }
            .background-loja img{
                width: 100%;
            }
            .main-content{
                position: relative;
                top: -200px;
                width: 90%;
                margin: 0 auto;
                margin-bottom: -150px;
                min-height: 300px;
                background-color: #fff;
                overflow: hidden;
            }
			.main-content .display-cont{
				display: flex;
				justify-content: center;
				flex-flow: row wrap;
				margin-bottom: 20px;
			}
			.main-content .display-cont .box-cont{
				flex: 0 0 25%;
				margin: 40px 10px 0px 10px;
				transition: .2s;
			}
			.main-content .display-cont .box-cont .item-thumb{
				transition: .3s;
			}
			.main-content .display-cont .box-cont .item-thumb img{
				display: block;
				margin: 0px;
			}
			.main-content .display-cont .box-cont .item-thumb:hover{
				filter: brightness(.8);
			}
			.main-content .display-cont .box-cont:hover{
				transform: scale(1.05);
			}
			.main-content .display-cont .box-cont .item-desc{
				-webkit-box-shadow: 0px 0px 6px 1px rgba(0, 0, 0, .1);
				-moz-box-shadow: 0px 0px 6px 1px rgba(0, 0, 0, .1);
				box-shadow: 0px 0px 6px 1px rgba(0, 0, 0, .1);
				height: 168px;
			}
			.main-content .display-cont .box-cont .item-int-desc{
				width: 90%;
				margin: 0 auto;
			}
			.main-content .display-cont .box-cont .item-desc .item-int-desc a{
				text-decoration: none;
				color: #555;
			}
			.main-content .display-cont .box-cont .item-desc .item-int-desc a .titulo{
				font-size: 20px;
				font-weight: normal;
				margin: 0;
				padding-top: 10px;
			}
			.main-content .display-cont .box-cont .item-desc .item-int-desc a:hover{
				color: #111;
			}
			.main-content .display-cont .box-cont .item-desc .item-int-desc p{
				font-size: 14px;
			}
			.main-content .display-cont .box-cont .item-desc .item-int-desc .btn-dicas{
				background-color: #eee;
				color: #999;
				padding: 3px 6px 3px;
				font-size: 12px;
			}
			.main-content .display-cont .box-cont .item-desc .item-int-desc .btn-dicas:hover{
				color: #111;
				background-color: #ddd;
			}
            @media screen and (max-width: 1100px){
                .main-content{
                    top: -150px;
                    margin-bottom: -100px;
                }
                @media screen and (max-width: 720px){
                    .main-content{
                        top: -100px;
                        margin-bottom: -50px;
                    }
                    @media screen and (max-width: 480px){
                         .main-content{
                            width: 100%;
                            padding: 0px;
                            top: 0px;
                            margin: 0 auto;
                        }
                    }
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
        <div class="background-loja">
            <img src="imagens/departamentos/background-dicas.png">
        </div>
        <div class="main-content">
        	<div class="display-cont">
        		<?php
        		echo "<div class='box-cont'>";
        			echo "<div class='item-thumb'>";
        				echo "<a href='#'><img src='imagens/Thumbizinha.png' width='100%'></a>";
        			echo "</div>";
        			echo "<div class='item-desc'>";
        				echo "<div class='item-int-desc'>";
							$max = 155;
							$descricao = "Dica para limpar sua bolsa</h2></a>
							<p>Lorem Ipsum é simplesmente uma simulação de texto da indústria tipográfica e de impressos, e vem sendo utilizado desde o século XVI, quando um impressor";
							$descricao = substr($descricao, 0, $max)."...";
							echo "<a href='#'><h2 class='titulo'>$descricao</p>";
							echo "<a href='#' class='btn-dicas'>Continuar lendo</a>";
        				echo "</div>";
        			echo "</div>";
        		echo "</div>";
        		?>
        	</div>
        </div>
        <!--END THIS PAGE CONTENT-->
        <?php
            require_once "@include-footer-principal.php";
        ?>
        <!--END REQUIRES PADRAO-->
    </body>
</html>
