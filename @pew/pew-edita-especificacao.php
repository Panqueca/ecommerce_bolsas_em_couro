<?php
    $post_fileds = array("id_especificacao");
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
        $idEspecificacao = $_POST["id_especificacao"];
        require_once "pew-system-config.php";
        $tabela_especificacoes = $pew_custom_db->tabela_especificacoes;
        $contar = mysqli_query($conexao, "select count(id) as total from $tabela_especificacoes where id = '$idEspecificacao'");
        $contagem = mysqli_fetch_assoc($contar);
        $total = $contagem["total"];
        if($total > 0){
            $queryEspecificacao = mysqli_query($conexao, "select * from $tabela_especificacoes where id = '$idEspecificacao'");
            $especificacao = mysqli_fetch_array($queryEspecificacao);
            $titulo = $especificacao["titulo"];
            $dataControle = $pew_functions->inverter_data(substr($especificacao["data_controle"], 0, 10));
            $status = $especificacao["status"] == 1 ? "Ativa" : "Desativada";
            echo "<h2 class='titulo-edita'>Informações da especificacão</h2>";
            echo "<form id='formUpdateEspecificacao' method='post' action='pew-update-especificacao.php'>";
                echo "<input type='hidden' name='id_especificacao' id='idEspecificacao' value='$idEspecificacao'>";
                echo "<div class='label half'>";
                    echo "<h3 class='label-title'>Título</h3>";
                    echo "<input type='text' class='label-input' placeholder='Título da especificação' name='titulo' id='tituloEspecificacao' value='$titulo' maxlength='35'>";
                echo "</div>";
                echo "<div class='label small'>";
                    echo "<h3 class='label-title'>Status</h3>";
                    echo "<select name='status' id='statusEspecificacao' class='label-input'>";
                        $possibleStatus = array("Ativa", "Desativada");
                        foreach($possibleStatus as $optionStatus){
                            $selected = $optionStatus == $status ? "selected" : "";
                            $value = $optionStatus == "Ativa" ? 1 : 0;
                            echo "<option $selected value='$value'>$optionStatus</option>";
                        }
                    echo "</select>";
                echo "</div>";
                echo "<div class='label full'>";
                    echo "<h3>Última modificação: $dataControle</h3>";
                echo "</div>";
                echo "<div class='group clear'>";
                    echo "<div class='label small'>";
                        echo "<input type='button' class='btn-excluir botao-acao label-input' pew-acao='deletar' pew-id-especificacao='$idEspecificacao' value='Excluir'>";
                    echo "</div>";
                    echo "<div class='label small'>";
                        echo "<input type='submit' class='btn-submit label-input' value='Atualizar'>";
                    echo "</div>";
                echo "</div>";
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
        var formUpdate = $("#formUpdateEspecificacao");
        var atualizando = false;
        formUpdate.off().on("submit", function(){
            event.preventDefault();
            if(!atualizando){
                atualizando = true;
                var objTitulo = $("#tituloEspecificacao");
                var titulo = objTitulo.val();
                if(titulo.length < 2){
                    mensagemAlerta("O campo Título deve conter no mínimo 2 caracteres.", objTitulo);
                    atualizando = false;
                    return false;
                }
                formUpdate.submit();
            }
        });
        $(".botao-acao").each(function(){
            var botao = $(this);
            var acao = botao.attr("pew-acao");
            var idEspecificacao = botao.attr("pew-id-especificacao");
            var msgErro = "Não foi possível excluir a especificacao. Recarregue a página e tente novamente.";
            var msgSucesso = "A especificacao foi excluida com sucesso!";
            function excluir(){
                $.ajax({
                    type: "POST",
                    url: "pew-deleta-especificacao.php",
                    data: {id_especificacao: idEspecificacao, acao: acao},
                    error: function(){
                        mensagemAlerta(msgErro);
                    },
                    success: function(resposta){
                        console.log(resposta);
                        if(resposta == "true"){
                            mensagemAlerta(msgSucesso, false,"#259e25", "pew-especificacoes.php");
                        }else{
                            mensagemAlerta(msgErro);
                        }
                    }
                });
            }
            botao.off().on("click", function(){
                mensagemConfirma("Você tem certeza que deseja excluir esta especificação?", excluir);
            });
        });
    });
</script>
