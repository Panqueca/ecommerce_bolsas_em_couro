<?php
if(isset($_POST["id_categoria"])){
    $idCategoria = $_POST["id_categoria"];
?>
<h2 class=titulo-edita>Cadastrar subcategoria</h2>
<form id='formCadCategoria'>
    <input type="hidden" value="<?php echo $idCategoria;?>" id="idCategoria">
    <div class='label-full'>
        <h3 class="input-title">Título</h3>
        <input type='text' class='input-full' placeholder='Título da subcategoria' name='titulo' id='titulSubcategoria' maxlength='35'>
    </div>
    <div class='label-full'>
        <h3 class="input-title">Descrição (opcional, recomendado 156 caracteres)</h3>
        <textarea class='input-full' placeholder='Descrição da subcategoria SEO Google' name='descricao' id='descricaoSubcategoria'></textarea>
    </div>
    <input type='submit' class='btn-submit' value='Cadastrar'>
    <br style="clear: both;"><br style="clear: both;">
</form>
<?php
}else{
    echo "<h3 align=center><br>Ocorreu um erro ao carregar os dados. Recarregue a página e tente novamente.</h3>";
}
?>
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
        var formCadastra = $("#formCadCategoria");
        $("#titulSubcategoria").focus();
        formCadastra.off().on("submit", function(){
            event.preventDefault();
            var objTitulo = $("#titulSubcategoria");
            var objDescricao = $("#descricaoSubcategoria");
            var idCategoria = $("#idCategoria").val();
            var titulo = objTitulo.val();
            var descricao = objDescricao.val();
            if(titulo.length < 3){
                mensagemAlerta("O campo Título deve conter no mínimo 3 caracteres.", objTitulo);
                return false;
            }
            var msgErro = "Não foi possível cadastrar a subcategoria. Recarregue a página e tente novamente.";
            var msgSucesso = "A Subcategoria foi cadastrada com sucesso!";
            $.ajax({
                type: "POST",
                url: "pew-grava-subcategoria.php",
                data: {id_categoria: idCategoria, titulo: titulo, descricao: descricao},
                error: function(){
                    mensagemAlerta(msgErro);
                },
                success: function(resposta){
                    if(resposta == "true"){
                        mensagemAlerta(msgSucesso, false, "#259e25", "pew-categorias.php?subfocus="+titulo+"&id_categoria="+idCategoria);
                    }else{
                        mensagemAlerta(msgErro);
                    }
                }
            });
        });
    });
</script>
