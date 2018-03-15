<?php

require_once "@pew/pew-system-config.php";
$tabela_minha_conta = $pew_custom_db->tabela_minha_conta;

$post_fields = array("campo", "data");
$invalid_fields = array();

$validar = true;
$i = 0;
foreach($post_fields as $post_name){
    if(!isset($_POST[$post_name])) $validar = false; $invalid_fields[$i] = $post_name; $i++;
}
if($validar){
    $campo = addslashes($_POST["campo"]);
    $data = addslashes($_POST["data"]);
    $collun = null;
    switch($campo){
        case "email":
            $collun = "email";
            break;
        case "cpf":
            $data = str_replace(".", "", $data);
            $collun = "cpf";
            break;
    }
    
    if($collun != null){
        $postData = $_POST[$post_name];
        $contar = mysqli_query($conexao, "select count(id) as total from $tabela_minha_conta where $collun = '$data'");
        $contagem = mysqli_fetch_array($contar);
        $total = $contagem["total"];
        $return = $total > 0 ? "duplicado" : "false";
        echo $return;
    }else{
        echo "false";
    }
}else{
    echo "false";
    //$print_r($invalid_fields);
}