<style>
    .section-login{
        position: fixed;
        width: 100%;
        height: 100vh;
        top: 0px;
        right: -100%;
        z-index: 100;
        background-color: #fff;
        text-align: center;
        font-size: 16px;
        visibility: hidden;
        transition: .4s all ease;
        opacity: .6;
        overflow: hidden;
        overflow-y: scroll;
    }
    .section-login .display-login{
        width: 40%;
        margin: 0 auto;
    }
    .section-login .titulo{
        margin: 0px;
        padding: 20px 0px 20px 0px;
        font-size: 32px;
        border-bottom: 1px solid #6abd45;
        display: block;
    }
    .section-login .descricao-cadastre{
        font-weight: normal;
    }
    .section-login .display-confirmacao{
        font-size: 24px;
        color: #6abd45;
        margin: 100px 0px 100px 0px;
        transition: .3s;
        opacity: 0;
        display: none;
    }
    .section-login .display-formularios{
        position: relative;
        width: 80%;
        height: 55vh;
        margin: 0 auto;
        margin-top: 40px;
        -webkit-box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);
        -moz-box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);
        box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);
        transition: .2s;
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }
    .section-login .display-formularios .background-loading{
        position: absolute;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, .5);
        top: 0px;
        margin: 0px;
        opacity: 0;
        transition: .3s;
        visibility: hidden;
        z-index: 80;
        text-align: center;
        display: flex;
    }
    .section-login .display-formularios .background-loading .icone-loading{
        position: absolute;
        font-size: 46px;
        color: #6abd45;
        top: 20vh;
        align-self: center;
        width: 100%;
    }
    /*FORM STYLES*/
    .section-login .display-formularios .formulario-login{
        position: relative;
        width: 95%;
        height: 54vh;
        padding: 5vh 2.5% 1vh 2.5%;
        text-align: left;
        overflow-y: auto;
        overflow-x: hidden;
        display: flex;
        flex-flow: row wrap;
    }
    .formulario-login::-webkit-scrollbar-button:hover{
        background-color: #AAA;
    }
    .formulario-login::-webkit-scrollbar-thumb{
        background-color: #ccc;
    }
    .formulario-login::-webkit-scrollbar-thumb:hover{
        background-color: #999;
    }
    .formulario-login::-webkit-scrollbar-track{
        background-color: #efefef;
    }
    .formulario-login::-webkit-scrollbar-track:hover{
        background-color: #efefef;
    }
    .formulario-login::-webkit-scrollbar{
        width: 3px;
        height: 3px;
    }
    .section-login .display-formularios .formulario-login div{
        position: relative;
        height: 65px;
        float: left;
    }
    .section-login .display-formularios .formulario-login .label-submit{
        height: 30px;   
    }
    .section-login .display-formularios .formulario-login div .msg-input{
        position: absolute;
        left: 5px;
        top: 35px;
        visibility: hidden;
        opacity: 0;
        transition: .2s;
    }
    .section-login .display-formularios .formulario-login .input-title{
        font-size: 14px;
        margin: 0px;
        text-align: left;
        color: #666;
    }
    .section-login .display-formularios .formulario-login .input-nochange{
        background-color: #f3f3f3;
        pointer-events: none;
    }
    .section-login .display-formularios .formulario-login input, .section-login .display-formularios .formulario-login select{
        width: calc(100% - 10px);
        height: 30px;
        margin-top: 5px;
        margin-bottom: 1px;
        padding: 0px 5px 0px 5px;
        border: 1px solid #ccc;
        outline: none;
        transition: .3s;
    }
    .section-login .display-formularios .formulario-login input:focus{
        border-bottom: 2px solid #ccc; 
        margin-bottom: 0px;
    }
    .section-login .display-formularios .formulario-login .wrong-input{
        border-bottom: 2px solid red;   
        margin-bottom: 0px;
    }
    /*END DISPLAY PASSOS*/
    .section-login .display-formularios h6{
        font-size: 12px;   
    }
    .section-login .display-formularios .link-padrao{
        color: #5583fe;
        cursor: pointer;
        border: none;   
    }
    .section-login .display-formularios .link-padrao:hover{
        border: none;
        text-decoration: underline;
    }
    .section-login .formulario-login .botao-submit{
        position: relative;
        background-color: #6abd45;
        color: #fff;
        border: none;
        width: 95px;
        height: 30px;
        line-height: 32px;
        text-align: left;
        padding: 0px 15px 0px 10px;
        font-weight: bold;
        display: flex;
        align-items: center;
        transition: .2s;
        cursor: pointer;
        outline: none;
        font-weight: normal;
        font-size: 12px;
    }
    .section-login .formulario-login .botao-submit .icone{
        font-size: 14px;
        position: absolute;
        top: 0px;
        height: 30px;
        right: 10px;
        transition: .2s;
    }
    .section-login .formulario-login .botao-submit:hover{
        background-color: #518f35;
    }
    .section-login .formulario-login .botao-submit:hover .icone{
        right: 5px;
    }
    /*END FORM SYLES*/
    
    /*SECTION BOTTOM*/
    .section-login .bottom{
        text-align: center;
    }
    .section-login .bottom .botao-voltar{
        background-color: transparent;
        color: #ccc;
        font-size: 36px;
        margin-top: 40px;
        border: none;
        cursor: pointer;
        opacity: .7;
        transition: .2s;
        outline: none;
        transform: rotate(-90deg);
    }
    .section-login .bottom .botao-voltar:hover{
        transform: rotate(0deg);
        opacity: 1;
    }
    /*END SECTION BOTTOM*/
    @media screen and (max-width: 860px){
        .section-login .display-login{
            width: 60%;   
        }
        @media screen and (max-width: 560px){
            .section-login .display-login{
                width: 95%;
            }      
            .section-login .display-login .titulo{
                font-size: 24px;
            }
            .section-login .display-formularios{
                height: 75vh;
                width: 90%;
            }
            .section-login .display-formularios .formulario-login{
                height: 74vh;   
            }
        }
    }
