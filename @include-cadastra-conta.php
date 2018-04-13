<style>
    .section-cadastra{
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
    .section-cadastra .display-cadastra{
        width: 80%;
        margin: 0 auto;
    }
    .section-cadastra .titulo{
        margin: 0px;
        padding: 20px 0px 20px 0px;
        font-size: 32px;
        border-bottom: 1px solid #6abd45;
        display: block;
    }
    .section-cadastra .descricao-cadastre{
        font-weight: normal;
    }
    .section-cadastra .descricao-cadastre .link-padrao{
        color: #5583fe;
        border: none;
        cursor: pointer;
    }
    .section-cadastra .descricao-cadastre .link-padrao:hover{
        text-decoration: underline;
    }
    .section-cadastra .display-confirmacao{
        font-size: 24px;
        color: #6abd45;
        margin: 100px 0px 100px 0px;
        transition: .3s;
        opacity: 0;
        display: none;
    }
    .section-cadastra .display-formularios{
        position: relative;
        width: 80%;
        height: 55vh;
        margin: 0 auto;
        margin-top: 40px;
        -webkit-box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);
        -moz-box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);
        box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);
        transition: .2s;
    }
    .section-cadastra .display-formularios .display-buttons{
        position: sticky;
        top: 0px;
        left: 0px;
        width: 100%;
        display: flex;
        z-index: 50;
    }
    .section-cadastra .display-formularios .top-buttons{
        height: 5vh;
        background-color: #fff;
        border: none;
        cursor: pointer;
        outline: none;
        width: 50%;
        color: #999;
        border-bottom: 2px solid #f6f6f6;
    }
    .section-cadastra .display-formularios .top-buttons:hover{
        background-color: #f1f1f1;
    }
    .section-cadastra .display-formularios .selected-button{   
        border-bottom: 2px solid green;
        color: green;
    }
    /*FORM STYLES*/
    .section-cadastra .display-formularios .formulario-cadastro{
        position: relative;
        width: 95%;
        height: 50vh;
        padding: 0px 2.5% 0px 2.5%;
        text-align: left;
        overflow-y: auto;
        overflow-x: hidden;
        clear: both;
    }
    .formulario-cadastro::-webkit-scrollbar-button:hover{
        background-color: #AAA;
    }
    .formulario-cadastro::-webkit-scrollbar-thumb{
        background-color: #ccc;
    }
    .formulario-cadastro::-webkit-scrollbar-thumb:hover{
        background-color: #999;
    }
    .formulario-cadastro::-webkit-scrollbar-track{
        background-color: #efefef;
    }
    .formulario-cadastro::-webkit-scrollbar-track:hover{
        background-color: #efefef;
    }
    .formulario-cadastro::-webkit-scrollbar{
        width: 3px;
        height: 3px;
    }
    .section-cadastra .display-formularios .formulario-cadastro .background-loading{
        position: sticky;
        width: 105%;
        height: 100%;
        background-color: rgba(255, 255, 255, .5);
        top: 0px;
        margin: 0px;
        margin-left: -2.5%;
        opacity: 0;
        transition: .3s;
        visibility: hidden;
        z-index: 80;
        text-align: center;
        display: flex;
        justify-content: center;
        text-align: center;
    }
    .section-cadastra .display-formularios .formulario-cadastro .background-loading .icone-loading{
        position: absolute;
        font-size: 46px;
        color: #6abd45;
        top: 20vh;
        align-self: center;
    }
    .section-cadastra .display-formularios .formulario-cadastro div{
        position: relative;
        height: 85px;
        float: left;
    }
    .section-cadastra .display-formularios .formulario-cadastro div .msg-input{
        position: absolute;
        left: 5px;
        top: 35px;
        visibility: hidden;
        opacity: 0;
        transition: .2s;
    }
    .section-cadastra .display-formularios .formulario-cadastro .input-title{
        font-size: 14px;
        margin: 0px;
        text-align: left;
        color: #666;
    }
    .section-cadastra .display-formularios .formulario-cadastro .input-nochange{
        background-color: #f3f3f3;
        pointer-events: none;
    }
    .section-cadastra .display-formularios .formulario-cadastro input, .section-cadastra .display-formularios .formulario-cadastro select{
        width: calc(100% - 10px);
        height: 30px;
        margin-top: 5px;
        margin-bottom: 1px;
        padding: 0px 5px 0px 5px;
        border: 1px solid #ccc;
        outline: none;
        transition: .3s;
    }
    .section-cadastra .display-formularios .formulario-cadastro input:focus{
        border-bottom: 2px solid #ccc; 
        margin-bottom: 0px;
    }
    .section-cadastra .display-formularios .formulario-cadastro .checkbox-label{
        position: relative;
        display: block;
        white-space: nowrap;
        font-size: 14px;
        width: 240px;
        height: 20px;
        text-align: left;
        top: 15px;
    }
    .section-cadastra .display-formularios .formulario-cadastro .checkbox-label a{
        color: #5583fe;
        text-decoration: none;
    }
    .section-cadastra .display-formularios .formulario-cadastro .checkbox-label a:hover{
        text-decoration: underline;
    }
    .section-cadastra .display-formularios .formulario-cadastro .checkbox-label .checkbox{
        position: relative;
        top: -4px;
        width: 15px;
        height: 15px;
        float: left;
    }
    .section-cadastra .display-formularios .formulario-cadastro .checkbox-label .msg-input-checkbox{
        position: absolute;
        top: -18px;
        left: 100%;
        visibility: hidden;
        opacity: 0;
        transition: .2s;
    }
    .section-cadastra .display-formularios .formulario-cadastro .wrong-input{
        border-bottom: 2px solid red;   
        margin-bottom: 0px;
    }
    .section-cadastra .display-formularios .formulario-cadastro .botao-continuar{
        position: relative;
        background-color: #6abd45;
        color: #fff;
        border: none;
        width: 120px;
        height: 30px;
        line-height: 32px;
        text-align: left;
        margin: 23px 0px 0px 0px;
        padding: 0px 15px 0px 10px;
        font-weight: bold;
        display: flex;
        align-items: center;
        transition: .2s;
        cursor: pointer;
        outline: none;
    }
    .section-cadastra .display-formularios .formulario-cadastro .botao-continuar .icone{
        font-size: 18px;
        position: absolute;
        top: 0px;
        height: 30px;
        right: 10px;
        transition: .2s;
    }
    .section-cadastra .display-formularios .formulario-cadastro .botao-continuar:hover{
        background-color: #518f35;
    }
    .section-cadastra .display-formularios .formulario-cadastro .botao-continuar:hover .icone{
        right: 5px;
    }
    /*DISPLAY PASSOS*/
    .section-cadastra .display-formularios .formulario-cadastro .displays{
        position: absolute;
        width: 100%;
        height: 85%;
        top: 0px;
        margin: 2.5% 0px 2.5% -2.5%;
        transition: .5s ease-out;
    }
    .section-cadastra .display-formularios .formulario-cadastro .display-info-contato{
        left: 2.5%;
    }
    .section-cadastra .display-formularios .formulario-cadastro .display-info-enderecos{
        left: 102.5%;
    }
    /*END DISPLAY PASSOS*/
    /*END FORM SYLES*/
    
    /*SECTION BOTTOM*/
    .section-cadastra .bottom{
        text-align: center;
    }
    .section-cadastra .bottom .botao-voltar{
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
    .section-cadastra .bottom .botao-voltar:hover{
        transform: rotate(0deg);
        opacity: 1;
    }
    /*END SECTION BOTTOM*/
    @media screen and (max-width: 860px){
        .section-cadastra .display-cadastra{
            width: 60%;   
        }
        @media screen and (max-width: 560px){
            .section-cadastra .display-cadastra{
                width: 95%;
            }      
            .section-cadastra .display-cadastra .titulo{
                font-size: 24px;   
            }
            .section-cadastra .display-formularios{
                height: 55vh;
                width: 90%;
            }
            .section-cadastra .display-formularios .formulario-login{
                height: 55vh;   
            }
            .section-cadastra .display-formularios .top-buttons{
                font-size: 10px;   
            }
            .section-cadastra .display-formularios .half{
                width: calc(100% - 30px);
                margin: 5px 15px 5px 15px;
            }
            .section-cadastra .display-formularios .medium{
                width: calc(100% - 30px);
                margin: 5px 15px 5px 15px;
            }
            .section-cadastra .display-formularios .small{
                width: calc(100% - 30px);
                margin: 5px 15px 5px 15px; 
            }
            .section-cadastra .display-formularios .xsmall{
                width: calc((100%/2) - 30px);
                margin: 5px 15px 5px 15px;   
            }
        }
    }
</style>
<div class="section-cadastra">
    <div class="display-cadastra">
        <h3 class="titulo">SE CADASTRE</h3>
        <h5 class="descricao-cadastre">
            <p>
                É um fato conhecido de todos que um leitor se distrairá com o conteúdo de texto legível de uma página quando estiver examinando sua diagramação.
            </p>
            <p>
                Existem muitas variações disponíveis de passagens de Lorem Ipsum, mas a maioria sofreu algum tipo de alteração.<br><br>
                Já tem conta? <a class="link-padrao" id="botaoAlternaLogin">Faça login aqui.</a>
            </p>
        </h5>
        <div class="display-confirmacao"></div>
        <div class="display-formularios">
            <div class="display-buttons">
                <button class="top-buttons selected-button" id="botaoPasso1">INFORMAÇÕES DE CONTATO</button>
                <button class="top-buttons" id="botaoPasso2">ENDEREÇO</button>
            </div>
            <form class="formulario-cadastro" name="formulario_cadastro">
                <div class="background-loading">
                    <i class="fas fa-spinner fa-spin icone-loading"></i>
                </div>
                <div class="displays display-info-contato">
                    <div class="half">
                        <h4 class="input-title">Nome Completo</h4>
                        <input type="text" placeholder="Nome Completo" name="nome" id="nome">
                        <h6 class="msg-input"></h6>
                    </div>
                    <div class="half">
                        <h4 class="input-title">E-mail</h4>
                        <input type="text" placeholder="contato@bolsasemcouro.com.br" name="email" id="email">
                        <h6 class="msg-input"></h6>
                    </div>
                    <div class="small">
                        <h4 class="input-title">Senha</h4>
                        <input type="password" placeholder="Senha" name="senha" id="senha">
                        <h6 class="msg-input"></h6>
                    </div>
                    <div class="small">
                        <h4 class="input-title">Confirmar Senha</h4>
                        <input type="password" placeholder="Senha" name="confirma_senha" id="confirmaSenha">
                        <h6 class="msg-input"></h6>
                    </div>
                    <div class="small">
                        <h4 class="input-title">Celular</h4>
                        <input type="text" placeholder="(41) 9999-9999" name="celular" id="celular" class="mascara-numero">
                        <h6 class="msg-input"></h6>
                    </div>
                    <div class="small">
                        <h4 class="input-title">Telefone</h4>
                        <input type="text" placeholder="(41) 3030-3030" name="telefone" id="telefone" class="mascara-numero">
                        <h6 class="msg-input"></h6>
                    </div>
                    <div class="small">
                        <h4 class="input-title">CPF</h4>
                        <input type="text" placeholder="000.000.000.00" name="cpf" id="cpf" class="mascara-cpf">
                        <h6 class="msg-input"></h6>
                    </div>
                    <div class="small">
                        <h4 class="input-title">SEXO</h4>
                        <select name="sexo" id="sexo">
                            <option value="">- Selecione -</option>
                            <option value="masculino">Masculino</option>
                            <option value="feminino">Feminino</option>
                        </select>
                        <h6 class="msg-input msg-input-sexo"></h6>
                    </div>
                    <div class="small">
                        <h4 class="input-title">Data de nascimento</h4>
                        <input type="date" name="data_nascimento" id="dataNascimento">
                        <h6 class="msg-input"></h6>
                    </div>
                    <div class="small">
                        <button class="botao-continuar" type="button">CONTINUAR <i class="fas fa-chevron-right icone"></i></button>
                    </div>
                    <br style="clear: both">
                </div>
                <div class="displays display-info-enderecos">
                    <div class="small">
                        <h4 class="input-title">CEP</h4>
                        <input type="text" placeholder="00000-000" name="cep" id="cep" tabindex="1" class="mascara-cep">
                        <h6 class="msg-input"></h6>
                    </div>
                    <div class="xlarge">
                        <h4 class="input-title">Rua</h4>
                        <input type="text" placeholder="Rua" name="rua" id="rua" class="input-nochange" readonly>
                        <h6 class="msg-input"></h6>
                    </div>
                    <br style="clear: both">
                    <div class="xsmall">
                        <h4 class="input-title">Número</h4>
                        <input type="text" placeholder="Numero" name="numero" id="numero" tabindex="2">
                        <h6 class="msg-input"></h6>
                    </div>
                    <div class="medium">
                        <h4 class="input-title">Complemento</h4>
                        <input type="text" placeholder="Complemento" name="complemento" id="complemento" tabindex="3">
                        <h6 class="msg-input"></h6>
                    </div>
                    <div class="xsmall">
                        <h4 class="input-title">Bairro</h4>
                        <input type="text" placeholder="Bairro" name="bairro" id="bairro" class="input-nochange" readonly>
                    </div>
                    <div class="xsmall">
                        <h4 class="input-title">Estado</h4>
                        <input type="text" placeholder="Estado" name="estado" id="estado" class="input-nochange" readonly>
                    </div>
                    <div class="xsmall">
                        <h4 class="input-title">Cidade</h4>
                        <input type="text" placeholder="Cidade" name="cidade" id="cidade" class="input-nochange" readonly>
                    </div>
                    <div class="medium checkbox-label">
                        <input type="checkbox" class="checkbox" id="termos" checked> Aceito os <a href="termos-e-condicoes.php" target="_blank">termos e condições</a>
                        <h6 class="msg-input-checkbox"></h6>
                    </div>
                    <div class="full">
                        <button class="botao-continuar" type="button">FINALIZAR <i class="fas fa-check icone"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="bottom">
            <button class="botao-voltar" title="Voltar para a página"><i class="fas fa-chevron-circle-left"></i></button>
        </div>
    </div>
</div>
<script type="text/javascript">
    /*INITIALIZE*/
    var sectionCadastra = $(".section-cadastra");
    var cadastreAberto = false;
    
    function toggleCadastreConta(){
        if(!cadastreAberto){
            cadastreAberto = true;
            sectionCadastra.css({
                visibility: "visible",
                right: "0px",
                opacity: "1",
                trasition: "1s"
            });
            $("body").css("overflow", "hidden");
        }else{
            cadastreAberto = false;
            sectionCadastra.css({
                visibility: "hidden",
                right: "-100%",
                opacity: ".6"
            });
            $("body").css("overflow", "auto");
        }
    }
    /*END INITIALIZE*/
    
    $(document).ready(function(){
        /*SET MASCARAS*/
        phone_mask(".mascara-numero");
        input_mask(".mascara-cpf", "999.999.999.99");
        input_mask(".mascara-cep", "99999-999");
        /*END SET MASCARAS*/
        
        /*BUSCA ENDERECO*/
        $("#cep").off().on("blur", function(){
            var cep = $(this).val();
            var objRua = $("#rua");
            var objBairro = $("#bairro");
            var objEstado = $("#estado");
            var objCidade = $("#cidade");
            if(cep.length == 9){
                var cepF = cep.replace("-", "");
                buscarCEP(cepF, objRua, objEstado, objCidade, objBairro);
            }else{
                objRua.val("");
                objBairro.val("");
                objEstado.val("");
                objCidade.val("");
            }
        });
        /*BUSCA ENDERECO*/
        
        /*SET PASSOS*/
        var displayPassos = [];
        displayPassos[0] = $(".display-info-contato");
        displayPassos[0]["botao_passo"] = $("#botaoPasso1");
        displayPassos[1] = $(".display-info-enderecos");
        displayPassos[1]["botao_passo"] = $("#botaoPasso2");
        var totalPassos = displayPassos.length;
        /*END SET PASSOS*/
        
        /*DEFAULT VARS*/
        var displayFormularios = $(".display-formularios");
        var displayConfirmacao = $(".display-confirmacao");
        var formularioCadastraConta = $(".formulario-cadastro");
        var botaoCadastraConta = $("#botaoCadastraConta");
        var botaoVoltar = $(".section-cadastra .botao-voltar");
        var backgroundLoading = $(".section-cadastra .background-loading");
        var botaoContinuar = $(".botao-continuar");
        var botaoAlternaLogin = $("#botaoAlternaLogin");
        var validandoDados = false;
        var lastValidationAtiva = false;
        var passoAtivo = 1;
        /*END DEFAULT VARS*/

        /*DEFAULT FUNCTIONS*/
        
        var mudandoPasso = false;
        function mudarPasso(passo){
            if(!mudandoPasso && !validandoDados){
                mudandoPasso = true;
                switch(passo){
                    case 1:
                        displayPassos[0].css({
                            opacity: "1",
                            left: "2.5%"
                        });
                        displayPassos[1].css({
                            left: "102.5%",
                        });
                        if(displayPassos[1]["botao_passo"].hasClass("selected-button")){
                            displayPassos[1]["botao_passo"].removeClass("selected-button");
                        }
                        displayPassos[0]["botao_passo"].addClass("selected-button");
                        passoAtivo = 1;
                        break;
                    case 2:
                        displayPassos[0].css({
                            left: "-100%",
                        });
                        displayPassos[1].css({
                            opacity: "1",
                            left: "2.5%"
                        });
                        if(displayPassos[0]["botao_passo"].hasClass("selected-button")){
                            displayPassos[0]["botao_passo"].removeClass("selected-button");
                        }
                        displayPassos[1]["botao_passo"].addClass("selected-button");
                        passoAtivo = 2;
                        break;
                }
                setTimeout(function(){
                    mudandoPasso = false;
                }, 500);
            }
        }
        
        function mensagemConfirmaEmail(email){
            var mensagem = "Foi enviando um e-mail para <b>" + email + "</b>  com um <b>link de confirmação</b>.<br><br>Clique no link para ativar sua conta e começar a aproveitar as ofertas e promoções da nossa loja!<br><br><a href='javascript:window.location.reload()' class='link-padrao'>Recarregar página</a>";
            displayFormularios.hide();
            displayConfirmacao.html(mensagem).css({
                display: "block",
                opacity: "1"
            });
        }
        
        /*END DEFAULT FUNCTIONS*/
        
        /*TRIGGERS PASSOS*/
        displayPassos[0]["botao_passo"].off().on("click", function(){
            if(!validandoDados && !lastValidationAtiva){
                mudarPasso(1);
            }
        });
        displayPassos[1]["botao_passo"].off().on("click", function(){
            if(!validandoDados && !lastValidationAtiva){
                mudarPasso(2);
            }
        });
        botaoContinuar.off().on("click", function(){
            if(!validandoDados && !lastValidationAtiva){
                validarDadosConta();
            }
        });
        /*END TRIGGERS PASSOS*/
        
        /*MAIN FUNCTION*/
        function validarDadosConta(){
            /*FORM FIELDS*/
            
            // PASSO 1
            var objNome = $("#nome");
            var objEmail = $("#email");
            var objSenha = $("#senha");
            var objConfirmaSenha = $("#confirmaSenha");
            var objCelular = $("#celular");
            var objCpf = $("#cpf");
            var objSexo = $("#sexo");
            var objDataNascimento = $("#dataNascimento");
            
            // PASSO 2
            var objCep = $("#cep");
            var objRua = $("#rua");
            var objNumero = $("#numero");
            var objTermos = $("#termos");
            
            // ULTIMO PASSO
            var validacaoPassos = [];
            var ctrlLastStep = 0;
            displayPassos.forEach(function(field){
                validacaoPassos[ctrlLastStep] = false;
                ctrlLastStep++;
            });
            
            /*END FORM FIELDS*/
            
            /*DEFAULT FUNCTIONS*/
            function setInputMessages(fields){
                fields.forEach(function(field){
                    switch(field){
                        /*PASSO 1*/
                        case objNome:
                            var msg = "O campo nome deve conter no mínimo 3 caracteres";
                            objNome.addClass("wrong-input");
                            objNome.next(".msg-input").text(msg).css({
                                visibility: "visible",
                                opacity: "1"
                            });
                            break;
                        case objEmail:
                            var msg = "O campo e-mail deve ser preenchido corretamente";
                            objEmail.addClass("wrong-input");
                            objEmail.next(".msg-input").text(msg).css({
                                visibility: "visible",
                                opacity: "1"
                            });
                            break;
                        case objSenha:
                            var msg = "O campo senha deve conter no mínimo 6 caracteres";
                            objSenha.addClass("wrong-input");
                            objSenha.next(".msg-input").text(msg).css({
                                visibility: "visible",
                                opacity: "1"
                            });
                            break;
                        case objConfirmaSenha:
                            var msg = "As senhas não são iguais";
                            objConfirmaSenha.addClass("wrong-input");
                            objConfirmaSenha.next(".msg-input").text(msg).css({
                                visibility: "visible",
                                opacity: "1"
                            });
                            break;
                        case objCelular:
                            var msg = "O campo celular deve conter no mínimo 6 caracteres";
                            objCelular.addClass("wrong-input");
                            objCelular.next(".msg-input").text(msg).css({
                                visibility: "visible",
                                opacity: "1"
                            });
                            break;
                        case objCpf:
                            var msg = "O campo CPF deve ser preenchido corretamente";
                            objCpf.addClass("wrong-input");
                            objCpf.next(".msg-input").text(msg).css({
                                visibility: "visible",
                                opacity: "1"
                            });
                            break;
                        case objSexo:
                            var msg = "Selecione uma opção no campo sexo";
                            objSexo.addClass("wrong-input");
                            objSexo.next(".msg-input").text(msg).css({
                                visibility: "visible",
                                opacity: "1"
                            });
                            break;
                        case objDataNascimento:
                            var msg = "Você precisa ser maior de 18 anos";
                            objDataNascimento.addClass("wrong-input");
                            objDataNascimento.next(".msg-input").text(msg).css({
                                visibility: "visible",
                                opacity: "1"
                            });
                            break;
                        case "email_duplicado":
                            var msg = "Já existe uma conta utilizando este e-mail";
                            objEmail.addClass("wrong-input");
                            objEmail.next(".msg-input").text(msg).css({
                                visibility: "visible",
                                opacity: "1"
                            });
                            break;
                        case "cpf_duplicado":
                            var msg = "Já existe uma conta utilizando este CPF";
                            objCpf.addClass("wrong-input");
                            objCpf.next(".msg-input").text(msg).css({
                                visibility: "visible",
                                opacity: "1"
                            });
                            break;
                        /*PASSO 2*/
                        case objCep:
                            var msg = "O CEP precisa ser preenchido corretamente";
                            objCep.addClass("wrong-input");
                            objCep.next(".msg-input").text(msg).css({
                                visibility: "visible",
                                opacity: "1"
                            });
                            break;
                        case objRua:
                            var msg = "Certifique-se de que tenha preenchido o campo CEP corretamente";
                            objRua.addClass("wrong-input");
                            objRua.next(".msg-input").text(msg).css({
                                visibility: "visible",
                                opacity: "1"
                            });
                            break;
                        case objNumero:
                            var msg = "O campo número deve conter no mínimo 1 caracter";
                            objNumero.addClass("wrong-input");
                            objNumero.next(".msg-input").text(msg).css({
                                visibility: "visible",
                                opacity: "1"
                            });
                            break;
                        case objTermos:
                            var msg = "Você precisa aceitar os Termos e Condições";
                            objTermos.addClass("wrong-input");
                            $(".msg-input-checkbox").text(msg).css({
                                visibility: "visible",
                                opacity: "1"
                            });
                            break;
                    }
                });
            }
            
            function finishValidation(errors, errorFields, thisStep, nextStep){
                validandoDados = false;
                var closeLoading = true;
                
                /*VARS DE VERIFICACAO NO LAST STEP*/
                var validationStatus = errors == 0 ? true : false;
                switch(thisStep){
                    case 1:
                        validacaoPassos[0] = validationStatus;
                        break;
                    case 2:
                        validacaoPassos[1] = validationStatus;
                        break;
                }
                /*END VARS DE VERIFICACAO NO LAST STEP*/
                
                if(errors > 0){
                    setInputMessages(errorFields); // Se ocorreu erros, mostra as mensagens de erro
                }else if(typeof nextStep != "undefined" && nextStep != null && nextStep != false && nextStep != "lastStep" && lastValidationAtiva == false){
                    mudarPasso(nextStep); // Nenhum erro e se houver próximo passo e não for a validação final 
                }else if(nextStep == "lastStep" && lastValidationAtiva == false){
                    closeLoading = false;
                    lastStep(); // Nenhum erro e fazer validação final
                }
                
                if(closeLoading){
                    toggleLoading();
                }
                
            }
            
            function prepareErrors(ctrlInvalid, allFields, invalidFields, thisStep, nextStep){
                
                allFields.forEach(function(field){
                    if(field.hasClass("wrong-input")){
                        field.removeClass("wrong-input");
                        field.next(".msg-input").text("").css({
                            visibility: "hidden",
                            opacity: "0"
                        });
                        $(".msg-input-sexo").text("").css({
                            visibility: "hidden",
                            opacity: "0"
                        });
                        switch(field){
                            case objTermos:
                                field.removeClass("wrong-input");
                                $(".msg-input-checkbox").text("").css({
                                    visibility: "hidden",
                                    opacity: "0"
                                });
                                break;
                            case objSexo:
                                field.removeClass("wrong-input");
                                $(".msg-input-sexo").text("").css({
                                    visibility: "hidden",
                                    opacity: "0"
                                });
                                break;
                                
                        }
                    }
                });

                setTimeout(function(){
                    finishValidation(ctrlInvalid, invalidFields, thisStep, nextStep);
                }, 300);
                
            }
            
            var loadingAberto = false;
            function toggleLoading(){
                if(!loadingAberto){
                    loadingAberto = true;
                    backgroundLoading.css({
                        visibility: "visible",
                        opacity: "1"
                    });
                }else if(!lastValidationAtiva){
                    loadingAberto = false;
                    backgroundLoading.css({
                        visibility: "hidden",
                        opacity: "0"
                    });
                }
            }
            /*END DEFAULT FUNCTIONS*/
            
            /*VALIDACAO PASSOS*/
            function validaPasso1(){
                var nome = objNome.val();
                var email = objEmail.val();
                var senha = objSenha.val();
                var confirmaSenha = objConfirmaSenha.val();
                var celular = objCelular.val();
                var cpf = objCpf.val();
                var sexo = objSexo.val();
                var dataNascimento = objDataNascimento.val();
                var allFields = [objNome, objEmail, objSenha, objConfirmaSenha, objCelular, objCpf, objSexo, objDataNascimento];
                var invalidFields = [];
                var ctrlInvalid = 0;
                var thisStep = 1;
                var nextStep = 2;
                
                function standardValidation(){
                    if(nome.length < 3){
                        invalidFields[ctrlInvalid] = objNome;
                        ctrlInvalid++;
                    }

                    if(validarEmail(email) == false){
                        invalidFields[ctrlInvalid] = objEmail;
                        ctrlInvalid++; 
                    }
                    if(senha.length < 6){
                        invalidFields[ctrlInvalid] = objSenha;
                        ctrlInvalid++;
                    }

                    if(confirmaSenha != senha){
                        invalidFields[ctrlInvalid] = objConfirmaSenha;
                        ctrlInvalid++;
                    }

                    if(celular.length < 14){
                        invalidFields[ctrlInvalid] = objCelular;
                        ctrlInvalid++;
                    }

                    if(validarCPF(cpf) == false){
                        invalidFields[ctrlInvalid] = objCpf;
                        ctrlInvalid++;
                    }
                    
                    if(sexo == ""){
                        invalidFields[ctrlInvalid] = objSexo;
                        ctrlInvalid++;
                    }

                    if(maiorIdade(objDataNascimento) == false){
                        invalidFields[ctrlInvalid] = objDataNascimento;
                        ctrlInvalid++;
                    }
                    
                    // Trigger das mensagens de erro
                    prepareErrors(ctrlInvalid, allFields, invalidFields, thisStep, nextStep);
                }
                
                function ajaxValidation(){
                    var ajaxFields = [objEmail, objCpf];
                    var duplicados = [];
                    var totalValidations = ajaxFields.length;
                    var ctrlValidations = 0;
                    var ctrlDuplicados = 0;
                    
                    function validaResult(){
                        if(duplicados.length > 0 && ctrlValidations == totalValidations){
                            duplicados.forEach(function(field){
                                switch(field){
                                    case objEmail:
                                        error = "email_duplicado";
                                        break;
                                    case objCpf:
                                        error = "cpf_duplicado";
                                        break;
                                }
                                invalidFields[ctrlInvalid] = error;
                                ctrlInvalid++;
                            });
                        }
                        if(ctrlValidations == totalValidations){
                            standardValidation();
                        }
                    }
                    
                    ajaxFields.forEach(function(field){
                        var campo = null;
                        var data = null;
                        switch(field){
                            case objEmail:
                                campo = "email";
                                data = objEmail.val();
                                break;
                            case objCpf:
                                campo = "cpf";
                                data = objCpf.val();
                                break;
                        }
                        
                        if(data != null){
                            $.ajax({
                                type: "POST",
                                url: "@valida-criar-conta.php",
                                data: {campo: campo, data: data},
                                error: function(){
                                    notificacaoPadrao("Desculpe ocorreu um erro ao validar os dados. Recarregue a página e tente novamente.");
                                    ctrlValidations++;
                                },
                                success: function(resposta){
                                    if(resposta == "duplicado"){
                                        duplicados[ctrlDuplicados] = field;
                                        ctrlDuplicados++;
                                    }
                                    ctrlValidations++;
                                    validaResult();
                                }
                            });
                        }
                    });
                }
                
                // Inicia com a validação do ajax
                ajaxValidation(); // Vai chamar o callback da segunda parte da validação
            }
            
            function validaPasso2(){
                cep = objCep.val();
                rua = objRua.val();
                numero = objNumero.val();
                termos = objTermos.prop("checked");
                var allFields = [objCep, objRua, objNumero, objTermos];
                var invalidFields = [];
                var ctrlInvalid = 0;
                var thisStep = 2;
                var nextStep = "lastStep";
                
                if(IsCEP(cep) == false){
                    invalidFields[ctrlInvalid] = objCep;
                    ctrlInvalid++;
                }
                
                if(rua.length == 0){
                    invalidFields[ctrlInvalid] = objRua;
                    ctrlInvalid++;
                }
                
                if(numero.length == 0){
                    invalidFields[ctrlInvalid] = objNumero;
                    ctrlInvalid++;
                }
                
                if(termos == false){
                    invalidFields[ctrlInvalid] = objTermos;
                    ctrlInvalid++;
                }
                
                prepareErrors(ctrlInvalid, allFields, invalidFields, thisStep, nextStep); // Trigger das mensagens de erro
            }
            
            function lastStep(){
                lastValidationAtiva = true;
                function resetValidationStatus(){
                    validacaoPassos.forEach(function(val, ctrl){
                        validacaoPassos[ctrl] = null;
                    });
                }
                
                resetValidationStatus();
                
                var isValidating = 0;
                var validationRunning = false;
                var validationHasFinished = false;
                var ctrlValidation = 0;

                setInterval(function(){
                    if(!validationHasFinished){
                        if(validacaoPassos[isValidating] == null){
                            validacaoPassos[isValidating] = "running";
                            ctrlValidation++;
                            switch(isValidating){
                                case 0:
                                    validaPasso1();
                                    break;
                                case 1:
                                    validaPasso2();
                                    break;
                            }
                        }else if(validacaoPassos[isValidating] != "running" && ctrlValidation < totalPassos){
                            isValidating++;
                        }else if(ctrlValidation == totalPassos){
                            
                            function finish(){
                                validationHasFinished = true;
                                lastValidationAtiva = false;
                                toggleLoading();
                            }
                            
                            var errors = 0;
                            validacaoPassos.forEach(function(val, step){
                                if(val == false){
                                    errors++;
                                    switch(step){
                                        case 0:
                                            if(validacaoPassos[1] == true){
                                                mudarPasso(1);
                                            }
                                            break;
                                    }
                                }
                            });
                            if(errors == 0){
                                var formData = new FormData(formularioCadastraConta.get(0));
                                var msgErro = "Desculpe, ocorreu um erro ao enviar os dados. Recarregue a página e tente novamente";
                                var msgSucesso = "Seu cadastro foi feito com sucesso!";
                                
                                $.ajax({
                                    type: "POST",
                                    data: formData,
                                    url: "@grava-cadastro-conta.php",
                                    cache: false,
                                    contentType: false,
                                    processData: false,
                                    error: function(){
                                        notificacaoPadrao(msgErro);
                                        finish();
                                    },
                                    success: function(resposta){
                                        //console.log(resposta);
                                        if(resposta == "true"){
                                            mensagemAlerta(msgSucesso, false, "limegreen");
                                            mensagemConfirmaEmail(objEmail.val());
                                        }else{
                                            mensagemAlerta(msgErro, false, "limegreen");
                                        }
                                        finish();
                                    }
                                });
                            }else{
                                finish();
                            }
                        }
                    }
                }, 500);
            }
            
            /*END VALIDACAO PASSOS*/
            
            /*TRIGGER VALIDA PASSO*/
            if(cadastreAberto && !validandoDados){
                toggleLoading();
                validandoDados = true;
                switch(passoAtivo){
                    case 1:
                        validaPasso1();
                        break;
                    case 2:
                        validaPasso2();
                        break;
                }
            }
            /*END TRIGGER VALIDA PASSO*/
        }
        /*END MAIN FUNCTION*/
        
        /*DEFAULT TRIGGERS*/
        botaoCadastraConta.off().on("click", function(){
            toggleCadastreConta();
        });
        
        botaoVoltar.off().on("click", function(){
            toggleCadastreConta();
        });
        botaoAlternaLogin.off().on("click", function(){
            if(cadastreAberto){
                toggleCadastreConta(); 
            }
            toggleLogin();
        });
        /*END DEFAULT TRIGGERS*/
    });
</script>