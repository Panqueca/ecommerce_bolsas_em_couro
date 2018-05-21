<?php

	ini_set('display_errors', 1);
	ini_set('display_startup_errors', 1);
	error_reporting(E_ALL);

	$post_fields = array("nome", "email", "telefone", "mensagem", "tipo");
    $invalid_fields = array();

    $gravar = true;
    $i = 0;
    foreach($post_fields as $post_name){
        if(!isset($_POST[$post_name])) $gravar = false; $invalid_fields[$i] = $post_name; $i++;
    }

	if(isset($_POST["tipo"])){
		$type = $_POST["tipo"];
	}else{
		$type = "Trabalhe Conosco";
	}

	$msgSucesso = "Sua mensagem foi enviada com sucesso. Logo entraremos em contato!";

	switch($type){
		case "Seja Fornecedor":
			$urlRedirect = "seja-fornecedor.php?msg=$msgSucesso&msgType=success";
			break;
		default:
			$urlRedirect = "trabalhe-conosco.php?msg=$msgSucesso&msgType=success";
	}

	if($gravar){
		require_once "@pew/pew-system-config.php";
		$nome = addslashes($_POST["nome"]);
		$email = addslashes($_POST["email"]);
		$telefone = addslashes($_POST["telefone"]);
		$mensagem = addslashes($_POST["mensagem"]);
		$tipo = addslashes($_POST["tipo"]);
		$data = date("Y-m-d H:i:s");
		$status = 0;
		
		$tabela_contatos_servicos = $pew_custom_db->tabela_contatos_servicos;
		
		mysqli_query($conexao, "insert into $tabela_contatos_servicos (nome, email, telefone, mensagem, tipo, data, status) values ('$nome', '$email', '$telefone', '$mensagem', '$tipo', '$data', '$status')");
		
		echo "<script>window.location.href = '$urlRedirect'</script>";
	}else{
		//print_r($invalid_fields);
		echo "<script>window.location.href = 'contato.php?msg=Ocorreu um erro ao enviar os dados! Tente novamente.'</script>";
	}