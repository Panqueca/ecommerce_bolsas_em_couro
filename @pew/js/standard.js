var notificacaoAtiva = false;
var timingNotificacao = 0;
function notificacaoPadrao(texto, notificationType, delay){
    notificacaoAtiva = true;
    var msgNotificacao = $(".msg-padrao");
    var delayAnimation = 300;
    var delayStart = 150;
    var delayFinish = 2500;
    if(typeof delay != "undefined" && delay > 0){
        delayFinish = delay;
    }
    timingNotificacao = delayFinish;
    msgNotificacao.html(texto);
    var cor = notificationType == "success" ? "limegreen" : "#ea5959";
    function abrir(){
        msgNotificacao.css({display: "block", backgroundColor: cor});
        setTimeout(function(){
            msgNotificacao.css({
                padding: "12px",
                fontSize: "20px",
                opacity: "1",
                left: "5%",
            });
            setTimeout(function(){
                msgNotificacao.css({
                    padding: "10px",
                    fontSize: "18px"
                })
            }, delayAnimation);
        }, delayStart);
    }
    abrir();
}
function fecharNotificacao(){
    var delayAnimation = 300;
    var msgNotificacao = $(".msg-padrao");
    setTimeout(function(){
        notificacaoAtiva = false;
        msgNotificacao.css({
            padding: "8px",
            fontSize: "14px",
            opacity: "0",
            left: "0px",
            transition: delayAnimation
        });
        setTimeout(function(){
            msgNotificacao.css("display", "none");
        }, delayAnimation);
    }, 10);
}
function timerNotificacao(){
    setInterval(function(){
        if(timingNotificacao > 0){
            timingNotificacao -= 100;
            timingNotificacao = timingNotificacao > 0 ? timingNotificacao : 0;
        }else{
            if(notificacaoAtiva == true){
                fecharNotificacao();
            }
        }
    }, 100);
}
timerNotificacao();

function mensagemConfirma(texto, fconfirmar, fcancelar){
    confirmando = true;
    var msgConfirma = $(".msg-confirma");
    var textoConfirma = $(".msg-confirma .texto-confirma");
    var btnConfirmar = $(".msg-confirma #btnConfirmar");
    var btnCancelar = $(".msg-confirma #btnCancelar");
    var bg = $(".background-interatividade");
    textoConfirma.html(texto);
    function abrir(){
        msgConfirma.css("display", "block");
        bg.css("display", "block");
        setTimeout(function(){
            bg.css("opacity", "0.3");
            msgConfirma.css({
                paddingTop: "10px",
                paddingBottom: "10px",
                opacity: "1"
            });
        }, 10);
    }
    abrir();
    function fechar(){
        msgConfirma.css({
            padding: "0px",
            opacity: "0"
        });
        bg.css("opacity", "0");
        setTimeout(function(){
            msgConfirma.css("display", "none");
            bg.css("display", "none");
        })
    }
    btnConfirmar.off().on("click", function(){
        if(typeof fconfirmar == "function"){
            fconfirmar();
        }
        fechar();
    });
    btnCancelar.off().on("click", function(){
        if(typeof fcancelar == "function"){
            fcancelar();
        }
        fechar();
    });

}
function mensagemAlerta(mensagem, focus, color, redirect){
    if(mensagem != ""){
        var msgAlerta = $(".msg-alerta");
        var msgTexto = $(".msg-alerta .texto-alerta");
        var botao = $(".msg-alerta #btnOk");
        var bg = $(".background-interatividade");
        var delayAnimation = 300;
        function abrir(){
            msgTexto.html(mensagem);
            msgAlerta.css("display", "block");
            bg.css("display", "block");
            if(color != "" && typeof color != "undefined"){
                botao.css({
                    backgroundColor: color,
                });
            }else{
                color = "#ea5959";
                botao.css({
                    backgroundColor: color,
                });
            }
            setTimeout(function(){
                bg.css("opacity", "0.3");
                msgAlerta.css({
                    opacity: "1",
                    paddingTop: "15px",
                    paddingBottom: "15px",
                });
                setTimeout(function(){
                    msgAlerta.css({
                        paddingTop: "10px",
                        paddingBottom: "10px",
                    });
                }, delayAnimation);
            }, 10);
        }
        abrir();

        function fechar(){
            msgAlerta.css({
                opacity: "0",
                padding: "0px",
                paddingTop: "0px",
                paddingBottom: "0px",
            });
            bg.css("opacity", "0");
            setTimeout(function(){
                bg.css("display", "none");
                msgAlerta.css("display", "none");
            }, delayAnimation);
        }
        botao.mouseover(function(){
            botao.css("background-color", "#111");
        });
        botao.mouseout(function(){
            botao.css("background-color", color);
        });

        function finishFunctions(){
            if(focus != "" && typeof focus == "object"){
                focus.focus();
            }else if(typeof focus != "undefined" && focus != false && focus != ""){
                $(focus).focus();
            }
            if(typeof redirect != "undefined" && redirect != false && redirect != ""){
                window.location.href = redirect;
            }
        }

        botao.click(function(){
            fechar();
            finishFunctions();
        });
        bg.click(function(){
            fechar();
            finishFunctions();
        });
    }
}

function validarEmail(email){
    usuario = email.substring(0, email.indexOf("@"));
    dominio = email.substring(email.indexOf("@")+ 1, email.length);
    if((usuario.length >=1) && (dominio.length >=3) && (usuario.search("@")==-1) && (dominio.search("@")==-1) && (usuario.search(" ")==-1) && (dominio.search(" ")==-1) && (dominio.search(".")!=-1) && (dominio.indexOf(".") >=1) && (dominio.lastIndexOf(".") < dominio.length - 1)){
        return true;
    }
    else{
        return false;
    }
}

function number_format(number, decimals, dec_point, thousands_sep) {
    // Strip all characters but numerical ones.
    number = (number + '').replace(/[^0-9+\-Ee.]/g, '');
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
        dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
        s = '',
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
        };
    // Fix for IE parseFloat(0.55).toFixed(0) = 0;
    s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || '').length < prec) {
        s[1] = s[1] || '';
        s[1] += new Array(prec - s[1].length + 1).join('0');
    }
    return s.join(dec);
}