<?php
    require_once "pew-system-config.php";
    session_start();
    $name_session_user = $pew_session->name_user;
    $name_session_pass = $pew_session->name_pass;
    $name_session_nivel = $pew_session->name_nivel;
    $name_session_empresa = $pew_session->name_empresa;
    unset($_SESSION[$name_session_user]);
    unset($_SESSION[$name_session_pass]);
    unset($_SESSION[$name_session_nivel]);
    unset($_SESSION[$name_session_empresa]);
    mysqli_close($conexao);
    header("location: index.php?msg=Faça login para continuar");
?>
