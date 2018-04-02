<?php
    function erroLogin(){
        echo "<script>window.location.href = 'index.php?msg=Usuário ou Senha incorretos'; </script>";
    }

    if(isset($_POST["usuario"]) && isset($_POST["senha"])){
        
        require_once "@link-important-functions.php";
        
        $tabela_usuarios = $pew_db->tabela_usuarios_administrativos;
        
        $default_redirect_page = "pew-banners.php";
        $max_nivel = 3;
        $selected_usuario = addslashes($_POST["usuario"]);
        $selected_senha = $_POST["senha"] != "" ? md5($_POST["senha"]) : "";
        
        
        if($selected_usuario != "" && $selected_senha != ""){
            $condicao = "usuario = '$selected_usuario' and senha = '$selected_senha'";
            $totalUsuario = $pew_functions->contar_resultados($tabela_usuarios, $condicao);
            
            if($totalUsuario > 0){
                $queryNivel = mysqli_query($conexao, "select nivel, empresa from $tabela_usuarios where $condicao");
                $array = mysqli_fetch_array($queryNivel);
                
                $selected_empresa = $array["empresa"];
                $selected_nivel = $array["nivel"];
                
                session_start();
                $_SESSION["pew_session"] = array();
                $_SESSION["pew_session"]["usuario"] = $selected_usuario;
                $_SESSION["pew_session"]["senha"] = $selected_senha;
                $_SESSION["pew_session"]["nivel"] = $selected_nivel;
                $_SESSION["pew_session"]["empresa"] = $selected_empresa;
                
                $default_redicect_page = $selected_nivel == $max_nivel ? "pew-painel-controle.php" : $default_redirect_page;
                $nextPage = isset($_POST["next_page"]) ? addslashes($_POST["next_page"]) : $default_redicect_page;
                
                echo "<script type='text/javascript'>window.location.href='$nextPage';</script>";
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
