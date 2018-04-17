<?php
    session_start();
    
    $thisPageURL = substr($_SERVER["REQUEST_URI"], strpos($_SERVER["REQUEST_URI"], '@pew'));
    $_POST["next_page"] = str_replace("@pew/", "", $thisPageURL);
    $_POST["invalid_levels"] = array(1);
    
    require_once "@link-important-functions.php";
    require_once "@valida-sessao.php";

    $navigation_title = "Vendas - " . $pew_session->empresa;
    $page_title = "Vendas";
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
        <script type="text/javascript" src="js/produtos.js"></script>
        
        <!--THIS PAGE CSS-->
        <style>
            .lista-produtos{
                width: calc(100% - 30px);
                margin: 40px 15px 40px 15px;
                padding-top: 50px;
            }
            .box-produto{
                position: relative;
                width: calc(25% - 22px);
                padding: 10px 0px 40px 0px;
                margin: 0px 20px 30px 0px;
                background-color: #fff;
                border: 1px solid #ccc;
                transition: .2s;
                color: #666;
                float: left;
            }
            .box-produto:hover{
                -webkit-box-shadow: 0px 0px 15px 8px rgba(0, 0, 0, .1);
                -moz-box-shadow: 0px 0px 15px 8px rgba(0, 0, 0, .1);
                box-shadow: 0px 0px 15px 8px rgba(0, 0, 0, .1); 
            }
            .box-produto .informacoes{
                width: calc(100%);
                padding: 0px;
                margin: 0px auto;
            }
            .box-produto .informacoes .nome-produto{
                text-align: left;
                font-size: 18px;
                margin: 10px 15px 10px 15px;
            }
            .box-produto .informacoes .nome-produto a{
                text-decoration: none;
                color: #111;
            }
            .box-produto .informacoes .nome-produto a:hover{
                color: #f78a14;
            }
            .box-info{
                position: relative;
                text-align: left;
                margin-bottom: 20px;
            }
            .box-info .titulo{
                font-size: 14px;
                border-bottom: 1px solid #ccc;
                padding: 5px 0px 5px 0px;
                margin: 0px;
                color: #111;
            }
            .box-info .descricao{
                font-size: 14px; 
                margin: 5px 0px 5px 0px;
            }
            .bottom-buttons{
                position: absolute;
                width: 100%;
                bottom: 0px;
                display: flex;
                flex-flow: row wrap;
                align-items: flex-end;
                font-size: 12px;
            }
            .bottom-buttons .box-button{
                width: 50%;
            }
            .bottom-buttons .btn-status-produto{
                width: 100%;
                margin: 0px;
                padding: 0px;
                border: none;
                border-bottom: 2px solid #bf1e1c;
                border-radius: 0px;
            }
            .bottom-buttons .btn-ativar{
                border-color: #2f912f;
            }
            .bottom-buttons .btn-alterar-produto{
                width: 100%;
                margin: 0px;
                padding: 0px;
                border: none;
                border-bottom: 2px solid #333;
                border-radius: 0px;
            }
            .display-produtos-pedido{
                position: absolute;
                width: 100%;
                height: 0%;
                bottom: 0;
                left: 0;
                background-color: #fff;
                transition: .3s;
                visibility: hidden;
                opacity: 0;
            }
            .display-produtos-pedido .box{
                width: 100%;
                margin: 10px 0px 10px 0px;
                display: flex;
            }
            .display-produtos-pedido .box:hover{
                background-color: #eee;
                color: #f78a14;
            }
            .display-produtos-pedido .box .quantidade{
                width: 50px;
                text-align: center;
            }
            .display-produtos-pedido .box .nome{
                width: calc(70% - 50px);
            }
            .display-produtos-pedido .box .subtotal{
                width: 30%;
                text-align: center;
            }
            .bottom-buttons .btn-status-produto:hover, .bottom-buttons .btn-alterar-produto:hover{
                background-color: #f0f0f0;
                transform: scale(1);
            }
            .display-info-pedido{
                position: absolute;
                width: 100%;
                padding-bottom: 30px;
                height: 0%;
                bottom: 0;
                left: 0;
                background-color: #fff;
                transition: .3s;
                visibility: hidden;
                overflow: hidden;
                overflow-y: auto;
                opacity: 0;
            }
            .display-info-pedido::-webkit-scrollbar-button:hover{
                background-color: #AAA;
            }
            .display-info-pedido::-webkit-scrollbar-thumb{
                background-color: #ccc;
            }
            .display-info-pedido::-webkit-scrollbar-thumb:hover{
                background-color: #999;
            }
            .display-info-pedido::-webkit-scrollbar-track{
                background-color: #efefef;
            }
            .display-info-pedido::-webkit-scrollbar-track:hover{
                background-color: #efefef;
            }
            .display-info-pedido::-webkit-scrollbar{
                width: 3px;
                height: 3px;
            }
            .titulo-info{
                font-size: 16px;
                line-height: 20px;
                font-weight: normal;
                margin: 16px;
            }
            .btn-voltar{
                position: absolute;
                bottom: 10px;
                right: 10px;
                width: 50px;
                padding: 4px;
                border: none;
                display: block;
                text-align: center;
                cursor: pointer;
                font-size: 14px;
            }
            .btn-voltar:hover{
                background-color: #dfdfdf;   
            }
            /*.display-info-pedido .btn-voltar{
                position: relative;
                top: 20px;
                margin: 0px 0px 0px auto;
            }*/
        </style>
        <!--FIM THIS PAGE CSS-->
    </head>
    <body>
        <?php
            // STANDARD REQUIRE
            require_once "@include-body.php";
            if(isset($block_level) && $block_level == true){
                $pew_session->block_level();
            }
        
            require_once "@classe-pedidos.php";
        
        ?>
        <!--PAGE CONTENT-->
        <h1 class="titulos"><?php echo $page_title; ?></h1>
            <section class="conteudo-painel">
            <div class="group clear">
                <form action="pew-vendas.php" method="get" class="label half clear">
                    <label class="group">
                        <div class="group">
                            <h3 class="label-title">Busca de pedidos</h3>
                        </div>
                        <div class="group">
                            <div class="xlarge" style="margin-left: -5px; margin-right: 0px;">
                                <input type="search" name="busca" placeholder="Busque por CPF, Nome, Pedido, Status" class="label-input" title="Buscar">
                            </div>
                            <div class="xsmall" style="margin-left: 0px;">
                                <button type="submit" class="btn-submit label-input btn-flat" style="margin: 10px;">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </label>
                </form>
                <div class="label half jc-left">
                    <div class="full">
                        <h4 class="subtitulos" align=left>Mais funções</h4>
                    </div>
                    <div class="label full">
                        <a href="pew-produtos-relatorios.php" class="btn-flat" title="Ver Relatórios"><i class="fas fa-chart-pie"></i> Relatórios</a>
                    </div>
                </div>
            </div>
            <div class="lista-produtos full clear">
                <h4 class="subtitulos group clear" align=left style="margin-bottom: 10px">Listagem de pedidos</h4>
                <?php
                    $tabela_pedidos = $pew_custom_db->tabela_pedidos;
                    if(isset($_GET["busca"]) && $_GET["busca"] != ""){
                        $busca = $pew_functions->sqli_format($_GET["busca"]);
                        $strBusca = "where id like '%".$busca."%' or nome like '%".$busca."%' or marca like '%".$busca."%' or descricao_curta like '%".$busca."%' or descricao_longa like '%".$busca."%'";
                        echo "<div class='group clear'><h3>Exibindo resultados para: $busca</h3></div>";
                    }else{
                        $strBusca = "";
                    }
                
                    $condicaoPedidos = "codigo_confirmacao != '0' order by id desc";
                    $totalPedidos = $pew_functions->contar_resultados($tabela_pedidos, $condicaoPedidos);
                    
                    if($totalPedidos > 0){
                        
                        $cls_pedido = new Pedidos();
                        $selectedPedidos = $cls_pedido->buscar_pedidos($condicaoPedidos);
                        $cls_pedido->listar_pedidos($selectedPedidos);
                        
                    }else{
                        if($strBusca == ""){
                            echo "<br><h3 align='center'>Nenhum Pedido foi feito ainda.</h3>";
                        }else{
                            echo "<br><h3 align='center'>Nenhum pedido foi encontrado.</h3>";
                        }
                    }
                ?>
            </div>
            <br style="clear: both;">
        </section>
    </body>
    <script>
        $(document).ready(function(){
            var botaoVerProdutos = $(".botao-ver-produtos");
            var botaoVerInfo = $(".botao-ver-info");
            var botaoVoltar = $(".display-produtos-pedido .btn-voltar-produtos");
            var botaoVoltarInfo = $(".display-info-pedido .btn-voltar-info");
            
            function toggleVerProdutos(id){
                var obj = $("#"+id);
                
                if(obj.css("opacity") == "0"){
                    obj.css({
                        visibility: "visible",
                        opacity: "1",
                        height: "100%"
                    });
                    obj.addClass("active");
                }else{
                    obj.css({
                        visibility: "hidden",
                        opacity: "0",
                        height: "0%"
                    });
                    obj.removeClass("active");
                }
            }
            
            function toggleInfoPedido(id){
                var obj = $("#"+id);
                
                if(obj.css("opacity") == "0"){
                    obj.css({
                        visibility: "visible",
                        opacity: "1",
                        height: "calc(100% - 30px)"
                    });
                    obj.addClass("active");
                }else{
                    obj.css({
                        visibility: "hidden",
                        opacity: "0",
                        height: "0%"
                    });
                    obj.removeClass("active");
                }
            }
            
            botaoVerProdutos.off().on("click", function(){
                var id = $(this).attr("id-pedido");
                toggleVerProdutos(id);
            });
            
            botaoVerInfo.off().on("click", function(){
                var id = $(this).attr("id-pedido");
                toggleInfoPedido(id);
            });
            
            botaoVoltar.off().on("click", function(){
                var id = $(this).attr("id-pedido");
                toggleVerProdutos(id);
            });
            
            botaoVoltarInfo.off().on("click", function(){
                var id = $(this).attr("id-pedido");
                toggleInfoPedido(id);
            });
        });
    </script>
</html>