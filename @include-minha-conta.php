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
    .section-minha-conta .display-paineis .background-loading{
        position: absolute;
        width: 100%;
        height: 55vh;
        background-color: rgba(255, 255, 255, .5);
        top: 0px;
        margin: 0px;
        opacity: 0;
        transition: .3s;
        visibility: hidden;
        z-index: 80;
        text-align: center;
        display: flex;
        overflow: hidden;
    }
    .section-minha-conta .display-paineis .background-loading .icone-loading{
        position: absolute;
        font-size: 46px;
        color: #6abd45;
        top: 20vh;
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
        left: 5px;
        bottom: -50px;
        visibility: hidden;
        opacity: 0;
        transition: .2s;
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
    <div class="display-paineis">
        <div class="background-loading">
            <i class="fas fa-spinner fa-spin icone-loading"></i>
        </div>
        <div class="display-buttons">
            <button class="top-buttons selected-button" id="Painel1"><i class="fas fa-shopping-cart"></i> PEDIDOS</button>
            <button class="top-buttons" id="Painel2"><i class="far fa-address-card"></i> MEUS DADOS</button>
            <button class="top-buttons" id="Painel3"><i class="fas fa-truck"></i> ENDEREÇOS DE ENTREGA</button>
        </div>
        <div class="painel painel-active" id="displayPainel1">
            Painel 1
        </div>
        <div class="painel" id="displayPainel2">
            <?php
                $nome = $infoConta["usuario"];
                $email = $infoConta["email"];
                $celular = $infoConta["celular"];
                $telefone = $infoConta["telefone"];
                $cpf = $infoConta["cpf"];
                $sexo = $infoConta["sexo"];
                $dataNascimento = $infoConta["data_nascimento"];
            ?>
            <form class="formulario-atualiza-conta">
                <div class="half label">
                    <input type="hidden" name="id_conta" id="idConta" value="<?php echo $idConta; ?>">
                    <input type="hidden" name="acao_conta" value="update_conta">
                    <h4 class="input-title">Nome Completo</h4>
                    <input type="text" class='input-standard' placeholder="Nome Completo" name="nome" id="nome" value="<?php echo $nome; ?>">
                    <h6 class="msg-input"></h6>
                </div>
                <div class="small label">
                    <h4 class="input-title">E-mail</h4>
                    <input type="text" class='input-standard' placeholder="contato@bolsasemcouro.com.br" name="email" id="email" value="<?php echo $email; ?>">
                    <h6 class="msg-input"></h6>
                </div>
                <div class="small label">
                    <h4 class="input-title">CPF</h4>
                    <input type="text" class='input-standard mascara-cpf-conta' placeholder="000.000.000.00" name="cpf" id="cpf" value="<?php echo $cpf; ?>">
                    <h6 class="msg-input"></h6>
                </div>
                <div class="small label">
                    <h4 class="input-title">Celular</h4>
                    <input type="text" class='input-standard mascara-numero-conta' placeholder="(41) 9999-9999" name="celular" id="celular" value="<?php echo $celular; ?>">
                    <h6 class="msg-input"></h6>
                </div>
                <div class="small label">
                    <h4 class="input-title">Telefone</h4>
                    <input type="text" class='input-standard mascara-numero-conta' placeholder="(41) 3030-3030" name="telefone" id="telefone" value="<?php echo $telefone; ?>">
                    <h6 class="msg-input"></h6>
                </div>
                <div class="small label">
                    <h4 class="input-title">Sexo</h4>
                    <select name="sexo" id="sexo" class="input-standard">
                        <option value="">- Selecione -</option>
                        <option value="masculino" <?php if($sexo == "masculino") echo "selected"; ?>>Masculino</option>
                        <option value="feminino" <?php if($sexo == "feminino") echo "selected"; ?>>Feminino</option>
                    </select>
                    <h6 class="msg-input msg-input-sexo"></h6>
                </div>
                <div class="small label">
                    <h4 class="input-title">Data de nascimento</h4>
                    <input type="date" name="data_nascimento" id="dataNascimento" class="input-standard" value="<?php echo $dataNascimento; ?>">
                    <h6 class="msg-input"></h6>
                </div>
                <br class='clear'>
                <div class="small label">
                    <h4 class="input-title">Senha atual</h4>
                    <input type="password" class='input-standard' placeholder="Senha" name="senha_atual" id="senhaAtual">
                    <h6 class="msg-input"></h6>
                </div>
                <div class="small label">
                    <h4 class="input-title">Nova senha</h4>
                    <input type="password" class='input-standard' placeholder="Senha" name="senha_nova" id="senhaNova">
                    <h6 class="msg-input"></h6>
                </div>
                <div class="small label">
                    <h4 class="input-title">Confirmar nova senha</h4>
                    <input type="password" class='input-standard' placeholder="Senha" name="confirma_senha_nova" id="confirmaSenhaNova">
                    <h6 class="msg-input"></h6>
                </div>
                <div class="small label">
                    <button class="botao-continuar" type="button" id="botaoAtualizarConta">ATUALIZAR <i class="fas fa-check icone"></i></button>
                </div>
            </form>
        </div>
        <div class="painel" id="displayPainel3">
            Painel 3
        </div>
    </div>
    <div class="bottom">
        <button class="botao-voltar botao-voltar-conta" title="Voltar para a página"><i class="fas fa-chevron-circle-left"></i></button>
    </div>
</section>
<?php
}
?>
<script>
    $(document).ready(function(){
        var displayPaineis = $(".section-minha-conta .display-paineis");
        var botoes = $(".section-minha-conta .top-buttons");
        var paineis = displayPaineis.children(".painel");
        var botaoAtualizar = $("#botaoAtualizarConta");
        var backgroundLoading = $(".section-minha-conta .background-loading");
        
        function mudarPainel(obj){
            paineis.each(function(){
                $(this).removeClass("painel-active");
            });
            obj.addClass("painel-active");
        }
        
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
        
        /*UPDATE*/
        var is_updating = false;
        
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

        function finishValidation(errors, errorFields, thisStep, nextStep){
            validandoDados = false;
            var closeLoading = true;

            if(errors > 0){
                setInputMessages(errorFields); // Se ocorreu erros, mostra as mensagens de erro
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
                    prepareErrors(ctrlInvalid, allFields, invalidFields, thisStep, nextStep);
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
                                    //window.location.reload();
                                }, 400);
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
        
        
        botaoAtualizar.off().on("click", function(){
             if(!is_updating){
                valida_update();
             }
        });
        /*END UPDATE*/
        
      
        phone_mask(".mascara-numero-conta");
        input_mask(".mascara-cpf-conta", "999.999.999.99");
        input_mask(".mascara-cep-conta", "99999-999");
        
        var sectionConta = $(".section-minha-conta");
        var minhaContaOpen = false;
        function toggleMinhaConta(){
            if(!minhaContaOpen){
                minhaContaOpen = true;
                sectionConta.css({
                    visibility: "visible",
                    left: "0px",
                    opacity: "1",
                });
                $("body").css("overflow-y", "hidden");
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
    });
</script>