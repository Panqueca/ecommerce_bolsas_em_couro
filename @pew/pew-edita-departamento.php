<?php
    $post_fileds = array("id_departamento");
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
        $idDepartamento = $_POST["id_departamento"];
        require_once "pew-system-config.php";
        $tabela_departamentos = $pew_custom_db->tabela_departamentos;
        $contarDepartamento = mysqli_query($conexao, "select count(id) as total_departamento from $tabela_departamentos where id = '$idDepartamento'");
        $contagem = mysqli_fetch_assoc($contarDepartamento);
        $totalDepartamento = $contagem["total_departamento"];
        if($totalDepartamento > 0){
            $queryDepartamento = mysqli_query($conexao, "select * from $tabela_departamentos where id = '$idDepartamento'");
            $departamento = mysqli_fetch_array($queryDepartamento);
            $titulo = $departamento["departamento"];
            $descricao = $departamento["descricao"];
            $posicao = $departamento["posicao"];
            $dataControle = pew_inverter_data(substr($departamento["data_controle"], 0, 10));
            $status = $departamento["status"] == 1 ? "Ativo" : "Desativado";
            echo "<h2 class=titulo-edita>Informações do departamento</h2>";
            echo "<form id='formUpdateDepartamento'>";
                echo "<input type='hidden' name='id_departamento' id='idDepartamento' value='$idDepartamento'>";
                echo "<div class='label-full'>";
                    echo "<h3 class='input-title'>Título</h3>";
                    echo "<input type='text' class='input-full' placeholder='Título do departamento' name='titulo' id='tituloDepartamento' value='$titulo' maxlength='35'>";
                echo "</div>";
                echo "<div class='label-full'>";
                    echo "<h3 class='input-title'>Descrição (opcional)</h3>";
                    echo "<textarea class='input-full' placeholder='Descrição do departamento' name='descricao' id='descricaoDepartamento'>$descricao</textarea>";
                echo "</div>";
                echo "<div class='label-medium'>";
                    echo "<h3 class='input-title'>Posição</h3>";
                    echo "<input type='number' class='input-full' name='posicao' id='posicaoDepartamento' placeholder='Posição' value='$posicao'>";
                echo "</div>";
                echo "<div class='label-medium'>";
                    echo "<h3 class='input-title'>Status</h3>";
                    echo "<select class='input-full' name='status' id='statusDepartamento'>";
                        $possibleStatus = array("Ativo", "Desativado");
                        foreach($possibleStatus as $optionStatus){
                            $selected = $optionStatus == $status ? "selected" : "";
                            $value = $optionStatus == "Ativo" ? 1 : 0;
                            echo "<option $selected value='$value'>$optionStatus</option>";
                        }
                    echo "</select>";
                echo "</div>";
                echo "<div class='label-medium'>";
                    echo "<h3 class='input-full'>Última modificação: $dataControle</h3>";
                echo "</div>";
                echo "<div class='label-full'>";
                    echo "<input type='button' class='btn-excluir botao-acao' pew-acao='deletar' pew-id-departamento='$idDepartamento' value='Excluir'>";
                    echo "<input type='submit' class='btn-submit' value='Atualizar'>";
                echo "</div>";
            echo "</form>";
            echo "<br style='clear: both;'>";
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
        var formUpdate = $("#formUpdateDepartamento");
        formUpdate.off().on("submit", function(){
            event.preventDefault();
            var objId = $("#idDepartamento");
            var objTitulo = $("#tituloDepartamento");
            var objDescricao = $("#descricaoDepartamento");
            var objPosicao = $("#posicaoDepartamento");
            var objStatus = $("#statusDepartamento");
            var idDepartamento = objId.val();
            var titulo = objTitulo.val();
            var descricao = objDescricao.val();
            var posicao = objPosicao.val();
            var status = objStatus.val();
            if(titulo.length < 3){
                mensagemAlerta("O campo Título deve conter no mínimo 3 caracteres.", objTitulo);
                return false;
            }
            var msgErro = "Não foi possível atualizar o departamento. Recarregue a página e tente novamente.";
            var msgSucesso = "O Departamento foi atualizado com sucesso!";
            $.ajax({
                type: "POST",
                url: "pew-update-departamento.php",
                data: {id_departamento: idDepartamento, titulo: titulo, descricao: descricao, posicao: posicao, status: status},
                error: function(){
                    mensagemAlerta(msgErro);
                },
                success: function(resposta){
                    if(resposta == "true"){
                        mensagemAlerta(msgSucesso, false, "#259e25", "pew-departamentos.php?focus="+titulo);
                    }else{
                        mensagemAlerta(msgErro);
                    }
                }
            });
        });
        $(".botao-acao").each(function(){
            var botao = $(this);
            var acao = botao.attr("pew-acao");
            var idDepartamento = botao.attr("pew-id-departamento");
            var msgErro = "Não foi possível excluir o departamento. Recarregue a página e tente novamente.";
            var msgSucesso = "O Departamento foi excluido com sucesso!";
            function excluir(){
                $.ajax({
                    type: "POST",
                    url: "pew-deleta-departamento.php",
                    data: {id_departamento: idDepartamento, acao: acao},
                    error: function(){
                        mensagemAlerta(msgErro);
                    },
                    success: function(resposta){
                        console.log(resposta);
                        if(resposta == "true"){
                            mensagemAlerta(msgSucesso, false,"#259e25", "pew-departamentos.php");
                        }else{
                            mensagemAlerta(msgErro);
                        }
                    }
                });
            }
            botao.off().on("click", function(){
                mensagemConfirma("Você tem certeza que deseja excluir este departamento?", excluir);
            });
        });
    });
</script>
