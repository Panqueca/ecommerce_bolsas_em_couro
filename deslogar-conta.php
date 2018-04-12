<?php
    session_start();
    if(isset($_SESSION["minha_conta"])){
        unset($_SESSION["minha_conta"]);
        
        echo "<script>window.history.back();</script>";
    }