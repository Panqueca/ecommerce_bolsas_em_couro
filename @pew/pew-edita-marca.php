<?php
    $post_fileds = array("id_marca");
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
        $idMarca = $_POST["id_marca"];
        $dirImagens = "../imagens/marcas/";
        require_once "pew-system-config.php";
        $tabela_marcas = $pew_custom_db->tabela_marcas;
        $contar = mysqli_query($conexao, "select count(id) as total from $tabela_marcas where id = '$idMarca'");
        $contagem = mysqli_fetch_assoc($contar);
        $total = $contagem["total"];
        if($total > 0){
            $queryMarca = mysqli_query($conexao, "select * from $tabela_marcas where id = '$idMarca'");
            $marca = mysqli_fetch_array($queryMarca);
            $titulo = $marca["marca"];
            $descricao = $marca["descricao"];
            $imagem = $marca["imagem"];
            $dataControle = $pew_functions->inverter_data(substr($marca["data_controle"], 0, 10));
            $status = $marca["status"] == 1 ? "Ativa" : "Desativada";
            echo "<h2 class='titulo-edita'>Informações da marca</h2>";
            echo "<form id='formUpdateMarca' method='post' action='pew-update-marca.php' enctype='multipart/form-data'>";
                echo "<input type='hidden' name='id_marca' id='idMarca' value='$idMarca'>";
                echo "<div class='label full'>";
                    echo "<h3 class='label-title'>Título</h3>";
                    echo "<input type='text' class='label-input' placeholder='Título da marca' name='titulo' id='tituloMarca' value='$titulo' maxlength='35'>";
                echo "</div>";
                echo "<div class='label full'>";
                    echo "<h3 class='label-title'>Descrição (opcional, recomendado 156 caracteres)</h3>";
                    echo "<textarea class='label-input' placeholder='Descrição da marca' name='descricao' id='descricaoMarca'>$descricao</textarea>";
                echo "</div>";
                if(file_exists($dirImagens.$imagem) && $imagem != ""){
                    echo "<div class='label full'>";
                            echo "<h3 class='label-title'>Imagem atual</h3>";
                            echo "<img src=".$dirImagens.$imagem." class='label-input'>";
                            echo "<br><br><br>";
                            echo "<h3 class='label-title'>Alterar imagem (300px : 300px)</h3>";
                            echo "<input type='file' class='input-half' name='imagem' accept='image/*'>";
                        echo "</div>";
                    echo "</div>";
                }else{
                    echo "<div class='label full'>";
                        echo "<h3 class='label-title'>Imagem (300px : 300px)</h3>";
                        echo "<input type='file' class='label-input' name='imagem' accept='image/*'>";
                    echo "</div>";
                }
                echo "<div class='label small'>";
                    echo "<h3 class='label-title'>Status</h3>";
                    echo "<select name='status' id='statusMarca' class='label-input'>";
                        $possibleStatus = array("Ativa", "Desativada");
                        foreach($possibleStatus as $optionStatus){
                            $selected = $optionStatus == $status ? "selected" : "";
                            $value = $optionStatus == "Ativa" ? 1 : 0;
                            echo "<option $selected value='$value'>$optionStatus</option>";
                        }
                    echo "</select>";
                echo "</div>";
                echo "<div class='label half'>";
                    echo "<h3>Última modificação: $dataControle</h3>";
                echo "</div>";
                echo "<div class='group clear'>";
                    echo "<div class='small'>";
                        echo "<input type='button' class='btn-excluir botao-acao label-input' pew-acao='deletar' pew-id-marca='$idMarca' value='Excluir'>";
                    echo "</div>";
                    echo "<div class='small'>";
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
        var formUpdate = $("#formUpdateMarca");
        var atualizando = false;
        formUpdate.off().on("submit", function(){
            event.preventDefault();
            if(!atualizando){
                atualizando = true;
                var objTitulo = $("#tituloMarca");
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
            var idMarca = botao.attr("pew-id-marca");
            var msgErro = "Não foi possível excluir a marca. Recarregue a página e tente novamente.";
            var msgSucesso = "A marca foi excluida com sucesso!";
            function excluir(){
                $.ajax({
                    type: "POST",
                    url: "pew-deleta-marca.php",
                    data: {id_marca: idMarca, acao: acao},
                    error: function(){
                        mensagemAlerta(msgErro);
                    },
                    success: function(resposta){
                        console.log(resposta);
                        if(resposta == "true"){
                            mensagemAlerta(msgSucesso, false,"#259e25", "pew-marcas.php");
                        }else{
                            mensagemAlerta(msgErro);
                        }
                    }
                });
            }
            botao.off().on("click", function(){
                mensagemConfirma("Você tem certeza que deseja excluir esta marca?", excluir);
            });
        });
    });
</script>
