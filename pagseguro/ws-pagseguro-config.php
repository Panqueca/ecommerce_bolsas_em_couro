<?php

    if(!class_exists("PagSeguroConfig")){
        class PagSeguroConfig{
            public $token = null;
            public $email = null;

            function __construct($token, $email){
                $this->token = $token;
                $this->email = $email;
            }

            function get_token(){
                return $this->token;
            }

            function get_email(){
                return $this->email;
            }

        }
    }

    if(!isset($pagseguro_config)){
        $pagseguro_config = new PagSeguroConfig("B6A5347FD62240238E529A5770A3FF79", "reyrogerio@hotmail.com");
    }