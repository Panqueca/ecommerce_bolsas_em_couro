<?php
    $post_fileds = array("id_destaque", "departamento");
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
        $idDestaque = $_POST["id_destaque"];
        $departamento = $_POST["departamento"];
        require_once "pew-system-config.php";
        $tabela_destaques = $departamento == "produto" ? $pew_custom_db->tabela_produtos_destaque : $pew_custom_db->tabela_colecao_destaque;
        $contarDestaque = mysqli_query($conexao, "select count(id) as total from $tabela_destaques where id = '$idDestaque'");
        $contagem = mysqli_fetch_assoc($contarDestaque);
        $total = $contagem["total"];
        if($total > 0){
            $queryDestaque = mysqli_query($conexao, "select * from $tabela_destaques where id = '$idDestaque'");
            $destaque = mysqli_fetch_array($queryDestaque);
            $titulo = $destaque["titulo"];
            $dataControle = pew_inverter_data(substr($destaque["data_controle"], 0, 10));
            $status = $destaque["status"] == 1 ? "Ativa" : "Desativada";
            echo "<h2 class=titulo-edita>Informações da categoria</h2>";
            echo "<form id='formUpdateCategoria'>";
                echo "<input type='hidden' name='id_destaque' id='idDestaque' value='$idDestaque'>";
                echo "<div class='label-full'>";
                    echo "<h3 class='input-title'>$titulo</h3>";
                echo "</div>";
                echo "<div class='label-full'>";
                    echo "<h3 class='input-title'>Descrição (opcional)</h3>";
                    echo "<textarea class='input-full' placeholder='Descrição da categoria' name='descricao' id='descricaoCategoria'>$descricao</textarea>";
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
                echo "<input type='button' class='btn-excluir botao-acao' pew-acao='deletar' pew-id-categoria='$idDestaque' value='Excluir'>";
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
            var objId = $("#idDestaque");
            var objTitulo = $("#tituloCategoria");
            var objDescricao = $("#descricaoCategoria");
            var objStatus = $("#statusCategoria");
            var idDestaque = objId.val();
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
                data: {id_destaque: idDestaque, titulo: titulo, descricao: descricao, status: status},
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
            var idDestaque = botao.attr("pew-id-categoria");
            var msgErro = "Não foi possível excluir a categoria. Recarregue a página e tente novamente.";
            var msgSucesso = "A categoria foi excluida com sucesso!";
            function excluir(){
                $.ajax({
                    type: "POST",
                    url: "pew-deleta-categoria.php",
                    data: {id_destaque: idDestaque, acao: acao},
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
