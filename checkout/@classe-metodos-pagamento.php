<?php

    class MetodosPagamento{
        private $titulo;
        private $codigo;
        private $icone;
        private $options;
        private $ativo;
        
        function set_metodo_pagamento($titulo, $codigo, $icone, $options, $ativo){
            $this->titulo = $titulo;
            $this->codigo = $codigo;
            $this->icone = $icone;
            $this->options = $options;
            $this->ativo = $ativo;
        }
        
        function set_cartao_credito(){
            $optionsCartaoCredito = array();
            
            $optionsCartaoCredito[0] = array();
            $optionsCartaoCredito[0]["titulo"] = "American Express";
            $optionsCartaoCredito[0]["codigo"] = 103;
            $optionsCartaoCredito[0]["imagem"] = "amex.png";
            
            $optionsCartaoCredito[1] = array();
            $optionsCartaoCredito[1]["titulo"] = "Aura";
            $optionsCartaoCredito[1]["codigo"] = 106;
            $optionsCartaoCredito[1]["imagem"] = "aura.png";
            
            $optionsCartaoCredito[2] = array();
            $optionsCartaoCredito[2]["titulo"] = "Banese Card";
            $optionsCartaoCredito[2]["codigo"] = 123;
            $optionsCartaoCredito[2]["imagem"] = "banesecard.png";
            
            $optionsCartaoCredito[3] = array();
            $optionsCartaoCredito[3]["titulo"] = "BrasilCard";
            $optionsCartaoCredito[3]["codigo"] = 112;
            $optionsCartaoCredito[3]["imagem"] = "brasilcard.png";
            
            $optionsCartaoCredito[4] = array();
            $optionsCartaoCredito[4]["titulo"] = "Cabal";
            $optionsCartaoCredito[4]["codigo"] = 116;
            $optionsCartaoCredito[4]["imagem"] = "cabal.png";
            
            $optionsCartaoCredito[5] = array();
            $optionsCartaoCredito[5]["titulo"] = "Diners";
            $optionsCartaoCredito[5]["codigo"] = 104;
            $optionsCartaoCredito[5]["imagem"] = "diners.png";
            
            $optionsCartaoCredito[6] = array();
            $optionsCartaoCredito[6]["titulo"] = "Elo";
            $optionsCartaoCredito[6]["codigo"] = 107;
            $optionsCartaoCredito[6]["imagem"] = "elo.png";
            
            $optionsCartaoCredito[7] = array();
            $optionsCartaoCredito[7]["titulo"] = "FORTBRASIL";
            $optionsCartaoCredito[7]["codigo"] = 113;
            $optionsCartaoCredito[7]["imagem"] = "fortbrasil.png";
            
            $optionsCartaoCredito[8] = array();
            $optionsCartaoCredito[8]["titulo"] = "GRANDCARD";
            $optionsCartaoCredito[8]["codigo"] = 119;
            $optionsCartaoCredito[8]["imagem"] = "grandcard.png";
            
            $optionsCartaoCredito[9] = array();
            $optionsCartaoCredito[9]["titulo"] = "Hipercard";
            $optionsCartaoCredito[9]["codigo"] = 105;
            $optionsCartaoCredito[9]["imagem"] = "hipercard.png";
            
            $optionsCartaoCredito[10] = array();
            $optionsCartaoCredito[10]["titulo"] = "Mais!";
            $optionsCartaoCredito[10]["codigo"] = 117;
            $optionsCartaoCredito[10]["imagem"] = "imagem.png";
            
            $optionsCartaoCredito[11] = array();
            $optionsCartaoCredito[11]["titulo"] = "MasterCard";
            $optionsCartaoCredito[11]["codigo"] = 102;
            $optionsCartaoCredito[11]["imagem"] = "mastercard.png";
            
            $optionsCartaoCredito[12] = array();
            $optionsCartaoCredito[12]["titulo"] = "PersonalCard";
            $optionsCartaoCredito[12]["codigo"] = 109;
            $optionsCartaoCredito[12]["imagem"] = "personalcard.png";
            
            $optionsCartaoCredito[13] = array();
            $optionsCartaoCredito[13]["titulo"] = "Sorocred";
            $optionsCartaoCredito[13]["codigo"] = 120;
            $optionsCartaoCredito[13]["imagem"] = "sorocred.png";
            
            $optionsCartaoCredito[14] = array();
            $optionsCartaoCredito[14]["titulo"] = "Up PoliCard";
            $optionsCartaoCredito[14]["codigo"] = 122;
            $optionsCartaoCredito[14]["imagem"] = "upbrasil.png";
            
            $optionsCartaoCredito[15] = array();
            $optionsCartaoCredito[15]["titulo"] = "VALECARD";
            $optionsCartaoCredito[15]["codigo"] = 115;
            $optionsCartaoCredito[15]["imagem"] = "valecard.png";
            
            $optionsCartaoCredito[16] = array();
            $optionsCartaoCredito[16]["titulo"] = "Visa";
            $optionsCartaoCredito[16]["codigo"] = 101;
            $optionsCartaoCredito[16]["imagem"] = "visa.png";
            
            $this->set_metodo_pagamento("Cartão de Crédito", 1, "<i class='far fa-credit-card'></i>", $optionsCartaoCredito, true);
        }
        
        function set_boleto(){
            $optionsBoleto = array();
            
            $optionsBoleto[0] = array();
            $optionsBoleto[0]["titulo"] = "Boleto";
            $optionsBoleto[0]["codigo"] = 202;
            
            $this->set_metodo_pagamento("Boleto", 2, "<i class='fas fa-barcode'></i>", $optionsBoleto, true);
        }
        
        function get_titulo(){
            return $this->titulo;
        }
        
        function get_codigo(){
            return $this->codigo;
        }
        
        function get_icone(){
            return $this->icone;
        }
        
        function get_options(){
            return $this->options;
        }
        
        function get_ativo(){
            return $this->ativo;
        }
        
        function get_info(){
            $array = array();
            
            $array["titulo"] = $this->get_titulo();
            $array["codigo"] = $this->get_codigo();
            $array["icone"] = $this->get_icone();
            $array["options"] = $this->get_options();
            $array["ativo"] = $this->get_ativo();
            
            return $array;
        }
    }