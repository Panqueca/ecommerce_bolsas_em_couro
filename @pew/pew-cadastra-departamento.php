<h2 class=titulo-edita>Cadastrar departamento</h2>
<form id='formCadDepartamento'>
    <div class='label-full'>
        <h3 class='input-title'>Título</h3>
        <input type='text' class='input-full' placeholder='Título do departamento' name='titulo' id='tituloDepartamento' maxlength='35'>
    </div>
    <div class='label-full'>
        <h3 class='input-title'>Descrição</h3>
        <textarea class='input-full' placeholder='Descrição do departamento' name='descricao' id='descricaoDepartamento'></textarea>
    </div>
    <div class='label-full'>
        <h3 class='input-title'>Posição</h3>
        <input type="number" class="input-small" name="posicao" id="posicaoDepartamento" placeholder="Posição">
    </div>
    <input type='submit' class='btn-submit' value='Cadastrar'>
    <br style="clear: both;"><br style="clear: both;">
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
        formCadastra.off().on("submit", function(){
            event.preventDefault();
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
            var msgErro = "Não foi possível cadastrar o departamento. Recarregue a página e tente novamente.";
            var msgSucesso = "O Departamento foi cadastrado com sucesso!";
            $.ajax({
                type: "POST",
                url: "pew-grava-departamento.php",
                data: {titulo: titulo, descricao: descricao, posicao: posicao},
                error: function(){
                    mensagemAlerta(msgErro);
                },
                success: function(resposta){
                    console.log(resposta)
                    if(resposta == "true"){
                        mensagemAlerta(msgSucesso, false, "#259e25", "pew-departamentos.php?focus="+titulo);
                    }else{
                        mensagemAlerta(msgErro);
                    }
                }
            });
        });
    });
</script>
