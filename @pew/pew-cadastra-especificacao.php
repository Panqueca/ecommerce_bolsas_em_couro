<h2 class=titulo-edita>Cadastrar especificação</h2>
<form id='formCadEspecificacao' method="post" action="pew-grava-especificacao.php">
    <div class='label-full'>
        <h3 class="input-title">Título</h3>
        <input type='text' class='input-full' placeholder='Título da Especificacao' name='titulo' id='tituloEspecificacao' maxlength='35'>
    </div>
    <input type='submit' class='btn-submit' value='Cadastrar'>
    <br style="clear: both;">
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
