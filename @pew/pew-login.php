<?php
    function erroLogin(){
        header("location: index.php?msg=Usuário ou Senha incorretos");
    }

    if(isset($_POST["usuario"]) && isset($_POST["senha"])){
        /*CONFIGURAÇÃO*/
        require_once "pew-system-config.php";
        $tabela_usuarios = $pew_db->tabela_usuarios_administrativos;
        $coluna_empresa = "empresa";
        $coluna_user = "usuario";
        $coluna_pass = "senha";
        $coluna_nivel = "nivel";
        $name_session_user = $pew_session->name_user;
        $name_session_pass = $pew_session->name_pass;
        $name_session_nivel = $pew_session->name_nivel;
        $name_session_empresa = $pew_session->name_empresa;
        $default_redirect_page = "pew-banners.php";
        $max_nivel = 3;
        /*CONFIGURAÇÃO*/
        $selected_usuario = addslashes($_POST["usuario"]);
        $selected_senha = $_POST["senha"] != "" ? md5($_POST["senha"]) : "";
        if($selected_usuario != "" && $selected_senha != ""){
            $contar = mysqli_query($conexao, "select count(id) as total_usuario from $tabela_usuarios where $coluna_user = '$selected_usuario' and $coluna_pass = '$selected_senha'");
            $contagem = mysqli_fetch_assoc($contar);
            if($contagem["total_usuario"] > 0){
                $queryNivel = mysqli_query($conexao, "select $coluna_nivel, $coluna_empresa from $tabela_usuarios where $coluna_user = '$selected_usuario' and $coluna_pass = '$selected_senha'");
                $array = mysqli_fetch_array($queryNivel);
                $selected_empresa = $array[$coluna_empresa];
                $selected_nivel = $array[$coluna_nivel];
                session_start();
                $_SESSION[$name_session_empresa] = $selected_empresa;
                $_SESSION[$name_session_user] = $selected_usuario;
                $_SESSION[$name_session_pass] = $selected_senha;
                $_SESSION[$name_session_nivel] = $selected_nivel;
                $default_redicect_page = $selected_nivel == $max_nivel ? "pew-painel-controle.php" : $default_redirect_page;
                echo "<script type='text/javascript'>window.location.href='$default_redirect_page';</script>";
            }else{
                erroLogin();
            }
        }else{
            erroLogin();
        }
        mysqli_close($conexao);
    }else{
        erroLogin();
    }
?>
