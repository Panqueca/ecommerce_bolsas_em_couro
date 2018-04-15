$(document).ready(function(){
    /*PRODUTOS RELACIONADOS*/
    var botaoCoresRelacionadas = $("#btn-cores-relacionadas");
    var displayCoresRelacionadas = $("#display-cores-relacionadas");
    var backgroundCores = $(".background-interatividade");
    var botaoSalvarCoresRelacionadas = $("#btnSalvarCoresRelacionadas");
    var botaoCleanRelacionados = $(".limpar-todos-relacionados");
    var labelCoresRelacionados = $(".label-cores-relacionadas");
    var barraBusca = $(".busca-relacionados");
    var checkCoresOnlyActives = $("#checkCoresOnlyActives");
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
    function setMessageCoresRelacionadas(str){
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
        var onlyActives = checkCoresOnlyActives.prop("checked");
        var ctrlView = 0;
        labelCoresRelacionados.each(function(){
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
            setMessageCoresRelacionadas("Resultados encontrados: "+ctrlView);
        }else{
            resetMessageRelacionados();
        }
    }
    function listLastSearch(){
        var onlyActives = checkCoresOnlyActives.prop("checked");
        var ctrlQtd = 0;
        labelCoresRelacionados.each(function(){
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
            setMessageCoresRelacionadas("Exibindo resultados mais aproximados:");
        }else{
            setMessageCoresRelacionadas("Nenhum resultado foi encontrado");
            botaoCleanRelacionados.css("visibility", "hidden");
        }
    }
    function contarProdutosSelecionados(){
        var contagem = 0;
        labelCoresRelacionados.each(function(){
            var label = $(this);
            var input = label.children("input");
            if(input.prop("checked") == true){
                contagem++;
            }
        });
        return contagem;
    }
    function clearRelacionados(){
        labelCoresRelacionados.each(function(){
            var label = $(this);
            var input = label.children("input");
            if(label.css("display") != "none"){
                input.prop("checked", false);
            }
        });
    }
    /*OPEN AND CLOSE*/
    var coresAbertas = false;
    function abrirCoresRelacionadas(){
        if(!coresAbertas){
            coresAbertas = true;
            backgroundCores.css("display", "block");
            displayCoresRelacionadas.css({
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
            checkCoresOnlyActives.off().on("change", function(){
                var checked = $(this).prop("checked");
                var buscaAtiva = barraBusca.val().length > 0 ? true : false;
                if(checked && !buscaAtiva){
                    var ctrlQtd = 0;
                    labelCoresRelacionados.each(function(){
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
                    setMessageCoresRelacionadas("Resultados encontrados: "+ctrlQtd);
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
    function fecharCoresRelacionadas(){
        if(coresAbertas){
            displayCoresRelacionadas.css({
                visibility: "hidden",
                opacity: "0"
            });
            setTimeout(function(){
                backgroundCores.css("display", "none");
                coresAbertas = false;
            }, 200);
            var totalSelecionados = contarProdutosSelecionados();
            botaoCoresRelacionadas.text("Produtos Relacionados ("+totalSelecionados+")");
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
        onlyActives = checkCoresOnlyActives.prop("checked");

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
                    var selectedCores = [];
                    var ctrlVQtdView = 0;
                    function listarOpcoes(){
                        labelCoresRelacionados.each(function(){
                            var label = $(this);
                            var input = label.children("input");
                            var inputIdProduto = input.val();
                            var inputChecked = input.prop("checked");
                            var arraySearch = selectedCores.some(function(id){
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
                        setMessageCoresRelacionadas("Resultados encontrados: "+ctrlVQtdView);
                        if(ctrlVQtdView == 0){
                            listLastSearch();
                        }
                    }
                    if(resposta != "false" && isJson(resposta) == true){
                        var jsonData = JSON.parse(resposta);
                        var ctrlQtd = 0;
                        jsonData.forEach(function(id_produto){
                            selectedCores[ctrlQtd] = id_produto;
                            ctrlQtd++;
                        });
                        listarOpcoes();
                    }else{
                        if(onlyActives){
                            listarOpcoes();
                        }else{
                            setMessageCoresRelacionadas("Exibindo resultados mais aproximados:");
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
    var triggerAtivado = false;
    if(!triggerAtivado){
        botaoCoresRelacionadas.off().on("click", function(){
            if(!coresAbertas){
                abrirCoresRelacionadas();
            }
            triggerAtivado = true;
        });
        botaoSalvarCoresRelacionadas.off().on("click", function(){
            if(coresAbertas){
                fecharCoresRelacionadas();
            }
            triggerAtivado = true;
        });
        backgroundCores.off().on("click", function(){
            if(coresAbertas){
                fecharCoresRelacionadas();
            }
            triggerAtivado = true;
        });
    }
    /*END TRIGGERS*/
});