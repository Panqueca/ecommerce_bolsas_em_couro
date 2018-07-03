$(document).ready(function(){

    // MODAL MULTI OPTIONS
    var objBgInteratividade = $(".background-interatividade");
    var objModalMultiOptions = $(".modal-multi-select");
    
    objModalMultiOptions.each(function(){
        var objMain = $(this);
        var objHeader = objMain.children(".header");
        var objBottom = objMain.children(".bottom");
        
        var attrBtnOpenID = objMain.attr("js-open-button");
        
        var searchBar = objHeader.children(".search-bar");
        var checkActiveLabel = $(".label-check-actives");
        var checkActiveOptions = checkActiveLabel.children(".check-only-actives");
        var optionsList = objMain.children(".options-list");
        var optionLabel = optionsList.children(".option-label");
        var msgOptionsList = optionsList.children(".options-list-msg");
        
        var btnOpenModal = $("#"+attrBtnOpenID);
        var btnCloseModal = objBottom.children(".btn-save-options");
        var btnClearOptions = objHeader.children(".clear-options");
        
        var urlSearch = objMain.attr("js-search-url");
        var searchParameter = objMain.attr("js-search-parameter");
        var modalSearchingOptions = false;
        var resetingBackground = false;
        var lastSearchString = null;

        var isOpenModal = false;
        function openModalMultiOptions(){
            if(!isOpenModal){
                isOpenModal = true;

                objBgInteratividade.css("display", "block");
                objMain.css({
                    visibility: "visible",
                    opacity: "1"
                });

                /*SEARCH TRIGGRES*/
                searchBar.on("keyup", function(){
                    searchOptions();
                });
                searchBar.on("search", function(){
                    searchOptions();
                });
                /*END SEARCH TRIGGRES*/

                checkActiveOptions.off().on("change", function(){
                    var checked = $(this).prop("checked");
                    var activeSearch = searchBar.val().length > 0 ? true : false;
                    if(checked && !activeSearch){
                        var ctrlQtd = 0;
                        optionLabel.each(function(){
                            var label = $(this);
                            var input = label.children("input");
                            var selecionado = input.prop("checked");
                            if(!selecionado){
                                label.css("display", "none");
                            }else{
                                ctrlQtd++;
                            }
                        });
                        btnClearOptions.css("visibility", "visible");
                        setResultMessage("Resultados encontrados: "+ctrlQtd);
                    }else if(activeSearch){
                        lastSearchString = null;
                        searchOptions();
                        if(checked){
                            btnClearOptions.css("visibility", "visible");
                        }else{
                            btnClearOptions.css("visibility", "hidden");
                        }
                    }else{
                        resetAllOptions();
                        btnClearOptions.css("visibility", "hidden");
                    }
                });

                btnClearOptions.off().on("click", function(){
                    clearRelacionados();
                });
            }
        }
        function closeModalMultiOptions(){
            if(isOpenModal){
                objMain.css({
                    visibility: "hidden",
                    opacity: "0"
                });
                setTimeout(function(){
                    objBgInteratividade.css("display", "none");
                    isOpenModal = false;
                }, 200);
                var totalSelected = countSelectedOptions();
                if(btnOpenModal.val() != "undefined"){
                    btnOpenModal.val("Selecionados ("+totalSelected+")");
                }else{
                    btnOpenModal.text("Selecionados ("+totalSelected+")");
                }
            }
        }

        function setResultMessage(str){
            optionsList.css("padding", "30px 0px 10px 0px");
            msgOptionsList.children("h4").text(str);
            msgOptionsList.css({
                height: "30px",
                lineHeight: "30px",
                visibility: "visible",
                opacity: "1"
            });
        }
        function resetResultMessage(){
            optionsList.css("padding", "0px 0px 40px 0px");
            msgOptionsList.children("h4").text("");
            msgOptionsList.css({
                height: "5px",
                lineHeight: "5px",
                visibility: "hidden",
                opacity: "0"
            });
        }
        function resetAllOptions(){
            var onlyActives = checkActiveOptions.prop("checked");
            var ctrlView = 0;
            optionLabel.each(function(){
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
                setResultMessage("Resultados encontrados: "+ctrlView);
            }else{
                resetResultMessage();
            }
        }
        function listLastSearch(){
            var onlyActives = checkActiveOptions.prop("checked");
            var ctrlQtd = 0;
            optionLabel.each(function(){
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
                setResultMessage("Exibindo resultados mais aproximados:");
            }else{
                setResultMessage("Nenhum resultado foi encontrado");
                btnClearOptions.css("visibility", "hidden");
            }
        }
        function countSelectedOptions(){
            var contagem = 0;
            optionLabel.each(function(){
                var label = $(this);
                var input = label.children("input");
                if(input.prop("checked") == true){
                    contagem++;
                }
            });
            return contagem;
        }
        function clearRelacionados(){
            optionLabel.each(function(){
                var label = $(this);
                var input = label.children("input");
                if(label.css("display") != "none"){
                    input.prop("checked", false);
                }
            });
        }

        /*MAIN SEARCH FUNCTION*/
        function searchOptions(){
            modalSearchingOptions = true;
            var searchString = searchBar.val();
            var searchLoadingBackground = optionsList.children(".loading-background");
            
            onlyActives = checkActiveOptions.prop("checked");

            function resetBackgroundLoading(){
                if(!resetingBackground){
                    setInterval(function(){
                        resetingBackground = true;
                        if(!modalSearchingOptions){
                            searchLoadingBackground.css({
                                visibility: "hidden",
                                opacity: "0"
                            });
                        }
                    }, 500);
                }
            }
            resetBackgroundLoading();
            if(searchString.length > 0 && lastSearchString != searchString){
                lastSearchString = searchString;
                $.ajax({
                    type: "POST",
                    url: urlSearch,
                    data: {search: searchString, custom_parameter: searchParameter},
                    error: function(){
                        searchLoadingBackground.css({
                            visibility: "hidden",
                            opacity: "0"
                        });
                        notificacaoPadrao("Ocorreu um erro ao buscar.");
                    },
                    success: function(resposta){
                        console.log("resposta de " + urlSearch + ": " + resposta);
                        setTimeout(function(){
                            modalSearchingOptions = false;
                        }, 500);
                        var selectedOptions = [];
                        var ctrlVQtdView = 0;
                        function listOptions(){
                            optionLabel.each(function(){
                                var label = $(this);
                                var input = label.children("input");
                                var inputIdProduto = input.val();
                                var inputChecked = input.prop("checked");
                                var arraySearch = selectedOptions.some(function(id){
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
                            setResultMessage("Resultados encontrados: "+ctrlVQtdView);
                            if(ctrlVQtdView == 0){
                                listLastSearch();
                            }
                        }
                        if(resposta != "false" && isJson(resposta) == true){
                            var jsonData = JSON.parse(resposta);
                            var ctrlQtd = 0;
                            jsonData.forEach(function(id_produto){
                                selectedOptions[ctrlQtd] = id_produto;
                                ctrlQtd++;
                            });
                            listOptions();
                        }else{
                            if(onlyActives){
                                listOptions();
                            }else{
                                setResultMessage("Exibindo resultados mais aproximados:");
                                listLastSearch();
                            }
                        }
                    },
                    beforeSend: function(){
                        searchLoadingBackground.css({
                            visibility: "visible",
                            opacity: "1"
                        });
                    }
                });
            }else if(searchString.length == 0){
                resetAllOptions();
            }
        }
        /*END MAIN SEARCH FUNCTION*/


        /*TRIGGERS*/
        btnOpenModal.off().on("click", function(){
            openModalMultiOptions();
        });

        btnCloseModal.off().on("click", function(){
            closeModalMultiOptions();
        }); 
        
        /*objBgInteratividade.off().on("click", function(){
            closeModalMultiOptions();
        });*/
    });


    // MULTI SELECT DE CATEGORIAS
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
            labelAberto = value == true ? false : true
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

    // MULTI TABLES
    var displayMultiTables = $(".multi-tables");

    if(typeof displayMultiTables != "undefined"){
        displayMultiTables.each(function(){
            var mainDiv = $(this);
            var topButtons = mainDiv.children(".top-buttons");
            var buttons = topButtons.children(".trigger-button");
            var displayPaineis = mainDiv.children(".display-paineis");
            var paineis = displayPaineis.children(".painel");

            buttons.each(function(){
                var button = $(this);
                var target = button.attr("mt-target");
                button.off().on("click", function(){
                    buttons.each(function(){
                        $(this).removeClass("trigger-button-selected");
                    });
                    paineis.each(function(){
                        $(this).removeClass("selected-painel"); 
                    });
                    button.addClass("trigger-button-selected");
                    $("#"+target).addClass("selected-painel");
                });
            });
        });
    }
});