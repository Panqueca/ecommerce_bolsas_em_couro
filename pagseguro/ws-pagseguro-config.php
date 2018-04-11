<?php

    class PagSeguroConfig{
        public $email = null;
        public $token = null;
        
        function __construct($email, $token){
            $this->email = $email;
            $this->token = $token;
        }
        
        function get_email(){
            return $this->email;
        }
        
        function get_token(){
            return $this->token;
        }
    }

    $pagseguro_config = new PagSeguroConfig("B6A5347FD62240238E529A5770A3FF79", "reyrogerio@hotmail.com");