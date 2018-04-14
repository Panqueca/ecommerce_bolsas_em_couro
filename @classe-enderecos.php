<?php
    class Enderecos{
        private $id;
        private $id_relacionado;
        private $ref_relacionado;
        private $cep;
        private $rua;
        private $numero;
        private $complemento;
        private $bairro;
        private $estado;
        private $cidade;
        private $data_cadastro;
        private $data_controle;
        private $status;
        private $endereco_montado;
        private $global_vars;
        private $pew_functions;
        
        function __construct(){
            global $globalVars, $pew_functions;
            $this->global_vars = $globalVars;
            $this->pew_functions = $pew_functions;
            $this->endereco_montado = false;
        }
        
        private function conexao(){
            return $this->global_vars["conexao"];
        }
        
        public function query_endereco($condicao){
            $tabela_enderecos = $this->global_vars["tabela_enderecos"];
            $condicao = str_replace("where", "", $condicao);
            if($this->pew_functions->contar_resultados($tabela_enderecos, $condicao) > 0){
                $query = mysqli_query($this->conexao(), "select id from $tabela_enderecos where $condicao");
                $info = mysqli_fetch_array($query);
                $idEndereco = $info["id"];
                return $idEndereco;
            }else{
                return false;
            }
        }
        
        public function montar_endereco($condicao){
            $tabela_enderecos = $this->global_vars["tabela_enderecos"];
            $condicao = str_replace("where", "", $condicao);
            $getIdEndereco = $this->query_endereco($condicao);
            if($getIdEndereco != false){
                $query = mysqli_query($this->conexao(), "select * from $tabela_enderecos where $condicao");
                $info = mysqli_fetch_array($query);
                $this->id = $info["id"];
                $this->id_relacionado = $info["id_relacionado"];
                $this->ref_relacionado = $info["ref_relacionado"];
                $this->cep = $info["cep"];
                $this->rua = $info["rua"];
                $this->numero = $info["numero"];
                $this->complemento = $info["complemento"];
                $this->bairro = $info["bairro"];
                $this->estado = $info["estado"];
                $this->cidade = $info["cidade"];
                $this->data_cadastro = $info["data_cadastro"];
                $this->data_controle = $info["data_controle"];
                $this->status = $info["status"];
                $this->endereco_montado = true;
            }else{
                return false;
            }
        }
        
        public function get_id(){
            return $this->id;
        }
        
        public function get_id_relacionado(){
            return $this->id_relacionado;
        }
        
        public function get_ref_relacionado(){
            return $this->ref_relacionado;
        }
        
        public function get_cep(){
            return $this->cep;
        }
        
        public function get_rua(){
            return $this->rua;
        }
        
        public function get_numero(){
            return $this->numero;
        }
        
        public function get_complemento(){
            return $this->complemento;
        }
        
        public function get_bairro(){
            return $this->bairro;
        }
        
        public function get_estado(){
            return $this->estado;
        }
        
        public function get_cidade(){
            return $this->cidade;
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
        
        function switch_relacionado($type){
            switch($type){
                case "cliente":
                    $type = 1;
                    break;
                default:
                    $type = 1;
            }
            return $type;
        }
        
        public function montar_array(){
            if($this->endereco_montado == true){
                $infoEndereco = array();
                $infoEndereco["id"] = $this->get_id();
                $infoEndereco["id_relacionado"] = $this->get_id_relacionado();
                $infoEndereco["ref_relacionado"] = $this->get_ref_relacionado();
                $infoEndereco["cep"] = $this->get_cep();
                $infoEndereco["rua"] = $this->get_rua();
                $infoEndereco["numero"] = $this->get_numero();
                $infoEndereco["complemento"] = $this->get_complemento();
                $infoEndereco["bairro"] = $this->get_bairro();
                $infoEndereco["estado"] = $this->get_estado();
                $infoEndereco["cidade"] = $this->get_cidade();
                $infoEndereco["data_cadastro"] = $this->get_data_cadastro();
                $infoEndereco["data_controle"] = $this->get_data_controle();
                $infoEndereco["status"] = $this->get_status();
                return $infoEndereco;
            }else{
                return false;
            }
        }
        
        public function validar_dados(){
            if((int)$this->id_relacionado == 0){
                return "id_relacionado";
            }
            if((int)$this->ref_relacionado == 0){
                return "ref_relacionado";
            }
            if(strlen($this->cep) < 8){
                return "cep";
            }
            if(strlen($this->rua) < 4){
                return "rua";
            }
            if(strlen($this->numero) == 0){
                return "numero";   
            }
            return "true";
        }
        
        private function grava_cadastro(){
            $tabela_enderecos = $this->global_vars["tabela_enderecos"];
            mysqli_query($this->conexao(), "insert into $tabela_enderecos (id_relacionado, ref_relacionado, cep, rua, numero, complemento, bairro, estado, cidade, data_cadastro, data_controle, status) values ('".$this->id_relacionado."', '".$this->ref_relacionado."', '".$this->cep."', '".$this->rua."', '".$this->numero."', '".$this->complemento."', '".$this->bairro."', '".$this->estado."', '".$this->cidade."', '".$this->data_cadastro."', '".$this->data_controle."', 1)");
            return true;
        }
        
        public function cadastra_endereco($id_relacionado, $ref_relacionado, $cep, $rua, $numero, $complemento, $bairro, $estado, $cidade){
            $this->id = null;
            $ref_relacionado = $this->switch_relacionado($ref_relacionado);
            $this->id_relacionado = $id_relacionado;
            $this->ref_relacionado = $ref_relacionado;
            $this->cep = $cep;
            $this->rua = $rua;
            $this->numero = $numero;
            $this->complemento = $complemento;
            $this->bairro = $bairro;
            $this->estado = $estado;
            $this->cidade = $cidade;
            $this->data_cadastro = date("Y-m-d h:i:s");
            $this->data_controle = date("Y-m-d h:i:s");
            $this->status = 1;
            $validacao = $this->validar_dados(); 
            if($validacao == "true"){
                $this->grava_cadastro();
            }else{
                echo $validacao;
            }
        }
        
        public function remove_endereco($idEndereco){
            $tabela_enderecos = $this->global_vars["tabela_enderecos"];
            $idEndereco = (int)$idEndereco;
            if($this->pew_functions->contar_resultados($tabela_enderecos, "id = '$idEndereco'") > 0){
                mysqli_query($this->conexao(), "delete from $tabela_enderecos where id = '$idEndereco'");
                return true;
            }else{
                return false;
            }
        }
        
        public function update_endereco($id_endereco, $id_relacionado, $ref_relacionado, $cep, $rua, $numero, $complemento, $bairro, $estado, $cidade){
            $tabela_enderecos = $this->global_vars["tabela_enderecos"];
            $dataAtual = date("Y-m-d h:i:s");
            
            $ref_relacionado = $this->switch_relacionado($ref_relacionado);
            
            if($this->query_endereco("id = '$id_endereco'") != false){
                
                mysqli_query($this->conexao(), "update $tabela_enderecos set id_relacionado = '$id_relacionado', ref_relacionado = '$ref_relacionado', cep = '$cep', rua = '$rua', numero = '$numero', complemento = '$complemento', bairro = '$bairro', estado = '$estado', cidade = '$cidade', data_controle = '$dataAtual' where id = '$id_endereco'");

                return true;
                
            }else{
                return false;
            }
        }
    }
?>