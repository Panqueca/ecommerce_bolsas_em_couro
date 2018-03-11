<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Efectus Web">
        <title>Área Administrativa</title>
        <link type="text/css" rel="stylesheet" href="fontes/font-awesome-4.7.0/css/font-awesome.min.css">
        <link type="image/png" rel="icon" href="imagens/sistema/identidadeVisual/icone-efectus-web.png">
        <style>
            @font-face{
                font-family: helvetica;
                src: url(fontes/HelveticaLt.ttf);
            }
            @font-face{
                font-family: montserrat;
                src: url(fontes/Montserrat-Regular.otf);
            }
            body{
                margin: 0;
                color: #111;
                overflow-x: hidden;
                font-family: helvetica;
                text-align: center;
                color: #DF2321;
            }
            .header-login{
                width: 100%;
            }
            .header-login .logo-efectus{
                width: 400px;
            }
            .descricao{
                font-family: montserrat;
            }
            form input{
                padding: 10px;
                margin: 10px;
                border: 2px solid #DF2321;
                border-bottom: 2px solid #DF2321;
                color: #DF2321;
                font-family: helvetica;
                width: 250px;
                outline: none;
                border-radius: 20px;
                transition: .2s;
            }
            form input:focus{
                border-color: #f78a14;
                color: #f78a14;
            }
            .btn-submit{
                background-color: #DF2321;
                color: #fff;
                cursor: pointer;
                border: 1px solid transparent;
                transition: .2s;
                width: 100px;
                padding-top: 5px;
                padding-bottom: 5px;
            }
            .btn-submit:hover{
                background-color: #f78a14;
            }
            .btn-submit:focus{
                color: #fff;
            }
            .msg{
                border-bottom: 1px solid red;
                font-weight: normal;
                padding: 10px;
                color: red;
                padding: 0px;
                padding-bottom: 5px;
            }
            .link-padrao{
                color: #f78a14;
            }
        </style>
    </head>
    <body>
        <section>
            <header class="header-login">
                <img src="imagens/sistema/identidadeVisual/logo-efectus-web.png" class="logo-efectus">
            </header>
            <h3 class="descricao"><i class="fa fa-lock" aria-hidden="true"></i> Painel Administrativo</h3>
            <form method="post" action="pew-login.php">
                <input type="text" placeholder="Usuário" name="usuario"><br>
                <input type="password" placeholder="Senha" name="senha"><br>
                <?php
                    if(isset($_GET["msg"])){
                        $msg = $_GET["msg"];
                        echo "<br><font class='msg'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> $msg</font><br><br>";
                    }
                ?>
                <input type="submit" value="ENTRAR" class="btn-submit"><br><br>
                <a href="pew-esqueci-senha.php" class="link-padrao">Esqueceu sua senha?</a>
            </form>
        </section>
    </body>
</html>
