<?php
    session_start();
    
    $thisPageURL = substr($_SERVER["REQUEST_URI"], strpos($_SERVER["REQUEST_URI"], '@pew'));
    $_POST["next_page"] = str_replace("@pew/", "", $thisPageURL);
    $_POST["invalid_levels"] = array(1);
    
    require_once "@link-important-functions.php";
    require_once "@valida-sessao.php";

    $navigation_title = "Editar produto - " . $pew_session->empresa;
    $page_title = "Editando produto";
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
        <script>
            var selecionandoCategoria = false;
            function checkSubcategorias(idSubcategoria){
                var startDelay = 200;
                $(document).ready(function(){
                    setTimeout(function(){
                        if(!selecionandoCategoria){
                            $(".checked-subcategoria-"+idSubcategoria).each(function(){
                                $(this).prop("checked", true);
                            });
                        }else{
                            checkSubcategorias(idSubcategoria);
                        }
                    }, startDelay);
                });
            }
            $(document).ready(function(){
                CKEDITOR.replace("descricaoLonga");
                var listCategorias = $(".list-categorias");
                var boxCategorias = listCategorias.children(".box-categoria");
                boxCategorias.each(function(){
                    var box = $(this);
                    var label = box.children("label");
                    var input = label.children(".check-categorias");
                    var listasubcategorias = box.children(".list-subcategorias");
                    var boxSubcategorias = listasubcategorias.children(".box-subcategoria");
                    var labelAberto = false;
                    input.off().on("change", function(){
                        var value = input.prop("checked");
                        labelAberto = value == true ? false : true;
                        if(!listasubcategorias.hasClass("list-subcategorias-active") && !labelAberto){
                            labelAberto = true;
                            listasubcategorias.css("display", "block");
                            setTimeout(function(){
                                listasubcategorias.addClass("list-subcategorias-active");
                            }, 50);
                        }else if(labelAberto){
                            listasubcategorias.removeClass("list-subcategorias-active");
                            labelAberto = false;
                            setTimeout(function(){
                                listasubcategorias.css("display", "none");
                            }, 300);
                            boxSubcategorias.each(function(){
                                var input = $(this).children("label").children(".check-subcategorias").prop("checked", false);
                            });
                        }
                        setTimeout(function(){
                            if(labelAberto){
                                listasubcategorias.css("display", "block");
                            }
                        }, 300);
                    });
                });

                var getIdProduto = $("#idProduto").val();
                setInterval(function(){
                    $(".botao-acao").off().on("click", function(){
                        var botao = $(this);
                        var idProduto = botao.attr("data-id-produto");
                        var acao = botao.attr("data-acao");
                        function statusProduto(){
                            $.ajax({
                                type: "POST",
                                url: "pew-status-produto.php",
                                data: {id_produto: idProduto, acao: acao},
                                beforeSend: function(){
                                    notificacaoPadrao("Aguarde...", "success");
                                },
                                error: function(){
                                    setTimeout(function(){
                                        notificacaoPadrao("Não foi possível "+acao+" o produto", "error", 5000);
                                    }, 1000);
                                },
                                success: function(resposta){
                                    console.log(resposta);
                                    setTimeout(function(){
                                        var resultado = null;
                                        var redirect = "pew-produtos.php";
                                        switch(acao){
                                            case "excluir":
                                                resultado  = "O produto foi excluido com sucesso";
                                                break;
                                            case "desativar":
                                                resultado = "O produto foi desativado";
                                                redirect = "pew-edita-produto.php?id_produto="+getIdProduto;
                                                break;
                                            case "excluir_imagem":
                                                resultado = "A imagem foi excluida com sucesso";
                                                redirect = "pew-edita-produto.php?id_produto="+getIdProduto;
                                                break;
                                            default:
                                                resultado = "O produto foi ativado com sucesso";
                                                redirect = "pew-edita-produto.php?id_produto="+getIdProduto;
                                        }
                                        if(resposta == "true"){
                                            mensagemAlerta(resultado, "", "limegreen", redirect);
                                        }else if(resposta == "imagem_excluida"){
                                            mensagemAlerta(resultado, "", "limegreen", redirect);
                                        }else{
                                            notificacaoPadrao("Não foi possível completar a ação", "error", 5000);
                                        }
                                    }, 500);
                                }
                            });
                        }
                        switch(acao){
                            case "excluir":
                                var msg  = "Tem certeza que deseja excluir este produto?";
                                break;
                            case "desativar":
                                var msg = "Tem certeza que deseja desativar este produto?";
                                break;
                            case "excluir_imagem":
                                var msg = "Tem certeza que deseja excluir a imagem deste produto?";
                                break;
                            default:
                                var msg = "Tem certeza que deseja ativar este produto?";
                        }
                        mensagemConfirma(msg, statusProduto);
                    });
                }, 500);

                /*ESPECIFICACOES TECNICAS*/
                var botaoAdicionarEspecificacao = $(".btn-especificacoes");
                var selectEspecificacao = $("#selectEspecificacao");
                var displayEspecificacoes = $(".display-especificacoes");
                var objTextareaEspecificacao = $("#descricaoEspecificacao");

                function resetEspecificacao(){
                    objTextareaEspecificacao.val("");
                    selectEspecificacao.val("");
                }

                botaoAdicionarEspecificacao.off().on("click", function(){
                    var selectedEspecificacaoId = selectEspecificacao.val();
                    if(selectedEspecificacaoId != ""){
                        selectEspecificacao.children("option").each(function(){
                            var option = $(this);
                            var idEspecificacao = option.val();
                            var tituloEspecificacao = option.text();
                            if(idEspecificacao == selectedEspecificacaoId){
                                var descricaoEspecificacao = objTextareaEspecificacao.val();
                                var ctrlInputVal = idEspecificacao+"|-|"+descricaoEspecificacao;
                                if(descricaoEspecificacao.length > 0){
                                    var addedEspecificacao = "<label class='label-especificacao'><b>"+tituloEspecificacao+": </b> <input type='text' class='input-especificacao' value='"+descricaoEspecificacao+"'><input type='hidden' class='input-ctrl-especificacao' name='especicacao_produto[]' value='"+ctrlInputVal+"' pew-id-especificacao='"+idEspecificacao+"'> <a class='btn-excluir-especificacao' title='Excluir especificação'><i class='fa fa-times' aria-hidden='true'></i></a></label>";
                                    displayEspecificacoes.append(addedEspecificacao);
                                    notificacaoPadrao("Especificação adicionada", "success");
                                    resetEspecificacao();
                                }else{
                                    mensagemAlerta("O campo descrição deve ser preenchido", objTextareaEspecificacao);
                                }
                            }
                        });
                    }else{
                        mensagemAlerta("Selecione uma especificação", selectEspecificacao);
                    }
                });

                setInterval(function(){
                    displayEspecificacoes.children(".label-especificacao").each(function(){
                        var label = $(this);
                        var objInputView = label.children(".input-especificacao");
                        var objInputCtrl = label.children(".input-ctrl-especificacao");
                        var idEspec = objInputCtrl.attr("pew-id-especificacao");
                        var botaoExcluir = label.children(".btn-excluir-especificacao");
                        var ctrlInputVal = idEspec+"|-|"+objInputView.val();
                        objInputCtrl.val(ctrlInputVal);
                        botaoExcluir.off().on("click", function(){
                            function excluir(){
                                label.remove();
                            }
                            mensagemConfirma("Você tem certeza que deseja excluir esta especificação?", excluir);
                        });
                    });
                }, 200);
                /*END ESPECIFICACOES TECNICAS*/

                /*PRODUTOS RELACIONADOS*/
                var botaoProdutosRelacionados = $("#btn-produtos-relacionados");
                var displayRelacionados = $("#display-produtos-relacionados");
                var backgroundProdutos = $(".background-interatividade");
                var botaoSalvarRelacionados = $(".btn-salvar-relacionados");
                var botaoCleanRelacionados = $(".limpar-todos-relacionados");
                var barraBusca = $(".busca-relacionados");
                var checkOnlyActives = $("#checkOnlyActives");
                var listaRelacionados = $(".lista-relacionados");
                var msgListaRelacionados = $(".lista-relacionados .lista-relacionados-msg");
                var buscandoProduto = false;
                var resetingBackground = false;
                var lastSearchString = null;

                /*!IMPORTANT FUNCTIONS*/
                function isJson(str){
                    try{
                        JSON.parse(str);
                    }catch(e){
                        return false;
                    }
                    return true;
                }
                function setMessageRelacionados(str){
                    listaRelacionados.css("padding", "30px 0px 10px 0px");
                    msgListaRelacionados.children("h4").text(str);
                    msgListaRelacionados.css({
                        height: "30px",
                        lineHeight: "30px",
                        visibility: "visible",
                        opacity: "1"
                    });
                }
                function resetMessageRelacionados(){
                    listaRelacionados.css("padding", "0px 0px 40px 0px");
                    msgListaRelacionados.children("h4").text("");
                    msgListaRelacionados.css({
                        height: "5px",
                        lineHeight: "5px",
                        visibility: "hidden",
                        opacity: "0"
                    });
                }
                function resetAllInputs(){
                    var onlyActives = checkOnlyActives.prop("checked");
                    var ctrlViewProduto = 0;
                    $("#label-produtos-relacionados").each(function(){
                        var label = $(this);
                        var input = label.children("input");
                        if(onlyActives && input.prop("checked") == true){
                            label.css("display", "inline-block").removeClass("last-search");
                            ctrlViewProduto++;
                        }else if(!onlyActives){
                            label.css("display", "inline-block").removeClass("last-search");
                            ctrlViewProduto++;
                        }
                    });
                    if(onlyActives){
                        setMessageRelacionados("Resultados encontrados: "+ctrlViewProduto);
                    }else{
                        resetMessageRelacionados();
                    }
                }
                function listLastSearch(){
                    var onlyActives = checkOnlyActives.prop("checked");
                    var ctrlQtd = 0;
                    $("#label-produtos-relacionados").each(function(){
                        var label = $(this);
                        var input = label.children("input");
                        if(onlyActives && label.hasClass("last-search") && input.prop("checked") == true){
                            label.css("display", "inline-block");
                            ctrlQtd++;
                        }else if(!onlyActives && label.hasClass("last-search")){
                            label.css("display", "inline-block");
                            ctrlQtd++;
                        }
                    });
                    if(ctrlQtd > 0){
                        setMessageRelacionados("Exibindo resultados mais aproximados:");
                    }else{
                        setMessageRelacionados("Nenhum resultado foi encontrado");
                        botaoCleanRelacionados.css("visibility", "hidden");
                    }
                }
                function contarProdutosSelecionados(){
                    var contagem = 0;
                    $("#label-produtos-relacionados").each(function(){
                        var label = $(this);
                        var input = label.children("input");
                        if(input.prop("checked") == true){
                            contagem++;
                        }
                    });
                    return contagem;
                }
                function clearRelacionados(){
                    $("#label-produtos-relacionados").each(function(){
                        var label = $(this);
                        var input = label.children("input");
                        if(label.css("display") != "none"){
                            input.prop("checked", false);
                        }
                    });
                }
                /*OPEN AND CLOSE*/
                var produtosAbertos = false;
                function abrirRelacionados(){
                    if(!produtosAbertos){
                        produtosAbertos = true;
                        backgroundProdutos.css("display", "block");
                        displayRelacionados.css({
                            visibility: "visible",
                            opacity: "1"
                        });
                        /*SEARCH TRIGGRES*/
                        barraBusca.on("keyup", function(){
                            buscarProdutos();
                        });
                        barraBusca.on("search", function(){
                            buscarProdutos();
                        });
                        /*END SEARCH TRIGGRES*/
                        /*BOTAO SOMENTE SELECIONADOS*/
                        checkOnlyActives.off().on("change", function(){
                            var checked = $(this).prop("checked");
                            var buscaAtiva = barraBusca.val().length > 0 ? true : false;
                            if(checked && !buscaAtiva){
                                var ctrlQtd = 0;
                                $("#label-produtos-relacionados").each(function(){
                                    var label = $(this);
                                    var input = label.children("input");
                                    var selecionado = input.prop("checked");
                                    if(!selecionado){
                                        label.css("display", "none");
                                    }else{
                                        ctrlQtd++;
                                    }
                                });
                                botaoCleanRelacionados.css("visibility", "visible");
                                setMessageRelacionados("Resultados encontrados: "+ctrlQtd);
                            }else if(buscaAtiva){
                                lastSearchString = null;
                                buscarProdutos();
                                if(checked){
                                    botaoCleanRelacionados.css("visibility", "visible");
                                }else{
                                    botaoCleanRelacionados.css("visibility", "hidden");
                                }
                            }else{
                                /*LISTA TODOS OS PRODUTOS*/
                                resetAllInputs();
                                botaoCleanRelacionados.css("visibility", "hidden");
                            }
                        });
                        /*END BOTAO SOMENTE SELECIONADOS*/
                        /*LIMPAR RELACIONADOS*/
                        botaoCleanRelacionados.off().on("click", function(){
                            clearRelacionados();
                        });
                    }
                }
                function fecharRelacionados(){
                    if(produtosAbertos){
                        displayRelacionados.css({
                            visibility: "hidden",
                            opacity: "0"
                        });
                        produtosAbertos = false;
                        setTimeout(function(){
                            backgroundProdutos.css("display", "none");
                        }, 200);
                        var totalSelecionados = contarProdutosSelecionados();
                        botaoProdutosRelacionados.text("Produtos Relacionados ("+totalSelecionados+")");
                    }
                }
                /*END OPEN AND CLOSE*/
                /*END !IMPORTANT FUNCTIONS*/

                /*MAIN SEARCH FUNCTION*/
                function buscarProdutos(){
                    buscandoProduto = true;
                    var busca = barraBusca.val();
                    var loadingBackground = $(".lista-relacionados .loading-background");
                    var urlBuscaProdutos = "pew-busca-produtos.php";
                    onlyActives = checkOnlyActives.prop("checked");

                    function resetBackgroundLoading(){
                        if(!resetingBackground){
                            setInterval(function(){
                                resetingBackground = true;
                                if(!buscandoProduto){
                                    loadingBackground.css({
                                        visibility: "hidden",
                                        opacity: "0"
                                    });
                                }
                            }, 500);
                        }
                    }
                    resetBackgroundLoading();
                    if(busca.length > 0 && lastSearchString != busca){
                        lastSearchString = busca;
                        $.ajax({
                            type: "POST",
                            url: urlBuscaProdutos,
                            data: {busca: busca},
                            error: function(){
                                loadingBackground.css({
                                    visibility: "hidden",
                                    opacity: "0"
                                });
                                notificacaoPadrao("Ocorreu um erro ao buscar o produto.");
                            },
                            success: function(resposta){
                                setTimeout(function(){
                                    buscandoProduto = false;
                                }, 500);
                                var selectedProdutos = [];
                                var ctrlVQtdView = 0;
                                function listarOpcoes(){
                                    $("#label-produtos-relacionados").each(function(){
                                        var label = $(this);
                                        var input = label.children("input");
                                        var inputIdProduto = input.val();
                                        var inputChecked = input.prop("checked");
                                        var arraySearch = selectedProdutos.some(function(id){
                                            if(onlyActives){
                                                return id === inputIdProduto && inputChecked == true;
                                            }else{
                                                return id === inputIdProduto;
                                            }
                                        });
                                        if(arraySearch == false){
                                            if(onlyActives){
                                                label.css("display", "none");
                                            }else{
                                                label.css("display", "none").removeClass("last-search");
                                            }
                                        }else{
                                            ctrlVQtdView++;
                                            label.css("display", "inline-block").addClass("last-search");
                                        }
                                    });
                                    setMessageRelacionados("Resultados encontrados: "+ctrlVQtdView);
                                    if(ctrlVQtdView == 0){
                                        listLastSearch();
                                    }
                                }
                                if(resposta != "false" && isJson(resposta) == true){
                                    var jsonData = JSON.parse(resposta);
                                    var ctrlQtd = 0;
                                    jsonData.forEach(function(id_produto){
                                        selectedProdutos[ctrlQtd] = id_produto;
                                        ctrlQtd++;
                                    });
                                    listarOpcoes();
                                }else{
                                    if(onlyActives){
                                        listarOpcoes();
                                    }else{
                                        setMessageRelacionados("Exibindo resultados mais aproximados:");
                                        listLastSearch();
                                    }
                                }
                            },
                            beforeSend: function(){
                                loadingBackground.css({
                                    visibility: "visible",
                                    opacity: "1"
                                });
                            }
                        });
                    }else if(busca.length == 0){
                        resetAllInputs();
                    }
                }
                /*END MAIN SEARCH FUNCTION*/
                
                var triggerAtivado = false;
                /*TRIGGERS*/
                if(!triggerAtivado){
                    botaoProdutosRelacionados.off().on("click", function(){
                        if(!produtosAbertos){
                            abrirRelacionados();
                        }
                        triggerAtivado = true;
                    });
                    botaoSalvarRelacionados.off().on("click", function(){
                        if(produtosAbertos){
                            fecharRelacionados();
                        }
                        triggerAtivado = true;
                    });
                    backgroundProdutos.off().on("click", function(){
                        if(produtosAbertos){
                            fecharRelacionados();
                        }
                        triggerAtivado = true;
                    });
                }
                /*END TRIGGERS*/

                /*END PRODUTOS RELACIONADOS*/
            });
        </script>
        <!--THIS PAGE CSS-->
        <style>
            .display-cores{
                width: 100%;
                height: 60px;
                padding-bottom: 10px;
                padding-top: 10px;
                text-align: center;
            }
            .display-cores .box-cor{
                width: 25px;
                height: 25px;
                background-color: #dedede;
                margin: 6px;
                display: inline-block;
                cursor: pointer;
                -webkit-box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.2);
                -moz-box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.2);
                box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.2);
            }
            .display-cores .box-cor:hover{
                border: 2px solid #111;
                border-radius: 5px;
                margin: 4px;
            }
            .display-cores .selected{
                border-radius: 50%;
                border: 2px solid #111;
                margin: 4px;
            }
            .display-cores .selected img{
                border-radius: 50%;
            }
            .display-cores .selected:hover{
                border-radius: 20px;
            }
            .file-field{
                height: 140px;
                line-height: 140px;
            }
            .file-field input{
                margin: 0px;
                padding: 0px;
            }
            .file-field:hover{
                line-height: 140px;
            }
            .btn-excluir-imagem{
                color: red;
                font-size: 16px;
                line-height: 20px;
                text-decoration: none;
                padding-bottom: 10px;
                position: absolute;
                bottom: -35px;
                margin: 0 auto;
                cursor: pointer;
                left: 0;
            }
            .msg-inputs{
                margin: 0px;
            }
            /*ESPECIFICACAO TECNICA*/
            .btn-especificacoes{
                cursor: pointer;
                border: 1px solid #333;
                transition: .2s;
                white-space: nowrap;
                text-align: center;
                display: block;
                width: 100%;
            }
            .btn-especificacoes:hover{
                background-color: #fff;
            }
            .label-especificacao{
                display: block;
                margin: 10px 0px 10px 20px;
            }
            .label-especificacao input{
                height: 14px;
                padding: 5px;
                font-size: 16px;
                margin-left: 6px;
            }
            .label-especificacao .btn-excluir-especificacao{
                cursor: pointer;
            }
            /*END ESPECIFICACAO TECNICA*/
            /*PRODUTOS RELACIONADOS CSS*/
            .btn-relacionados{
                padding: 10px;
                cursor: pointer;
                border: 1px solid #999;
                transition: .2s;
                display: block;
                width: 240px;
                text-align: center;
                margin-top: 10px;
            }
            .btn-relacionados:hover{
                background-color: #fff;
            }
            .display-relacionados{
                position: fixed;
                width: 60%;
                height: 70vh;
                margin: 0 auto;
                top: 15vh;
                left: 0;
                right: 0;
                z-index: 200;
                visibility: hidden;
                opacity: 0;
                transition: .3s;
            }
            .display-relacionados .header-relacionados{
                position: relative;
                width: 100%;
                height: 10vh;
                background-color: #f78a14;
                color: #fff;
                border-radius: 6px 6px 0px 0px;
                text-align: center;
                line-height: 10vh;
                text-align: center;
                z-index: 50;
            }
            .display-relacionados .header-relacionados .title-relacionados{
                width: 26%;
                height: 10vh;
                margin: 0px;
                padding: 0px 2% 0px 2%;
                float: left;
            }
            .display-relacionados .header-relacionados .busca-relacionados{
                width: 38%;
                height: 5vh;
                font-size: 14px;
                margin: 2.5vh 1% 0px 1%;
                padding: 0px 1% 0px 1%;
                float: left;
                border: none;
            }
            .display-relacionados .header-relacionados label{
                width: 26%;
                height: 10vh;
                margin: 0px 2% 0px 0px;
                font-size: 12px;
                cursor: pointer;
            }
            .display-relacionados .header-relacionados label input{
                position: relative;
                vertical-align: middle;
                top: -1px;
                cursor: pointer;
            }
            .display-relacionados .bottom-relacionados{
                width: 100%;
                height: 10vh;
                background-color: #eee;
                line-height: 10vh;
                text-align: center;
                border-radius: 0px 0px 6px 6px;
                border-top: 2px solid #dedede;
            }
            .display-relacionados .bottom-relacionados .btn-salvar-relacionados{
                background-color: limegreen;
                color: #fff;
                padding: 10px 30px 10px 30px;
                cursor: pointer;
            }
            .display-relacionados .bottom-relacionados .btn-salvar-relacionados:hover{
                background-color: green;
            }
            .display-relacionados .lista-relacionados{
                position: relative;
                height: 50vh;
                overflow-x: auto;
                padding: 0px 0px 40px 0px;
                background-color: #eee;
                transition: .2s;
                clear: both;
                z-index: 40;
            }
            .display-relacionados .lista-relacionados .loading-background{
                position: fixed;
                width: 60%;
                height: 53vh;
                line-height: 53vh;
                margin: 0 auto;
                top: 30vh;
                left: 0;
                right: 0;
                background-color: rgba(255, 255, 255, .4);
                z-index: 50;
                visibility: hidden;
                transition: .3s;
                opacity: 0;
            }
            .display-relacionados .lista-relacionados .loading-background .loading-message{
                font-size: 18px;
                text-align: center;
                color: #f78a14;
                margin: 0px;
            }
            .display-relacionados .lista-relacionados .lista-relacionados-msg{
                position: fixed;
                width: 60%;
                height: 5px;
                line-height: 5px;
                margin: -30px 0px 0px 0px;
                visibility: hidden;
                opacity: 0;
                transition: .3s;
                background-color: #eee;
                border-bottom: 1px solid #dedede;
                z-index: 40;
            }
            .display-relacionados .lista-relacionados .lista-relacionados-msg h4{
                margin: 0px;
                padding: 0px 1% 5px 1%;
            }
            .display-relacionados .lista-relacionados .lista-relacionados-msg .limpar-todos-relacionados{
                position: absolute;
                height: 30px;
                top: 0px;
                right: 12.5%;
                width: 12%;
                font-size: 14px;
                white-space: nowrap;
                text-align: center;
                visibility: hidden;
            }
            .display-relacionados .lista-relacionados .label-relacionados{
                cursor: pointer;
                width: 98%;
                padding: 5px 1% 5px 1%;
                float: none;
                display: inline-block;
            }
            .display-relacionados .lista-relacionados .label-relacionados:hover{
                background-color: #fff;
            }
            /*END PRODUTOS RELACIONADOS CSS*/
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
            
            require_once "../@classe-produtos.php";
        ?>
        <!--PAGE CONTENT-->
        <h1 class="titulos"><?php echo $page_title; ?><a href="pew-produtos.php" class="btn-voltar"><i class="fa fa-arrow-left" aria-hidden="true"></i> Voltar</a></h1>
        <?php
            /*SET TABLES*/
            $tabela_produtos = $pew_custom_db->tabela_produtos;
            $tabela_imagens_produtos = $pew_custom_db->tabela_imagens_produtos;
            $tabela_categorias = $pew_db->tabela_categorias;
            $tabela_subcategorias = $pew_db->tabela_subcategorias;
            $tabela_categorias_produtos = $pew_custom_db->tabela_categorias_produtos;
            $tabela_subcategorias_produtos = $pew_custom_db->tabela_subcategorias_produtos;
            $tabela_marcas = $pew_custom_db->tabela_marcas;
            $tabela_cores = $pew_custom_db->tabela_cores;
            $tabela_produtos_relacionados = $pew_custom_db->tabela_produtos_relacionados;
            $tabela_cores_relacionadas = $pew_custom_db->tabela_cores_relacionadas;
            $tabela_especificacoes = $pew_custom_db->tabela_especificacoes;
            $tabela_especificacoes_produtos = $pew_custom_db->tabela_especificacoes_produtos;
            $tabela_departamentos = $pew_custom_db->tabela_departamentos;
            $tabela_departamentos_produtos = $pew_custom_db->tabela_departamentos_produtos;
            /*END SET TABLES*/

            /*DEFAULT VARS*/
            $idProduto = isset($_GET["id_produto"]) ? (int)$_GET["id_produto"] : 0;
            $dirImagensProdutos = "../imagens/produtos";
            /*END DEFAULT VARS*/

            /*SET DADOS PRODUTOS*/
            $totalProduto = $pew_functions->contar_resultados($tabela_produtos, "id = '$idProduto'");
            if($totalProduto > 0){
                $produto = new Produtos();
                $produto->montar_produto($idProduto);
                $infoProduto = $produto->montar_array();
                $skuProduto = $infoProduto["sku"];
                $nomeProduto = $infoProduto["nome"];
                $precoProduto = $infoProduto["preco"];
                $precoProduto = $pew_functions->custom_number_format($precoProduto);
                $precoPromocaoProduto = $infoProduto["preco_promocao"];
                $precoPromocaoProduto = $pew_functions->custom_number_format($precoPromocaoProduto);
                $promocaoAtiva = $infoProduto["promocao_ativa"];
                $marcaProduto = $infoProduto["marca"];
                $idCorProduto = $infoProduto["id_cor"];
                $estoqueProduto = $infoProduto["estoque"];
                $estoqueBaixoProduto = $infoProduto["estoque_baixo"];
                $tempoFabricacaoProduto = $infoProduto["tempo_fabricacao"];
                $descricaoCurtaProduto = $infoProduto["descricao_curta"];
                $descricaoLongaProduto = $infoProduto["descricao_longa"];
                $urlVideoProduto = $infoProduto["url_video"];
                $pesoProduto = $infoProduto["peso"];
                $comprimentoProduto = $infoProduto["comprimento"];
                $larguraProduto = $infoProduto["largura"];
                $alturaProduto = $infoProduto["altura"];
                $statusProduto = $infoProduto["status"];
                $imagensProduto = $infoProduto["imagens"];
                $departamentosProduto = $produto->get_departamentos_produto();
                $categoriasProduto = $produto->get_categorias_produto();
                $subcategoriasProduto = $produto->get_subcategorias_produto();
                $especificacoesProduto = $produto->get_especificacoes_produto();
                $relacionadosProdutos = $produto->get_relacionados_produto();
                $relacionadosCores = $produto->get_cores_relacionadas();
                
                $selectedDepartamentos = array();
                if($departamentosProduto != false){
                    foreach($departamentosProduto as $infoDepartamento){
                        $idDepartamento = $infoDepartamento["id"];
                        $selectedDepartamentos[$idDepartamento] = true;
                    }
                }
                
                $selectedCategorias = array();
                if($categoriasProduto != false){
                    foreach($categoriasProduto as $infoCategoria){
                        $idCategoria = $infoCategoria["id"];
                        $tituloCategoria = $infoCategoria["titulo"];
                        $selectedCategorias[$idCategoria] = $tituloCategoria;
                    }
                }
                
                $selectedSubcategorias = array();
                if($subcategoriasProduto != false){
                    foreach($subcategoriasProduto as $infoSubcategoria){
                        $idSubcategoria = $infoSubcategoria["id_subcategoria"];
                        $idCategoriaMain = $infoSubcategoria["id_categoria"];
                        $tituloSubcategoria = $infoSubcategoria["titulo"];
                        $selectedSubcategorias[$idSubcategoria] = $tituloSubcategoria;
                        echo "<script>$(document).ready(function(){ checkSubcategorias($idSubcategoria); });</script>";
                    }
                }
                
                $selectedProdutosRelacionados = array();
                $ctrlRelacionados = 0;
                if($relacionadosProdutos != false){
                    foreach($relacionadosProdutos as $infoRelacionados){
                        $idRelacionado = $infoRelacionados["id_relacionado"];
                        $selectedProdutosRelacionados[$idRelacionado] = true;
                        $ctrlRelacionados++;
                    }
                }
                
                $selectedCoresRelacionadas = array();
                $ctrlCoresRelacionadas = 0;
                if($relacionadosProdutos != false){
                    foreach($relacionadosCores as $infoRelacionados){
                        $idRelacionado = $infoRelacionados["id_relacao"];
                        $selectedCoresRelacionadas[$idRelacionado] = true;
                        $ctrlCoresRelacionadas++;
                    }
                }
                
                print_r($relacionadosCores);
                /*END SET DADOS PRODUTO*/
        ?>
        <section class="conteudo-painel">
            <form id="formAtualizaProduto" name="formulario_cadastro" method="post" action="pew-update-produto.php" enctype="multipart/form-data">
                <input type="hidden" name="id_produto" value="<?php echo $idProduto;?>" id="idProduto">
                <!--LINHA 1-->
                <div class="label medium">
                    <h2 class='label-title'>Nome do Produto</h2>
                    <input type="text" name="nome" id="nome" placeholder="Produto" class="label-input" value="<?php echo $nomeProduto;?>">
                </div>
                <div class="label xsmall">
                    <h2 class='label-title'>Marca</h2>
                    <select name="marca" class="label-input">
                        <option value="">- Selecione -</option>
                        <?php
                            $contarMarcas = mysqli_query($conexao, "select count(id) as total from $tabela_marcas where status = 1");
                            $contagemMarcas = mysqli_fetch_array($contarMarcas);
                            $totalMarcas = $contagemMarcas["total"];
                            if($totalMarcas > 0){
                                $queryMarcas = mysqli_query($conexao, "select * from $tabela_marcas where status = 1");
                                while($infoMarcas = mysqli_fetch_array($queryMarcas)){
                                    $nomeMarca = $infoMarcas["marca"];
                                    $selected = $nomeMarca == $marcaProduto ? "selected" : "";
                                    echo "<option value='$nomeMarca' $selected>$nomeMarca</option>";
                                }
                            }
                        ?>
                    </select>
                    <?php
                    if($totalMarcas == 0){
                        echo "<h5 style='margin: 0px; margin-top: -6px;'>Nenhum marca cadastrada</h5>";
                    }
                    ?>
                </div>
                <div class="label xsmall">
                    <h2 class='label-title'>Estoque</h2>
                    <input type="number" step="any" name="estoque" id="estoque" class="label-input" value="<?php echo $estoqueProduto;?>">
                </div>
                <div class="label xsmall">
                    <h2 class='label-title'>Estoque baixo</h2>
                    <input type="number" step="any" name="estoque_baixo" value="<?php echo $estoqueBaixoProduto;?>" id="estoque_baixo" placeholder="Quantidade estoque baixo" class="label-input">
                </div>
                <div class="label xsmall">
                    <h2 class='label-title'>Fabricação (dias)</h2>
                    <input type="number" step="any" name="tempo_fabricacao" id="tempo_fabricacao" value="<?php echo $tempoFabricacaoProduto;?>" placeholder="Tempo em dias" class="label-input">
                </div>
                <!--END LINHA 1-->
                
                <!--LINHA 2-->
                <br class="clear">
                <div class="label half">
                    <h2 class='label-title'>Descrição Curta SEO Google<br>(Recomendado 156 caracteres)</h2>
                    <textarea placeholder="Descrição do produto" name="descricao_curta" maxlength="180" id="descricaoCurta" class="label-textarea" rows="3"><?php echo $descricaoCurtaProduto;?></textarea>
                </div>
                <div class="label half">
                    <h2 class='label-title'>Descrição Longa</h2>
                    <textarea placeholder="Descrição do produto" name="descricao_longa" id="descricaoLonga" class="label-input" rows="5"><?php echo $descricaoLongaProduto;?></textarea>
                </div>
                <!--END LINHA 2-->
                <br class="clear">
                <br class="clear">
                <!--LINHA 3-->
                <div class="label xsmall">
                    <h2 class='label-title'>Status</h2>
                    <select name="status" class="label-input">
                        <?php
                            $possibleStatus = array(0, 1);
                            foreach($possibleStatus as $selectStatus){
                                $nameStatus = $selectStatus == 1 ? "Ativo" : "Inativo";
                                $selected = $selectStatus == $statusProduto ? "selected" : "";
                                echo "<option value='$selectStatus' $selected>$nameStatus</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="label xsmall">
                    <h2 class='label-title'>Preço</h2>
                    <input type="number" step="any" name="preco" id="preco" placeholder="Preço" class="label-input" style="margin-top: 10px;" value="<?php echo $precoProduto;?>">
                </div>
                <div class="label xsmall">
                    <h2 class='label-title'>Preço promoção</h2>
                    <input type="number" step="any" name="preco_promocao" id="precoPromocao" placeholder="Preço promocao" class="label-input" style="margin-top: 10px;" value="<?php echo $precoPromocaoProduto;?>">
                </div>
                <div class="label xsmall">
                    <h2 class='label-title'>Promoção</h2>
                    <select name="promocao_ativa" class="label-input">
                        <?php
                            $possibleStatus = array(0, 1);
                            foreach($possibleStatus as $selectStatusPromocao){
                                $nameStatus = $selectStatusPromocao == 1 ? "Ativa" : "Inativa";
                                $selected = $selectStatusPromocao == $promocaoAtiva ? "selected" : "";
                                echo "<option value='$selectStatusPromocao' $selected>$nameStatus</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class="label xsmall">
                    <h2 class='label-title'>SKU</h2>
                    <input type="text" name="sku" id="sku" placeholder="SKU" class="label-input" value="<?php echo $skuProduto;?>">
                </div>
                <div class="label xsmall">
                    <h2 class='label-title'>Cor</h2>
                    <select name="id_cor" id="idCor" class="label-input">
                        <option value="">- Selecione -</option>
                        <?php
                            $condicaoCores = "status = 1";
                            $totalCores = $pew_functions->contar_resultados($tabela_cores, $condicaoCores);
                            if($totalCores > 0){
                                $queryCores = mysqli_query($conexao, "select * from $tabela_cores order by cor asc");
                                while($infoCores = mysqli_fetch_array($queryCores)){
                                    $idCor = $infoCores["id"];
                                    $tituloCor = $infoCores["cor"];
                                    $selectedCor = $idCorProduto == $idCor ? "selected" : "";
                                    echo "<option value='$idCor' $selectedCor>$tituloCor</option>";
                                }
                            }
                        ?>
                    </select>
                    <?php
                        if($totalCores == 0){
                            echo "<h5 style='margin: 0px; margin-top: -6px;'>Nenhum cor cadastrada</h5>";
                        }
                    ?>
                </div>
                <!--END LINHA 3-->
                <br class="clear">
                <br class="clear">
                <!--LINHA 4-->
                <div class="medium">
                    <div class="select-categorias">
                        <h3 class="titulo">Selecione os departamentos</h3>
                        <ul class="list-categorias">
                            <?php
                                $condicaoDepartamentos = "true";
                                $totalCategorias = $pew_functions->contar_resultados($tabela_departamentos, $condicaoDepartamentos);
                                if($totalCategorias > 0){
                                    $queryCategorias = mysqli_query($conexao, "select departamento, id from $tabela_departamentos where $condicaoDepartamentos");
                                    while($departamentos = mysqli_fetch_array($queryCategorias)){
                                        $idDepartamento = $departamentos["id"];
                                        $departamento = $departamentos["departamento"];
                                        $checkedStatus = isset($selectedDepartamentos[$idDepartamento]) ? true : false;
                                        $checked = $checkedStatus == true ? "checked" : "";
                                        echo "<li class='box-categoria'><label><i class='fas fa-folder icone'></i>$departamento<input type='checkbox' value='$idDepartamento' class='check-categorias' name='departamentos[]' $checked></label>";
                                        echo "</li>";
                                    }
                                }else{
                                    echo "<div class='full'>Nenhuma categoria foi cadastrada</div>";
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="medium">
                    <div class="select-categorias">
                        <h3 class="titulo">Selecione as categorias e subcategorias</h3>
                        <ul class="list-categorias">
                            <?php
                                $condicaoCategorias = "status  = 1";
                                $totalCategorias = $pew_functions->contar_resultados($tabela_categorias, $condicaoCategorias);
                                if($totalCategorias > 0){
                                    $queryCategorias = mysqli_query($conexao, "select categoria, id from $tabela_categorias where $condicaoCategorias");
                                    while($categorias = mysqli_fetch_array($queryCategorias)){
                                        $idCategoria = $categorias["id"];
                                        $categoria = $categorias["categoria"];
                                        $condicaoSubcategorias = "status = 1 and id_categoria = '$idCategoria'";
                                        $totalSubcategorias = $pew_functions->contar_resultados($tabela_subcategorias, $condicaoSubcategorias);
                                        $checkedStatus = isset($selectedCategorias[$idCategoria]) ? true : false;
                                        $checkedCategoria = $checkedStatus == true ? "checked" : "";
                                        $classeSub = $checkedStatus == true ? "list-subcategorias-active" : "";
                                        $styleSub = $checkedStatus == true ? "style='display: block;'" : "";
                                        echo "<li class='box-categoria'><label><i class='fas fa-folder icone'></i>$categoria<input type='checkbox' value='$idCategoria' class='check-categorias' name='categorias[]' $checkedCategoria></label>";
                                        if($totalSubcategorias > 0){
                                            echo "<ul class='list-subcategorias $classeSub' $styleSub>";
                                            $querySubcategorias = mysqli_query($conexao, "select subcategoria, id from $tabela_subcategorias where $condicaoSubcategorias");
                                            while($subcategorias = mysqli_fetch_array($querySubcategorias)){
                                                $idSubcategoria = $subcategorias["id"];
                                                $subcategoria = $subcategorias["subcategoria"];
                                                $checkedSub = isset($selectedSubcategorias[$idSubcategoria]) == true ? "checked" : "";
                                                echo "<li class='box-subcategoria'><label><i class='fas fa-folder icone'></i> $subcategoria<input type='checkbox' value='$subcategoria||$idSubcategoria' class='check-subcategorias' $checkedSub name='subcategorias[]'></label></li>";
                                            }
                                            echo "</ul>";
                                        }
                                        echo "</li>";
                                    }
                                }else{
                                    echo "<div class='full'>Nenhuma categoria foi cadastrada</div>";
                                }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="medium">
                    <h2 align=left style="margin: 0px;">Dimensões (Calculo frete)</h2>
                    <div class="label half">
                        <h2 class="label-title" title="Peso">Peso (kg)</h2>
                        <input type="number" step="any" name="peso" id="peso" placeholder="Ex: 0.500" class="label-input" value="<?php echo $pesoProduto;?>">
                    </div>
                    <div class="label half">
                        <h2 class="label-title" title="Comprimento">Comp. (cm)</h2>
                        <input type="number" step="any" name="comprimento" id="comprimento" placeholder="Ex: 20" class="label-input" value="<?php echo $comprimentoProduto;?>">
                    </div>
                    <div class="label half">
                        <h2 class="label-title" title="Largura">Largura (cm)</h2>
                        <input type="number" step="any" name="largura" id="largura" placeholder="Ex: 20" class="label-input" value="<?php echo $larguraProduto;?>">
                    </div>
                    <div class="label half">
                        <h2 class="label-title" title="Altura">Altura (cm)</h2>
                        <input type="number" step="any" name="altura" id="altura" placeholder="Ex: 20" class="label-input" value="<?php echo $alturaProduto;?>">
                    </div>
                </div>
                <!--END LINHA 4-->
                <br class="clear">
                <br class="clear">
                <br class="clear">
                <br class="clear">
                <!--LINHA 5-->
                <div class="half" align=right>
                    <h2 align=right>Especificações técnicas</h2>
                    <?php
                        $contarEspec = mysqli_query($conexao, "select count(id) as total from $tabela_especificacoes where status = 1");
                        $contagem = mysqli_fetch_assoc($contarEspec);
                        $totalEspec = $contagem["total"];
                        if($totalEspec > 0){
                            $queryEspecificacoes = mysqli_query($conexao, "select * from $tabela_especificacoes where status = 1 order by titulo asc");
                            echo "<div class='medium'>";
                            echo "<select id='selectEspecificacao' class='label-input'>";
                                echo "<option value=''>- Selecione -</option>";
                                while($infoEspecificacao = mysqli_fetch_array($queryEspecificacoes)){
                                    $tituloEspecificacao = $infoEspecificacao["titulo"];
                                    $idEspecificacao = $infoEspecificacao["id"];
                                    echo "<option value='$idEspecificacao'>$tituloEspecificacao</option>";
                                }
                            echo "</select>";
                            echo "</div>";
                            echo "<div class='medium'>";
                            echo "<input type='text' id='descricaoEspecificacao' class='label-input' placeholder='Descrição' form='addEspecificacao'>";
                            echo "</div>";
                            echo "<div class='medium'>";
                            echo "<a class='btn-especificacoes label-input'>Adicionar</a>";
                            echo "</div>";
                        }else{
                            echo "<h4>Nenhuma especificação foi cadastrada.</h4>";
                        }
                    ?>
                </div>
                <div class="label half" align=left>
                    <h2 class="label-title" align=left style="position: relative; top: 25px; margin-bottom: 25px;">Especificações adicionadas:</h2>
                    <div class="display-especificacoes">
                        <!--ESPECIFICACOES ADICIONADAS-->
                        <?php
                            $totalEspecificacoes = is_array($especificacoesProduto) ? count($especificacoesProduto) : 0;
                            if($totalEspecificacoes > 0 && $especificacoesProduto != null){
                                foreach($especificacoesProduto as $infoEspecificacao){
                                    $idEspec = $infoEspecificacao["id"];
                                    $tituloEspec = $infoEspecificacao["titulo"];
                                    $descricaoEspec = $infoEspecificacao["descricao"];
                                    $valueInput = $idEspec."|-|".$descricaoEspec;
                                    echo "<label class='label-especificacao'><b>$tituloEspec: </b> <input type='text' class='input-especificacao' value='$descricaoEspec'><input type='hidden' class='input-ctrl-especificacao' name='especicacao_produto[]' value='$valueInput' pew-id-especificacao='$idEspec'> <a class='btn-excluir-especificacao' title='Excluir especificação'><i class='fa fa-times' aria-hidden='true'></i></a></label>";
                                }
                            }
                        ?>
                    </div>
                </div>
                <!--END LINHA 5-->
                <br class="clear">
                <br class="clear">
                <br class="clear">
                <br class="clear">
                
                <div class="label full">
                    <h2 class="label-title">Imagens do produto: (900px : 900px) OBRIGATÓRIO</h2>
                    <?php
                        $contarImagens = mysqli_query($conexao, "select count(id) as total_imagens from $tabela_imagens_produtos where id_produto = '$idProduto'");
                        $contagem = mysqli_fetch_assoc($contarImagens);
                        $maxImagens = 4;
                        $selectedImagens = 0;
                        foreach($imagensProduto as $infoImagem){
                            $selectedImagens++;
                            $idImagem = $infoImagem["id_imagem"];
                            $srcImagem = $infoImagem["src"];
                            $excludeImage = $selectedImagens > 1 ? "<br><a class='btn-excluir-imagem botao-acao' data-id-produto='$idImagem' data-acao='excluir_imagem'>Excluir imagem</a>" : "";
                            echo "<div class='file-field imagem-ativa small' id='imagem$selectedImagens' data-id-imagem='$idImagem'>";
                                echo "<div class='view'><img src='$dirImagensProdutos/$srcImagem' class='preview'></div>";
                                echo "<input type='file' name='imagem$selectedImagens' accept='image/*' title='Arquivo selecionado'>";
                                echo "<div class='legenda' style='background-color: limegreen;'>Arquivo selecionado</div><br>";
                                echo $excludeImage;
                            echo "</div>";
                        }
                        for($i = $selectedImagens + 1; $i <= $maxImagens; $i++){
                            echo "<div class='file-field small' id='imagem$i'>";
                            echo "<div class='view'><i class='fa fa-plus' aria-hidden='true'></i></div>";
                            echo "<input type='file' name='imagem$i' accept='image/*'>";
                            echo "<div class='legenda'>Selecione o arquivo</div>";
                            echo "</div>";
                        }
                        echo "<input type='hidden' name='maximo_imagens' value='$maxImagens'>";
                    ?>
                </div>
                <!--END LINHA 6-->
                <br style="clear: both;">
                <br style="clear: both;">
                <br style="clear: both;">
                <br style="clear: both;">
                <!--LINHA 7-->
                <div class="label half" align="left">
                    <h3 class="label-title">Iframe Vídeo</h3>
                    <input type="text" class="label-input" name="url_video" placeholder="<iframe></iframe>" value="<?php echo $urlVideoProduto; ?>">
                </div>
                <div class="small" align=left>
                    <!--PRODUTOS RELACIONADOS-->
                    <h3 class="label-title">Produtos Relacionados</h3>
                    <a class="btn-relacionados" id="btn-produtos-relacionados">Produtos Selecionados <?php echo "(".$ctrlRelacionados.")";?></a>
                    <div class="display-relacionados" id="display-produtos-relacionados">
                        <div class="header-relacionados">
                            <h3 class="title-relacionados">Produtos relacionados</h3>
                            <!--<h5 class="descricao-relacionados">Selecione os produtos relacionados</h5>-->
                            <input type="search" class="busca-relacionados" name="busca_relacionados" placeholder="Busque categoria, nome, marca, id, ou sku" form="busca_produto">
                            <label title="Listar somente os produtos que já foram selecionados"><input type="checkbox" id="checkOnlyActives"> Somente os selecionados</label>
                        </div>
                        <div class="lista-relacionados">
                            <div class="loading-background">
                                <h4 class="loading-message"><i class='fa fa-spinner fa-pulse fa-3x fa-fw'></i></h4>
                            </div>
                            <div class="lista-relacionados-msg"><h4>Exibindo todos os produtos:</h4><a class="link-padrao limpar-todos-relacionados" title="Limpar todos os produtos listados abaixo e que foram selecionados">Limpar todos</a></div>
                        <?php
                            $condicaoRelacionados = "id != '$idProduto' and status = 1";
                            $totalRelacionados = $pew_functions->contar_resultados($tabela_produtos, $condicaoRelacionados);
                            if($totalRelacionados > 0){
                                $queryAllProdutos = mysqli_query($conexao, "select id, nome from $tabela_produtos where $condicaoRelacionados order by nome asc");
                                while($infoRelacionados = mysqli_fetch_array($queryAllProdutos)){
                                    $idProdutoRelacionado = $infoRelacionados["id"];
                                    $nomeProdutoRelacionado = $infoRelacionados["nome"];
                                    $checked = "";
                                    foreach($selectedProdutosRelacionados as $prodRelacionado){
                                        if($idProdutoRelacionado == $prodRelacionado){
                                            $checked = "checked";
                                        }
                                    }
                                    echo "<label class='label-relacionados' id='label-produtos-relacionados'><input type='checkbox' name='produtos_relacionados[]' value='$idProdutoRelacionado' $checked> $nomeProdutoRelacionado</label>";
                                }
                            }else{
                                echo "<h4 class='full'>Nenhum produto encontrado</h4>";
                            }
                        ?>
                        </div>
                        <div class="bottom-relacionados">
                            <a class="btn-salvar-relacionados">Salvar</a>
                        </div>
                    </div>
                    <!--END PRODUTOS RELACIONADOS-->
                </div>
                <script type="text/javascript" src="asas.js"></script>
                <div class="small" align=left>
                    <!--PRODUTOS RELACIONADOS-->
                    <h3 class="label-title">Produtos com Cores Relacionadas</h3>
                    <a class="btn-relacionados" id="btn-cores-relacionadas">Produtos Selecionados <?php echo "(".$ctrlCoresRelacionadas.")";?></a>
                    <div class="display-relacionados" id="display-cores-relacionadas">
                        <div class="header-relacionados">
                            <h3 class="title-relacionados">Cores relacionadas</h3>
                            <!--<h5 class="descricao-relacionados">Selecione os produtos relacionados</h5>-->
                            <input type="search" class="busca-relacionados" id="busca-relacionados" name="busca_relacionados" placeholder="Busque categoria, nome, marca, id, ou sku" form="busca_produto">
                            <label title="Listar somente os produtos que já foram selecionados"><input type="checkbox" id="checkCoresOnlyActives"> Somente os selecionados</label>
                        </div>
                        <div class="lista-relacionados" id="lista-relacionados">
                            <div class="loading-background">
                                <h4 class="loading-message"><i class='fa fa-spinner fa-pulse fa-3x fa-fw'></i></h4>
                            </div>
                            <div class="lista-relacionados-msg" id="lista-relacionados-msg"><h4>Exibindo todos os produtos:</h4><a class="link-padrao limpar-todos-relacionados" title="Limpar todos os produtos listados abaixo e que foram selecionados" id="limpar-todos-relacionados">Limpar todos</a></div>
                        <?php
                            $condicaoRelacionados = "id != '$idProduto' and status = 1";
                            $totalRelacionados = $pew_functions->contar_resultados($tabela_produtos, $condicaoRelacionados);
                            if($totalRelacionados > 0){
                                $queryAllProdutos = mysqli_query($conexao, "select id, nome from $tabela_produtos where $condicaoRelacionados order by nome asc");
                                while($infoRelacionados = mysqli_fetch_array($queryAllProdutos)){
                                    $idProdutoRelacionado = $infoRelacionados["id"];
                                    $nomeProdutoRelacionado = $infoRelacionados["nome"];
                                    $checked = "";
                                    foreach($selectedCoresRelacionadas as $prodRelacionado){
                                        if($idProdutoRelacionado == $prodRelacionado){
                                            $checked = "checked";
                                        }
                                    }
                                    echo "<label class='label-relacionados label-cores-relacionadas'><input type='checkbox' name='cores_relacionadas[]' value='$idProdutoRelacionado' $checked> $nomeProdutoRelacionado</label>";
                                }
                            }else{
                                echo "<h4 class='full'>Nenhum produto encontrado</h4>";
                            }
                        ?>
                        </div>
                        <div class="bottom-relacionados">
                            <a id="btn-salvar-relacionados" class="btn-salvar-relacionados">Salvar</a>
                        </div>
                    </div>
                    <!--END PRODUTOS RELACIONADOS-->
                </div>
                <!--END LINHA 7-->
                <br class="clear">
                <br class="clear">
                <br class="clear">
                <br class="clear">
                <br class="clear">
                
                <div class="label full jc-center">
                    <div class="small">
                        <button type='button' class='btn-excluir botao-acao label-input' data-id-produto='<?php echo $idProduto; ?>' data-acao='excluir'><i class="fas fa-trash-alt"></i> Excluir produto</button>
                    </div>
                    <div class="small">
                    <?php
                        $botao = $statusProduto == 1 ? "<button type='button' class='btn-excluir botao-acao label-input' data-id-produto='$idProduto' data-acao='desativar'><i class='fas fa-power-off'></i> Desativar produto</button>" : "<button type='button' class='btn-submit botao-acao label-input' data-id-produto='$idProduto' data-acao='ativar'><i class='fas fa-power-off'></i> Ativar produto</button>";
                        echo $botao;
                    ?>
                    </div>
                    <div class="small">
                        <a href="pew-cadastra-produto.php?id_produto=<?php echo $idProduto;?>" class="btn-submit label-input" style="display: block; font-size: 18px; line-height: 40px; height: 36px;"><i class="fas fa-plus"></i> Clonar produto</a>
                    </div>
                    <div class="small">
                        <button type="submit" class="btn-submit label-input">
                            <i class="far fa-save"></i> Salvar
                        </button>
                    </div>
                </div>
                <br><br>
                <div class="full" align=center>
                    <a href="pew-produtos.php" class="link-padrao">Voltar</a>
                </div>
            </form>
        </section>
    </body>
</html>
<?php
            }else{
                echo "<h3 align='center'>Nenhum produto foi encontrado. <a href='pew-produtos.php' class='link-padrao'>Voltar.</a></h3>";
            }
?>