</style>
<div class="section-login">
    <div class="display-login">
        <h3 class="titulo">ENTRE COM SUA CONTA</h3>
        <article class="descricao-cadastre">
            <p>
                É um fato conhecido de todos que um leitor se distrairá com o conteúdo de texto legível de uma página quando estiver examinando sua diagramação.
            </p>
        </article>
        <div class="display-confirmacao"></div>
        <div class="display-formularios">
                <div class="background-loading">
                    <i class="fas fa-spinner fa-spin icone-loading"></i>
                </div>
            <form class="formulario-login" name="formulario_login" id="formularioLogin">
                <div class="full">
                    <h3 class="input-title">E-mail</h3>
                    <input type="text" name="email" id="emailLogin" autocomplete="off">
                    <h6 class="msg-input"></h6>
                </div>
                <div class="full">
                    <h3 class="input-title">Senha</h3>
                    <input type="password" name="senha" id="senhaLogin">
                    <h6 class="msg-input"></h6>
                </div>
                <div class="full submit">
                    <button class="botao-submit" type="submit" id="botaoSubmit">ENTRAR <i class="fas fa-unlock-alt icone"></i></button>
                </div>
                <div class="full">
                    <a href="esqueci-minha-senha.php" class="link-padrao" target="_blank">Esqueci minha senha</a><br>
                    <h6>Não tem conta? Então <a class='link-padrao' id="botaoAlternaCadastre">cadastre-se</a></h6>
                </div>
            </form>
        </div>
        <div class="bottom">
            <button class="botao-voltar" title="Voltar para a página"><i class="fas fa-chevron-circle-left"></i></button>
        </div>
    </div>
