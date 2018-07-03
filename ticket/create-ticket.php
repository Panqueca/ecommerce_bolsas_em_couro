<style>
    .container-ticket{
        width: 60%;
        margin: 0 auto;
    }
    .container-ticket article{
        font-weight: bold;
    }
    .container-ticket label{
        font-size: 14px;   
    }
    .container-ticket .inputs{
        padding: 10px;
        margin: 10px;
    }
    .container-ticket .submit-field{
        text-align: right;
    }
    .container-ticket .submit-field .submit-button{
        background-color: #6abd45;
        color: #fff;
        border: none;
        padding: 10px 15px 10px 15px;
        border-radius: 3px;
        cursor: pointer;
    }
</style>
<script>
    $(document).ready(function(){
        CKEDITOR.replace("sendTicketTxtArea");
        
        var enviandoForm = false;
        $("#jsFormSendTicket").off().on("submit", function(event){
            event.preventDefault(); 
            if(!enviandoForm){
                enviandoForm = true;
                var form = $(this);
                var assunto = $("#jsTopicTicket").val();
                var descricao = CKEDITOR.instances["sendTicketTxtArea"].getData();

                function validar(){
                    if(assunto.length < 5){
                        mensagemAlerta("O campo assunto deve conter no mínimo 5 caracteres", $("#jsTopicTicket"));
                        return false;
                    }
                    if($(descricao).text().length < 20){
                        mensagemAlerta("O campo descrição deve conter no mínimo 20 caracteres");
                        return false;
                    }
                    return true;
                }

                if(validar()){
                    form.unbind("submit").submit();
                }else{
                    enviandoForm = false;
                }
            }
            
        });
    });
</script>
<h1 align=center>Adicionar Ticket</h1>
<?php
$emailSessao = null;
$senhaSessao = null;
$cls_conta = new MinhaConta();
if(isset($_SESSION["minha_conta"])){
    $emailSessao = $_SESSION["minha_conta"]["email"];
    $senhaSessao = $_SESSION["minha_conta"]["senha"];
}

if($cls_conta->auth($emailSessao, $senhaSessao)){
?>
<div class="container-ticket">
    <article>Como podemos lhe ajudar?</article>
    <form action="ticket/salvar/" method="post" id="jsFormSendTicket" enctype="multipart/form-data">
        <label>
            Departamento
            <select name="departamento" class='inputs'>
                <option>Entregas</option>
                <option>Trocas e Devoluções</option>
                <option>Financeiro</option>
                <option>Serviços</option>
                <option>Outros</option>
            </select>
        </label>
        <label>
            Prioridade
            <select name="prioridade" class='inputs'>
                <option value="0">Normal</option>
                <option value="1">Média</option>
                <option value="2">Urgente</option>
            </select>
        </label>
        <label>
            <input type="text" name="assunto" class="inputs" placeholder="Assunto" id="jsTopicTicket">
        </label>
        <textarea id="sendTicketTxtArea" name="mensagem" required></textarea>
        <label>
            Imagens:
            <input type="file" accept="image/*" name="imagens[]" multiple>
        </label>
        <div class="submit-field">
            <input type="submit" value="Enviar" class="submit-button js-submit-ticket">
        </div>
    </form>
    <br><br>
    <center><a href='ticket/' class="link-padrao">Voltar</a></center>
    <br><br>
</div>
<?php
}else{
    echo "<h3 align=center>Faça login para continuar</h3>";
}
?>