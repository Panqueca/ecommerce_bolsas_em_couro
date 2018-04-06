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

/*MASCARA TELEFONE*/
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):a("object"==typeof exports?require("jquery"):jQuery)}(function(a){var b,c=navigator.userAgent,d=/iphone/i.test(c),e=/chrome/i.test(c),f=/android/i.test(c);a.mask={definitions:{9:"[0-9]",a:"[A-Za-z]","*":"[A-Za-z0-9]"},autoclear:!0,dataName:"rawMaskFn",placeholder:"_"},a.fn.extend({caret:function(a,b){var c;if(0!==this.length&&!this.is(":hidden"))return"number"==typeof a?(b="number"==typeof b?b:a,this.each(function(){this.setSelectionRange?this.setSelectionRange(a,b):this.createTextRange&&(c=this.createTextRange(),c.collapse(!0),c.moveEnd("character",b),c.moveStart("character",a),c.select())})):(this[0].setSelectionRange?(a=this[0].selectionStart,b=this[0].selectionEnd):document.selection&&document.selection.createRange&&(c=document.selection.createRange(),a=0-c.duplicate().moveStart("character",-1e5),b=a+c.text.length),{begin:a,end:b})},unmask:function(){return this.trigger("unmask")},mask:function(c,g){var h,i,j,k,l,m,n,o;if(!c&&this.length>0){h=a(this[0]);var p=h.data(a.mask.dataName);return p?p():void 0}return g=a.extend({autoclear:a.mask.autoclear,placeholder:a.mask.placeholder,completed:null},g),i=a.mask.definitions,j=[],k=n=c.length,l=null,a.each(c.split(""),function(a,b){"?"==b?(n--,k=a):i[b]?(j.push(new RegExp(i[b])),null===l&&(l=j.length-1),k>a&&(m=j.length-1)):j.push(null)}),this.trigger("unmask").each(function(){function h(){if(g.completed){for(var a=l;m>=a;a++)if(j[a]&&C[a]===p(a))return;g.completed.call(B)}}function p(a){return g.placeholder.charAt(a<g.placeholder.length?a:0)}function q(a){for(;++a<n&&!j[a];);return a}function r(a){for(;--a>=0&&!j[a];);return a}function s(a,b){var c,d;if(!(0>a)){for(c=a,d=q(b);n>c;c++)if(j[c]){if(!(n>d&&j[c].test(C[d])))break;C[c]=C[d],C[d]=p(d),d=q(d)}z(),B.caret(Math.max(l,a))}}function t(a){var b,c,d,e;for(b=a,c=p(a);n>b;b++)if(j[b]){if(d=q(b),e=C[b],C[b]=c,!(n>d&&j[d].test(e)))break;c=e}}function u(){var a=B.val(),b=B.caret();if(o&&o.length&&o.length>a.length){for(A(!0);b.begin>0&&!j[b.begin-1];)b.begin--;if(0===b.begin)for(;b.begin<l&&!j[b.begin];)b.begin++;B.caret(b.begin,b.begin)}else{for(A(!0);b.begin<n&&!j[b.begin];)b.begin++;B.caret(b.begin,b.begin)}h()}function v(){A(),B.val()!=E&&B.change()}function w(a){if(!B.prop("readonly")){var b,c,e,f=a.which||a.keyCode;o=B.val(),8===f||46===f||d&&127===f?(b=B.caret(),c=b.begin,e=b.end,e-c===0&&(c=46!==f?r(c):e=q(c-1),e=46===f?q(e):e),y(c,e),s(c,e-1),a.preventDefault()):13===f?v.call(this,a):27===f&&(B.val(E),B.caret(0,A()),a.preventDefault())}}function x(b){if(!B.prop("readonly")){var c,d,e,g=b.which||b.keyCode,i=B.caret();if(!(b.ctrlKey||b.altKey||b.metaKey||32>g)&&g&&13!==g){if(i.end-i.begin!==0&&(y(i.begin,i.end),s(i.begin,i.end-1)),c=q(i.begin-1),n>c&&(d=String.fromCharCode(g),j[c].test(d))){if(t(c),C[c]=d,z(),e=q(c),f){var k=function(){a.proxy(a.fn.caret,B,e)()};setTimeout(k,0)}else B.caret(e);i.begin<=m&&h()}b.preventDefault()}}}function y(a,b){var c;for(c=a;b>c&&n>c;c++)j[c]&&(C[c]=p(c))}function z(){B.val(C.join(""))}function A(a){var b,c,d,e=B.val(),f=-1;for(b=0,d=0;n>b;b++)if(j[b]){for(C[b]=p(b);d++<e.length;)if(c=e.charAt(d-1),j[b].test(c)){C[b]=c,f=b;break}if(d>e.length){y(b+1,n);break}}else C[b]===e.charAt(d)&&d++,k>b&&(f=b);return a?z():k>f+1?g.autoclear||C.join("")===D?(B.val()&&B.val(""),y(0,n)):z():(z(),B.val(B.val().substring(0,f+1))),k?b:l}var B=a(this),C=a.map(c.split(""),function(a,b){return"?"!=a?i[a]?p(b):a:void 0}),D=C.join(""),E=B.val();B.data(a.mask.dataName,function(){return a.map(C,function(a,b){return j[b]&&a!=p(b)?a:null}).join("")}),B.one("unmask",function(){B.off(".mask").removeData(a.mask.dataName)}).on("focus.mask",function(){if(!B.prop("readonly")){clearTimeout(b);var a;E=B.val(),a=A(),b=setTimeout(function(){B.get(0)===document.activeElement&&(z(),a==c.replace("?","").length?B.caret(0,a):B.caret(a))},10)}}).on("blur.mask",v).on("keydown.mask",w).on("keypress.mask",x).on("input.mask paste.mask",function(){B.prop("readonly")||setTimeout(function(){var a=A(!0);B.caret(a),h()},0)}),e&&f&&B.off("input.mask").on("input.mask",u),A()})}})});

function phone_mask(objInput){
    $(document).ready(function(){
        objInput = typeof objInput == "object" ? objInput : $(objInput);
        objInput.mask("(99) 9999-9999?9").focusout(function (event){
            var target, phone, element;
            target = (event.currentTarget) ? event.currentTarget : event.srcElement;
            phone = target.value.replace(/\D/g, '');
            element = $(target);
            element.unmask();
            if(phone.length > 10){
                element.mask("(99) 99999-999?9");
            }else{
                element.mask("(99) 9999-9999?9");
            }
        });
    });
}

function input_mask(objInput, maskPattern){
    $(document).ready(function(){
        objInput = typeof objInput == "object" ? objInput : $(objInput);
        objInput.mask(maskPattern).focusout(function (event){
            var target, phone, element;
            target = (event.currentTarget) ? event.currentTarget : event.srcElement;
            phone = target.value.replace(/\D/g, '');
            element = $(target);
            element.unmask();
            element.mask(maskPattern);
        });
    });
}

function isJson(str){
    try{
        JSON.parse(str);
    }catch(e){
        return false;
    }
    return true;
}