</div>
<script>
    /*INITIALIZE*/
    var sectionLogin = $(".section-login");
    var loginAberto = false;
    
    function toggleLogin(){
        if(!loginAberto){
            loginAberto = true;
            sectionLogin.css({
                visibility: "visible",
                right: "0px",
                opacity: "1",
                trasition: "1s"
            });
            $("body").css("overflow", "hidden");
        }else{
            loginAberto = false;
            sectionLogin.css({
                visibility: "hidden",
                right: "-100%",
                opacity: ".6"
            });
            $("body").css("overflow", "auto");
        }
    }
    /*END INITIALIZE*/
    
    $(document).ready(function(){
        /*DEFAULT VARS*/
        var formularioLogin = $("#formularioLogin");
        var botaoEntrar = $("#botaoEntrar");
        var botaoVoltar = $(".section-login .botao-voltar");
        var botaoAlternaCadastre = $("#botaoAlternaCadastre");
        var botaoSubmit = $("#botaoSubmit");
        var backgroundLoading = $(".section-login .background-loading");
        var logando = false;
        /*END DEFAULT VARS*/
        
        /*DEFAULT FUNCTIONS*/
        
        var loadingAberto = false;
        function toggleLoading(){
            if(!loadingAberto){
                loadingAberto = true;
                backgroundLoading.css({
                    visibility: "visible",
                    opacity: "1"
                });
            }else{
                loadingAberto = false;
                backgroundLoading.css({
                    visibility: "hidden",
                    opacity: "0"
                });
            }
        }
        /*END DEFAULT FUNCTIONS*/
        
        function validarLogin(){
            var objEmail = $("#emailLogin");
            var objSenha = $("#senhaLogin");
            var erroEmail = "email_incorreto";
            var erroSenha = "senha_incorreta";
            var erroConfirmacaoPendente = "confirmar_email";
            var erroSenhaEmail = "senha_email_incorretos";
            
            function setInputMessages(fields){
                fields.forEach(function(field){
                    switch(field){
                        /*PASSO 1*/
                        case objEmail:
                            var msg = "O campo e-mail deve ser preenchido corretamente";
                            objEmail.addClass("wrong-input");
                            objEmail.next(".msg-input").html(msg).css({
                                visibility: "visible",
                                opacity: "1"
                            });
                            break;
                        case objSenha:
                            var msg = "O campo senha deve conter no mínimo 6 caracteres";
                            objSenha.addClass("wrong-input");
                            objSenha.next(".msg-input").html(msg).css({
                                visibility: "visible",
                                opacity: "1"
                            });
                            break;
                        case erroEmail:
                            var msg = "Não foi encontrado um cadastro com seu e-mail";
                            objEmail.addClass("wrong-input");
                            objEmail.next(".msg-input").html(msg).css({
                                visibility: "visible",
                                opacity: "1"
                            });
                            break;
                        case erroSenha:
                            var msg = "A senha está incorreta";
                            objSenha.addClass("wrong-input");
                            objSenha.next(".msg-input").html(msg).css({
                                visibility: "visible",
                                opacity: "1"
                            });
                            break;
                        case erroConfirmacaoPendente:
                            var msg = "Seu e-mail ainda não foi validado. Favor verificar em sua caixa de e-mails o link de validação.";
                            objEmail.addClass("wrong-input");
                            objEmail.next(".msg-input").html(msg).css({
                                visibility: "visible",
                                opacity: "1"
                            });
                            break;
                        case erroSenhaEmail:
                            var msg = "E-mail ou senha incorretos";
                            objSenha.addClass("wrong-input");
                            objSenha.next(".msg-input").html(msg).css({
                                visibility: "visible",
                                opacity: "1"
                            });
                            objEmail.addClass("wrong-input");
                            objEmail.next(".msg-input").html(msg).css({
                                visibility: "visible",
                                opacity: "1"
                            });
                            break;
                    }
                });
            }
            
            function finishValidation(errors, errorFields){
                logando = false;
                var closeLoading = true;
                
                if(errors > 0){
                    setInputMessages(errorFields);
                }else{
                    window.location.reload();
                }
                
                if(closeLoading){
                    toggleLoading();
                }
            }
            
            function prepareErrors(ctrlInvalid, allFields, invalidFields){
                
                allFields.forEach(function(field){
                    if(field.hasClass("wrong-input")){
                        field.removeClass("wrong-input");
                        field.next(".msg-input").html("").css({
                            visibility: "hidden",
                            opacity: "0"
                        });
                    }
                });
                
                if(ctrlInvalid == 0){
                    notificacaoPadrao("Fazendo login...", "success", 5000);
                }

                setTimeout(function(){
                    finishValidation(ctrlInvalid, invalidFields);
                }, 300);
                
            }
            
            function validaDados(){
                var email = objEmail.val();
                var senha = objSenha.val();
                var allFields = [objEmail, objSenha];
                var invalidFields = [];
                var ctrlInvalid = 0;
                
                toggleLoading();
                
                function standard(){
                    if(validarEmail(email) == false){
                        invalidFields[ctrlInvalid] = objEmail;
                        ctrlInvalid++;
                    }

                    if(senha.length < 6){
                        invalidFields[ctrlInvalid] = objSenha;
                        ctrlInvalid++;
                    }

                    // Trigger das mensagens de erro
                    prepareErrors(ctrlInvalid, allFields, invalidFields);
                }
                
                function ajaxValidation(){
                    var ajaxFields = [objEmail, objSenha];
                    var incorretos = [];
                    var ctrlValidations = 0;
                    var ctrlIncorretos = 0;
                    
                    function validaResult(){
                        if(incorretos.length > 0){
                            incorretos.forEach(function(field){
                                var error = erroEmail;
                                switch(field){
                                    case erroEmail:
                                        error = erroEmail;
                                        break;
                                    case erroSenha:
                                        error = erroSenha;
                                        break;
                                    case erroConfirmacaoPendente:
                                        error = erroConfirmacaoPendente;
                                }
                                invalidFields[ctrlInvalid] = error;
                                ctrlInvalid++;
                            });
                        }
                        standard();
                    }
                    
                    $.ajax({
                        type: "POST",
                        url: "@valida-login.php",
                        data: {email: email, senha: senha, iniciar_login: true},
                        error: function(){
                            notificacaoPadrao("Desculpe ocorreu um erro ao validar os dados. Recarregue a página e tente novamente.");
                            ctrlValidations++;
                        },
                        success: function(resposta){
                            console.log(resposta)
                            if(resposta == erroSenha){
                                incorretos[ctrlIncorretos] = erroSenha;
                                ctrlIncorretos++;
                            }else if(resposta == erroEmail){
                                incorretos[ctrlIncorretos] = erroEmail;
                                ctrlIncorretos++;
                            }else if(resposta == erroConfirmacaoPendente){
                                incorretos[ctrlIncorretos] = erroConfirmacaoPendente;
                                ctrlIncorretos++;
                            }else if(resposta == erroSenhaEmail){
                                incorretos[ctrlIncorretos] = erroSenhaEmail;
                                ctrlIncorretos++;
                            }
                            ctrlValidations++;
                            validaResult();
                        }
                    });
                }
                
                // Inicia com a validação do ajax
                ajaxValidation(); // Vai chamar o callback da segunda parte da validação
            }
            
            validaDados();
        }
        
        /*TRIGGER VALIDAR*/
        formularioLogin.off().on("submit", function(){
            event.preventDefault();
            if(!logando){
                logando = true;
                validarLogin();
            }
        });
        /*END TRIGGER VALIDAR*/
        
        /*DEFAULT TRIGGERS*/
        botaoEntrar.off().on("click", function(){
            toggleLogin();
        });
        
        botaoVoltar.off().on("click", function(){
            toggleLogin();
        });
        
        botaoAlternaCadastre.off().on("click", function(){
            if(loginAberto){
                toggleLogin(); 
            }
            toggleCadastreConta();
        });
        /*END DEFAULT TRIGGERS*/
    });
</script>