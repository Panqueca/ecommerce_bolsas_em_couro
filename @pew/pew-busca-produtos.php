<?php
if(isset($_POST["datatype"]) || isset($_GET["datatype"])){
    $dataType = isset($_POST["datatype"]) ? addslashes($_POST["datatype"]) : addslashes($_GET["datatype"]);
}else{
    $dataType = "POST";
}
$varName = "busca";
if($dataType == "POST" || $dataType == "post"){
    $dataType = "POST";
    $dataSend = $_POST[$varName];
}else{
    $dataType = "GET";
    $dataSend = $_GET[$varName];
}
if(isset($dataSend)){
    require_once "pew-system-config.php";
    $tabela_produtos = $pew_custom_db->tabela_produtos;
    $tabela_categorias_produtos = $pew_custom_db->tabela_categorias_produtos;
    $busca = addslashes($dataSend);
    $searchColluns = array("id", "nome", "marca", "sku");
    $searchCondition = "";
    $ctrlColluns = 0;
    foreach($searchColluns as $collun){
        if($ctrlColluns == 0){
            $searchCondition .= "$collun like '%$busca%' ";
        }else{
            $searchCondition .= "or $collun like '%$busca%' ";
        }
        $ctrlColluns++;
    }
    /*CUSTOM SEARCH VARS*/
    $custom_search = $busca;
    $custom_table = false;
    if($dataType == "POST"){
        $custom_table = isset($_POST["custom_table"]) && $_POST["custom_table"] != null ? $_POST["custom_table"] : false;
    }else{
        $custom_table = isset($_GET["custom_table"]) && $_GET["custom_table"] != null ? $_GET["custom_table"] : false;
    }
    /*END CUSTOM SEARCH VARS*/

    function contarResultados($table, $condition){
        global $conexao;
        $condition = str_replace("where", "", $condition);
        $contar = mysqli_query($conexao, "select count(id) as total from $table where $condition");
        $contagem = mysqli_fetch_assoc($contar);
        $totalContagem = $contagem["total"];
        return $totalContagem;
    }

    $produtosSelecionados = array();
    $ctrlProdutos = 0;
    if(contarResultados($tabela_produtos, $searchCondition) > 0 && $custom_table == false){
        $queryProdutos = mysqli_query($conexao, "select id from $tabela_produtos where $searchCondition");
        while($produtos = mysqli_fetch_array($queryProdutos)){
            $idProduto = $produtos["id"];
            $produtosSelecionados[$ctrlProdutos] = $idProduto;
            $ctrlProdutos++;
        }
        function buscarCategorias(){
            global $conexao, $produtosSelecionados;
            $queryCategorias = mysqli_query($conexao, "select id from $tabela_categorias_produtos where $searchCondition");
            while($infoCategorias = mysqli_fetch_array($queryCategorias)){
                $idProduto = $infoCategorias["id"];
                $produtosSelecionados[$ctrlProdutos] = $idProduto;
                $ctrlProdutos++;
            }
        }
        if($dataType == "POST" && isset($_POST["categoria"])){
            buscarCategorias();
        }else if(isset($_POST["categoria"])){
            buscarCategorias();
        }
        print_r(json_encode($produtosSelecionados));
    }else if($custom_table != false && $custom_table != null){
        $custom_search = str_replace("where", "", $custom_search);
        $totalResultados = contarResultados($custom_table, $custom_search);
        if($totalResultados > 0){
            $resultadosSelecionados = array();
            $ctrlResultados = 0;
            $query = mysqli_query($conexao, "select id from $custom_table where $custom_search");
            while($info = mysqli_fetch_array($query)){
                $id = $info["id"];
                $resultadosSelecionados[$ctrlResultados] = $id;
                $ctrlResultados++;
            }
            print_r(json_encode($resultadosSelecionados));
        }else{
            echo "false";
        }
    }else{
        echo "false";
    }
}else{
    echo "false";
}
?>
