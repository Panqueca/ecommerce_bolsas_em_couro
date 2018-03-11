<?php
    require_once "@include-global-vars.php";
    require_once "@classe-system-functions.php";
    class Produtos{
        private $id;
        private $sku;
        private $nome;
        private $preco;
        private $preco_promocao;
        private $promocao_ativa;
        private $marca;
        private $estoque;
        private $estoque_baixo;
        private $tempo_fabricacao;
        private $descricao_curta;
        private $descricao_longa;
        private $peso;
        private $comprimento;
        private $largura;
        private $altura;
        private $imagens = array();
        private $cores = array();
        private $data;
        private $visualizacoes;
        private $status;
        private $produto_montado;
        protected $global_vars;
        protected $pew_functions;

        function __construct(){
            global $globalVars, $pew_functions;
            $this->global_vars = $globalVars;
            $this->pew_functions = $pew_functions;
            $produto_montado = false;
        }

        private function conexao(){
            return $this->global_vars["conexao"];
        }

        public function query_produto($condicao = 1){
            $tabela_produtos = $this->global_vars["tabela_produtos"];
            $condicao = str_replace("where", "", $condicao);
            if($this->pew_functions->contar_resultados($tabela_produtos, $condicao) > 0){
                $queryProduto = mysqli_query($this->conexao(), "select id from $tabela_produtos where $condicao");
                $infoProduto = mysqli_fetch_array($queryProduto);
                $idProduto = $infoProduto["id"];
                return $idProduto;
            }else{
                return false;
            }
        }

        public function montar_produto($idProduto){
            $tabela_produtos = $this->global_vars["tabela_produtos"];
            $tabela_imagens_produtos = $this->global_vars["tabela_imagens_produtos"];
            $this->produto_montado = false;
            if($this->pew_functions->contar_resultados($tabela_produtos, "id = '$idProduto'") > 0){
                $query = mysqli_query($this->conexao(), "select * from $tabela_produtos where id = '$idProduto'");
                $info = mysqli_fetch_array($query);
                $this->id = $info["id"];
                $this->sku = $info["sku"];
                $this->nome = $info["nome"];
                $this->preco = $this->pew_functions->custom_number_format($info["preco"]);
                $this->preco_promocao = $this->pew_functions->custom_number_format($info["preco_promocao"]);
                $this->promocao_ativa = $this->pew_functions->custom_number_format($info["promocao_ativa"]);
                $this->marca = $info["marca"];
                $this->estoque = $info["estoque"];
                $this->estoque_baixo = $info["estoque_baixo"];
                $this->tempo_fabricacao = $info["tempo_fabricacao"];
                $this->descricao_curta = $info["descricao_curta"];
                $this->descricao_longa = $info["descricao_longa"];
                $this->peso = $info["peso"];
                $this->comprimento = $info["comprimento"];
                $this->largura = $info["largura"];
                $this->altura = $info["altura"];
                $this->data = $info["data"];
                $this->visualizacoes = $info["visualizacoes"];
                $this->produto_montado = true;
                $info_produto = array();
                if($this->pew_functions->contar_resultados($tabela_imagens_produtos, "where id_produto = '$idProduto'") > 0){
                    $queryImagens = mysqli_query($this->conexao(), "select * from $tabela_imagens_produtos where id_produto = '$idProduto'");
                    $ctrlImagens = 0;
                    while($infoImagens = mysqli_fetch_array($queryImagens)){
                        $this->imagens[$ctrlImagens] = $infoImagens["imagem"];
                        $ctrlImagens++;
                    }
                }
            }else{
                $this->produto_montado = false;
                return false;
            }
        }
        public function get_id_produto(){
            return $this->id;
        }
        public function get_sku_produto(){
            return $this->sku;
        }
        public function get_nome_produto(){
            return $this->nome;
        }
        public function get_preco_produto(){
            return $this->preco;
        }
        public function get_preco_promocao_produto(){
            return $this->preco_promocao;
        }
        public function get_promocao_ativa(){
            return $this->promocao_ativa;
        }
        public function get_marca_produto(){
            return $this->marca;
        }
        public function get_estoque_produto(){
            return $this->estoque;
        }
        public function get_estoque_baixo_produto(){
            return $this->estoque_baixo;
        }
        public function get_tempo_fabricacao_produto(){
            return $this->tempo_fabricacao;
        }
        public function get_descricao_curta_produto(){
            return $this->descricao_curta;
        }
        public function get_descricao_longa_produto(){
            return $this->descricao_longa;
        }
        public function get_peso_produto(){
            return $this->peso;
        }
        public function get_comprimento_produto(){
            return $this->comprimento;
        }
        public function get_largura_produto(){
            return $this->largura;
        }
        public function get_altura_produto(){
            return $this->altura;
        }
        public function get_imagens_produto(){
            return $this->imagens;
        }
        public function get_data_produto(){
            return $this->data;
        }
        public function get_visualizacoes_produto(){
            return $this->visualizacoes;
        }
        public function montar_array(){
            if($this->produto_montado == true){
                $infoProduto = array();
                $infoProduto["id"] = $this->get_id_produto();
                $infoProduto["sku"] = $this->get_sku_produto();
                $infoProduto["nome"] = $this->get_nome_produto();
                $infoProduto["preco"] = $this->get_preco_produto();
                $infoProduto["preco_promocao"] = $this->get_preco_promocao_produto();
                $infoProduto["promocao_ativa"] = $this->get_promocao_ativa();
                $infoProduto["marca"] = $this->get_marca_produto();
                $infoProduto["estoque"] = $this->get_estoque_produto();
                $infoProduto["estoque_baixo"] = $this->get_estoque_baixo_produto();
                $infoProduto["tempo_fabricacao"] = $this->get_tempo_fabricacao_produto();
                $infoProduto["descricao_curta"] = $this->get_descricao_curta_produto();
                $infoProduto["descricao_longa"] = $this->get_descricao_longa_produto();
                $infoProduto["peso"] = $this->get_peso_produto();
                $infoProduto["comprimento"] = $this->get_comprimento_produto();
                $infoProduto["largura"] = $this->get_largura_produto();
                $infoProduto["altura"] = $this->get_altura_produto();
                $infoProduto["imagens"] = $this->get_imagens_produto();
                $infoProduto["data"] = $this->get_data_produto();
                $infoProduto["visualizacoes"] = $this->get_visualizacoes_produto();
                return $infoProduto;
            }else{
                return false;
            }
        }
    }
?>
