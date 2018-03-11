$(document).ready(function(){
    $(".btn-status-banner").off().on("click", function(){
        var botao = $(this);
        var idBanner = botao.attr("data-banner-id");
        var acao = botao.attr("data-acao");
        function statusBanner(){
            $.ajax({
                type: "POST",
                url: "pew-status-banner.php",
                data: {id_banner: idBanner, acao: acao},
                beforeSend: function(){
                    notificacaoPadrao("Aguarde...", "success");
                },
                error: function(){
                    setTimeout(function(){
                        notificacaoPadrao("Não foi possível "+acao+" o banner", "error", 5000);
                    }, 1000);
                },
                success: function(respota){
                    setTimeout(function(){
                        if(respota == "true"){
                            var resultado = acao == "ativar" ? "ativado" : "desativado";
                            notificacaoPadrao("O Banner foi "+resultado+"!", "success", 5000);
                            if(resultado == "ativado"){
                                botao.addClass("btn-desativar").removeClass("btn-ativar").text("Desativar");
                                botao.attr("data-acao", "desativar");
                            }else{
                                botao.addClass("btn-ativar").removeClass("btn-desativar").text("Ativar");
                                botao.attr("data-acao", "ativar");
                            }
                        }else{
                            notificacaoPadrao("Não foi possível desativar o banner", "error", 5000);
                        }
                    }, 500);
                }
            });
        }
        mensagemConfirma("Tem certeza que deseja "+acao+" este banner?", statusBanner);
    });
});
