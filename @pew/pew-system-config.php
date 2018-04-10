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
            public $tabela_cores;
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
            public $tabela_cores_relacionadas;
            public $tabela_newsletter;
            public $tabela_minha_conta;
            public $tabela_enderecos;
            public $tabela_links_menu;
            public $tabela_dicas;

            function __construct($tb_produtos, $tb_marcas, $tb_marcas_produtos, $tb_cores, $tb_cores_produtos, $tb_imagens_produtos, $tb_departamentos, $tb_departamentos_produtos, $tb_categorias_produtos, $tb_subcategorias_produtos, $tb_orcamentos, $tb_config_orcamentos, $tb_categorias_vitrine, $tb_categoria_destaque, $tb_especificacoes, $tb_especificacoes_produtos, $tb_produtos_relacionados, $tb_cores_relacionadas, $tb_newsletter, $tb_minha_conta, $tb_enderecos, $tb_links_menu, $tb_dicas){
                $this->tabela_produtos = $tb_produtos;
                $this->tabela_marcas = $tb_marcas;
                $this->tabela_marcas_produtos = $tb_marcas_produtos;
                $this->tabela_cores = $tb_cores;
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
                $this->tabela_cores_relacionadas = $tb_cores_relacionadas;
                $this->tabela_newsletter = $tb_newsletter;
                $this->tabela_minha_conta = $tb_minha_conta;
                $this->tabela_enderecos = $tb_enderecos;
                $this->tabela_links_menu = $tb_links_menu;
                $this->tabela_dicas = $tb_dicas;
            }
        }
    }
    $pew_custom_db = new Pew_Custom_Data_Base("pew_produtos", "pew_marcas", "pew_marcas_produtos", "pew_cores", "pew_cores_produtos", "pew_imagens_produtos", "pew_departamentos", "pew_departamentos_produtos", "pew_categorias_produtos", "pew_subcategorias_produtos", "pew_orcamentos", "pew_config_orcamentos", "pew_categorias_vitrine", "pew_categoria_destaque", "pew_especificacoes_tecnicas", "pew_especificacoes_produtos", "pew_produtos_relacionados", "pew_cores_relacionadas", "pew_newsletter", "pew_minha_conta", "pew_enderecos", "pew_links_menu", "pew_dicas");
    /*FIM TABELAS CUSTOMIZADAS ADICIONAIS*/

    /*GLOBAL VARS*/
    $globalVars = array(
        "conexao" => $conexao,
        "tabela_categorias" => $pew_db->tabela_categorias,
        "tabela_subcategorias" => $pew_db->tabela_subcategorias,
        "tabela_produtos" => $pew_custom_db->tabela_produtos,
        "tabela_cores" => $pew_custom_db->tabela_cores,
        "tabela_cores_produtos" => $pew_custom_db->tabela_cores_produtos,
        "tabela_marcas_produtos" => $pew_custom_db->tabela_marcas_produtos,
        "tabela_imagens_produtos" => $pew_custom_db->tabela_imagens_produtos,
        "tabela_departamentos" => $pew_custom_db->tabela_departamentos,
        "tabela_departamentos_produtos" => $pew_custom_db->tabela_departamentos_produtos,
        "tabela_categorias_produtos" => $pew_custom_db->tabela_categorias_produtos,
        "tabela_subcategorias_produtos" => $pew_custom_db->tabela_subcategorias_produtos,
        "tabela_categorias_vitrine" => $pew_custom_db->tabela_categorias_vitrine,
        "tabela_categoria_destaque" => $pew_custom_db->tabela_categoria_destaque,
        "tabela_especificacoes" => $pew_custom_db->tabela_especificacoes,
        "tabela_especificacoes_produtos" => $pew_custom_db->tabela_especificacoes_produtos,
        "tabela_produtos_relacionados" => $pew_custom_db->tabela_produtos_relacionados,
        "tabela_minha_conta" => $pew_custom_db->tabela_minha_conta,
        "tabela_enderecos" => $pew_custom_db->tabela_enderecos,
    );
    global $globalVars;

    /*END GLOBAL VARS*/

    // Aditional Functions
    require_once "@classe-system-functions.php";

    /*CLASSE SESSÃO ADMINISTRATIVA*/
    if(!class_exists("Pew_Session")){
        class Pew_Session{
            public $usuario;
            public $senha;
            public $nivel;
            public $empresa;

            function __construct($usuario, $senha, $nivel, $empresa){
                $this->usuario = $usuario;
                $this->senha = $senha;
                $this->nivel = $nivel;
                $this->empresa = $empresa;
            }
            
            function auth(){
                global $pew_db, $pew_functions, $conexao;
                $tabela_usuarios_administrativos = $pew_db->tabela_usuarios_administrativos;
                $authCondition = "usuario = '" . $this->usuario . "' and senha = '" . $this->senha . "'";
                $totalUsuario = $pew_functions->contar_resultados($tabela_usuarios_administrativos, $authCondition);
                if($totalUsuario > 0){
                    return true;
                }else{
                    return false;
                }
            }
            
            function block_level(){
                echo "<h3 align=center style='padding-top: 150px;'><i class='fas fa-exclamation-triangle'></i><br>Acesso restrito<br>Você não pode acessar esta página.<br><br> Qualquer dúvida entre em contato com a <a href='https://www.efectusdigital.com.br' target='_blank' class='link-padrao'>Efectus Digital</a></h3>";
                die();
            }
        }
    }
    /*FIM CLASSE SESSÃO ADMINISTRATIVA*/

    date_default_timezone_set("America/Sao_Paulo");
?>
