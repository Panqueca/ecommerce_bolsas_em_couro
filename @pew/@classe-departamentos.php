<?php

    require_once "@classe-system-functions.php";
    require_once "@include-global-vars.php";

    class Departamentos{
        public $functions;
        public $tables;
        
        function __construct(){
            global $pew_functions, $globalVars;
            $this->functions = $pew_functions;
            $this->tables = $globalVars;
        }
        
        function build_array($s = "*", $t, $c = true){
            $conexao = $this->tables["conexao"];
            $return = array();
            $query = mysqli_query($conexao, "select $s from $t where $c");
            while($info = mysqli_fetch_array($query)){
                array_push($return, $info);
            }
            return $return;
        }
        
        function get_departamentos($condicao = "true", $select = "id, departamento"){
            $tabela_departamentos = $this->tables["tabela_departamentos"];
            
            $total = $this->functions->contar_resultados($tabela_departamentos, $condicao);
            if($total > 0){
                return $this->build_array($select, $tabela_departamentos, $condicao);
            }else{
                return array();
            }
        }
        
        function get_categorias($condicao = "true", $select = "id, categoria"){
            $tabela_categorias = $this->tables["tabela_categorias"];
            
            $total = $this->functions->contar_resultados($tabela_categorias, $condicao);
            if($total > 0){
                return $this->build_array($select, $tabela_categorias, $condicao);
            }else{
                return array();
            }
        }
        
        function get_subcategorias($condicao = "true", $select = "id, subcategoria"){
            $tabela_subcategorias = $this->tables["tabela_subcategorias"];
            
            $total = $this->functions->contar_resultados($tabela_subcategorias, $condicao);
            if($total > 0){
                return $this->build_array($select, $tabela_subcategorias, $condicao);
            }else{
                return array();
            }
        }
        
        function get_produtos_departamento($idDepartamento){
            $tabela_departamentos = $this->tables["tabela_departamentos"];
            $tabela_departamentos_produtos = $this->tables["tabela_departamentos_produtos"];
            
            $total = $this->functions->contar_resultados($tabela_departamentos, "id = '$idDepartamento'");
            if($total > 0){
                $select = "id_produto";
                return $this->build_array($select, $tabela_departamentos_produtos, "id_departamento = '$idDepartamento'");
            }else{
                return array();
            }
        }
        
        function get_produtos_categoria($idCategoria){
            $tabela_categorias = $this->tables["tabela_categorias"];
            $tabela_categorias_produtos = $this->tables["tabela_categorias_produtos"];
            
            $total = $this->functions->contar_resultados($tabela_categorias, "id = '$idCategoria'");
            if($total > 0){
                $select = "id_produto";
                return $this->build_array($select, $tabela_categorias_produtos, "id_categoria = '$idCategoria'");
            }else{
                return array();
            }
        }
        
        function get_produtos_subcategoria($idSubcategoria){
            $tabela_subcategorias = $this->tables["tabela_subcategorias"];
            $tabela_subcategorias_produtos = $this->tables["tabela_subcategorias_produtos"];
            
            $total = $this->functions->contar_resultados($tabela_subcategorias, "id = '$idSubcategoria'");
            if($total > 0){
                $select = "id_produto";
                return $this->build_array($select, $tabela_subcategorias_produtos, "id_subcategoria = '$idSubcategoria'");
            }else{
                return array();
            }
        }
        
    }

    if(isset($_POST["custom_search"])){
        $type = $_POST["custom_search"];
        $search = isset($_POST["search"]) ? $_POST["search"] : null;
        
        switch($type){
            case "search_get_categorias":
                $searchCondition = "categoria like '%".$search."%'";
                $array = get_categorias($searchCondition, "id");
                break;
            case "search_get_subcategorias":
                $searchCondition = "subcategoria like '%".$search."%'";
                $array = get_subcategorias($searchCondition, "id");
                break;
            default: // search_get_departamentos
                $searchCondition = "departamento like '%".$search."%'";
                $array = get_departamentos($searchCondition, "id");
                
        }
    }