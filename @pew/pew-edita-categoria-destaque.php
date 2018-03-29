<?php
    $post_fileds = array("id_categoria_destaque");
    $invalid_fileds = array();
    $carregar = true;
    $i = 0;
    foreach($post_fileds as $post_name){
        /*Validação se todos campos foram enviados*/
        if(!isset($_POST[$post_name])){
            $carregar = false;
            $i++;
            $invalid_fileds[$i] = $post_name;
        }
    }
    function loadingError(){
        /*Se algo deu errado essa função é executada*/
        echo "<h3 align='center'>Ocorreu um erro ao carregar os dados. Recarregue a página e tente novamente.</h3>";
    }

    if($carregar){
        require_once "pew-system-config.php";
        $tabela_categoria_destaque = $pew_custom_db->tabela_categoria_destaque;
        $idCategoriaDestaque = $_POST["id_categoria_destaque"];

        $contar = mysqli_query($conexao, "select count(id) as total from $tabela_categoria_destaque where id = '$idCategoriaDestaque'");
        $contagem = mysqli_fetch_assoc($contar);
        if($contagem["total"] > 0){
            $query = mysqli_query($conexao, "select * from $tabela_categoria_destaque where id = '$idCategoriaDestaque'");
            $infoCategoriaVitrine = mysqli_fetch_array($query);
            $titulo = $infoCategoriaVitrine["titulo"];
            $status = $infoCategoriaVitrine["status"];
            $dataControle = $infoCategoriaVitrine["data_controle"];
            $imagem = $infoCategoriaVitrine["imagem"];
            $dirImagens = "../imagens/categorias/destaques/";


?>
            <h2 class=titulo-edita>Editar categoria destaque</h2>
            <form id='formUpdateCategoria'>
                <input type="hidden" name="id_categoria_destaque" id="idCategoriaVitrine" value="<?php echo $idCategoriaDestaque;?>">
                <input type="hidden" name="status" value="<?php echo $status;?>">
                <input type='hidden' name='imagem_antiga' value="<?php echo $imagem;?>">
                <div class='label half'>
                    <h3 class="label-title">Categoria</h3>
                    <select name="info_categoria" id="infoCategoria" class="label-input">
                    <?php
                        require_once "pew-system-config.php";
                        $tabela_categorias = $pew_db->tabela_categorias;
                        $queryCategorias = mysqli_query($conexao, "select id, categoria from $tabela_categorias where status = 1 order by categoria");
                        while($infoCategorias = mysqli_fetch_array($queryCategorias)){
                            $idCategoria = $infoCategorias["id"];
                            $tituloCategoria = $infoCategorias["categoria"];
                            $selected = $titulo == $tituloCategoria ? "selected" : "";
                            echo "<option value='$idCategoria||$tituloCategoria' $selected>$tituloCategoria</option>";
                        }
                    ?>
                    </select>
                </div>
                <div class='label half'>
                    <h3 class="label-title">Alterar Imagem da categoria (500px : 400px)</h3>
                    <input type='file' class='label-input' name='imagem' id='imagem' accept="image/*">
                </div>
                <div class='half'>
                    <h3 class="label-title">Imagem atual</h3>
                    <img src="<?php echo $dirImagens.$imagem;?>" class="full">
                </div>
                <div class='label small'>
                    <h3 class="label-title">Status</h3>
                    <select name="status" class="label-input">
                        <?php
                            $possibleStatus = array(0, 1);
                            foreach($possibleStatus as $optionStatus){
                                switch($optionStatus){
                                    case 1:
                                        $nameStatus = "Ativa";
                                        break;
                                    default:
                                        $nameStatus = "Desativada";
                                }
                                $selected = $optionStatus == $status ? "selected" : "";
                                echo "<option value='$optionStatus' $selected>$nameStatus</option>";
                            }
                        ?>
                    </select>
                </div>
                <div class='label half'>
                    <div class='label half'>
                        <input type='button' class='btn-excluir label-input' value='Excluir'>
                    </div>
                    <div class='label half'>
                        <input type='submit' class='btn-submit label-input' value='Atualizar'>
                    </div>
                </div>
                <br class="clear">
            </form>
<?php
        }else{
            loadingError();
        }
    }else{
        loadingError();
    }
?>
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
        var formCadastra = $("#formUpdateCategoria");
        $("#tituloCategoria").focus();
        var cadastrando = false;
        formCadastra.off().on("submit", function(){
            event.preventDefault();
            if(!cadastrando){
                cadastrando = true;
                var formulario = new FormData($(this)[0]);
                var objInfoCategoria = $("#infoCategoria");
                var infoCategoria = objInfoCategoria.val();
                if(infoCategoria == ""){
                    mensagemAlerta("Deve ser selecionada uma categoria", objInfoCategoria);
                    return false;
                }
                var msgErro = "Não foi possível atualizar a categoria. Recarregue a página e tente novamente.";
                var msgSucesso = "A Categoria foi atualizada com sucesso!";
                $.ajax({
                    type: "POST",
                    url: "pew-update-categoria-destaque.php",
                    data: formulario,
                    processData: false,
                    contentType: false,
                    error: function(){
                        mensagemAlerta(msgErro);
                        cadastrando = false;
                    },
                    success: function(resposta){
                        console.log(resposta);
                        if(resposta == "true"){
                            mensagemAlerta(msgSucesso, false, "#259e25", "pew-categoria-destaque.php");
                            cadastrando = false;
                        }else{
                            mensagemAlerta(msgErro);
                            cadastrando = false;
                        }
                    }
                });
            }
        });
        $(".btn-excluir").off().on("click", function(){
            function excluir(){
                var id = $("#idCategoriaVitrine").val();
                var msgErro = "Não foi possível remover a categoria. Recarregue a página e tente novamente.";
                var msgSucesso = "A categoria foi removida com sucesso!";
                $.ajax({
                    type: "POST",
                    url: "pew-deleta-categoria-destaque.php",
                    data: {id_categoria_destaque: id, acao: "deletar"},
                    error: function(){
                        mensagemAlerta(msgErro);
                    },
                    success: function(resposta){
                        mensagemAlerta(msgSucesso, false, "#259e25", "pew-categoria-destaque.php");
                    }
                });
            }

            mensagemConfirma("Você tem certeza que deseja remover essa categoria?", excluir);
        });
    });
</script>
