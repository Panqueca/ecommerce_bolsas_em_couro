<?php
    session_start();
    unset($_SESSION["pew_session"]);
    
    header("location: index.php?msg=Faça login para continuar");
?>
