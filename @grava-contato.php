<?php

	$post_fields = array("nome", "email", "telefone", "assunto", "mensagem");
    $invalid_fields = array();

    $gravar = true;
    $i = 0;
    foreach($post_fields as $post_name){
        if(!isset($_POST[$post_name])) $gravar = false; $invalid_fields[$i] = $post_name; $i++;
    }

	if($gravar){
		require_once "@pew/pew-system-config.php";
		$nome = addslashes($_POST["nome"]);
		$email = addslashes($_POST["email"]);
		$telefone = addslashes($_POST["telefone"]);
		$assunto = addslashes($_POST["assunto"]);
		$mensagem = addslashes($_POST["mensagem"]);
		$data = date("Y-m-d h:i:s");
		$status = 0;
		
		$tabela_contatos = $pew_db->tabela_contatos;
		
		mysqli_query($conexao, "insert into $tabela_contatos (nome, email, telefone, assunto, mensagem, data, status) values ('$nome', '$email', '$telefone', '$assunto', '$mensagem', '$data', '$status')");
		
		echo "<script>window.location.href = 'contato.php?msg=Sua mensagem foi enviada com sucesso. Logo entraremos em contato.&msgType=success'</script>";
	}else{
		//print_r($invalid_fields);
		echo "<script>window.location.href = 'contato.php?msg=Ocorreu um erro ao enviar os dados! Tente novamente.'</script>";
	}