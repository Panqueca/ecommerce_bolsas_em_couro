<h2 class=titulo-edita>Cadastrar categoria destaque</h2>
<form id='formCadCategoria'>
    <div class='label-half'>
        <h3 class="input-title">Categoria</h3>
        <select class="input-full" name="info_categoria" id="infoCategoria">
            <option value="">- Selecione -</option>
            <?php
                require_once "pew-system-config.php";
                $tabela_categorias = $pew_db->tabela_categorias;
                $queryCategorias = mysqli_query($conexao, "select id, categoria from $tabela_categorias where status = 1 order by categoria");
                while($infoCategorias = mysqli_fetch_array($queryCategorias)){
                    $idCategoria = $infoCategorias["id"];
                    $tituloCategoria = $infoCategorias["categoria"];
                    echo "<option value='$idCategoria||$tituloCategoria' data-id-categoria='$idCategoria'>$tituloCategoria</option>";
                }
            ?>
        </select>
        <h4 style="color: red; display: none;" id="mensagemCadastro">Esta categoria já está ativa.</h4>
    </div>
    <div class='label-half'>
        <h3 class="input-title">Imagem da categoria (500px : 400px)</h3>
        <input type='file' class='input-full' name='imagem' id='imagemCategoria' accept="image/*" required>
    </div>
    <br style="clear: both;">
    <div class='label-full'>
        <h3>Selecionar esta categoria como ativa?</h3>
        <select name="status">
            <option value="1">Sim</option>
            <option value="0">Não</option>
        </select>
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
        var cadastrar = true;
        $("#infoCategoria").off().on("change", function(){
            var idCategoria = null;
            $("#infoCategoria option").each(function(){
                if($(this).prop("selected") == true){
                    idCategoria = $(this).attr("data-id-categoria");
                }
            });
            var urlValida = "pew-valida-categoria-destaque.php";
            $.ajax({
                type: "POST",
                url: urlValida,
                data: {id_categoria: idCategoria},
                success: function(resposta){
                    if(resposta == "false"){
                        $("#mensagemCadastro").css("display", "block");
                        cadastrar = false;
                    }else{
                        $("#mensagemCadastro").css("display", "none");
                        cadastrar = true;
                    }
                },
            });
        })
        var formCadastra = $("#formCadCategoria");
        formCadastra.off().on("submit", function(){
            event.preventDefault();
            if(cadastrar){
                var formulario = new FormData($(this)[0]);
                var objInfoCategoria = $("#infoCategoria");
                var infoCategoria = objInfoCategoria.val();
                if(infoCategoria == ""){
                    mensagemAlerta("Deve ser selecionada uma categoria", objInfoCategoria);
                    return false;
                }
                var msgErro = "Não foi possível adicionar a categoria. Recarregue a página e tente novamente.";
                var msgSucesso = "A Categoria foi adicionada com sucesso!";
                $.ajax({
                    type: "POST",
                    url: "pew-grava-categoria-destaque.php",
                    data: formulario,
                    processData: false,
                    contentType: false,
                    error: function(){
                        mensagemAlerta(msgErro);
                    },
                    success: function(resposta){
                        console.log(resposta);
                        if(resposta == "true"){
                            mensagemAlerta(msgSucesso, false, "#259e25", "pew-categoria-destaque.php");
                        }else{
                            mensagemAlerta(msgErro);
                        }
                    }
                });
            }else{
                mensagemAlerta("A categoria selecionada já está ativa. Selecione outra categoria.", objInfoCategoria);
            }
        });
    });
</script>
