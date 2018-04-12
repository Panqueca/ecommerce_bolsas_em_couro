<?php
    $post_fileds = array("id_cor");
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
        require_once "@classe-system-functions.php";
        
        $idCor = $_POST["id_cor"];
        $dirImagens = "../imagens/cores/";
        
        $tabela_cores = $pew_custom_db->tabela_cores;
        $condicaoCor = "id = '$idCor'";
        
        $totalCor = $pew_functions->contar_resultados($tabela_cores, $condicaoCor);
        if($totalCor > 0){
            
            $query = mysqli_query($conexao, "select * from $tabela_cores where id = '$idCor'");
            $infoCor = mysqli_fetch_array($query);
            $titulo = $infoCor["cor"];
            $imagem = $infoCor["imagem"];
            $dataControle = $pew_functions->inverter_data(substr($infoCor["data_controle"], 0, 10));
            $status = $infoCor["status"] == 1 ? "Ativa" : "Desativada";
            
            echo "<h2 class='titulo-edita'>Informações da cor</h2>";
            echo "<form id='formUpdate' method='post' action='pew-update-cor.php' enctype='multipart/form-data'>";
                echo "<input type='hidden' name='id_cor' id='idCor' value='$idCor'>";
                echo "<div class='label full'>";
                    echo "<h3 class='label-title'>Título</h3>";
                    echo "<input type='text' class='label-input' placeholder='Título da cor' name='titulo' id='titulo' value='$titulo' maxlength='35'>";
                echo "</div>";
                if(file_exists($dirImagens.$imagem) && $imagem != ""){
                    echo "<div class='small'>";
                            echo "<h3 class='label-title'>Imagem atual</h3>";
                            echo "<img src=".$dirImagens.$imagem." class='group'>";
                            echo "<br><br><br>";
                        echo "</div>";
                    echo "</div>";
                }else{
                    echo "<div class='label full'>";
                        echo "<h3 class='label-title'>Imagem (40px : 40px)</h3>";
                        echo "<input type='file' class='label-input' name='imagem' accept='image/*'>";
                    echo "</div>";
                }
                echo "<div class='label half'>";
                    echo "<h3 class='label-title'>Alterar imagem (40px : 40px)</h3>";
                    echo "<input type='file' class='label-input' name='imagem' accept='image/*'>";
                echo "</div>";
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
                        echo "<input type='button' class='btn-excluir botao-acao label-input' pew-acao='deletar' pew-id-marca='$idCor' value='Excluir'>";
                    echo "</div>";
                    echo "<div class='small'>";
                        echo "<input type='submit' class='btn-submit label-input' value='Atualizar'>";
                    echo "</div>";
                    echo "</div>";
                echo "<br class='clear'>";
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
        var formUpdate = $("#formUpdate");
        var atualizando = false;
        formUpdate.off().on("submit", function(){
            event.preventDefault();
            if(!atualizando){
                atualizando = true;
                var objTitulo = $("#titulo");
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
            var idCor = botao.attr("pew-id-marca");
            var msgErro = "Não foi possível excluir a cor. Recarregue a página e tente novamente.";
            var msgSucesso = "A cor foi excluida com sucesso!";
            function excluir(){
                $.ajax({
                    type: "POST",
                    url: "pew-deleta-cor.php",
                    data: {id_cor: idCor, acao: acao},
                    error: function(){
                        mensagemAlerta(msgErro);
                    },
                    success: function(resposta){
                        console.log(resposta);
                        if(resposta == "true"){
                            mensagemAlerta(msgSucesso, false,"#259e25", "pew-cores.php");
                        }else{
                            mensagemAlerta(msgErro);
                        }
                    }
                });
            }
            botao.off().on("click", function(){
                mensagemConfirma("Você tem certeza que deseja excluir esta cor?", excluir);
            });
        });
    });
</script>