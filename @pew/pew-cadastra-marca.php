<h2 class=titulo-edita>Cadastrar marca</h2>
<form id='formCadMarca' method="post" action="pew-grava-marca.php" enctype="multipart/form-data">
    <div class='label full'>
        <h3 class="label-title">Título</h3>
        <input type='text' class='label-input' placeholder='Título da Marca' name='titulo' id='tituloMarca' maxlength='35'>
    </div>
    <div class='label full'>
        <h3 class="label-title">Descrição (opcional, recomendado 156 caracteres)</h3>
        <textarea class='label-textarea' placeholder='Descrição da Marca' name='descricao' id='descricaoMarca'></textarea>
    </div>
    <div class='label full'>
        <h3 class='label-title'>Imagem (300px : 300px)</h3>
        <input type='file' class='label-input' name='imagem' accept='image/*'>
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
        var formCadastra = $("#formCadMarca");
        $("#tituloMarca").focus();
        var cadastrando = false;
        formCadastra.off().on("submit", function(){
            event.preventDefault();
            var objTitulo = $("#tituloMarca");
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
