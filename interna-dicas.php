<?php
    session_start();
    
    require_once "@classe-paginas.php";

    $cls_paginas->set_titulo("Título da Dica");
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
                width: 100%;
                margin: 0 auto;
                min-height: 300px;
            }
            .main-content .box{
                position: relative;
            }
            .main-content .box img{
                width: 100%;
            }
            .main-content .box .breadcrumb{
                position: absolute;
                bottom: 5vw;
                left: 10vw;
                color: #fff;
                font-size: 1vw;
            }
            .main-content .box .breadcrumb a{
                color: inherit;
                text-decoration: none;
            }
            .main-content .display{
                width: 75vw;
                margin: 10vh auto;
                color: #aaa;
                text-align: center;
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
        <div class="main-content">
            <!--GET = titulo, ref-->
            <?php
                $getNome = isset($_GET["titulo"]) ? $_GET["titulo"] : "Produto não encontrado";
                $selectedId = isset($_GET["id_dica"]) ? $_GET["id_dica"] : "Produto não encontrado";
                
				require_once "@pew/pew-system-config.php";
				$tabela_dicas = $pew_custom_db->tabela_dicas;
				
				$dirImagens = "imagens/dicas";
                
                $condicao = "id = $selectedId and status = 1";
                $contar = mysqli_query($conexao, "select count(id) as total from $tabela_dicas where $condicao");
                $contagem = mysqli_fetch_assoc($contar);
                $total = $contagem["total"];
            
				if($total > 0){
					$queryDicas = mysqli_query($conexao, "select * from $tabela_dicas where $condicao");
					while($dicas = mysqli_fetch_array($queryDicas)){
						$imagem = $dicas["imagem"];
						$titulo = $dicas["titulo"];
						$subtitulo = $dicas["subtitulo"];
						$video = $dicas["video"];
						$refDica = $dicas["ref"];
						$descricaoCurta = $dicas["descricao_curta"];
						$descricaoLonga = $dicas["descricao_longa"];
                        $imagem = $dicas["imagem"];
						$srcImagem = file_exists($dirImagens."/".$imagem) && $imagem != "" ? $dirImagens."/".$imagem : $dirImagens."/"."banner-padrao.png";
                        
                        echo "<div class='box'>";  
                            echo "<img src='$srcImagem' title='' alt=''>";
                            echo "<div class='breadcrumb'>";
                                echo "<h4><a href='index.php'>Página Inicial > </a><a href='dicas.php'>Dicas > </a>$titulo</h4>";
                                echo "<h1>$titulo</h1>";
                                echo "<h2>$subtitulo</h2>";
                            echo "</div>";
                        echo "</div>";  
                        echo "<div class='display'>";
                            if($video){
                                echo $video;
                            }
                            echo "<article>$descricaoLonga</article>";
                        echo "</div>";
                    }
				}
				
            
            ?>
        </div>
        <!--END THIS PAGE CONTENT-->
        <?php
            require_once "@include-footer-principal.php";
        ?>
        <!--END REQUIRES PADRAO-->
    </body>
</html>