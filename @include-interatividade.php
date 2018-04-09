<!--Interatividade Visual -> Estrutura Essencial -->
<style>
    .msg-padrao{
        position: fixed;
        padding: 5px;/*10px*/
        background-color: limegreen;
        left: 0px;/*5%*/
        color: #fff;
        border-radius: 5px;
        font-size: 16px;/*18px*/
        transition: .3s;
        opacity: 0;
        display: none;
        z-index: 500;
        bottom: 40px;
    }
    .background-interatividade{
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #000;
        z-index: 150;
        opacity: 0.3;/*0.3*/
        display: none;
        transition: .3s;
    }
    .background-paineis{
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #000;
        z-index: 130;
        opacity: 0.3;/*0.3*/
        display: none;
        transition: .3s;
    }
    .msg-confirma{
        position: fixed;
        z-index: 500;
        width: 100%;
        top: 200px;
        background-color: #fbfbfb;
        padding-top: 0px;/*10px*/
        padding-bottom: 0px;/*10px*/
        text-align: center;
        margin: 0 auto;
        left: 0;
        right: 0;
        -webkit-box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.4);
        -moz-box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.4);
        box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.4);
        display: none;
        opacity: 0;
        transition: .3s;
    }
    .msg-alerta{
        position: fixed;
        z-index: 500;
        width: 100%;
        top: 200px;
        background-color: #fbfbfb;
        padding-top: 0px;/*10px*/
        padding-bottom: 0px;/*10px*/
        text-align: center;
        margin: 0 auto;
        left: 0;
        right: 0;
        -webkit-box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.4);
        -moz-box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.4);
        box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.4);
        display: none;
        opacity: 0;
        transition: .3s;
        padding-bottom: 20px;
    }
    .msg-alerta #btnOk{
        padding: 10px;
        padding-left: 20px;
        padding-right: 20px;
        cursor: pointer;
        background-color: #ea5959;
        border: none;
        color: #fff;
    }
    .msg-alerta #btnOk:hover{
        -webkit-box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.2);
        box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.2);
    }
    #btnConfirmar{
        background-color: #32cd32;
        color: #111;
        padding: 10px;
        padding-left: 15px;
        padding-right: 15px;
        color: #fff;
        border: none;
        margin: 10px;
        text-decoration: none;
        transition: .2s;
        cursor: pointer;
        font-size: 14px;
    }
    #btnConfirmar:hover{
        background-color: #2aa32a;
        -webkit-box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.2);
        box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.2);
    }
    #btnCancelar{
        background-color: #ea5959;
        color: #111;
        padding: 10px;
        padding-left: 15px;
        padding-right: 15px;
        color: #fff;
        border: none;
        margin: 10px;
        text-decoration: none;
        transition: .2s;
        cursor: pointer;
        font-size: 14px;
    }
    #btnCancelar:hover{
        background-color: #af2120;
        -webkit-box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.2);
        box-shadow: 1px 1px 25px 1px rgba(0, 0, 0, 0.2);
    }
</style>
<div class="msg-padrao"></div>
<?php
if(isset($_GET["msg"])){
    $msg = $_GET["msg"];
    if(isset($_GET["msgType"])){
        $msgType = $_GET["msgType"];
    }else{
        $msgType = "error";
    }
    echo "<script type='text/javascript'>";
    echo "$(document).ready(function(){ notificacaoPadrao('$msg', '$msgType'); });";
    echo "</script>";
}
?>
<div class="background-interatividade"></div>
<div class="background-paineis"></div>
<div class="msg-confirma">
    <h3 aling='center' class="texto-confirma">Mensagem...</h3>
    <input type="button" value="Confirmar" id='btnConfirmar'>
    <input type="button" value="Cancelar" id='btnCancelar'>
</div>
<div class="msg-alerta">
    <h3 aling='center' class="texto-alerta">Mensagem...</h3>
    <input type="button" value="Ok" id="btnOk">
</div>
<!--FIM Interatividade Visual -> Estrutura Essencial -->
