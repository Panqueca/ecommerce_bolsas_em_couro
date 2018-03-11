<?php
    $post_fileds = array("id_categoria");
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
        $idCategoria = $_POST["id_categoria"];
        require_once "pew-system-config.php";
        $tabela_categorias = $pew_db->tabela_categorias;
        $contarCategoria = mysqli_query($conexao, "select count(id) as total_categoria from $tabela_categorias where id = '$idCategoria'");
        $contagem = mysqli_fetch_assoc($contarCategoria);
        $totalCategoria = $contagem["total_categoria"];
        if($totalCategoria > 0){
            $queryCategoria = mysqli_query($conexao, "select * from $tabela_categorias where id = '$idCategoria'");
            $categoria = mysqli_fetch_array($queryCategoria);
            $titulo = $categoria["categoria"];
            $descricao = $categoria["descricao"];
            $dataControle = pew_inverter_data(substr($categoria["data_controle"], 0, 10));
            $status = $categoria["status"] == 1 ? "Ativa" : "Desativada";
            echo "<h2 class=titulo-edita>Informações da categoria</h2>";
            echo "<form id='formUpdateCategoria'>";
                echo "<input type='hidden' name='id_categoria' id='idCategoria' value='$idCategoria'>";
                echo "<div class='label-full'>";
                    echo "<h3 class='input-title'>Título</h3>";
                    echo "<input type='text' class='input-full' placeholder='Título da categoria' name='titulo' id='tituloCategoria' value='$titulo' maxlength='35'>";
                echo "</div>";
                echo "<div class='label-full'>";
                    echo "<h3 class='input-title'>Descrição (opcional, recomendado 156 caracteres)</h3>";
                    echo "<textarea class='input-full' placeholder='Descrição da categoria SEO Google' name='descricao' id='descricaoCategoria'>$descricao</textarea>";
                echo "</div>";
                echo "<div class='label-full'>";
                    echo "<h3 class='input-title'>Status</h3>";
                    echo "<select name='status' id='statusCategoria' class='input-small'>";
                        $possibleStatus = array("Ativa", "Desativada");
                        foreach($possibleStatus as $optionStatus){
                            $selected = $optionStatus == $status ? "selected" : "";
                            $value = $optionStatus == "Ativa" ? 1 : 0;
                            echo "<option $selected value='$value'>$optionStatus</option>";
                        }
                    echo "</select>";
                echo "</div>";
                echo "<h3 class='input-full'>Última modificação: $dataControle</h3>";
                echo "<input type='button' class='btn-excluir botao-acao' pew-acao='deletar' pew-id-categoria='$idCategoria' value='Excluir'>";
                echo "<input type='submit' class='btn-submit' value='Atualizar'>";
            echo "</form>";
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
        border-bottom: 1px solid #f78a14;
        border-top: 1px solid #f78a14;
        margin-bottom: 20px;
    }
</style>
<script>
    $(document).ready(function(){
        var formUpdate = $("#formUpdateCategoria");
        formUpdate.off().on("submit", function(){
            event.preventDefault();
            var objId = $("#idCategoria");
            var objTitulo = $("#tituloCategoria");
            var objDescricao = $("#descricaoCategoria");
            var objStatus = $("#statusCategoria");
            var idCategoria = objId.val();
            var titulo = objTitulo.val();
            var descricao = objDescricao.val();
            var status = objStatus.val();
            if(titulo.length < 3){
                mensagemAlerta("O campo Título deve conter no mínimo 3 caracteres.", objTitulo);
                return false;
            }
            var msgErro = "Não foi possível atualizar a categoria. Recarregue a página e tente novamente.";
            var msgSucesso = "A Categoria foi atualizada com sucesso!";
            $.ajax({
                type: "POST",
                url: "pew-update-categoria.php",
                data: {id_categoria: idCategoria, titulo: titulo, descricao: descricao, status: status},
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
        $(".botao-acao").each(function(){
            var botao = $(this);
            var acao = botao.attr("pew-acao");
            var idCategoria = botao.attr("pew-id-categoria");
            var msgErro = "Não foi possível excluir a categoria. Recarregue a página e tente novamente.";
            var msgSucesso = "A categoria foi excluida com sucesso!";
            function excluir(){
                $.ajax({
                    type: "POST",
                    url: "pew-deleta-categoria.php",
                    data: {id_categoria: idCategoria, acao: acao},
                    error: function(){
                        mensagemAlerta(msgErro);
                    },
                    success: function(resposta){
                        console.log(resposta);
                        if(resposta == "true"){
                            mensagemAlerta(msgSucesso, false,"#259e25", "pew-categorias.php");
                        }else{
                            mensagemAlerta(msgErro);
                        }
                    }
                });
            }
            botao.off().on("click", function(){
                mensagemConfirma("Você tem certeza que deseja excluir esta categoria?", excluir);
            });
        });
    });
</script>
