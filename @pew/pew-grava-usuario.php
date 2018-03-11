<?php
    function error(){
        header("location: cadastrar-usuario.php?msg=Ocorreu um erro ao salvar os dados. Dados insuficiêntes&msgType=Error");
    }

    if(isset($_POST["usuario"]) && isset($_POST["senha"]) && isset($_POST["email"]) && isset($_POST["nivel"])){
        require_once "pew-system-config.php";
        $tabela_usuarios = $pew_db->tabela_usuarios_administrativos;
        $usuario = $_POST["usuario"];
        $senha = addslashes($_POST["senha"]);
        $email = $_POST["email"];
        $nivel = $_POST["nivel"];
        if($usuario != "" && $senha != "" && $email != "" && $nivel != ""){
            $senha = md5($senha);
            $contarUsuario = mysqli_query($conexao, "select count(id) as total_usuario from $tabela_usuarios where usuario = '$usuario'");
            $contagem = mysqli_fetch_assoc($contarUsuario);
            if($contagem["total_usuario"] > 0){
                header("location: pew-cadastra-usuario.php?msg=Já existe um usuário chamado: $usuario");
            }else{
                mysqli_query($conexao, "insert into $tabela_usuarios (usuario, senha, email, nivel) values ('$usuario', '$senha', '$email', '$nivel')");
                header("location: pew-usuarios.php?msg=Usuário cadastrado com sucesso!&msgType=success");
            }
            mysqli_close($conexao);
        }else{
            error();
        }
    }else{
        error();
    }
?>
