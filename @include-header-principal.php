<style>
    .header-principal{
        position: relative;
        width: 100%;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        margin-bottom: 20px;
    }
    .header-principal .nav-header{
        position: relative;
        z-index: 80;
        width: 90%;
    }
    /*END TOP BAR CART AND LOGIN CSS*/
    .header-principal .nav-header .top-bar{
        position: fixed;
        width: 90%;
        padding: 0px 5% 0px 5%;
        z-index: 10;
        height: 50px;
        top: 0;
        left: 0;
        font-size: 12px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: end;
        -ms-flex-pack: end;
        justify-content: flex-end;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        background-color: #fff;
        border-bottom: 1px solid #dedede;
        z-index: 80;
    }
    .header-principal .nav-header .top-bar .link-padrao{
        margin: 0px 10px 0px 10px;
        -webkit-transition: .2s;
        -o-transition: .2s;
        transition: .2s;
        cursor: pointer;
        color: #666;
    }
    .header-principal .nav-header .top-bar .link-padrao:hover{
        color: #111;
        border-color: #111;
    }
    .header-principal .nav-header .top-bar .header-cart{
        position: relative;
        width: 50px;
        height: 50px;
        margin: 0px 10px 0px 30px;
        font-size: 14px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: end;
        -ms-flex-pack: end;
        justify-content: flex-end;
    }
    .header-principal .nav-header .top-bar .header-cart .cart-button{
        position: relative;
        font-size: 26px;
        line-height: 50px;
        cursor: pointer;
        width: 23px;
        padding: 0px 10px 0px 10px;
        height: 0px;
        background-color: #f4f4f4;
        outline: none;
        -webkit-transition: .2s;
        -o-transition: .2s;
        transition: .2s;
        z-index: 110;
    }
    .header-principal .nav-header .top-bar .header-cart:hover .cart-button{
        height: 50px;
        color: #444;
        pointer-events: none;
    }
    .header-principal .nav-header .top-bar .header-cart .cart-display{
        position: absolute;
        width: 350px;
        height: auto;
        max-height: 0px;
        top: 50px;
        right: 0px;
        z-index: 200;
        background-color: #f4f4f4;
        overflow: hidden;
        opacity: 0;
        visibility: hidden;
        -webkit-transition: .4s, max-height .5s ease-in;
        -o-transition: .4s, max-height .5s ease-in;
        transition: .4s, max-height .5s ease-in;
    }
    .header-principal .nav-header .top-bar .header-cart:hover .cart-display{
        max-height: 400px;
        opacity: 1;
        visibility: visible;
    }
    .header-principal .nav-header .top-bar .header-cart .cart-display .cart-title{
        font-size: 16px;
        line-height: 19px;
        margin: 10px;
        text-align: left;
        border-bottom: 1px solid #999;
    }
    .header-principal .nav-header .top-bar .header-cart .cart-display .display-itens{
        max-height: 280px;
        overflow-y: auto;
        text-align: right;
    }
    .display-itens::-webkit-scrollbar-button:hover{
        background-color: #AAA;
    }
    .display-itens::-webkit-scrollbar-thumb{
        background-color: #ccc;
    }
    .display-itens::-webkit-scrollbar-thumb:hover{
        background-color: #999;
    }
    .display-itens::-webkit-scrollbar-track{
        background-color: #efefef;
    }
    .display-itens::-webkit-scrollbar-track:hover{
        background-color: #efefef;
    }
    .display-itens::-webkit-scrollbar{
        width: 5px;
        height: 5px;
    }
    .header-principal .nav-header .top-bar .header-cart .cart-display .display-itens .cart-item{
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: end;
        -ms-flex-pack: end;
        justify-content: flex-end;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        -webkit-box-flex: 1;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        line-height: 16px;
        padding-bottom: 10px;
    }
    .header-principal .nav-header .top-bar .header-cart .cart-display .display-itens .cart-item .item-quantity{
        padding: 0px 10px 0px 10px;
        cursor: pointer;
    }
    .header-principal .nav-header .top-bar .header-cart .cart-display .display-itens .cart-item .item-name{
        text-decoration: none;
        color: #111;
        border-bottom: 1px solid transparent;
        text-align: left;
    }
    .header-principal .nav-header .top-bar .header-cart .cart-display .display-itens .cart-item .item-name:hover{
        border-color: #111;
    }
    .header-principal .nav-header .top-bar .header-cart .cart-display .display-itens .cart-item .item-price{
        font-weight: bold;
        padding: 0px 10px 0px 10px;
        white-space: nowrap;
    }
    .header-principal .nav-header .top-bar .header-cart .cart-display .display-itens .cart-item .remove-button{
        background-color: transparent;
        border: none;
        cursor: pointer;
        margin: 0px 15px 0px 10px;
        color: #ccc;
    }
    .header-principal .nav-header .top-bar .header-cart .cart-display .display-itens .cart-item .remove-button:hover{
        color: #333;
    }
    .header-principal .nav-header .top-bar .header-cart .cart-display .cart-bottom{
        margin: 10px 10px 0px 10px;
        padding-bottom: 20px;
        display: block;
        position: relative;
        border-top: 1px solid #dedede;
    }
    .header-principal .nav-header .top-bar .header-cart .cart-display .cart-bottom .total-price{
        line-height: 30px;
        padding: 0px 0px 0px 10px;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: end;
        -ms-flex-pack: end;
        justify-content: flex-end;
    }
    .header-principal .nav-header .top-bar .header-cart .cart-display .cart-bottom .total-price .price-view{
        padding: 0px 0px 0px 10px;
        font-weight: bold;
    }
    .header-principal .nav-header .top-bar .header-cart .cart-display .cart-bottom .finalize-button{
        position: absolute;
        width: 140px;
        height: 24px;
        line-height: 24px;
        bottom: 10px;
        right: 0px;
        background-color: #41ba2f;
        text-decoration: none;
        text-align: center;
        color: #fff;
    }
    .header-principal .nav-header .top-bar .header-cart .cart-display .cart-bottom .finalize-button:hover{
        background-color: #318d24;
    }
    .header-principal .nav-header .top-bar .header-cart .cart-background{
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background: #000;
        z-index: 100;
        pointer-events: none;
        opacity: 0;
        visibility: hidden;
        -webkit-transition: .4s;
        -o-transition: .4s;
        transition: .4s;
    }
    .header-principal .nav-header .top-bar .header-cart:hover .cart-background{
        opacity: .4;
        visibility: visible;
    }
    /*END TOP BAR CART AND LOGIN CSS*/
    /*NAV TOP FIELD, SEARCH BAR, LOGO, SOCIAL MEDIA*/
    .header-principal .nav-header .top-nav{
        position: relative;
        width: 100%;
        margin-top: 50px;
        height: 100px;
        border-bottom: 1px solid #333;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        z-index: 1;
    }
    .header-principal .nav-header .top-nav .search-field{
        width: 30%;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: start;
        -ms-flex-pack: start;
        justify-content: flex-start;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
    }
    .header-principal .nav-header .top-nav .search-field form{
        position: relative;
        width: 225px;
        -webkit-transition: .3s;
        -o-transition: .3s;
        transition: .3s;
        background-color: #333;
    }
    .header-principal .nav-header .top-nav .search-field .form-focused{
        width: 100%;
    }
    .header-principal .nav-header .top-nav .search-field .search-bar{
        width: 100%;
        max-width: 100%;
        height: 30px;
        padding: 5px 40px 5px 5px;
        border: 1px solid #333;
        outline: none;
        -webkit-transition: .3s;
        -o-transition: .3s;
        transition: .3s;
    }
    .header-principal .nav-header .top-nav .search-field .search-submit{
        position: absolute;
        border: none;
        width: 40px;
        height: 28px;
        background-color: rgba(255, 255, 255, 0.5);
        top: 1px;
        right: 1px;
        cursor: pointer;
        -webkit-transition: .2s;
        -o-transition: .2s;
        transition: .2s;
    }
    .header-principal .nav-header .top-nav .search-field .search-submit:hover{
        background-color: #111;
        color: #fff;
    }
    .header-principal .nav-header .top-nav .logo-header{
        width: 40%;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        text-align: center;
    }
    .header-principal .nav-header .top-nav .logo-header img{
        width: 45%;
        -webkit-transition: .2s;
        -o-transition: .2s;
        transition: .2s;
    }
    .header-principal .nav-header .top-nav .logo-header img:hover{
        transform: scale(1.1);
    }
    .header-principal .nav-header .top-nav .social-media-field{
        width: 30%;
        height: 100%;
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        -webkit-box-pack: end;
        -ms-flex-pack: end;
        justify-content: flex-end;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
    }
    .header-principal .nav-header .top-nav .social-media-field a{
        position: relative;
        width: 30px;
        height: 30px;
        text-align: center;
        line-height: 32px;
        font-size: 18px;
        margin: 10px;
        color: #fff;
        border-radius: 50%;
        -webkit-transition: .2s;
        -o-transition: .2s;
        transition: .2s;
    }
    .header-principal .nav-header .top-nav .social-media-field .facebook{
        border: 1px solid #4267b2;
        color: #4267b2;
    }
    .header-principal .nav-header .top-nav .social-media-field .facebook:hover{
        background-color: #4267b2;
        color: #fff;
    }
    .header-principal .nav-header .top-nav .social-media-field .instagram{
        border: 1px solid #cd486b;
        color: #cd486b;
    }
    .header-principal .nav-header .top-nav .social-media-field .instagram:hover{
        background-color: #cd486b;
        color: #fff;
    }
    /*NAV TOP FIELD, SEARCH BAR, LOGO, SOCIAL MEDIA*/
    /*DISPLAY LINKS*/
    .header-principal .nav-header .nav-background{
        position: fixed;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background-color: #000;
        visibility: hidden;
        opacity: 0;
        -webkit-transition: .4s ease;
        -o-transition: .4s ease;
        transition: .4s ease;
        z-index: 80;
    }
    .header-principal .nav-header .display-links{
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        height: 60px;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        padding: 0px;
        margin: 0px;
        font-size: 14px;
    }
    .display-links::-webkit-scrollbar-button:hover{
        background-color: #AAA;
    }
    .display-links::-webkit-scrollbar-thumb{
        background-color: #ccc;
    }
    .display-links::-webkit-scrollbar-thumb:hover{
        background-color: #999;
    }
    .display-links::-webkit-scrollbar-track{
        background-color: #efefef;
    }
    .display-links::-webkit-scrollbar-track:hover{
        background-color: #efefef;
    }
    .display-links::-webkit-scrollbar{
        width: 5px;
        height: 5px;
    }
    .header-principal .nav-header .botao-nav-mobile{
        position: fixed;
        top: 0px;
        font-size: 26px;
        text-align: center;
        z-index: 100;
        width: 50px;
        height: 45px;
        line-height: 55px;
        display: none;
        outline: none;
        cursor: pointer;
    }
    .header-principal .nav-header .active-botao{
        display: block;
    }
    .header-principal .nav-header .display-links span{
        position: relative;
        height: auto;
    }
    .header-principal .nav-header .display-links .first-li{
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
        z-index: 51;
        -webkit-box-flex: 1;
        -ms-flex: 1 1 auto;
        flex: 1 1 auto;
        -webkit-box-pack: center;
        -ms-flex-pack: center;
        justify-content: center;
    }
    .header-principal .nav-header .display-links .logo-menu-mobile{
        position: relative;
        width: 100%;
        height: 80px;
        -webkit-box-pack: start;
        -ms-flex-pack: start;
        justify-content: flex-start;
        -webkit-box-align: center;
        -ms-flex-align: center;
        align-items: center;
        border-bottom: 1px solid #eee;
        display: none;
    }
    .header-principal .nav-header .display-links .logo-menu-mobile img{
        width: 120px;
        height: 50px;
        margin-left: 5%;
    }
    .header-principal .nav-header .display-links .logo-menu-mobile .btn-voltar-menu{
        position: absolute;
        width: 50px;
        height: 50px;
        top: 15px;
        right: 0px;
        font-size: 26px;
        color: #ccc;
        line-height: 50px;
        text-align: center;
        cursor: pointer;
    }
    .header-principal .nav-header .display-links .logo-menu-mobile .btn-voltar-menu:hover{
        color: #333;
    }
    .header-principal .nav-header .display-links .link-principal{
        display: inline-block;
        height: 60px;
        line-height: 60px;
        padding: 0px 10px 0px 10px;
        -webkit-transition: .2s linear;
        -o-transition: .2s linear;
        transition: .2s linear;
        text-decoration: none;
        color: #333;
        font-weight: bold;
    }
    .header-principal .nav-header .display-links .sub-menu{
        background-color: #f6f6f6;
        padding: 0px;
        position: absolute;
        top: 60px;
        left: 0px;
        list-style: none;
        -webkit-transition: .2s;
        -o-transition: .2s;
        transition: .2s;
        visibility: hidden;
        opacity: 0;
    }
    .header-principal .nav-header .display-links .sub-menu ul{
        list-style: none;
    }
    .header-principal .nav-header .display-links .first-li:hover .link-principal{
        background-color: #f6f6f6;
    }
    .header-principal .nav-header .display-links .first-li:hover .sub-menu{
        opacity: 1;
        visibility: visible;
        -webkit-transition: visibility 0s, opacity .2s;
        -o-transition: visibility 0s, opacity .2s;
        transition: visibility 0s, opacity .2s;
    }
    .header-principal .nav-header .display-links .sub-menu li{
        position: relative;
        white-space: nowrap;
        min-width: 250px;
    }
    .header-principal .nav-header .display-links .sub-menu .sub-link{
        display: block;
        text-decoration: none;
        color: #333;
        width: 85%;
        padding: 10px;
        padding-left: 5%;
        padding-right: 10%;
        -webkit-transition: .2s;
        -o-transition: .2s;
        transition: .2s;
        font-weight: bold;
    }
    .header-principal .nav-header .display-links .sub-menu li:hover .sub-link{
        background-color: #303030;
        color: #fff;
        font-weight: bold;
    }
    .header-principal .nav-header .display-links .sub-menu li .sub-sub-menu{
        position: absolute;
        top: 0px;
        left: 96%;
        z-index: -1;
        background-color: #f2f2f2;
        padding: 0px;
        opacity: 0;
        visibility: hidden;
    }
    .header-principal .nav-header .display-links .sub-menu li:hover .sub-sub-menu{
        visibility: visible;
        opacity: 1;
        left: 100%;
        -webkit-transition: visibility 0s, opacity .3s, left .2s;
        -o-transition: visibility 0s, opacity .3s, left .2s;
        transition: visibility 0s, opacity .3s, left .2s;
    }
    .header-principal .nav-header .display-links .sub-menu li .sub-sub-menu li{
        position: relative;
        white-space: nowrap;
        min-width: 200px;
    }
    .header-principal .nav-header .display-links .sub-menu li .sub-sub-menu li .box-destaque{
        position: absolute;
        width: 250px;
        top: 0px;
        left: 100%;
    }
    .header-principal .nav-header .display-links .sub-menu li .sub-sub-menu li .box-destaque .imagem{
        width: 100%;   
    }
    .header-principal .nav-header .display-links .sub-menu li .sub-sub-menu .sub-sub-links{
        display: block;
        text-decoration: none;
        color: #111;
        width: 90%;
        padding: 10px;
        padding-left: 5%;
        padding-right: 5%;
        -webkit-transition: .2s;
        -o-transition: .2s;
        transition: .2s;
    }
    .header-principal .nav-header .display-links .sub-menu li .sub-sub-menu .sub-sub-links:hover{
        font-weight: bold;
    }
    .header-principal .nav-header .display-links .sub-menu li .sub-sub-links-icon{
        position: absolute;
        top: 0px;
        right: 5px;
        width: 10%;
        height: 100%;
        line-height: 38px;
        color: #ccc;
        -webkit-transition: .2s;
        -o-transition: .2s;
        transition: .2s;
    }
    .header-principal .nav-header .display-links .sub-menu li:hover .sub-sub-links-icon{
        color: #fff;
        right: 0px;
    }
    /*MOBILE MENU*/
    .header-principal .nav-header-mobile .display-links{
        position: fixed;
        display: block;
        width: 50%;
        height: 100vh;
        top: 0px;
        left: -100%;
        background-color: #fff;
        z-index: 110;
        overflow: hidden;
        overflow-y: auto;
        -webkit-transition: .4s ease;
        -o-transition: .4s ease;
        transition: .4s ease;
    }
    .header-principal .nav-header-mobile .display-links .first-li{
        display: block;
    }
    .header-principal .nav-header-mobile .display-links .logo-menu-mobile{
        display: -webkit-box;
        display: -ms-flexbox;
        display: flex;
    }
    .header-principal .nav-header-mobile .display-links .link-principal{
        display: block;
        width: 80%;
        height: 35px;
        line-height: 35px;
        padding: 10px 10% 10px 10%;
        white-space: nowrap;
        border-bottom: 1px solid #ddd;
    }
    .header-principal .nav-header-mobile .display-links .sub-menu{
        position: static;
        width: 100%;
        padding: 0px;
        top: 0px;
        left: 0px;
        visibility: visible;
        opacity: 1;
        background-color: #eee;
    }
    .header-principal .nav-header-mobile .display-links .sub-menu .sub-link{
        width: 80%;
        padding: 10px 10% 10px 10%;
    }
    .header-principal .nav-header-mobile .display-links .sub-menu li .sub-sub-links-icon{
        display: none;
    }
    /*END MOBILE MENU*/
    @media screen and (max-width: 980px){
        .header-principal .nav-header .top-bar{
            width: 100%;
            padding: 0px;
        }
        .header-principal .nav-header .top-nav .search-field{
            -webkit-box-pack: center;
            -ms-flex-pack: center;
            justify-content: center;
        }
        .header-principal .nav-header{
            width: 100%;
        }
        .header-principal .nav-header .top-nav .logo-header img{
            width: 60%;
        }
        .header-principal .nav-header .top-nav .logo-header img:hover{
            width: 65%;
        }
        .header-principal .nav-header .display-links{
            font-size: 12px;
        }
        @media screen and (max-width: 720px){
            .header-principal .nav-header .top-bar{
                position: fixed;
                width: 100%;
                top: 0px;
                left: 0px;
            }
            .header-principal .nav-header .top-bar .header-cart{
                margin: 0px 5px 0px 5px;
            }
            .header-principal .nav-header .top-nav{
                margin-top: 40px;
            }
            .header-principal .nav-header .top-nav{
                -webkit-box-flex: 1;
                -ms-flex: 1;
                flex: 1;
                -webkit-box-orient: vertical;
                -webkit-box-direction: normal;
                -ms-flex-direction: column;
                flex-direction: column;
                height: auto;
                border: none;
            }
            .header-principal .nav-header .top-nav .search-field{
                width: 100%;
                -webkit-box-ordinal-group: 2;
                -ms-flex-order: 1;
                order: 1;
            }
            .header-principal .nav-header .top-nav .search-field form{
                width: 50%;
                margin: 0px 0px 20px 0px;
            }
            .header-principal .nav-header .top-nav .logo-header{
                width: 100%;
                -webkit-box-ordinal-group: 1;
                -ms-flex-order: 0;
                order: 0;
            }
            .header-principal .nav-header .top-nav .logo-header img{
                width: 60%;
                margin: 40px 0px 10px 0px;
            }

            .header-principal .nav-header .top-nav .social-media-field{
                width: 100%;
                -webkit-box-ordinal-group: 3;
                -ms-flex-order: 2;
                order: 2;
                -webkit-box-pack: center;
                -ms-flex-pack: center;
                justify-content: center;
            }
            .header-principal .nav-header .botao-nav-mobile{
                display: block;
                cursor: pointer;
            }
            .header-principal .nav-header .display-links{
                position: fixed;
                display: block;
                width: 75%;
                height: 100vh;
                top: 0px;
                left: -100%;
                background-color: #fff;
                z-index: 110;
                overflow: hidden;
                overflow-y: auto;
                -webkit-transition: .4s ease;
                -o-transition: .4s ease;
                transition: .4s ease;
            }
            .header-principal .nav-header .display-links .first-li{
                display: block;
            }
            .header-principal .nav-header .display-links .link-principal{
                display: block;
                width: 80%;
                height: 35px;
                line-height: 35px;
                padding: 10px 10% 10px 10%;
                white-space: nowrap;
                border-bottom: 1px solid #ddd;
            }
            .header-principal .nav-header .display-links .sub-menu{
                position: static;
                width: 100%;
                padding: 0px;
                top: 0px;
                left: 0px;
                visibility: visible;
                opacity: 1;
                background-color: #eee;
            }
            .header-principal .nav-header .display-links .sub-menu .sub-link{
                width: 80%;
                padding: 10px 10% 10px 10%;
            }
            .header-principal .nav-header .display-links .sub-menu li .sub-sub-links-icon{
                display: none;
            }
            @media screen and (max-width: 480px){
                .header-principal .nav-header .top-bar{
                    font-size: 11px;
                }
                .header-principal .nav-header .top-bar .header-cart .cart-display{
                    width: 300px;
                }
                .header-principal .nav-header .top-nav .search-field form{
                    width: 65%;
                }
            }
        }
    }
    /*END DISPLAY LINKS*/
