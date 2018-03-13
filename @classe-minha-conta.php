<?php
    require_once "@include-global-vars.php";
    require_once "@classe-produtos.php";
    require_once "@classe-enderecos.php";

    class MinhaConta{
        private $id;
        private $usuario;
        private $email;
        private $senha;
        private $celular;
        private $telefone;
        private $cpf;
        private $data_nascimento;
        private $sexo;
        private $data_cadastro;
        private $data_controle;
        private $status;
        private $enderecos = array();
        private $quantidade_enderecos;
        private $minha_conta_montada;
        private $global_vars;
        private $pew_functions;
        
        function __construct(){
            global $globalVars, $pew_functions;
            $this->global_vars = $globalVars;
            $this->pew_functions = $pew_functions;
        }
        
        private function conexao(){
            return $this->global_vars["conexao"];
        }
        
        public function query_minha_conta($condicao = 1){
            $tabela_minha_conta = $this->global_vars["tabela_minha_conta"];
            $condicao = str_replace("where", "", $condicao);
            if($this->pew_functions->contar_resultados($tabela_minha_conta, $condicao) > 0){
                $queryMinhaContaID = mysqli_query($this->conexao(), "select id from $tabela_minha_conta where $condicao");
                $infoMinhaConta = mysqli_fetch_array($queryMinhaContaID);
                $idMinhaConta = $infoMinhaConta["id"];
                return $idMinhaConta;
            }else{
                return false;
            }
        }
        
        public function montar_minha_conta($idMinhaConta){
            $tabela_minha_conta = $this->global_vars["tabela_minha_conta"];
            $this->minha_conta_montada = false;
            if($this->pew_functions->contar_resultados($tabela_minha_conta, "id = '$idMinhaConta'") > 0){
                $query = mysqli_query($this->conexao(), "select * from $tabela_minha_conta where id = '$idMinhaConta'");
                $info = mysqli_fetch_array($query);
                $this->id = $info["id"];
                $this->usuario = $info["usuario"];
                $this->email = $info["email"];
                $this->senha = $info["senha"];
                $this->celular = $info["celular"];
                $this->telefone = $info["telefone"];
                $this->cpf = $info["cpf"];
                $this->data_nascimento = $info["data_nascimento"];
                $this->sexo = $info["sexo"];
                $this->data_cadastro = $info["data_cadastro"];
                $this->data_controle = $info["data_controle"];
                $this->status = $info["status"];
                $this->enderecos = "usar_classe_enderecos";
                $this->quantidade_enderecos = "usar_classe_enderecos";
                $this->minha_conta_montada = true;
            }else{
                $this->minha_conta_montada = false;
                return false;
            }
        }
        
        public function get_id(){
            return $this->id;
        }
        
        public function get_usuario(){
            return $this->usuario;
        }
        
        public function get_email(){
            return $this->email;
        }
        
        public function get_senha(){
            return $this->senha;
        }
        
        public function get_celular(){
            return $this->celular;
        }
        
        public function get_telefone(){
            return $this->telefone;
        }
        
        public function get_cpf(){
            return $this->cpf;
        }
        
        public function get_data_nascimento(){
            return $this->data_nascimento;
        }
        
        public function get_sexo(){
            return $this->sexo;
        }
        
        public function get_data_cadastro(){
            return $this->data_cadastro;
        }
        
        public function get_data_controle(){
            return $this->data_controle;
        }
        
        public function get_status(){
            return $this->status;
        }
        
        public function get_enderecos(){
            return $this->enderecos;
        }
        
        public function get_quantidade_enderecos(){
            return $this->quantidade_enderecos;
        }
        
        public function montar_array(){
            if($this->minha_conta_montada == true){
                $infoMinhaConta = array();
                $infoMinhaConta["id"] = $this->get_id();
                $infoMinhaConta["usuario"] = $this->get_usuario();
                $infoMinhaConta["email"] = $this->get_email();
                $infoMinhaConta["senha"] = $this->get_senha();
                $infoMinhaConta["celular"] = $this->get_celular();
                $infoMinhaConta["telefone"] = $this->get_telefone();
                $infoMinhaConta["cpf"] = $this->get_cpf();
                $infoMinhaConta["data_nascimento"] = $this->get_data_nascimento();
                $infoMinhaConta["sexo"] = $this->get_sexo();
                $infoMinhaConta["data_cadastro"] = $this->get_data_cadastro();
                $infoMinhaConta["data_controle"] = $this->get_data_controle();
                $infoMinhaConta["status"] = $this->get_status();
                $infoMinhaConta["enderecos"] = $this->get_enderecos();
                $infoMinhaConta["quantidade_enderecos"] = $this->get_quantidade_enderecos();
                return $infoMinhaConta;
            }else{
                return false;
            }
        }
        
        public function validar_dados(){
            if(strlen($this->usuario) < 3){
                return "usuario";
            }
            if($this->pew_functions->validar_email($this->email) == false){
                return "email";
            }
            if(strlen($this->senha) < 6){
                return "senha";
            }
            if(strlen($this->celular) < 14){
                return "celular";
            }
            if($this->telefone != null && strlen($this->telefone) < 14){
                return "telefone";
            }
            if(strlen($this->cpf) < 11 || strlen($this->cpf) > 11){
                return "cpf";
            }
            if($this->enderecos == null){
                return "validar enderecos";
            }
            return "true";
        }
        
        private function grava_conta(){
            $tabela_minha_conta = $this->global_vars["tabela_minha_conta"];
            $alreadySubscribed = $this->pew_functions->contar_resultados($tabela_minha_conta, "email = '".$this->email."' or cpf = '".$this->cpf."'");
            if($alreadySubscribed == 0){
                $this->senha = md5($this->senha);
                mysqli_query($this->conexao(), "insert into $tabela_minha_conta (usuario, email, senha, celular, telefone, cpf, data_nascimento, sexo, data_cadastro, data_controle, status) values ('".$this->usuario."', '".$this->email."', '".$this->senha."', '".$this->celular."', '".$this->telefone."', '".$this->cpf."', '".$this->data_nascimento."', '".$this->sexo."', '".$this->data_cadastro."', '".$this->data_controle."', 0)");
                $selectID = mysqli_query($this->conexao(), "select last_insert_id()");
                $selectedID = mysqli_fetch_assoc($selectID);
                $selectedID = $selectedID["last_insert_id()"];
                return $selectedID;
            }else{
                return false;
            }
        }
        
        public function cadastrar_conta($usuario, $email, $senha, $celular, $telefone, $cpf, $data_nascimento, $sexo, $enderecos){
            $this->id = null;
            $this->usuario = $usuario;
            $this->email = $email;
            $this->senha = $senha;
            $this->celular = $celular;
            $this->telefone = $telefone;
            $this->cpf = $cpf;
            $this->data_nascimento = $data_nascimento;
            $this->sexo = $sexo;
            $this->data_cadastro = date("Y-m-d h:i:s");
            $this->data_controle = date("Y-m-d h:i:s");
            $this->enderecos = $enderecos;
            $this->quantidade_enderecos = 0;
            $this->status = 0;
            
            
            $validacao = $this->validar_dados();
            if($validacao == "true"){
                $idConta = $this->grava_conta();
                if((int)$idConta != 0){
                    /*ENDERECO*/
                    $ctrlEnderecos = 0;
                    foreach($enderecos as $infoEndereco){
                        $cep = $infoEndereco["cep"];
                        $rua = $infoEndereco["rua"];
                        $numero = $infoEndereco["numero"];
                        $complemento = $infoEndereco["complemento"];
                        $cadastraEndereco[$ctrlEnderecos] = new Enderecos();
                        $cadastraEndereco[$ctrlEnderecos]->cadastra_endereco($idConta, "cliente", $cep, $rua, $numero, $complemento);
                        $ctrlEnderecos++;
                    }
                }else{
                    return false;
                }
            }else{
                echo $validacao;
            }
        }
    }
?>