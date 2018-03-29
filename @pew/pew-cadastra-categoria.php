<h2 class=titulo-edita>Cadastrar categoria</h2>
<form id='formCadCategoria'>
    <div class='label full'>
        <h3 class="label-title">Título</h3>
        <input type='text' class='label-input' placeholder='Título da categoria' name='titulo' id='tituloCategoria' maxlength='35'>
    </div>
    <div class='label full clear'>
        <h3 class="label-title">Descrição (opcional, recomendado 156 caracteres)</h3>
        <textarea class='label-textarea' placeholder='Descrição da categoria SEO Google' name='descricao' id='descricaoCategoria' rows="3"></textarea>
    </div>
    <div class="label small">
        <input type='submit' class='btn-submit label-input' value='Cadastrar'>
    </div>
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
        var formCadastra = $("#formCadCategoria");
        $("#tituloCategoria").focus();
        formCadastra.off().on("submit", function(){
            event.preventDefault();
            var objTitulo = $("#tituloCategoria");
            var objDescricao = $("#descricaoCategoria");
            var titulo = objTitulo.val();
            var descricao = objDescricao.val();
            if(titulo.length < 3){
                mensagemAlerta("O campo Título deve conter no mínimo 3 caracteres.", objTitulo);
                return false;
            }
            var msgErro = "Não foi possível cadastrar a categoria. Recarregue a página e tente novamente.";
            var msgSucesso = "A Categoria foi cadastrada com sucesso!";
            $.ajax({
                type: "POST",
                url: "pew-grava-categoria.php",
                data: {titulo: titulo, descricao: descricao},
                error: function(){
                    mensagemAlerta(msgErro);
                },
                success: function(resposta){
                    if(resposta == "true"){
                        mensagemAlerta(msgSucesso, false, "#259e25", "pew-categorias.php?focus="+titulo);
                    }else{
                        mensagemAlerta(msgErro);
                    }
                }
            });
        });
    });
</script>
