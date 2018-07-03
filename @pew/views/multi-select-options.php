<?php

    if(!function_exists("create_modal_ms")){
        function create_modal_ms($titulo, $optionsArray, $checkArray, $id, $name, $url, $searchParameter, $buttonID){
            $enterHash = uniqid();
            $return = "<div class='modal-multi-select' id='$id' js-open-button='$buttonID' js-search-url='$url' js-search-parameter='$searchParameter'>
                <div class='header'>
                    <h3 class='main-title'>$titulo</h3>
                    <input type='search' class='search-bar' name='search_bar' placeholder='Buscar'>
                    <label title='Listar somente os que já foram selecionados' class='label-check-actives'><input type='checkbox' class='check-only-actives'> Somente os selecionados</label>
                </div>
                <div class='options-list'>
                    <div class='loading-background'>
                        <h4 class='loading-message'><i class='fa fa-spinner fa-pulse fa-3x fa-fw'></i></h4>
                    </div>
                    <div class='options-list-msg'><h4>Exibindo todos:</h4><a class='link-padrao clear-options' title='Limpar todos os listados abaixo e que foram selecionados'>Limpar todos</a></div>";
                    foreach($optionsArray as $infoOption){
                        $text = $infoOption["text"];
                        $value = $infoOption["value"];
                        $checked = in_array($value, $checkArray) ? "checked" : null;
                        $return .= "<label class='option-label'><input type='checkbox' name='{$name}[]' value='$value' form='form_filtro_relatorios' $checked> $text</label>";
                    }
            $return .= "</div>
                <div class='bottom'>
                    <a class='btn-save-options'>Salvar</a>
                </div>
            </div>";
            return $return;
        }
    }