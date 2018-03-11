<?php
    function error($id){
        header("location: pew-edita-usuario.php?id_usuario=$id&msg=Ocorreu um erro ao editar o usuário");
    }

    if(isset($_POST["id_usuario"]) && isset($_POST["usuario"]) && isset($_POST["newsenha"]) && isset($_POST["email"]) && isset($_POST["nivel"])){
        require_once "pew-system-config.php";
        $tabela_usuarios = $pew_db->tabela_usuarios_administrativos;
        $idUsuario = $_POST["id_usuario"];
        $usuario = $_POST["usuario"];
        $senha = addslashes($_POST["newsenha"]);
        $email = $_POST["email"];
        $nivel = $_POST["nivel"];
        if($usuario != "" && $email != "" && $nivel != ""){
            $contarUsuario = mysqli_query($conexao, "select count(id) as total_usuario from $tabela_usuarios where id = '$idUsuario'");
            $contagem = mysqli_fetch_assoc($contarUsuario);
            if($contagem["total_usuario"] > 0){
                mysqli_query($conexao, "update $tabela_usuarios set usuario = '$usuario', email = '$email', nivel = '$nivel' where id = '$idUsuario'");
                if($senha != ""){
                    $senha = md5($senha);
                    mysqli_query($conexao, "update $tabela_usuarios set senha = '$senha' where id = '$idUsuario'");
                }
                header("location: pew-usuarios.php?msg=O usuário foi atualizado com sucesso!&msgType=success");
            }else{
                header("location: pew-usuarios.php?msg=O usuário não foi encontrado");
            }
            mysqli_close($conexao);
        }else{
            error($id);
        }
    }else{
        error("");
    }
?>
