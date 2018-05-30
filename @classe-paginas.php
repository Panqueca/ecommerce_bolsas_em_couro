<?php

    if(!class_exists("Paginas")){
        class Paginas{
            public $titulo;
            public $descricao;
            public $empresa;
            public $logo;
            public $base_path;
            private $email_user;
            private $smtp_host;
            private $smtp_user;
            private $smtp_pass;
            private $smtp_port;
            
            function __construct(){
                $this->empresa     = "Bolsas em Couro";
                
                $this->logo        = "logo-bolsa-em-couro.png";
                
                $this->base_path   = "www.efectusdigital.com.br/bolsas";
                
                $this->email_user  = "dev@efectusdigital.com.br";
                
                $this->smtp_host   = "mail.efectusdigital.com.br";
                
                $this->smtp_user   = "dev@efectusdigital.com.br";
                
                $this->smtp_pass   = "3f3ctu5d1g1t4l";
                
                $this->smtp_port   = 587;
            }
            
            function set_titulo($titulo){
                $this->titulo = $titulo . " - " . $this->empresa;
            }
            
            function set_descricao($descricao){
                $this->descricao = $descricao;
            }
            
            function get_email_user(){
                return $this->email_user;
            }
            
            function get_email_pass(){
                return $this->email_pass;
            }
            
            function get_smtp_host(){
                return $this->smtp_host;
            }
            
            function get_smtp_user(){
                return $this->smtp_user;
            }
            
            function get_smtp_pass(){
                return $this->smtp_pass;
            }
            
            function get_smtp_port(){
                return $this->smtp_port;
            }
        }
    }

    $cls_paginas = new Paginas();