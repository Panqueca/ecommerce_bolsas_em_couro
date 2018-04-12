<style>
    .section-minha-conta{
        position: fixed;
        width: 100%;
        height: 100vh;
        top: 0px;
        right: 0px;
        z-index: 100;
        background-color: #fff;
        text-align: center;
        font-size: 16px;
        visibility: visible;
        transition: .4s all ease;
        opacity: 1;
        overflow: hidden;
        overflow-y: scroll;
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
        top: 0px;
        left: 100%;
        transition: .3s;
    }
    .section-minha-conta .display-paineis .painel-active{
        position: relative;
        visibility: visible;
        opacity: 1;
        left: 0px;
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
</style>

<section class="section-minha-conta">
    <h3 class="titulo">Minha conta</h3>
    <article class="descricao">É um fato conhecido de todos que um leitor se distrairá com o conteúdo de texto legível de uma página quando estiver examinando sua diagramação.</article>
    <div class="display-paineis">
        <div class="background-loading">
            <i class="fas fa-spinner fa-spin icone-loading"></i>
        </div>
        <div class="display-buttons">
            <button class="top-buttons selected-button" id="Painel1"><i class="far fa-address-card"></i> MEUS DADOS</button>
            <button class="top-buttons" id="Painel2"><i class="fas fa-shopping-cart"></i> PEDIDOS</button>
            <button class="top-buttons" id="Painel3"><i class="fas fa-truck"></i> ENDEREÇO ENTREGA</button>
        </div>
        <div class="painel painel-active" id="displayPainel1">
            <?php
                require_once "@classe-minha-conta.php";
            ?>
            <div class="label-half">
                <h4 class="input-title">Nome Completo</h4>
                <input type="text" class='input-standard' placeholder="Nome Completo" name="nome" id="nome">
                <h6 class="msg-input"></h6>
            </div>
            <div class="label-half">
                <h4 class="input-title">E-mail</h4>
                <input type="text" class='input-standard' placeholder="contato@bolsasemcouro.com.br" name="email" id="email">
                <h6 class="msg-input"></h6>
            </div>
            <div class="label-small">
                <h4 class="input-title">Senha</h4>
                <input type="password" class='input-standard' placeholder="Senha" name="senha" id="senha">
                <h6 class="msg-input"></h6>
            </div>
            <div class="label-small">
                <h4 class="input-title">Confirmar Senha</h4>
                <input type="password" class='input-standard' placeholder="Senha" name="confirma_senha" id="confirmaSenha">
                <h6 class="msg-input"></h6>
            </div>
            <div class="label-small">
                <h4 class="input-title">Celular</h4>
                <input type="text" class='input-standard' placeholder="(41) 9999-9999" name="celular" id="celular" class="mascara-numero">
                <h6 class="msg-input"></h6>
            </div>
            <div class="label-small">
                <h4 class="input-title">Telefone</h4>
                <input type="text" class='input-standard' placeholder="(41) 3030-3030" name="telefone" id="telefone" class="mascara-numero">
                <h6 class="msg-input"></h6>
            </div>
            <div class="label-small">
                <h4 class="input-title">CPF</h4>
                <input type="text" class='input-standard' placeholder="000.000.000.00" name="cpf" id="cpf" class="mascara-cpf">
                <h6 class="msg-input"></h6>
            </div>
            <div class="label-small">
                <h4 class="input-title">SEXO</h4>
                <select name="sexo" id="sexo" class="input-standard">
                    <option value="">- Selecione -</option>
                    <option value="masculino">Masculino</option>
                    <option value="feminino">Feminino</option>
                </select>
                <h6 class="msg-input msg-input-sexo"></h6>
            </div>
            <div class="label-small">
                <h4 class="input-title">Data de nascimento</h4>
                <input type="date" name="data_nascimento" id="dataNascimento" class="input-standard">
                <h6 class="msg-input"></h6>
            </div>
            <div class="label-small">
                <button class="botao-continuar" type="button">ATUALIZAR <i class="fas fa-check icone"></i></button>
            </div>
        </div>
        <div class="painel" id="displayPainel2">
            Painel 2
        </div>
        <div class="painel" id="displayPainel3">
            Painel 3
        </div>
    </div>
    <div class="bottom">
        <button class="botao-voltar" title="Voltar para a página"><i class="fas fa-chevron-circle-left"></i></button>
    </div>
</section>

<script>
    $(document).ready(function(){
        var displayPaineis = $(".display-paineis");
        var botoes = $(".top-buttons");
        var paineis = displayPaineis.children(".painel");
        
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
    });
</script>