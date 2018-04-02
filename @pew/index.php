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
        <link type="text/css" rel="stylesheet" href="css/estilo.css">
        <style>
            .header-login{
                width: 100%;
                display: flex;
                flex-flow: row wrap;
                justify-content: center;
                align-items: center;
                background-color: #f6f6f6;
            }
            .header-login .logo-efectus{
                width: 400px;
            }
            .descricao{
                font-family: montserrat;
                text-align: center;
                font-size: 14px;
            }
            .form-login{
                text-align: center;
                width: 300px;
                margin: 0 auto;
            }
            .btn-submit{
                background-color: #DF2321;
                color: #fff;
                cursor: pointer;
                border: 1px solid transparent;
                transition: .2s;
                width: 100px;
                font-size: 12px;
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
                border-color: #f78a14;
                font-size: 12px;
            }
            .link-padrao:hover{ 
                color: #111;
                border-color: #111;
            }
            .bottom{
                margin-top: 40px;
            }
        </style>
    </head>
    <body>
        <section>
            <header class="header-login">
                <img src="imagens/sistema/identidadeVisual/logo-efectus-web.png" class="logo-efectus">
            </header>
            <h3 class="descricao"><i class="fa fa-lock" aria-hidden="true"></i> Painel Administrativo</h3>
            <form method="post" action="pew-login.php" class="form-login">
                <input type="text" placeholder="Usuário" name="usuario" class="label-input"><br>
                <input type="password" placeholder="Senha" name="senha" class="label-input"><br>
                <?php
                    if(isset($_GET["msg"])){
                        $msg = $_GET["msg"];
                        echo "<br><font class='msg'><i class='fa fa-exclamation-triangle' aria-hidden='true'></i> $msg</font><br><br>";
                    }
                ?>
                <div class="label group">
                    <input type="submit" value="ENTRAR" class="btn-submit label-input"><br><br>
                </div>
                <div class="group clear bottom">
                    <div align=left>
                        <a href="pew-esqueci-senha.php" class="link-padrao">Esqueceu sua senha?</a>
                    </div>
                
                </div>
            </form>
        </section>
    </body>
</html>
