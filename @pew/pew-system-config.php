<?php
    /*CLASSE PRINCIPAL DO SISTEMA*/
    if(!class_exists("Pew_Data_Base")){
        class Pew_Data_Base{
            public $db_host;
            public $db_name;
            public $db_user;
            public $db_pass;
            public $tabela_banners;
            public $tabela_categorias;
            public $tabela_subcategorias;
            public $tabela_contatos;
            public $tabela_usuarios_administrativos;

            function __construct($database_host, $database_user, $database_pass, $database_name, $tb_banners, $tb_categorias, $tb_subcategorias, $tb_contatos, $tb_usuarios_administrativos){
                $this->db_host = $database_host;
                $this->db_name = $database_name;
                $this->db_user = $database_user;
                $this->db_pass = $database_pass;
                $this->tabela_banners = $tb_banners;
                $this->tabela_categorias = $tb_categorias;
                $this->tabela_subcategorias = $tb_subcategorias;
                $this->tabela_contatos = $tb_contatos;
                $this->tabela_usuarios_administrativos = $tb_usuarios_administrativos;
            }
        }
    }
    /*$pew_db = new Pew_Data_Base("www.efectusdigital.com.br", "efectus_rogerio", "efectusRogerio@123", "efectus_bolsasemcouro", "pew_banners", "pew_categorias", "pew_subcategorias", "pew_contatos", "pew_usuarios_administrativos");*/
    $pew_db = new Pew_Data_Base("localhost", "root", "", "pew_bolsasemcouro", "pew_banners", "pew_categorias", "pew_subcategorias", "pew_contatos", "pew_usuarios_administrativos");
    $conexao = mysqli_connect($pew_db->db_host, $pew_db->db_user, $pew_db->db_pass, $pew_db->db_name);
    /*CLASSE PRINCIPAL DO SISTEMA*/

    /*CLASSE TABELAS CUSTOMIZADAS ADICIONAIS*/
    if(!class_exists("Pew_Custom_Data_Base")){
        class Pew_Custom_Data_Base{
            public $tabela_produtos;
            public $tabela_marcas;
            public $tabela_marcas_produtos;
            public $tabela_cores_produtos;
            public $tabela_imagens_produtos;
            public $tabela_departamentos;
            public $tabela_departamentos_produtos;
            public $tabela_categorias_produtos;
            public $tabela_subcategorias_produtos;
            public $tabela_orcamentos;
            public $tabela_config_orcamentos;
            public $tabela_categorias_vitrine;
            public $tabela_categoria_destaque;
            public $tabela_especificacoes;
            public $tabela_especificacoes_produtos;
            public $tabela_produtos_relacionados;
            public $tabela_newsletter;
            public $tabela_minha_conta;
            public $tabela_enderecos;
            public $tabela_links_menu;

            function __construct($tb_produtos, $tb_marcas, $tb_marcas_produtos, $tb_cores_produtos, $tb_imagens_produtos, $tb_departamentos, $tb_departamentos_produtos, $tb_categorias_produtos, $tb_subcategorias_produtos, $tb_orcamentos, $tb_config_orcamentos, $tb_categorias_vitrine, $tb_categoria_destaque, $tb_especificacoes, $tb_especificacoes_produtos, $tb_produtos_relacionados, $tb_newsletter, $tb_minha_conta, $tb_enderecos, $tb_links_menu){
                $this->tabela_produtos = $tb_produtos;
                $this->tabela_marcas = $tb_marcas;
                $this->tabela_marcas_produtos = $tb_marcas_produtos;
                $this->tabela_cores_produtos = $tb_cores_produtos;
                $this->tabela_imagens_produtos = $tb_imagens_produtos;
                $this->tabela_departamentos = $tb_departamentos;
                $this->tabela_departamentos_produtos = $tb_departamentos_produtos;
                $this->tabela_categorias_produtos = $tb_categorias_produtos;
                $this->tabela_subcategorias_produtos = $tb_subcategorias_produtos;
                $this->tabela_orcamentos = $tb_orcamentos;
                $this->tabela_config_orcamentos = $tb_config_orcamentos;
                $this->tabela_categorias_vitrine = $tb_categorias_vitrine;
                $this->tabela_categoria_destaque = $tb_categoria_destaque;
                $this->tabela_especificacoes = $tb_especificacoes;
                $this->tabela_especificacoes_produtos = $tb_especificacoes_produtos;
                $this->tabela_produtos_relacionados = $tb_produtos_relacionados;
                $this->tabela_newsletter = $tb_newsletter;
                $this->tabela_minha_conta = $tb_minha_conta;
                $this->tabela_enderecos = $tb_enderecos;
                $this->tabela_links_menu = $tb_links_menu;
            }
        }
    }
    $pew_custom_db = new Pew_Custom_Data_Base("pew_produtos", "pew_marcas", "pew_marcas_produtos", "pew_cores_produtos", "pew_imagens_produtos", "pew_departamentos", "pew_departamentos_produtos", "pew_categorias_produtos", "pew_subcategorias_produtos", "pew_orcamentos", "pew_config_orcamentos", "pew_categorias_vitrine", "pew_categoria_destaque", "pew_especificacoes_tecnicas", "pew_especificacoes_produtos", "pew_produtos_relacionados", "pew_newsletter", "pew_minha_conta", "pew_enderecos", "pew_links_menu");
    /*FIM TABELAS CUSTOMIZADAS ADICIONAIS*/

    /*CLASSE SESSÃO ADMINISTRATIVA*/
    if(!class_exists("Pew_Session")){
        class Pew_Session{
            public $name_user;
            public $name_pass;
            public $name_nivel;
            public $name_empresa;

            function __construct($n_user, $n_pass, $n_nivel, $n_empresa){
                $this->name_user = $n_user;
                $this->name_pass = $n_pass;
                $this->name_nivel = $n_nivel;
                $this->name_empresa = $n_empresa;
            }
        }
    }
    $pew_session = new Pew_Session("efectusweb_usuario_administrativo", "efectusweb_senha_administrativo", "efectusweb_nivel_administrativo", "efectusweb_empresa_administrativo");
    /*FIM CLASSE SESSÃO ADMINISTRATIVA*/

    /*FUNCOES DE SEGURANÇA DO SISTEMA*/
    if(!function_exists('pew_string_format')){ /*FUNÇÃO CONTRA SQL INJECTION*/
        function pew_string_format($string){
            //remove tudo que contenha sintaxe sql
            $valCampos = array("'", '"', "update", "from", "select", "insert", "delete", "where", "drop table", "show tables", "#", "*", "--");
            foreach($valCampos as $validacao){
                $string = str_replace($validacao, "", $string);
            }
            $string = trim($string);//limpa espaços vazio
            $string = strip_tags($string);//tira tags html e php
            return $string;
        }
    }
    /*FIM FUNCOES DE SEGURANÇA DO SISTEMA*/

    /*FUNCOES COMPLEMENTARES AO SISTEMA*/
    if(!function_exists('pew_inverter_data')){
        function pew_inverter_data($data){
            if(count(explode("-",$data)) > 1){
                return implode("/",array_reverse(explode("-",$data)));
            }elseif(count(explode("/",$data)) > 1){
                return implode("-",array_reverse(explode("/",$data)));
            }
        }
    }
    if(!function_exists('pew_number_format')){
        function pew_number_format($val, $sep = "."){
            $prepareStr = str_replace(" ", "", $val);
            $prepareStr = str_replace(",", ".", $prepareStr);
            $totalCaracteres = strlen($prepareStr);
            $cleanedVal = floatval(str_replace(".", "", $prepareStr));
            $temPonto = strlen($cleanedVal) < $totalCaracteres ? true : false;
            if($temPonto){
                $explodedVal = explode(".", $prepareStr);
                $totalExplodes = count($explodedVal);
                $indiceLastExplode = $totalExplodes - 1;
                $decimal = strlen($explodedVal[$indiceLastExplode]) == 2 ? true : false;
                if($decimal){
                    $caracteresStrCleaned = strlen($cleanedVal);
                    $totalCaractesMilhar = $caracteresStrCleaned - 2;
                    $milharVal = substr($cleanedVal, 0, $totalCaractesMilhar);
                    $decimalsVal = substr($cleanedVal, $totalCaractesMilhar, 2);
                    $sep = $sep == "." || $sep ==  "," ? $sep : ".";
                    $formatedVal = $milharVal.$sep.$decimalsVal;
                }else{
                    $formatedVal = $cleanedVal.$sep."00";
                }
                return $formatedVal;
            }else{
                return $cleanedVal;
            }
        }
    }
    /*FIM FUNCOES COMPLEMENTARES AO SISTEMA*/

    date_default_timezone_set("America/Sao_Paulo");
?>
