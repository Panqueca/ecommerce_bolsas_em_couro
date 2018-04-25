<h2 class=titulo-edita>Cadastrar departamento</h2>
<form id='formCadDepartamento' method="post" action="pew-grava-departamento.php" enctype="multipart/form-data">
    <div class='medium'>
        <h3 class='label-title'>Título</h3>
        <input type='text' class='label-input' placeholder='Título do departamento' name='titulo' id='tituloDepartamento' maxlength='35'>
    </div>
    <div class='half'>
        <h3 class='label-title'>Imagem (1280px : 570px)</h3>
        <input type="file" name="imagem" accept="image/*" class="label-input">
    </div>
    <div class='label xlarge'>
        <h3 class='label-title'>Descrição</h3>
        <textarea class='label-textarea' placeholder='Descrição do departamento' name='descricao' id='descricaoDepartamento'></textarea>
    </div>
    <div class='label xsmall'>
        <h3 class='label-title'>Posição</h3>
        <input type="number" class="label-input" name="posicao" id="posicaoDepartamento" placeholder="Posição" style="margin-top: 10px;">
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
        border-bottom: 1px solid #f78a14;
        border-top: 1px solid #f78a14;
        margin-bottom: 20px;
    }
</style>
<script>
    $(document).ready(function(){
        var formCadastra = $("#formCadDepartamento");
        $("#tituloDepartamento").focus();
        var cadastrando = false;
        formCadastra.off().on("submit", function(){
            event.preventDefault();
            if(!cadastrando){
                cadastrando = true;
                var objTitulo = $("#tituloDepartamento");
                var objDescricao = $("#descricaoDepartamento");
                var objPosicao = $("#posicaoDepartamento");
                var titulo = objTitulo.val();
                var descricao = objDescricao.val();
                var posicao = objPosicao.val();
                if(titulo.length < 3){
                    mensagemAlerta("O campo Título deve conter no mínimo 3 caracteres.", objTitulo);
                    return false;
                }

                formCadastra.submit();
            }
        });
    });
</script>