</style>
<header class="header-principal">
    <?php
        $dirLogoPrincipal = "imagens/identidadeVisual/logo-bolsa-em-couro.png";
    ?>
    <nav class="nav-header">
        <div class="top-bar">
            <a class="link-padrao botao-entrar" id="botaoEntrar"><i class="fas fa-sign-in-alt" data-fa-transform="grow-6 left-6"></i> ENTRAR</a> OU
            <a class="link-padrao" id="botaoCadastraConta">CRIE SUA CONTA</a>
            <div class="header-cart">
                <div class="cart-button"><i class="fas fa-shopping-bag"></i></div>
                <div class="cart-display">
                    <h4 class="cart-title">Sua Bolsa</h4>
                    <div class="display-itens">
                        <div class="cart-item">
                            <span class="item-quantity" title="Alterar quantidade">3x</span> <a href="#" class="item-name">Bolsa Marrom Amerela brilhante</a><span class="item-price">R$ 250.00</span> <button class="remove-button" title="Remover este item"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <div class="cart-bottom">
                        <span class="total-price">TOTAL: <span class="price-view">R$ 250.00</span></span><br>
                        <a href="#" class="finalize-button">Finalizar compra</a>
                    </div>
                </div>
                <div class="cart-background"></div>
            </div>
        </div>
        <div class="top-nav">
            <div class="search-field">
                <form name="busca" method="get" action="busca-produtos.php">
                    <input type="search" class="search-bar" placeholder="O QUE VOCÊ PROCURA?">
                    <button type="submit" class="search-submit"><i class="fas fa-search"></i></button>
                </form>
            </div>
            <div class="logo-header"><a href="index.php"><img src="<?php echo $dirLogoPrincipal;?>" alt="Logo - Bolsas em Couro by Maidi Grey" title="Página Inicial - Bolsas em Couro"></a></div>
            <div class="social-media-field">
                <a href="#" class="facebook"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="instagram"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
        <?php
        /*Primeiro Link*/

        class NavLinks{
            private $titulo_link;
            private $url_link;
            private $qtd_sublinks;
            private $sublinks;
            private $qtd_sub_sublinks;
            private $sub_sublinks;

            function __construct($tituloLink, $urlLink){
                $this->titulo_link = $tituloLink;
                $this->url_link = $urlLink;
                $this->qtd_sublinks = 0;
                $this->sublinks = array();
                $this->qtd_sub_sublinks = 0;
                $this->sub_sublinks = array();
            }

            public function add_sublink($id, $titulo, $url){
                $this->sublinks[$this->qtd_sublinks] = array();
                $this->sublinks[$this->qtd_sublinks]["id"] = $id;
                $this->sublinks[$this->qtd_sublinks]["titulo"] = $titulo;
                $this->sublinks[$this->qtd_sublinks]["url"] = $url;
                $this->sublinks[$this->qtd_sublinks]["qtd_sub_sublinks"] = 0;
                $this->qtd_sublinks++;
            }

            public function add_sub_sublink($idSublink, $titulo, $url, $produto_destaque = false){
                $this->sub_sublinks[$this->qtd_sub_sublinks] = array();
                $this->sub_sublinks[$this->qtd_sub_sublinks]["id_sublink"] = $idSublink;
                $this->sub_sublinks[$this->qtd_sub_sublinks]["titulo"] = $titulo;
                $this->sub_sublinks[$this->qtd_sub_sublinks]["url"] = $url;
                $this->sub_sublinks[$this->qtd_sub_sublinks]["produto_destaque"] = $produto_destaque;
                foreach($this->sublinks as $indice => $sublink){
                    $id = $sublink["id"];
                    if($idSublink == $id){
                        $this->sublinks[$indice]["qtd_sub_sublinks"]++;
                    }
                }
                $this->qtd_sub_sublinks++;
            }

            public function get_qtd_sublinks(){
                return $this->qtd_sublinks;
            }

            public function listar_link(){
                $tituloPrincipal = $this->titulo_link;
                $urlPrincipal = $this->url_link;
                $subLinks = $this->sublinks;
                echo "<li class='first-li'>";
                echo "<span>";
                    echo "<a href='$urlPrincipal' class='link-principal'>$tituloPrincipal</a>";
                    if($this->qtd_sublinks > 0){
                        echo "<ul class='sub-menu'>";
                        foreach($subLinks as $subLink){
                            $idSubLink = $subLink["id"];
                            $tituloSubLink = $subLink["titulo"];
                            $urlSubLink = $subLink["url"];
                            $qtd_sub_subLinks = $subLink["qtd_sub_sublinks"];
                            $sub_subLinks = $this->sub_sublinks;
                            echo "<li><a href='$urlSubLink' class='sub-link'>$tituloSubLink</a>";
                            if($qtd_sub_subLinks > 0){
                                echo "<span class='sub-sub-links-icon'><i class='fa fa-arrow-right' aria-hidden='true'></i></span>";
                                echo "<ul class='sub-sub-menu'>";
                                foreach($sub_subLinks as $subSubLink){
                                    $getIdSubLink = $subSubLink["id_sublink"];
                                    $titulo = $subSubLink["titulo"];
                                    $url = $subSubLink["url"];
                                    $produto_destaque = $subSubLink["produto_destaque"];
                                    $displayDestaque = null;
                                    if($produto_destaque != false && $produto_destaque != ""){
                                        $imagemDestaque = $produto_destaque["imagem"];
                                        $displayDestaque = "<div class='box-destaque'><img src='$imagemDestaque' class='imagem'></div>";
                                    }
                                    
                                    if($getIdSubLink == $idSubLink){
                                        echo "<li><a href='$url' class='sub-sub-links'>$titulo</a>";
                                            echo $displayDestaque;
                                        echo "</li>";
                                    }
                                }
                                echo "</ul>";
                            }
                            echo "</li>";
                        }
                        echo "</ul>";
                    }
                echo "</span>";
                echo "</li>";
            }
        }
        
        /*DISPLAY LINKS*/
        
        /*LINKS*/
        
        $link_nav = null;
        $countLinks = 0;
        $link_nav[$countLinks] = new NavLinks("PÁGINA INICIAL", "index.php");
        $countLinks++;
        
        /*INICIO LINKS ALTERAVEIS*/
        
        /*SET TABLES*/
        require_once "@pew/pew-system-config.php";
        require_once "@classe-system-functions.php";
        $tabela_categorias = $pew_db->tabela_categorias;
        $tabela_subcategorias = $pew_db->tabela_subcategorias;
        $tabela_categorias_produtos = $pew_custom_db->tabela_categorias_produtos;
        $tabela_subcategorias_produtos = $pew_custom_db->tabela_subcategorias_produtos;
        $tabela_produtos = $pew_custom_db->tabela_produtos;
        $tabela_imagens_produtos = $pew_custom_db->tabela_imagens_produtos;
        $tabela_departamentos = $pew_custom_db->tabela_departamentos;
        $tabela_links_menu = $pew_custom_db->tabela_links_menu;
        /*END SET TABLES*/
        
        
        global $departamentoLinks, $ctrlDepartamentoLinks;
        $departamentoLinks = array();
        $ctrlDepartamentoLinks = 0;
            
        $totalDepartamentos = (int)$pew_functions->contar_resultados($tabela_departamentos, "status = 1");

        if($totalDepartamentos > 0){
            $queryDepartamentos = mysqli_query($conexao, "select * from $tabela_departamentos where status = 1 order by posicao asc");
            while($infoDepartamentos = mysqli_fetch_array($queryDepartamentos)){
                $idDepartamento = $infoDepartamentos["id"];
                $tituloDepartamento = $infoDepartamentos["departamento"];
                $refDepartamento = $infoDepartamentos["ref"];
                $urlDepartamento = "loja.php?departamento=$refDepartamento";
                $departamentoLinks[$ctrlDepartamentoLinks] = array();
                $departamentoLinks[$ctrlDepartamentoLinks]["titulo"] = $tituloDepartamento;
                $departamentoLinks[$ctrlDepartamentoLinks]["url"] = $urlDepartamento;
                $qtdSub = $pew_functions->contar_resultados($tabela_links_menu, "id_departamento = '$idDepartamento'");
                if($qtdSub > 0){
                    $querySub = mysqli_query($conexao, "select * from $tabela_links_menu where id_departamento = '$idDepartamento'");
                    $ctrlSub = 0;
                    $departamentoLinks[$ctrlDepartamentoLinks]["sublinks"] = array();
                    while($infoSub = mysqli_fetch_array($querySub)){
                        $idCategoria = $infoSub["id_categoria"];
                        $totalCategoria = $pew_functions->contar_resultados($tabela_categorias, "id = '$idCategoria' and status = 1");
                        if($totalCategoria > 0){
                            $queryCategoria = mysqli_query($conexao, "select * from $tabela_categorias where id = '$idCategoria' and status = 1");
                            $infoCategoria = mysqli_fetch_array($queryCategoria);
                            $tituloCategoria = $infoCategoria["categoria"];
                            $refCategoria = $infoCategoria["ref"];
                            $urlCategoria = "loja.php?departamento=$refDepartamento&categoria=$refCategoria";
                            $departamentoLinks[$ctrlDepartamentoLinks]["sublinks"][$ctrlSub] = array();
                            $departamentoLinks[$ctrlDepartamentoLinks]["sublinks"][$ctrlSub]["titulo"] = $tituloCategoria;
                            $departamentoLinks[$ctrlDepartamentoLinks]["sublinks"][$ctrlSub]["url"] = $urlCategoria;
                            $totalSubcategorias = $pew_functions->contar_resultados($tabela_subcategorias, "id_categoria = '$idCategoria'");
                            $ctrlSubsublinks = 0;
                            if($totalSubcategorias > 0){
                                $querySubcategorias = mysqli_query($conexao, "select * from $tabela_subcategorias where id_categoria = '$idCategoria' order by subcategoria asc");
                                while($infoSubcategoriras = mysqli_fetch_array($querySubcategorias)){
                                    $idSubcategoria = $infoSubcategoriras["id"];
                                    $tituloSubcategoria = $infoSubcategoriras["subcategoria"];
                                    $refSubcategoria = $infoSubcategoriras["ref"];
                                    $urlSubcategoria = "loja.php?departamento=$refDepartamento&categoria=$refCategoria&subcategoria=$refSubcategoria";
                                    $departamentoLinks[$ctrlDepartamentoLinks]["sublinks"][$ctrlSub]["subsublinks"][$ctrlSubsublinks] = array();
                                    $departamentoLinks[$ctrlDepartamentoLinks]["sublinks"][$ctrlSub]["subsublinks"][$ctrlSubsublinks]["titulo"] = $tituloSubcategoria;
                                    $departamentoLinks[$ctrlDepartamentoLinks]["sublinks"][$ctrlSub]["subsublinks"][$ctrlSubsublinks]["url"] = $urlSubcategoria;
                                    $totalProdutos = $pew_functions->contar_resultados($tabela_subcategorias_produtos, "id_subcategoria = '$idSubcategoria'");
                                    if($totalProdutos > 0){
                                        $queryIdProdutos = mysqli_query($conexao, "select id_produto from $tabela_subcategorias_produtos where id_subcategoria = '$idSubcategoria' order by rand()");
                                        $infoQuery = mysqli_fetch_array($queryIdProdutos);
                                        $idProduto = $infoQuery["id_produto"];
                                        $totalProduto = $pew_functions->contar_resultados($tabela_produtos, "id = '$idProduto'");
                                        if($totalProduto > 0){
                                            $queryImagemProduto = mysqli_query($conexao, "select * from $tabela_imagens_produtos where id_produto = '$idProduto' order by posicao desc");
                                            $infoImagem = mysqli_fetch_array($queryImagemProduto);
                                            $imagem = $infoImagem["imagem"];
                                            $dirImagens = "imagens/produtos/";
                                            
                                            /*$departamentoLinks[$ctrlDepartamentoLinks]["sublinks"][$ctrlSub]["subsublinks"][$ctrlSubsublinks]["box_destaque"] = array();
                                            $departamentoLinks[$ctrlDepartamentoLinks]["sublinks"][$ctrlSub]["subsublinks"][$ctrlSubsublinks]["box_destaque"]["imagem"] = $dirImagens.$imagem;*/
                                            
                                        }
                                    }
                                }
                            }
                            $ctrlSub++;
                        }
                    }
                }
                $ctrlDepartamentoLinks++;
            }   
        }

        
        foreach($departamentoLinks as $link_departamento){
            $tituloLink = $link_departamento["titulo"];
            $urlLink = $link_departamento["url"];
            $link_nav[$countLinks] = new NavLinks($tituloLink, $urlLink);
            $sublinks = isset($link_departamento["sublinks"]) ? $link_departamento["sublinks"] : null;
            $totalSublinks = count($sublinks);
            foreach($sublinks as $indice => $slink){
                $titulo = $slink["titulo"];
                $url = $slink["url"];
                $subsublinks = isset($slink["subsublinks"]) ? $slink["subsublinks"] : null;
                $totalSubsub = count($subsublinks);
                $link_nav[$countLinks]->add_sublink($countLinks, $titulo, $url);
                if($totalSubsub > 0){
                    foreach($subsublinks as $sublink){
                        $tituloSub = $sublink["titulo"];
                        $urlSub = $sublink["url"];
                        $boxDestaque = isset($sublink["box_destaque"]) && $sublink["box_destaque"] != "" ? $sublink["box_destaque"] : false;
                        $link_nav[$countLinks]->add_sub_sublink($countLinks, $tituloSub, $urlSub, $boxDestaque);
                    }
                }
            }
            $countLinks++;
        }
        
        /*END LINKS ALTERAVEIS*/
        
        $link_nav[$countLinks] = new NavLinks("DICAS", "dicas.php");
        $countLinks++;
        $link_nav[$countLinks] = new NavLinks("CONTATO", "contato.php");
        
        /*END LINKS*/
        
        
        /*DESENHA A ESTRUTURA*/
        $quantidadeLinks = count($link_nav);
        if($quantidadeLinks > 0){
            echo "<div class='botao-nav-mobile'><i class='fas fa-bars'></i></div>";
            echo "<div class='nav-background'></div>";
            echo "<ul class='display-links'>";
            echo "<li class='logo-menu-mobile'><img src='$dirLogoPrincipal'><div class='btn-voltar-menu' alt='Logo - Bolsas em Couro by Maidi Grey'><i class='fas fa-angle-double-left'></i></div></li>";
                foreach($link_nav as $link){
                    $link->listar_link();
                }
            echo "</ul>";
        }
        
        /*END DISPLAY LINKS*/
        ?>
    </nav>
