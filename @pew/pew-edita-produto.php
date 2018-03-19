<?php
session_start();
require_once "pew-system-config.php";
$name_session_user = $pew_session->name_user;
$name_session_pass = $pew_session->name_pass;
$name_session_nivel = $pew_session->name_nivel;
$name_session_empresa = $pew_session->name_empresa;
if(isset($_SESSION[$name_session_user]) && isset($_SESSION[$name_session_pass]) && isset($_SESSION[$name_session_nivel]) && isset($_SESSION[$name_session_empresa])){
    $efectus_empresa_administrativo = $_SESSION[$name_session_empresa];
    $efectus_user_administrativo = $_SESSION[$name_session_user];
    $efectus_nivel_administrativo = $_SESSION[$name_session_nivel];
    $navigation_title = "Editar produto - $efectus_empresa_administrativo";
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
        <!--LINKS e JS PADRAO-->
        <link type="image/png" rel="icon" href="imagens/sistema/identidadeVisual/icone-efectus-web.png">
        <link type="text/css" rel="stylesheet" href="css/estilo.css">
        <script type="text/javascript" src="js/jquery.min.js"></script>
        <script type="text/javascript" src="js/standard.js"></script>
        <!--FIM LINKS e JS PADRAO-->
        <!--THIS PAGE LINKS-->
        <script type="text/javascript" src="js/produtos.js"></script>
        <script type="text/javascript" src="custom-textarea/ckeditor.js"></script>
        <!--FIM THIS PAGE LINKS-->
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
                var categoriasSelecionadas = 0;
                $(".check-categorias").each(function(){
                    var checkbox = $(this);
                    var idCategoria = checkbox.val();
                    var initialCheck = checkbox.prop("checked");
                    selecionandoCategoria = true;
                    if(initialCheck){
                        buscar();
                    }
                    function buscar(){
                        var checked = checkbox.prop("checked");
                        if(checked == true){
                            categoriasSelecionadas++;
                            $.ajax({
                                type: "POST",
                                url: "pew-busca-subcategorias.php",
                                data: {id_categoria: idCategoria},
                                error: function(){
                                    notificacaoPadrao("Ocorreu um erro ao buscar as subcategorias", "error", 5000);
                                },
                                success: function(subcategorias){
                                    if(subcategorias != "false"){
                                        var subcategorias = subcategorias.split("||");
                                        var quantidade = subcategorias.length;
                                        var ctrlQuantidade = 0;
                                        for(var i = 0; i < quantidade; i++){
                                            var infosub = subcategorias[i].split("##");;
                                            var sub = infosub[0];
                                            var idSub = infosub[1];
                                            if(sub != ""){
                                                $(".opcao-padrao").hide();
                                                $("#spanSubCategorias").append("<label class='label-full added-subcategorias' data-id-categoria='"+idCategoria+"' style='position: relative; top: -15px;'><input type='checkbox' name='subcategorias[]' value='"+sub+"||"+idCategoria+"' class='checked-subcategoria-"+idSub+"'>"+sub+"<br style='clear: both;'></label>");
                                                ctrlQuantidade++;
                                            }
                                        }
                                        if(ctrlQuantidade == 0){
                                            $("#spanSubCategorias option").each(function(){
                                                $(this).remove();
                                            });
                                            $("#spanSubCategorias").append("<option>- Selecione -</option>");
                                        }
                                    }
                                    selecionandoCategoria = false;
                                }
                            });
                        }else{
                            categoriasSelecionadas--;
                            $("#spanSubCategorias .added-subcategorias").each(function(){
                                var selectCategoria = $(this).attr("data-id-categoria");
                                if(selectCategoria == idCategoria){
                                    $(this).remove();
                                }
                                if(categoriasSelecionadas == 0){
                                    $(".opcao-padrao").show();
                                }
                            });
                        }
                    }
                    checkbox.off().on("change", function(){
                        buscar();
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
                                        switch(acao){
                                            case "excluir":
                                                resultado  = "O produto foi excluido com sucesso";
                                                break;
                                            case "desativar":
                                                resultado = "O produto foi desativado";
                                                break;
                                            case "excluir_imagem":
                                                resultado = "A imagem foi excluida com sucesso";
                                                break;
                                            default:
                                                resultado = "O produto foi ativado com sucesso";
                                        }
                                        if(resposta == "true"){
                                            mensagemAlerta(resultado, "", "limegreen", "pew-produtos.php");
                                        }else if(resposta == "imagem_excluida"){
                                            mensagemAlerta(resultado, "", "limegreen", "pew-edita-produto.php?id_produto="+getIdProduto);
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
                var botaoProdutosRelacionados = $(".btn-produtos-relacionados");
                var displayRelacionados = $(".display-produtos-relacionados");
                var background = $(".background-interatividade");
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
                    var ctrlView = 0;
                    $(".label-relacionados").each(function(){
                        var label = $(this);
                        var input = label.children("input");
                        if(onlyActives && input.prop("checked") == true){
                            label.css("display", "inline-block").removeClass("last-search");
                            ctrlView++;
                        }else if(!onlyActives){
                            label.css("display", "inline-block").removeClass("last-search");
                            ctrlView++;
                        }
                    });
                    if(onlyActives){
                        setMessageRelacionados("Resultados encontrados: "+ctrlView);
                    }else{
                        resetMessageRelacionados();
                    }
                }
                function listLastSearch(){
                    var onlyActives = checkOnlyActives.prop("checked");
                    var ctrlQtd = 0;
                    $(".label-relacionados").each(function(){
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
                    $(".label-relacionados").each(function(){
                        var label = $(this);
                        var input = label.children("input");
                        if(input.prop("checked") == true){
                            contagem++;
                        }
                    });
                    return contagem;
                }
                function clearRelacionados(){
                    $(".label-relacionados").each(function(){
                        var label = $(this);
                        var input = label.children("input");
                        if(label.css("display") != "none"){
                            input.prop("checked", false);
                        }
                    });
                }
                /*OPEN AND CLOSE*/
                function abrirRelacionados(){
                    background.css("display", "block");
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
                            $(".label-relacionados").each(function(){
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
                function fecharRelacionados(){
                    displayRelacionados.css({
                        visibility: "hidden",
                        opacity: "0"
                    });
                    setTimeout(function(){
                        background.css("display", "none");
                    }, 200);
                    var totalSelecionados = contarProdutosSelecionados();
                    botaoProdutosRelacionados.text("Produtos Relacionados ("+totalSelecionados+")");
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
                                    $(".label-relacionados").each(function(){
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

                /*TRIGGERS*/
                botaoProdutosRelacionados.off().on("click", function(){
                    abrirRelacionados();
                });
                botaoSalvarRelacionados.off().on("click", function(){
                    fecharRelacionados();
                });
                background.off().on("click", function(){
                    fecharRelacionados();
                });
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
                padding: 10px;
                cursor: pointer;
                border: 1px solid #333;
                transition: .2s;
                white-space: nowrap;
                margin-top: 5px;
                display: block;
                width: 200px;
                text-align: center;
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
            .btn-produtos-relacionados{
                padding: 10px;
                cursor: pointer;
                border: 1px solid #333;
                transition: .2s;
            }
            .btn-produtos-relacionados:hover{
                background-color: #fff;
            }
            .display-produtos-relacionados{
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
            .display-produtos-relacionados .header-relacionados{
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
            .display-produtos-relacionados .header-relacionados .title-relacionados{
                width: 26%;
                height: 10vh;
                margin: 0px;
                padding: 0px 2% 0px 2%;
                float: left;
            }
            .display-produtos-relacionados .header-relacionados .busca-relacionados{
                width: 38%;
                height: 5vh;
                font-size: 14px;
                margin: 2.5vh 1% 0px 1%;
                padding: 0px 1% 0px 1%;
                float: left;
                border: none;
            }
            .display-produtos-relacionados .header-relacionados label{
                width: 26%;
                height: 10vh;
                margin: 0px 2% 0px 0px;
                font-size: 12px;
                cursor: pointer;
            }
            .display-produtos-relacionados .header-relacionados label input{
                position: relative;
                vertical-align: middle;
                top: -1px;
                cursor: pointer;
            }
            .display-produtos-relacionados .bottom-relacionados{
                width: 100%;
                height: 10vh;
                background-color: #eee;
                line-height: 10vh;
                text-align: center;
                border-radius: 0px 0px 6px 6px;
                border-top: 2px solid #dedede;
            }
            .display-produtos-relacionados .bottom-relacionados .btn-salvar-relacionados{
                background-color: limegreen;
                color: #fff;
                padding: 10px 30px 10px 30px;
                cursor: pointer;
            }
            .display-produtos-relacionados .bottom-relacionados .btn-salvar-relacionados:hover{
                background-color: green;
            }
            .display-produtos-relacionados .lista-relacionados{
                position: relative;
                height: 50vh;
                overflow-x: auto;
                padding: 0px 0px 40px 0px;
                background-color: #eee;
                transition: .2s;
                clear: both;
                z-index: 40;
            }
            .display-produtos-relacionados .lista-relacionados .loading-background{
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
            .display-produtos-relacionados .lista-relacionados .loading-background .loading-message{
                font-size: 18px;
                text-align: center;
                color: #f78a14;
                margin: 0px;
            }
            .display-produtos-relacionados .lista-relacionados .lista-relacionados-msg{
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
            .display-produtos-relacionados .lista-relacionados .lista-relacionados-msg h4{
                margin: 0px;
                padding: 0px 1% 5px 1%;
            }
            .display-produtos-relacionados .lista-relacionados .lista-relacionados-msg .limpar-todos-relacionados{
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
            .display-produtos-relacionados .lista-relacionados .label-relacionados{
                cursor: pointer;
                width: 98%;
                padding: 5px 1% 5px 1%;
                float: none;
                display: inline-block;
            }
            .display-produtos-relacionados .lista-relacionados .label-relacionados:hover{
                background-color: #fff;
            }
            /*END PRODUTOS RELACIONADOS CSS*/
        </style>
        <!--FIM THIS PAGE CSS-->
    </head>
    <body>
        <?php
            require_once "pew-system-config.php";
            require_once "header-efectus-web.php";
            require_once "pew-interatividade.php";
        ?>
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
            $tabela_produtos_relacionados = $pew_custom_db->tabela_produtos_relacionados;
            $tabela_especificacoes = $pew_custom_db->tabela_especificacoes;
            $tabela_especificacoes_produtos = $pew_custom_db->tabela_especificacoes_produtos;
            /*END SET TABLES*/

            /*DEFAULT VARS*/
            $idProduto = isset($_GET["id_produto"]) ? pew_string_format($_GET["id_produto"]) : 0;
            $dirImagensProdutos = "../imagens/produtos/";
            /*END DEFAULT VARS*/

            /*SET DADOS PRODUTOS*/
            /*SET DADOS PRODUTOS*/
            $contarProduto = mysqli_query($conexao, "select count(id) as total_produto from $tabela_produtos where id = '$idProduto'");
            $contagem = mysqli_fetch_assoc($contarProduto);
            if($contagem["total_produto"] > 0){
                $queryProduto = mysqli_query($conexao, "select * from $tabela_produtos where id = '$idProduto'");
                $infoProduto = mysqli_fetch_array($queryProduto);
                $skuProduto = $infoProduto["sku"];
                $nomeProduto = $infoProduto["nome"];
                $precoProduto = $infoProduto["preco"];
                $precoProduto = pew_number_format($precoProduto);
                $precoPromocaoProduto = $infoProduto["preco_promocao"];
                $precoPromocaoProduto = pew_number_format($precoPromocaoProduto);
                $promocaoAtiva = $infoProduto["promocao_ativa"];
                $marcaProduto = $infoProduto["marca"];
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
                $contarCategoriasProduto = mysqli_query($conexao, "select count(id) as total_categorias from $tabela_categorias_produtos where id_produto = '$idProduto'");
                $contagem = mysqli_fetch_assoc($contarCategoriasProduto);
                $totalCatProd = $contagem["total_categorias"];
                $selectedCategorias = array();
                if($totalCatProd > 0){
                    $queryCategorias = mysqli_query($conexao, "select id_categoria, titulo_categoria from $tabela_categorias_produtos where id_produto = '$idProduto'");
                    while($categoriasProduto = mysqli_fetch_array($queryCategorias)){
                        $idCategoria = $categoriasProduto["id_categoria"];
                        $selectedCategorias[$idCategoria] = $categoriasProduto["titulo_categoria"];
                    }
                }
                $contarSubcategoriasProduto = mysqli_query($conexao, "select count(id) as total_subcategorias from $tabela_subcategorias_produtos where id_produto = '$idProduto'");
                $contagem = mysqli_fetch_assoc($contarSubcategoriasProduto);
                $totalSubcatProd = $contagem["total_subcategorias"];
                $selectedSubcategorias = array();
                if($totalSubcatProd > 0){
                    $querySubcategorias = mysqli_query($conexao, "select id_categoria, id_subcategoria, titulo_subcategoria from $tabela_subcategorias_produtos where id_produto = '$idProduto'");
                    while($subcategoriaProduto = mysqli_fetch_array($querySubcategorias)){
                        $idCat = $subcategoriaProduto["id_categoria"];
                        $idSubcategoria = $subcategoriaProduto["id_subcategoria"];
                        $tituloSubcategoria = $subcategoriaProduto["titulo_subcategoria"];
                        $selectedSubcategorias[$idSubcategoria] = $tituloSubcategoria;
                        echo "<script>$(document).ready(function(){ checkSubcategorias($idSubcategoria); });</script>";
                    }
                }
                $selectedProdutosRelacionados = array();
                $ctrlRelacionados = 0;
                $condicao_relacionados = "id_produto = '$idProduto'";
                $queryProdRelacionados = mysqli_query($conexao, "select * from $tabela_produtos_relacionados where $condicao_relacionados");
                while($infoRelacionados = mysqli_fetch_array($queryProdRelacionados)){
                    $idSelectedRelacionado = $infoRelacionados["id_relacionado"];
                    $selectedProdutosRelacionados[$ctrlRelacionados] = $idSelectedRelacionado;
                    $ctrlRelacionados++;
                }
        ?>
        <section class="conteudo-painel">
            <form id="formAtualizaProduto" method="post" action="pew-update-produto.php" enctype="multipart/form-data">
                <input type="hidden" name="id_produto" value="<?php echo $idProduto;?>" id="idProduto">
                <label class="label-half">
                    <h2 class='input-title'>Nome do Produto</h2>
                    <input type="text" name="nome" id="nome" placeholder="Produto" value="<?php echo $nomeProduto;?>"  class="input-full">
                </label>
                <label class="label-half">
                    <h2 class='input-title'>Marca</h2>
                    <select name="marca" class="input-full">
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
                </label>
                <label class="label-medium" style="margin-top: 0px;">
                    <h2 class='input-title'>Estoque</h2>
                    <input type="number" step="any" name="estoque" id="estoque" placeholder="Quantidade produtos" value="<?php echo $estoqueProduto;?>" class="input-full">
                </label>
                <label class="label-medium" style="margin-top: 0px;">
                    <h2 class='input-title'>Notificação estoque baixo</h2>
                    <input type="number" step="any" name="estoque_baixo" value="1" id="estoque_baixo" placeholder="Quantidade estoque baixo" value="<?php echo $estoqueBaixoProduto;?>" class="input-full">
                </label>
                <label class="label-medium" style="margin-top: 0px;">
                    <h2 class='input-title'>Tempo de fabricação (dias)</h2>
                    <input type="number" step="any" name="tempo_fabricacao" id="tempo_fabricacao" placeholder="Tempo em dias" value="<?php echo $tempoFabricacaoProduto;?>" class="input-full">
                </label>
                <label class="label-half">
                    <h2 class='input-title'>Descrição Curta SEO Google<br>(Recomendado 156 caracteres)</h2>
                    <textarea placeholder="Descrição do produto" name="descricao_curta" maxlength="180" id="descricaoCurta" class="input-full" rows="3"><?php echo $descricaoCurtaProduto;?></textarea>
                </label>
                <label class="label-half">
                    <h2 class='input-title'>Descrição Longa</h2>
                    <textarea placeholder="Descrição do produto" name="descricao_longa" id="descricaoLonga" class="input-full" rows="5"><?php echo $descricaoLongaProduto;?></textarea>
                </label>
                <label class="label-medium">
                    <div class="label-half" style="margin-top: 0px;">
                        <h2 class='input-title'>Status</h2>
                        <select name="status" class="input-full">
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
                    <div class="label-half" style="margin-top: 0px;">
                        <h2 class='input-title'>Preço</h2>
                        <input type="number" step="any" name="preco" id="preco" placeholder="Preço" class="input-full" style="margin-top: 10px;" value="<?php echo $precoProduto;?>">
                    </div>
                </label>
                <label class="label-medium">
                    <div class="label-half" style="margin-top: 0px;">
                        <h2 class='input-title'>Preço promoção</h2>
                        <input type="number" step="any" name="preco_promocao" id="precoPromocao" placeholder="Preço promocao" class="input-full" style="margin-top: 10px;" value="<?php echo $precoPromocaoProduto;?>">
                    </div>
                    <div class="label-half" style="margin-top: 0px;">
                        <h2 class='input-title'>Promoção</h2>
                        <select name="promocao_ativa" class="input-full">
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
                </label>
                <label class="label-medium">
                    <h2 class='input-title'>SKU</h2>
                    <input type="text" name="sku" id="sku" placeholder="SKU" value="<?php echo $skuProduto;?>" class="input-full">
                </label>
                <br style="clear: both">
                <label class="label-half" align=right>
                    <h2 class='input-title'>Categoria</h2>
                    <?php
                    $contarCategorias = mysqli_query($conexao, "select count(id) as total_categorias from $tabela_categorias where status = 1");
                    $contagem = mysqli_fetch_assoc($contarCategorias);
                    if($contagem["total_categorias"] > 0){
                        $queryCategorias = mysqli_query($conexao, "select categoria, id from $tabela_categorias where status = 1");
                        while($categorias = mysqli_fetch_array($queryCategorias)){
                            $idCategoria = $categorias["id"];
                            $categoria = $categorias["categoria"];
                            $checked = isset($selectedCategorias[$idCategoria]) ? "checked" : "";
                            echo "<label class='label-full'>$categoria<input type='checkbox' value='$idCategoria' class='check-categorias' name='categorias[]' $checked><br style='clear: both;'></label>";
                        }
                    }
                    if($contagem["total_categorias"] == 0){
                        echo "<h3 class='msg-inputs'>Nenhuma categoria foi adicionada.</h3>";
                    }
                    ?>
                </label>
                <label class="label-half" align=left>
                    <h2 class='input-title'>Subcategoria</h2>
                    <label class="input-full" name="subcategoria" id="spanSubCategorias">
                        <label class="label-full opcao-padrao">- Selecione a categoria -</label>
                        <br style="clear: both;">
                    </label>
                </label>
                <br style="clear: both;">
                <br style="clear: both;">
                <div class="label-full">
                    <h2 align=left>Dimensões (Calculo frete)</h2>
                    <div class="label-small">
                        <h2 class="input-title">Peso (kg)</h2>
                        <input type="number" step="any" name="peso" id="peso" placeholder="Ex: 0.500" value="<?php echo $pesoProduto;?>" class="input-full">
                    </div>
                    <div class="label-small">
                        <h2 class="input-title">Comprimento (cm)</h2>
                        <input type="number" step="any" name="comprimento" id="comprimento" placeholder="Ex: 20" value="<?php echo $comprimentoProduto;?>" class="input-full">
                    </div>
                    <div class="label-small">
                        <h2 class="input-title">Largura (cm)</h2>
                        <input type="number" step="any" name="largura" id="largura" placeholder="Ex: 20" value="<?php echo $larguraProduto;?>" class="input-full">
                    </div>
                    <div class="label-small">
                        <h2 class="input-title">Altura (cm)</h2>
                        <input type="number" step="any" name="altura" id="altura" placeholder="Ex: 20" value="<?php echo $alturaProduto;?>" class="input-full">
                    </div>
                </div>
                <br style="clear: both;">
                <br style="clear: both;">
                <div class="label-half" align=right>
                    <h2 align=right>Especificações técnicas</h2>
                    <?php
                        $contarEspec = mysqli_query($conexao, "select count(id) as total from $tabela_especificacoes where status = 1");
                        $contagem = mysqli_fetch_assoc($contarEspec);
                        $totalEspec = $contagem["total"];
                        if($totalEspec > 0){
                            $queryEspecificacoes = mysqli_query($conexao, "select * from $tabela_especificacoes where status = 1 order by titulo asc");
                            echo "<select id='selectEspecificacao' class='input-medium'>";
                                echo "<option value=''>- Selecione -</option>";
                            while($infoEspecificacao = mysqli_fetch_array($queryEspecificacoes)){
                                $tituloEspecificacao = $infoEspecificacao["titulo"];
                                $idEspecificacao = $infoEspecificacao["id"];
                                echo "<option value='$idEspecificacao'>$tituloEspecificacao</option>";
                            }
                            echo "</select>";
                            echo "<input type='text' id='descricaoEspecificacao' class='input-medium' placeholder='Descrição da especificação' form='addEspecificacao'>";
                            echo "<a class='btn-especificacoes input-medium'>Adicionar especificação</a>";
                        }else{
                            echo "<h4>Nenhuma especificação foi cadastrada.</h4>";
                        }
                    ?>
                </div>
                <div class="label-half" align=left>
                    <br><h2 class="input-title" align=left>Especificações adicionadas:</h2>
                    <div class="display-especificacoes">
                        <!--ESPECIFICACOES ADICIONADAS-->
                        <?php
                            $contar = mysqli_query($conexao, "select count(id) as total from $tabela_especificacoes_produtos where id_produto = '$idProduto'");
                            $contagem = mysqli_fetch_assoc($contar);
                            $total = $contagem["total"];
                            if($total > 0){
                                $queryEspecProduto = mysqli_query($conexao, "select * from $tabela_especificacoes_produtos where id_produto = '$idProduto'");
                                while($infoEspec = mysqli_fetch_array($queryEspecProduto)){
                                    $idEspec = $infoEspec["id_especificacao"];
                                    $descricao = $infoEspec["descricao"];
                                    $queryTituloEspec = mysqli_query($conexao, "select titulo from $tabela_especificacoes where id = '$idEspec'");
                                    $infoTitulo = mysqli_fetch_array($queryTituloEspec);
                                    $titulo = $infoTitulo["titulo"];
                                    $ctrlInputVal = $idEspec."|-|".$descricao;
                                    echo "<label class='label-especificacao'><b>$titulo: </b> <input type='text' class='input-especificacao' value='$descricao'><input type='hidden' class='input-ctrl-especificacao' name='especicacao_produto[]' value='$ctrlInputVal' pew-id-especificacao='$idEspec'> <a class='btn-excluir-especificacao' title='Excluir especificação'><i class='fa fa-times' aria-hidden='true'></i></a></label>";
                                }
                            }
                        ?>
                    </div>
                </div>
                <br style="clear: both;">
                <br style="clear: both;">
                <div class="label-full">
                    <h2 class="input-title">Imagens do produto: (1200px : 1600px) OBRIGATÓRIO</h2>
                    <?php
                        $contarImagens = mysqli_query($conexao, "select count(id) as total_imagens from $tabela_imagens_produtos where id_produto = '$idProduto'");
                        $contagem = mysqli_fetch_assoc($contarImagens);
                        $maxImagens = 4;
                        $selectedImagens = 0;
                        if($contagem["total_imagens"] > 0){
                            $queryImagens = mysqli_query($conexao, "select * from $tabela_imagens_produtos where id_produto = '$idProduto'");
                            while($imagens = mysqli_fetch_array($queryImagens)){
                                $selectedImagens++;
                                $idImagem = $imagens["id"];
                                $imagem = $imagens["imagem"];
                                $excludeImage = $selectedImagens > 1 ? "<br><a class='btn-excluir-imagem botao-acao' data-id-produto='$idImagem' data-acao='excluir_imagem'>Excluir imagem</a>" : "";
                                echo "<div class='file-field imagem-ativa' id='imagem$selectedImagens' data-id-imagem='$idImagem'>";
                                echo "<div class='view'><img src='$dirImagensProdutos$imagem' class='preview'></div>";
                                echo "<input type='file' name='imagem$selectedImagens' class='input-full' accept='image/*' title='Arquivo selecionado'>";
                                echo "<div class='legenda' style='background-color: limegreen;'>Arquivo selecionado</div><br>";
                                echo $excludeImage;
                                echo "</div>";
                            }
                        }
                        for($i = $selectedImagens + 1; $i <= $maxImagens; $i++){
                            echo "<div class='file-field' id='imagem$i'>";
                            echo "<div class='view'><i class='fa fa-plus' aria-hidden='true'></i></div>";
                            echo "<input type='file' name='imagem$i' class='input-full' accept='image/*'>";
                            echo "<div class='legenda'>Selecione o arquivo</div>";
                            echo "</div>";
                        }
                        echo "<input type='hidden' name='maximo_imagens' value='$maxImagens'>";
                    ?>
                </div>
                <br style="clear: both;">
                <br style="clear: both;">
                <br style="clear: both;">
                <br style="clear: both;">
                <div class="label-half" align=left style="margin: 0px;">
                    <h3 class="input-title">Iframe Vídeo</h3>
                    <input type="text" class="input-full" name="url_video" placeholder="https://www.youtube.com/watch?v=Ro7yHf_pU14" value="<?php echo $urlVideoProduto; ?>">
                </div>
                <br style="clear: both;">
                <div class="label-full" align=left>
                    <!--PRODUTOS RELACIONADOS-->
                    <h3 align=left>Produto relacionados</h3>
                    <a class="btn-produtos-relacionados">Produtos Relacionados <?php echo "(".$ctrlRelacionados.")";?></a>
                    <div class="display-produtos-relacionados">
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
                            $queryAllProdutos = mysqli_query($conexao, "select id, nome from $tabela_produtos where status = 1 order by nome asc");
                            while($infoRelacionados = mysqli_fetch_array($queryAllProdutos)){
                                $idProdutoRelacionado = $infoRelacionados["id"];
                                $nomeProdutoRelacionado = $infoRelacionados["nome"];
                                $checked = "";
                                foreach($selectedProdutosRelacionados as $prodRelacionado){
                                    if($idProdutoRelacionado == $prodRelacionado){
                                        $checked = "checked";
                                    }
                                }
                                echo "<label class='label-relacionados'><input type='checkbox' name='produtos_relacionados[]' value='$idProdutoRelacionado' $checked> $nomeProdutoRelacionado</label>";
                            }
                        ?>
                        </div>
                        <div class="bottom-relacionados">
                            <a class="btn-salvar-relacionados">Salvar</a>
                        </div>
                    </div>
                    <!--END PRODUTOS RELACIONADOS-->
                </div>
                <input type='button' class='btn-excluir botao-acao' data-id-produto='<?php echo $idProduto; ?>' data-acao='excluir' value='Excluir produto'>
                <?php
                    $botao = $statusProduto == 1 ? "<input type='button' class='btn-excluir botao-acao' data-id-produto='$idProduto' data-acao='desativar' value='Desativar produto'>" : "<input type='button' class='btn-submit botao-acao' data-id-produto='$idProduto' data-acao='ativar' value='Ativar produto'>";
                    echo $botao;
                ?>
                <input type="submit" class="btn-submit" value="Salvar Alterações">
                <br><br>
                <a href="pew-produtos.php" class="link-padrao">Voltar</a>
            </form>
        </section>
    </body>
</html>
<?php
            }else{
                echo "<h3 align='center'>Nenhum produto foi encontrado. <a href='pew-produtos.php' class='link-padrao'>Voltar.</a></h3>";
            }
}else{
    header("location: index.php?msg=Área Restrita. É necessário fazer login para continuar.");
}
?>
