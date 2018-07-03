<style>
    .section-minha-conta{
        position: fixed;
        width: 100%;
        height: 100vh;
        top: 0px;
        left: 100%;
        z-index: 100;
        background-color: #fff;
        text-align: center;
        font-size: 16px;
        visibility: hidden;
        transition: .4s all ease;
        opacity: 1;
        overflow: hidden;
        overflow-y: auto;
    }
    .section-minha-conta .titulo{
        font-size: 32px;   
    }
    .section-minha-conta .descricao{
        width: 60%;
        margin: 0 auto 40px auto;
    }
    .section-minha-conta .display-paineis{
        position: relative;
        width: 80%;
        height: 55vh;
        margin: 0 auto;
        margin-top: 40px;
        -webkit-box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);
        -moz-box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);
        box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);
        transition: .2s;
        align-items: center;
        overflow: hidden;
        overflow-y: auto;
    }
    .display-paineis::-webkit-scrollbar-button:hover{
        background-color: #AAA;
    }
    .display-paineis::-webkit-scrollbar-thumb{
        background-color: #ccc;
    }
    .display-paineis::-webkit-scrollbar-thumb:hover{
        background-color: #999;
    }
    .display-paineis::-webkit-scrollbar-track{
        background-color: #efefef;
    }
    .display-paineis::-webkit-scrollbar-track:hover{
        background-color: #efefef;
    }
    .display-paineis::-webkit-scrollbar{
        width: 3px;
        height: 3px;
    }
    .section-minha-conta .background-loading{
        position: absolute;
        width: 100vw;
        height: 100vh;
        background-color: rgba(255, 255, 255, .5);
        top: 0px;
        left: 0;
        margin: 0px;
        opacity: 0;
        transition: .3s;
        visibility: hidden;
        z-index: 150;
        text-align: center;
        display: flex;
        overflow: hidden;
    }
    .section-minha-conta .background-loading .icone-loading{
        position: absolute;
        font-size: 46px;
        color: #6abd45;
        top: 50vh;
        align-self: center;
        width: 100%;
    }
    .section-minha-conta .display-paineis .display-buttons{
        position: sticky;
        width: 100%;
        top: 0px;
        left: 0px;
        margin-top: 0px;
        display: flex;
        z-index: 80;
    }
    .section-minha-conta .display-paineis .top-buttons{
        height: 5vh;
        background-color: #fff;
        border: none;
        cursor: pointer;
        outline: none;
        width: 50%;
        color: #999;
        border-bottom: 2px solid #f6f6f6;
    }
    .section-minha-conta .display-paineis .top-buttons:hover{
        background-color: #f1f1f1;
    }
    .section-minha-conta .display-paineis .selected-button{   
        border-bottom: 2px solid green;
        color: green;
    }
    .section-minha-conta .display-paineis .painel{
        position: absolute;
        width: calc(100% - 80px);
        height: calc(50vh - 80px);
        padding: 40px;
        z-index: 50;
        text-align: left;
        top: 100%;
        left: 0;
        transition: .5s;
        background-color: #fff;
        opacity: 0;
        visibility: hidden;
        display: none;
        transition: 1s all, display 0s;
    }
    .section-minha-conta .display-paineis .painel-active{
        position: relative;
        opacity: 1;
        top: 0px;
        left: 0px;
        display: block;
        visibility: visible;
        opacity: 1;
    }
    /*SECTION BOTTOM*/
    .section-minha-conta .bottom{
        text-align: center;
    }
    .section-minha-conta .bottom .botao-voltar{
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
    .section-minha-conta .bottom .botao-voltar:hover{
        transform: rotate(0deg);
        opacity: 1;
    }
    /*END SECTION BOTTOM*/
    .botao-continuar{
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
    .botao-continuar .icone{
        font-size: 18px;
        position: absolute;
        top: 0px;
        height: 30px;
        line-height: 30px;
        right: 10px;
        transition: .2s;
    }
    .botao-continuar:hover{
        background-color: #518f35;
    }
    .botao-continuar:hover .icone{
        right: 5px;
    }
    .msg-input{
        position: absolute;
        left: 2px;
        top: 30px;
        visibility: hidden;
        opacity: 0;
        transition: .2s;
    }
    .box-pedido{
        position: relative;
        width: calc(100% - 20px);
        padding: 10px;
        display: flex;
        flex-flow: row wrap;
        border-bottom: 2px solid #eee;
        z-index: 50;
    }
    .box-pedido .right{
        width: 40%;
    }
    .box-pedido .right .titulo{
        font-size: 18px;
        margin: 0px 0px 15px 0px;
    }
    .box-pedido .right .descricao{
        font-size: 14px;
        color: #666;
        font-weight: normal;
        text-align: left;
        margin: 0px;
    }
    .box-pedido .middle{
        width: 40%;
    }
    .box-pedido .middle .descricao{
        font-weight: normal;
        margin: 0px 0px 10px 0px;
    }
    .box-pedido .middle .btn-mais-info{
        display: inline-block;
        margin: 5px 0px 0px 0px;
        cursor: pointer;
    }
    .box-pedido .left{
        width: 20%;
    }
    .box-pedido .left .descricao{
        width: 100px;
        float: left;
        font-weight: normal;
        margin: 0px 0px 10px 0px;
    }
    .box-pedido .left .status{
        clear: both;
        color: limegreen;
        font-weight: normal;
    }
    .box-pedido .display-info-pedido{
        position: absolute;
        top: -100%;
        left: 0;
        width: calc(100% - 20px);
        min-height: 100%;
        padding: 10px;
        border-bottom: 2px solid #eee;
        background-color: #fff;
        display: flex;
        flex-flow: row wrap;
        visibility: hidden;
        opacity: 0;
        transition: .3s;
        -webkit-box-shadow: 0px 4px 20px 0px rgba(0, 0, 0, .4);
        -moz-box-shadow: 0px 4px 20px 0px rgba(0, 0, 0, .4);
        box-shadow: 0px 4px 20px 0px rgba(0, 0, 0, .4);
    }
    .box-pedido .display-info-pedido .titulo{
        font-size: 18px;
        margin: 0px 0px 15px 0px;
        width: 100%;
    }
    .box-pedido .display-info-pedido .lista-produtos{
        width: calc(50% - 41px);
        margin: 0px 20px 0px 20px;
        border-right: 1px solid #eee;
    }
    .box-pedido .display-info-pedido .info-frete{
        width: calc(50% - 40px);
        margin: 0px 20px 0px 20px;
    }
    .box-pedido .display-info-pedido .info-frete .titulo{
        font-size: 18px;
        margin: 0px 0px 5px 0px;
        font-weight: bold;
        color: #666;
    }
    .box-pedido .display-info-pedido .info-frete .info{
        font-size: 16px;
        font-weight: normal;
        margin: 0px;
    }
    .box-pedido .display-info-pedido .bottom-info{
        text-align: left;
        width: 100%;
        padding: 10px 0px 10px 0px;
    }
    .box-pedido .display-info-pedido .bottom-info .btn-voltar{
        cursor: pointer;
    }
    @media screen and (max-width: 720px){
        .section-minha-conta .descricao{
            width: 90%; 
        }
        .section-minha-conta .xsmall{
            width: calc((100%/2) - 30px);
            margin: 5px 15px 5px 15px;
            float: left;
        }
        .section-minha-conta .small{
            width: calc((100%) - 30px);
            margin: 5px 15px 5px 15px;
            float: left;
        }
        .section-minha-conta .medium{
            width: calc((100%) - 30px);
            margin: 5px 15px 5px 15px;
            float: left;
        }
        .section-minha-conta .half{
            width: calc((100%) - 30px);
            margin: 5px 15px 5px 15px;
            float: left;
        }
        .section-minha-conta .large{
            width: calc((100%) - 30px);
            margin: 5px 15px 5px 15px;
            float: left;
        }
        .section-minha-conta .xlarge{
            width: calc((100%) - 30px);
            margin: 5px 15px 5px 15px;
            float: left;
        }
        .section-minha-conta .full{
            width: calc(100% - 30px);
            margin: 5px 15px 5px 15px;
        }
        .section-minha-conta .display-paineis{
            width: 90%;
            height: auto;
        }
        .section-minha-conta .display-paineis .top-buttons{
            height: auto;
            font-size: 10px;
        }
        .section-minha-conta .display-paineis .painel{
            width: calc(100% - 40px);
            padding: 20px;
            height: auto;
        }
        .box-pedido{
            width: 100%;
            padding: 0px;
            margin-bottom: 10px;   
        }
        .box-pedido .right{
            width: 100%;
        }
        .box-pedido .middle{
            width: 100%;
        }
        .box-pedido .left{
            width: 100%;
        }
        .box-pedido .display-info-pedido .lista-produtos{
            width: calc(100% - 20px);
            margin: 0px 10px 0px 10px;
            border: none;
            font-size: 12px;
        }
        .box-pedido .display-info-pedido .info-frete{
            width: calc(100% - 21px);
            margin: 30px 10px 0px 10px;
        }
    }
</style>

<?php
    require_once "@classe-minha-conta.php";

    $cls_conta = new MinhaConta();
    
    $listar = true;
    
    if(isset($_SESSION["minha_conta"])){
        $sessao_conta = $_SESSION["minha_conta"];
        $email = $sessao_conta["email"];
        $senha = $sessao_conta["senha"];
        
        if($cls_conta->auth($email, $senha) == false){
            $listar = false;
        }else{
            $idConta = $cls_conta->query_minha_conta("md5(email) = '$email' and senha = '$senha'");
            $cls_conta->montar_minha_conta($idConta);
            $infoConta = $cls_conta->montar_array();
        }
        
    }else{
        $listar = false;
    }

if($listar){
?>
<section class="section-minha-conta">
    <h3 class="titulo">Minha conta</h3>
    <article class="descricao">É um fato conhecido de todos que um leitor se distrairá com o conteúdo de texto legível de uma página quando estiver examinando sua diagramação.</article>
    <div class="background-loading">
        <i class="fas fa-spinner fa-spin icone-loading"></i>
    </div>
    <div class="display-paineis"><!--LOAD @INTERNA-MINHA-CONTA.PHP--></div>
    <div class="bottom">
        <button class="botao-voltar botao-voltar-conta" title="Voltar para a página"><i class="fas fa-chevron-circle-left"></i></button>
    </div>
</section>
<?php
}
?>
<script>
    $(document).ready(function(){
        
        // PEDIDOS
        var boxPedidos = $(".box-pedido");
        
        function toggle_info(objTarget){
            var is_open = objTarget.css("visibility") == "visible" ? true : false;
            
            if(!is_open){
                objTarget.css({
                    visibility: "visible",
                    opacity: "1",
                    top: "0px"
                });
            }else{
                objTarget.css({
                    visibility: "hidden",
                    opacity: "0",
                    top: "-100%"
                });
            }
        }
        var ctrlIndexPedidos = 0;
        setInterval(function(){
            boxPedidos = $(".box-pedido");
            boxPedidos.each(function(){
                var box = $(this);
                var btnInfo = box.children(".control-info").children(".btn-mais-info");
                var refTarget = btnInfo.attr('data-target-pedido');
                var objTarget = $("#"+refTarget);
                var botaoVoltar = objTarget.children(".bottom-info").children(".btn-voltar");
                
                btnInfo.off().on("click", function(){
                    var is_open = objTarget.css("visibility") == "visible" ? true : false;
                    if(!is_open){
                        var zIndex = 60 + ctrlIndexPedidos;
                        box.css("z-index", zIndex);
                        ctrlIndexPedidos++;
                    }
                    toggle_info(objTarget);
                });
                
                botaoVoltar.off().on("click", function(){
                    toggle_info(objTarget);
                    box.css("z-index", "50");
                });
            });
        }, 200);
        // END PEDIDOS
        
        var displayPaineis = $(".section-minha-conta .display-paineis");
        var botoes = $(".section-minha-conta .top-buttons");
        var paineis = displayPaineis.children(".painel");
        var botaoAtualizarConta = $("#botaoAtualizarConta");
        var botaoAtualizarEndereco = $("#botaoAtualizarEndereco");
        var backgroundLoading = $(".section-minha-conta .background-loading");
        
        var formUpdateConta = $(".formulario-atualiza-conta");
        var objIdConta = $("#idConta");
        var idConta = objIdConta.val();
        var objNome = $("#nome");
        var objEmail = $("#email");
        var objSenhaAtual = $("#senhaAtual");
        var objSenhaNova = $("#senhaNova");
        var objConfirmaSenhaNova = $("#confirmaSenhaNova");
        var objCelular = $("#celular");
        var objCpf = $("#cpf");
        var objSexo = $("#sexo");
        var objDataNascimento = $("#dataNascimento");
        
        var objIdEndereco = $("#idEnderecoConta");
        var objCep = $("#cepConta");
        var objRua = $("#ruaConta");
        var objNumero = $("#numeroConta");
        var objComplemento = $("#complementoConta");
        var objBairro = $("#bairroConta");
        var objEstado = $("#estadoConta");
        var objCidade = $("#cidadeConta");
        
        function reload_display_dom(){
            displayPaineis = $(".section-minha-conta .display-paineis");
            botoes = $(".section-minha-conta .top-buttons");
            paineis = displayPaineis.children(".painel");
            botaoAtualizarConta = $("#botaoAtualizarConta");
            botaoAtualizarEndereco = $("#botaoAtualizarEndereco");
            backgroundLoading = $(".section-minha-conta .background-loading");
            
            botoes.each(function(){
                var botao = $(this);
                var idBotao = botao.prop("id");
                var objPainel = $("#display"+idBotao);
                botao.off().on("click", function(){
                    botoes.each(function(){
                        $(this).removeClass("selected-button"); 
                    });
                    botao.addClass("selected-button");
                    mudarPainel(objPainel); 
                });
            });
            
            botaoAtualizarConta.off().on("click", function(){
                 if(!is_updating){
                    valida_update();
                 }
            });
            
            botaoAtualizarEndereco.off().on("click", function(){
                 if(!is_updating){
                    valida_endereco();
                 }
            });
            
            /*VARS*/
            formUpdateConta = $(".formulario-atualiza-conta");
            objIdConta = $("#idConta");
            objIdEndereco = $("#idEnderecoConta");
            idConta = objIdConta.val();
            objNome = $("#nome");
            objEmail = $("#email");
            objSenhaAtual = $("#senhaAtual");
            objSenhaNova = $("#senhaNova");
            objConfirmaSenhaNova = $("#confirmaSenhaNova");
            objCelular = $("#celular");
            objCpf = $("#cpf");
            objSexo = $("#sexo");
            objDataNascimento = $("#dataNascimento");
            
            objCep = $("#cepConta");
            objRua = $("#ruaConta");
            objNumero = $("#numeroConta");
            objComplemento = $("#complementoConta");
            objBairro = $("#bairroConta");
            objEstado = $("#estadoConta");
            objCidade = $("#cidadeConta");
            
            phone_mask(".mascara-numero-conta");
            input_mask(".mascara-cpf-conta", "999.999.999.99");
            input_mask(".mascara-cep-conta", "99999-999");
            
            /*BUSCA ENDERECO*/
            objCep.off().on("blur", function(){
                var cep = $(this).val();
                
                // ENDERECO
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
        }
        
        var sectionConta = $(".section-minha-conta");
        var minhaContaOpen = false;
        function toggleMinhaConta(){
            reload_display_dom();
            
            if(!minhaContaOpen){
                minhaContaOpen = true;
                sectionConta.css({
                    visibility: "visible",
                    left: "0px",
                    opacity: "1",
                });
                toggleLoading();
                $("body").css("overflow-y", "hidden");
                displayPaineis.load("@interna-minha-conta.php", function(){
                    if(loadingAberto) toggleLoading();
                    
                    reload_display_dom();
                });
            }else{
                minhaContaOpen = false;
                sectionConta.css({
                    visibility: "hidden",
                    left: "100%",
                    opacity: "0",
                });
                $("body").css("overflow-y", "auto");
            }
        }
        
        $(".btn-open-minha-conta").off().on("click", function(){
            toggleMinhaConta(); 
        });
        
        $(".botao-voltar-conta").off().on("click", function(){
            toggleMinhaConta(); 
        });
        
        $(".btn-trigger-minha-conta").off().on("click", function(){
            toggleMinhaConta(); 
        });
        
        function mudarPainel(obj){
            paineis.each(function(){
                $(this).removeClass("painel-active");
            });
            obj.addClass("painel-active");
        }
        
        /*UPDATE*/
        var is_updating = false;
        var lastValidationAtiva = false;
        
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
                    case "senha_incorreta":
                        var msg = "A sua senha está incorreta";
                        objSenhaAtual.addClass("wrong-input");
                        objSenhaAtual.next(".msg-input").text(msg).css({
                            visibility: "visible",
                            opacity: "1"
                        });
                        break;
                    case objSenhaNova:
                        var msg = "O campo senha deve conter no mínimo 6 caracteres";
                        objSenhaNova.addClass("wrong-input");
                        objSenhaNova.next(".msg-input").text(msg).css({
                            visibility: "visible",
                            opacity: "1"
                        });
                        break;
                    case objConfirmaSenhaNova:
                        var msg = "As senhas não são iguais";
                        objConfirmaSenhaNova.addClass("wrong-input");
                        objConfirmaSenhaNova.next(".msg-input").text(msg).css({
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
                }
            });
        }

        function finishValidation(errors, errorFields){
            validandoDados = false;
            var closeLoading = true;

            if(errors > 0){
                setInputMessages(errorFields); // Se ocorreu erros, mostra as mensagens de erro
            }

            if(closeLoading && loadingAberto){
                toggleLoading();
            }

        }

        function prepareErrors(ctrlInvalid, allFields, invalidFields){

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
                finishValidation(ctrlInvalid, invalidFields);
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
            }else{
                loadingAberto = false;
                backgroundLoading.css({
                    visibility: "hidden",
                    opacity: "0"
                });
            }
        }
        /*END DEFAULT FUNCTIONS*/

        /*VALIDACAO PASSOS*/
        function valida_update(){
            var nome = objNome.val();
            var email = objEmail.val();
            var senhaAtual = objSenhaAtual.val();
            var senhaNova = objSenhaNova.val();
            var confirmaSenha = objConfirmaSenhaNova.val();
            var celular = objCelular.val();
            var cpf = objCpf.val();
            var sexo = objSexo.val();
            var dataNascimento = objDataNascimento.val();
            var allFields = [objNome, objEmail, objSenhaNova, objConfirmaSenhaNova, objCelular, objCpf, objSexo, objDataNascimento];
            var invalidFields = [];
            var ctrlInvalid = 0;

            function standardValidation(){
                if(nome.length < 3){
                    invalidFields[ctrlInvalid] = objNome;
                    ctrlInvalid++;
                }

                if(validarEmail(email) == false){
                    invalidFields[ctrlInvalid] = objEmail;
                    ctrlInvalid++; 
                }
                if(senhaNova.length < 6 && senhaNova.length > 0){
                    invalidFields[ctrlInvalid] = objSenhaNova;
                    ctrlInvalid++;
                }

                if(confirmaSenha != senhaNova){
                    invalidFields[ctrlInvalid] = objConfirmaSenhaNova;
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
                if(ctrlInvalid > 0){
                    prepareErrors(ctrlInvalid, allFields, invalidFields);
                    return false;
                }else{
                    var formData = new FormData(formUpdateConta.get(0));
                    var msgErro = "Desculpe, ocorreu um erro ao enviar os dados. Recarregue a página e tente novamente";
                    var msgSucesso = "Seus dados foram atualizados!";

                    $.ajax({
                        type: "POST",
                        data: formData,
                        url: "@classe-minha-conta.php",
                        cache: false,
                        contentType: false,
                        processData: false,
                        error: function(){
                            notificacaoPadrao(msgErro);
                        },
                        success: function(resposta){
                            console.log(resposta);
                            if(resposta == "true"){
                                mensagemAlerta(msgSucesso, false, "limegreen");
                                setTimeout(function(){
                                    window.location.reload();
                                }, 1000);
                            }else{
                                mensagemAlerta(msgErro, false, "limegreen");
                            }
                        }
                    });
                }
            }

            function ajaxValidation(){
                var addSenha = senhaNova.length > 0 ? "senha_atual" : null;
                var ajaxFields = [objEmail, objCpf, addSenha];
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
                                case "senha_atual":
                                    error = "senha_incorreta";
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
                        case "senha_atual":
                            campo = "senha_atual";
                            data = objSenhaAtual.val();
                            data = data.length > 0 ? data : null;
                            break;
                        default:
                            data = null;
                    }
                    
                    if(data != null){
                        $.ajax({
                            type: "POST",
                            url: "@valida-criar-conta.php",
                            data: {campo: campo, data: data, update: "valida_update_conta", id_conta: idConta},
                            error: function(){
                                notificacaoPadrao("Desculpe ocorreu um erro ao validar os dados. Recarregue a página e tente novamente.");
                                ctrlValidations++;
                            },
                            success: function(resposta){
                                //console.log(resposta)
                                if(resposta == "duplicado"){
                                    duplicados[ctrlDuplicados] = field;
                                    ctrlDuplicados++;
                                }
                                ctrlValidations++;
                                validaResult();
                            }
                        });
                    }else{
                        if(field == "senha_atual"){
                            duplicados[ctrlDuplicados] = "senha_atual";
                        }
                        ctrlValidations++;
                    }
                });
            }

            // Inicia com a validação do ajax
            ajaxValidation(); // Vai chamar o callback da segunda parte da validação
            toggleLoading();
        }
        /*END UPDATE*/
        
        /*UPDATE ENDERECO*/
        function valida_endereco(){
            var idEndereco = objIdEndereco.val();
            cep = objCep.val();
            rua = objRua.val();
            numero = objNumero.val();
            complemento = objComplemento.val();
            bairro = objBairro.val();
            cidade = objCidade.val();
            estado = objEstado.val();
            var allFields = [objCep, objRua, objNumero];
            var invalidFields = [];
            var ctrlInvalid = 0;
            
            toggleLoading();

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

            prepareErrors(ctrlInvalid, allFields, invalidFields); // Trigger das mensagens de erro
            
            if(ctrlInvalid == 0){
                
                toggleLoading();
                
                var dados = {
                    acao_conta: "update_endereco",
                    id_conta: idConta,
                    id_endereco: idEndereco,
                    cep: cep,
                    rua: rua,
                    numero: numero,
                    complemento: complemento,
                    bairro: bairro,
                    cidade: cidade,
                    estado: estado,
                }
                
                $.ajax({
                    type: "POST",
                    url: "@classe-minha-conta.php",
                    data: dados,
                    error: function(){
                        mensagemAlerta("Ocorreu um erro ao atualizar o endereço. Atualize a página e tente novamente.");
                    },
                    success: function(resposta){
                        //console.log(resposta);
                        if(resposta == "true"){
                            toggleLoading();
                            mensagemAlerta("Seu endereço foi atualizado com sucesso!", false, "limegreen");
                            setTimeout(function(){
                                window.location.reload();
                            }, 1000);
                        }else{
                            mensagemAlerta("Ocorreu um erro ao atualizar o endereço. Atualize a página e tente novamente.");
                        }
                    }
                });
            }
        }
        /*END UPDATE ENDERECO*/
    });
</script>