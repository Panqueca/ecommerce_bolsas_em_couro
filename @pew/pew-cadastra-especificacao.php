<h2 class=titulo-edita>Cadastrar especificação</h2>
<form id='formCadEspecificacao' method="post" action="pew-grava-especificacao.php">
    <div class='label half'>
        <h3 class="label-title">Título</h3>
        <input type='text' class='label-input' placeholder='Título da Especificacao' name='titulo' id='tituloEspecificacao' maxlength='35'>
    </div>
    <div class='label small clear'>
        <input type='submit' class='btn-submit label-input' value='Cadastrar'>
    </div>
</form>
<style>
    .titulo-edita{
        width: 100%;
        padding-top: 10px;
        padding-bottom: 10px;
        background-color: #eee;
        color: #f78a14;
    }
</style>
<script>
    $(document).ready(function(){
        var formCadastra = $("#formCadEspecificacao");
        $("#tituloEspecificacao").focus();
        var cadastrando = false;
        formCadastra.off().on("submit", function(){
            event.preventDefault();
            var objTitulo = $("#tituloEspecificacao");
            var titulo = objTitulo.val();
            if(titulo.length < 2){
                mensagemAlerta("O campo Título deve conter no mínimo 2 caracteres.", objTitulo);
                cadastrando = false;
                return false;
            }
            if(!cadastrando){
                cadastrando = true;
                formCadastra.submit();
            }
        });
    });
</script>
