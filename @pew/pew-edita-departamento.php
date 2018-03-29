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
        require_once "@classe-system-functions.php";

        /*SET TABLES*/
        $tabela_departamentos = $pew_custom_db->tabela_departamentos;
        $tabela_links_menu = $pew_custom_db->tabela_links_menu;
        $tabela_categorias = $pew_db->tabela_categorias;
        $tabela_subcategorias = $pew_db->tabela_subcategorias;
        /*END SET TABLES*/
        
        $contarDepartamento = mysqli_query($conexao, "select count(id) as total_departamento from $tabela_departamentos where id = '$idDepartamento'");
        $contagem = mysqli_fetch_assoc($contarDepartamento);
        $totalDepartamento = $contagem["total_departamento"];
        
        $selectedCategorias = array();
        if($totalDepartamento > 0){
            $queryDepartamento = mysqli_query($conexao, "select * from $tabela_departamentos where id = '$idDepartamento'");
            $departamento = mysqli_fetch_array($queryDepartamento);
            $titulo = $departamento["departamento"];
            $descricao = $departamento["descricao"];
            $posicao = $departamento["posicao"];
            $dataControle = pew_inverter_data(substr($departamento["data_controle"], 0, 10));
            $status = $departamento["status"] == 1 ? "Ativo" : "Desativado";
            echo "<h2 class=titulo-edita>Informações do departamento</h2>";
            echo "<form id='formUpdateDepartamento' method='post' action='pew-update-departamento.php'>";
                echo "<input type='hidden' name='id_departamento' id='idDepartamento' value='$idDepartamento'>";
                echo "<div class='label full'>";
                    echo "<h3 class='label-title'>Título</h3>";
                    echo "<input type='text' class='label-input' placeholder='Título do departamento' name='titulo' id='tituloDepartamento' value='$titulo' maxlength='35'>";
                echo "</div>";
            ?>
            <div class="half">
                <div class="select-categorias">
                    <h3 class="titulo">Selecione as categorias para o menu</h3>
                    <ul class="list-categorias">
                        <?php
                            $condicaoCategorias = "status  = 1";
                            $totalCategorias = $pew_functions->contar_resultados($tabela_categorias, $condicaoCategorias);
                            if($totalCategorias > 0){
                                $queryCategorias = mysqli_query($conexao, "select categoria, id from $tabela_categorias where $condicaoCategorias");
                                while($categorias = mysqli_fetch_array($queryCategorias)){
                                    $idCategoria = $categorias["id"];
                                    $categoria = $categorias["categoria"];
                                    $checked = $pew_functions->contar_resultados($tabela_links_menu, "id_departamento = '$idDepartamento' and id_categoria = '$idCategoria'") > 0 ? "checked" : "";
                                    echo "<li class='box-categoria'><label><i class='fas fa-folder icone'></i>$categoria<input type='checkbox' value='$idCategoria' class='check-categorias' name='categorias_menu[]' $checked></label>";
                                    echo "</li>";
                                }
                            }else{
                                echo "<div class='full'>Nenhuma categoria foi cadastrada</div>";
                            }
                        ?>
                    </ul>
                </div>
            </div>
            <?php
                echo "<div class='label half'>";
                    echo "<h3 class='label-title'>Descrição (opcional)</h3>";
                    echo "<textarea class='label-textarea' placeholder='Descrição do departamento' name='descricao' id='descricaoDepartamento' rows=5>$descricao</textarea>";
                echo "</div>";
                echo "<br class='clear'>";
                echo "<br class='clear'>";
                echo "<div class='label medium'>";
                    echo "<h3 class='label-title'>Posição</h3>";
                    echo "<input type='number' class='label-input' name='posicao' id='posicaoDepartamento' placeholder='Posição' value='$posicao'>";
                echo "</div>";
                echo "<div class='label medium'>";
                    echo "<h3 class='label-title'>Status</h3>";
                    echo "<select class='label-input' name='status' id='statusDepartamento'>";
                        $possibleStatus = array("Ativo", "Desativado");
                        foreach($possibleStatus as $optionStatus){
                            $selected = $optionStatus == $status ? "selected" : "";
                            $value = $optionStatus == "Ativo" ? 1 : 0;
                            echo "<option $selected value='$value'>$optionStatus</option>";
                        }
                    echo "</select>";
                echo "</div>";
                echo "<div class='medium'>";
                    echo "<h3>Última modificação: $dataControle</h3>";
                echo "</div>";
                echo "<div class='label half jc-center'>";
                    echo "<div class='half'>";
                        echo "<input type='button' class='btn-excluir botao-acao label-input' pew-acao='deletar' pew-id-departamento='$idDepartamento' value='Excluir'>";
                    echo "</div>";
                    echo "<div class='half'>";
                        echo "<input type='submit' class='btn-submit label-input' value='Atualizar'>";
                    echo "</div>";
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
        var atualizando = false;
        formUpdate.off().on("submit", function(){
            event.preventDefault();
            if(!atualizando){
                atualizando = true;
                var objTitulo = $("#tituloDepartamento");
                var titulo = objTitulo.val();
                if(titulo.length < 3){
                    mensagemAlerta("O campo Título deve conter no mínimo 3 caracteres.", objTitulo);
                    atualizando = false;
                    return false;
                }
                formUpdate.submit();
            }
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
