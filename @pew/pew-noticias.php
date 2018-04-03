<?php
    session_start();
    
    $thisPageURL = substr($_SERVER["REQUEST_URI"], strpos($_SERVER["REQUEST_URI"], '@pew'));
    $_POST["next_page"] = str_replace("@pew/", "", $thisPageURL);
    $_POST["invalid_levels"] = array(1);
    
    require_once "@link-important-functions.php";
    require_once "@valida-sessao.php";

    $navigation_title = "Notícias - " . $pew_session->empresa;
    $page_title = "Gerenciamento de noticias";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Acesso Restrito. Efectus Web.">
        <meta name="author" content="Efectus Web">
        <title><?php echo $navigation_title; ?></title>
        <?php
            require_once "@link-standard-styles.php";
            require_once "@link-standard-scripts.php";
        ?>
    </head>
    <body>
        <?php
            // STANDARD REQUIRE
            require_once "@include-body.php";
            if(isset($block_level) && $block_level == true){
                $pew_session->block_level();
            }
        ?>
        <!--PAGE CONTENT-->
        <h1 class="titulos"><?php echo $page_title; ?></h1>
        <section class="conteudo-painel">
            <a href="pew-cadastra-noticia.php" class="btn-padrao" title="Cadastre uma nova notícia">Cadastrar nova</a>
            <br><br><br><br>
            <form class="form-busca" method="get" action="pew-noticias.php">
                <label class="field-busca">
                    <h3 class="titulo-busca">Buscar notícias</h3>
                    <input type="search" name="busca" placeholder="Busque por titulo, texto, data ou status" class="barra-busca" autocomplete="off">
                    <input type="submit" value="Buscar" class="btn-buscar">
                </label>
            </form>
            <table class="table-padrao" cellspacing="0">
            <?php
                $tabela_noticias = $pew_custom_db->tabela_noticias;
                if(isset($_GET["busca"]) && $_GET["busca"] != ""){
                    $busca = pew_string_format($_GET["busca"]);
                    $strBusca = "where titulo like '%".$busca."%' or texto like '%".$busca."%' or data like '%".$busca."%'";
                    $busca = $busca == "" ? "Todos produtos" : $busca;
                    echo "<h3>Exibindo resultados para: $busca</h3>";
                }else{
                    $strBusca = "";
                }
                $contarNoticias = mysqli_query($conexao, "select count(id) as total_noticias from $tabela_noticias $strBusca");
                $contagemProdutos = mysqli_fetch_assoc($contarNoticias);
                $totalNoticias = $contagemProdutos["total_noticias"];
                if($totalNoticias > 0){
                    echo "<thead>";
                        echo "<td>Data</td>";
                        echo "<td style='width: 100px;'>Imagem</td>";
                        echo "<td>Título</td>";
                        echo "<td>Texto</td>";
                        echo "<td>Status</td>";
                        echo "<td>Editar</td>";
                    echo "</thead>";
                    echo "<tbody>";
                    $queryNoticias = mysqli_query($conexao, "select * from $tabela_noticias $strBusca order by data desc");
                    while($noticias = mysqli_fetch_array($queryNoticias)){
                        $id = $noticias["id"];
                        $titulo = $noticias["titulo"];
                        $texto = $noticias["texto"];
                        $imagem = $noticias["imagem"];
                        $maxCaracteres = 149;
                        if(strlen($texto) >= $maxCaracteres){
                            $texto = substr($texto, 0, $maxCaracteres)."...";
                        }
                        $data = inverterData(substr($noticias["data"], 0, 10));
                        $status = $noticias["status"] == 1 ? "Ativo" : "Inativo";
                        $dirImagens = "../imagens/news";
                        echo "<tr><td>$data</td>";
                        echo "<td><img src='$dirImagens/$imagem' class='imagem'></td>";
                        echo "<td>$titulo</td>";
                        echo "<td>$texto</td>";
                        echo "<td>$status</td>";
                        echo "<td><a href='pew-edita-noticia.php?id_noticia=$id' class='btn-editar'><i class='fa fa-pencil-square-o' aria-hidden='true'></i></a></td></tr>";
                    }
                    echo "</tbody>";
                }else{
                    $msg = $strBusca != "" ? "Nenhum resultado encontrado." : "Nenhuma notícia foi cadastrada.";
                    echo "<br><br><br><br><br><h3 align='center'>$msg <a href='pew-cadastra-noticia.php' class='link-padrao'>Clique aqui e cadastre</a></h3></td>";
                    if($msg == "Nenhum resultado encontrado."){
                        echo "<br><br><a href='pew-noticias.php' class='link-padrao'>Voltar</a>";
                    }
                }
            ?>
            </table>
        </section>
    </body>
</html>