</header>
<script>
    $(document).ready(function(){
        var searchField = $(".search-field");
        var formSearch = searchField.children("form");
        var searchBar = formSearch.children(".search-bar");
        if(screen.width > 720){
            searchBar.focus(function(){
                if(!formSearch.hasClass("form-focused")){
                    formSearch.addClass("form-focused");
                }
            });
            searchBar.blur(function(){
                if(formSearch.hasClass("form-focused")){
                    formSearch.removeClass("form-focused");
                }
            });
        }

        /*MENU MAIN FUNCTIONS*/
        var botaoNavMobile = $(".botao-nav-mobile");
        var navHeader = $(".nav-header");
        var displayLinks = $(".nav-header .display-links");
        var btnVoltarMenu = $(".btn-voltar-menu");
        var backgroundNav = $(".nav-background");
        var topNav = $(".top-nav");
        var navTopBar = $(".header-principal .nav-header .top-bar");
        var scrollAtual = $(document).scrollTop();
        var menuAberto = false;
        function toggleMenu(){
            if(!menuAberto){
                menuAberto = true;
                displayLinks.css({
                    left: "0px"
                });
                backgroundNav.css({
                    visibility: "visible",
                    opacity: ".5",
                });
            }else{
                menuAberto = false;
                displayLinks.css({
                    left: "-100%"
                });
                backgroundNav.css({
                    visibility: "hidden",
                    opacity: "0"
                });
            }
            scrollMenu();
        }
        botaoNavMobile.off().on("click", function(){
            toggleMenu();
        });
        btnVoltarMenu.off().on("click", function(){
            toggleMenu();
        });
        backgroundNav.off().on("click", function(){
            toggleMenu();
        });

        var scrollDisplayLinks = displayLinks.offset().top;
        function scrollMenu(){
            scrollAtual = $(document).scrollTop();
            var whiteSpace = 10;
            var alturaDisplayLinks = parseFloat(scrollDisplayLinks) - parseFloat(whiteSpace);
            var tamanhoDisplayLinks = displayLinks.height();
            if(scrollAtual >= alturaDisplayLinks){
                if(!botaoNavMobile.hasClass("active-botao")){
                    botaoNavMobile.addClass("active-botao");
                }
                if(!navHeader.hasClass("nav-header-mobile")){
                    navHeader.addClass("nav-header-mobile");
                    topNav.css("margin-bottom", tamanhoDisplayLinks+"px");
                }
            }else if(!menuAberto){
                if(botaoNavMobile.hasClass("active-botao")){
                    botaoNavMobile.removeClass("active-botao");
                }
                if(navHeader.hasClass("nav-header-mobile")){
                    navHeader.removeClass("nav-header-mobile");
                    topNav.css("margin-bottom", "0px");
                }
            }
        }
        if(screen.width > 720){
            scrollMenu();
            $(document).scroll(function(e){
                scrollMenu();
            });
        }
        /*END MENU MAIN FUNCTIONS*/

    });
</script>
<?php
    if(isset($_SESSION["minha_conta"])){
        print_r($_SESSION["minha_conta"]);
    }
    require_once "@include-cadastra-conta.php";
    require_once "@include-login.php";
?>