$(document).ready(function(){
    
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