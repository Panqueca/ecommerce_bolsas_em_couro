<?php

    if(isset($_POST["codigo_rastreamento"]) && isset($_POST["id_pedido"])){
        $idPedido = $_POST["id_pedido"];
        $codigoRastreamento = $_POST["codigo_rastreamento"];
        
        require_once "pew-system-config.php";
        require_once "@classe-system-functions.php";
        
        $tabela_pedidos = $pew_custom_db->tabela_pedidos;
        
        $totalPedido = $pew_functions->contar_resultados($tabela_pedidos, "id = '$idPedido'");
        
        if($totalPedido > 0){
            
            mysqli_query($conexao, "update $tabela_pedidos set status_transporte = '2', codigo_rastreamento = '$codigoRastreamento'");
            
            echo "<script>window.location.href='pew-vendas.php?msg=O pedido foi atualizado&msgType=success';</script>";
        }else{
            echo "<script>window.location.href='pew-vendas.php?msg=O pedido não foi atualizado&msgType=error';</script>";
        }
    }else{
        echo "<script>window.location.href='pew-vendas.php?msg=O pedido não foi atualizado&msgType=error';</script>";
    }