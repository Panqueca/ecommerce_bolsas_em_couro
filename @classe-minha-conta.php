<?php
    require_once "@include-global-vars.php";
    require_once "@classe-produtos.php";

    class MinhaConta(){
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
        
        function __construct(){
            global $globalVars;
            $this->global_vars = $globalVars;
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
        
        public function montar_array(){
               
        }
    }
?>