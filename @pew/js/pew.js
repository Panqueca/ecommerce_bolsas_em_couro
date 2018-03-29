$(document).ready(function(){
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
});