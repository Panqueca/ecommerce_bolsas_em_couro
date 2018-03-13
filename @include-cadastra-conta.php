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
    }
    .section-cadastra .display-cadastra{
        width: 80%;
        margin: 0 auto;
    }
    .section-cadastra .titulo-cadastre{
        margin: 0px;
        padding: 20px 0px 20px 0px;
        font-size: 32px;
        border-bottom: 1px solid #ccc;
        display: block;
    }
    .section-cadastra .descricao-cadastre{
        font-weight: normal;
    }
    .section-cadastra .display-formularios{
        position: relative;
        width: 80%;
        height: 50vh;
        margin: 0 auto;
        margin-top: 40px;
        padding-bottom: 40px;
        -webkit-box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);
        -moz-box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);
        box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);
        overflow-y: auto;
        overflow-x: hidden;
    }
    .display-formularios::-webkit-scrollbar-button:hover{
        background-color: #AAA;
    }
    .display-formularios::-webkit-scrollbar-thumb{
        background-color: #ccc;
    }
    .display-formularios::-webkit-scrollbar-thumb:hover{
        background-color: #999;
    }
    .display-formularios::-webkit-scrollbar-track{
        background-color: #efefef;
    }
    .display-formularios::-webkit-scrollbar-track:hover{
        background-color: #efefef;
    }
    .display-formularios::-webkit-scrollbar{
        width: 3px;
        height: 3px;
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
        height: 40px;
        background-color: #fff;
        border: none;
        cursor: pointer;
        outline: none;
        width: 50%;
        color: #999;
    }
    .section-cadastra .display-formularios .top-buttons:hover{
        background-color: #f1f1f1;
    }
    .section-cadastra .display-formularios .selected-button{   
        border-bottom: 2px solid green;
        color: green;
    }
    .section-cadastra .display-formularios .formulario-cadastro{
        position: relative;
        width: auto;
        margin: 10px 30px 10px 30px;
        text-align: left;
    }
    .section-cadastra .display-formularios .formulario-cadastro .label-half{
        width: 45%;
        margin: 20px 2.5% 20px 2.5%;
        float: left;
    }
    .section-cadastra .display-formularios .formulario-cadastro .label-small{
        width: 20%;
        margin: 20px 2.5% 20px 2.5%;
        float: left;
    }
    .section-cadastra .display-formularios .formulario-cadastro .input-title{
        font-size: 14px;
        margin: 0px;
        text-align: left;
        color: #666;
    }
    .section-cadastra .display-formularios .formulario-cadastro input{
        width: 95%;
        height: 30px;
        margin-top: 5px;
        margin-bottom: 1px;
        padding: 0px 2.5% 0px 2.5%;
        border: 1px solid #ccc;
        outline: none;
    }
    .section-cadastra .display-formularios .formulario-cadastro input:focus{
        border-bottom: 2px solid #ccc; 
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
</style>
<div class="section-cadastra">
    <div class="display-cadastra">
        <h3 class="titulo-cadastre">SE CADASTRE</h3>
        <h5 class="descricao-cadastre">
            <p>
                É um fato conhecido de todos que um leitor se distrairá com o conteúdo de texto legível de uma página quando estiver examinando sua diagramação.
            </p>
            <p>
                Existem muitas variações disponíveis de passagens de Lorem Ipsum, mas a maioria sofreu algum tipo de alteração.
            </p>
        </h5>
        <div class="display-formularios">
            <div class="display-buttons">
                <button class="top-buttons selected-button">INFORMAÇÕES DE CONTATO</button>
                <button class="top-buttons">ENDEREÇOS</button>
            </div>
            <form class="formulario-cadastro" name="formulario_cadastro">
                <div class="display-info-contato">
                    <div class="label-half">
                        <h4 class="input-title">Nome Completo</h4>
                        <input type="text" placeholder="Nome Completo">
                    </div>
                    <div class="label-half">
                        <h4 class="input-title">E-mail</h4>
                        <input type="text" placeholder="contato@bolsasemcouro.com.br">
                    </div>
                    <div class="label-small">
                        <h4 class="input-title">Senha</h4>
                        <input type="text" placeholder="Senha">
                    </div>
                    <div class="label-small">
                        <h4 class="input-title">Confirmar Senha</h4>
                        <input type="text" placeholder="Senha">
                    </div>
                    <div class="label-small">
                        <h4 class="input-title">Celular</h4>
                        <input type="text" placeholder="(41) 9999-9999">
                    </div>
                    <div class="label-small">
                        <h4 class="input-title">Telefone</h4>
                        <input type="text" placeholder="(41) 3030-3030">
                    </div>
                    <div class="label-small">
                        <h4 class="input-title">CPF</h4>
                        <input type="text" placeholder="000.000.000.00">
                    </div>
                    <div class="label-small">
                        <h4 class="input-title">Data de nascimento</h4>
                        <input type="date">
                    </div>
                    <div class="label-small">
                        <button class="botao-continuar" type="button">CONTINUAR <i class="fas fa-chevron-right icone"></i></button>
                    </div>
                </div>
            </form>
        </div>
        <div class="bottom">
            <button class="botao-voltar" title="Voltar para a página"><i class="fas fa-chevron-circle-left"></i></button>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        var botaoCadastraConta = $("#botaoCadastraConta");
        var sectionCadastra = $(".section-cadastra");
        var botaoVoltar = $(".section-cadastra .botao-voltar");
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
        
        botaoCadastraConta.off().on("click", function(){
            toggleCadastreConta();
        });
        botaoVoltar.off().on("click", function(){
            toggleCadastreConta();
        });
    });
</script>