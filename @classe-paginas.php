<?php

    if(!class_exists("Paginas")){
        class Paginas{
            public $titulo;
            public $descricao;
            public $empresa;
            
            function __construct(){
                $this->empresa = "Bolsas em Couro";
            }
            
            function set_titulo($titulo){
                $this->titulo = $titulo . " - " . $this->empresa;
            }
            
            function set_descricao($descricao){
                $this->descricao = $descricao;
            }
        }
    }

    $cls_paginas = new Paginas();