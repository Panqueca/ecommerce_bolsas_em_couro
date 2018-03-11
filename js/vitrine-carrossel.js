$(document).ready(function(){
    var vitrineCarrossel = $(".vitrine-carrossel");
    var displayProdutos = vitrineCarrossel.children(".display-produtos");
    var controllerCarrossel = vitrineCarrossel.children(".controller-carrossel");
    var leftArrow = controllerCarrossel.children(".left-arrow");
    var rightArrow = controllerCarrossel.children(".right-arrow");
    displayProdutos.slick({
        infinite: false,
        slidesToShow: 5,
        slidesToScroll: 1,
        prevArrow: rightArrow,
        nextArrow: leftArrow,
        arrows: true,
        variableWidth: true,
        responsive: [{
            breakpoint: 1000,
            settings: {
                  slidesToShow: 5,
            },
            breakpoint: 760,
            settings: {
                  slidesToShow: 3,
            },
            breakpoint: 480,
            settings: {
                  slidesToShow: 1,
            },
        }]
    });
});
