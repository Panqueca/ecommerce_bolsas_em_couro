<?php
    
    require_once "@link-important-functions.php";
    require_once "@classe-departamentos.php";
    $cls_departamentos = new Departamentos();

    if(isset($_GET["ref-option"])){
        $option = $_GET["ref-option"];
        $optionID = isset($_GET["ref-option-id"]) ? $_GET["ref-option-id"] : uniqid();
        $optionName = isset($_GET["ref-option-name"]) ? $_GET["ref-option-name"] : uniqid();
        $optionsCheckArray = isset($_GET["ref-option-check-array"]) ? $_GET["ref-option-check-array"] : array();
        $searchUrl = isset($_GET["ref-option-url"]) ? $_GET["ref-option-url"] : null;
        $searchParameter = isset($_GET["ref-option-parameter"]) ? $_GET["ref-option-parameter"] : null;
        $buttonID = isset($_GET["ref-option-button"]) ? $_GET["ref-option-button"] : uniqid();
        $optionsArray = array();
        
        switch($option){
            case "categoria":
                
                $infoCategorias = $cls_departamentos->get_categorias();
                foreach($infoCategorias as $info){
                    $array = array();
                    $array["text"] = $info["categoria"];
                    $array["value"] = $info["id"];
                    array_push($optionsArray, $array);
                }
                
                echo create_modal_ms("Categorias", $optionsArray, $optionsCheckArray, $optionID, $optionName, $searchUrl, $searchParameter, $buttonID);
                break;
            case "subcategoria":
                
                $infoSubcategorias = $cls_departamentos->get_subcategorias();
                foreach($infoSubcategorias as $info){
                    $array = array();
                    $array["text"] = $info["subcategoria"];
                    $array["value"] = $info["id"];
                    array_push($optionsArray, $array);
                }
                
                echo create_modal_ms("Subcategorias", $optionsArray, $optionsCheckArray, $optionID, $optionName, $searchUrl, $searchParameter, $buttonID);
                break;
            default: // departamento
                
                $infoDepartamentos = $cls_departamentos->get_departamentos();
                foreach($infoDepartamentos as $info){
                    $array = array();
                    $array["text"] = $info["departamento"];
                    $array["value"] = $info["id"];
                    array_push($optionsArray, $array);
                }
                
                echo create_modal_ms("Departamentos", $optionsArray, $optionsCheckArray, $optionID, $optionName, $searchUrl, $searchParameter, $buttonID);
        }
    }
?>