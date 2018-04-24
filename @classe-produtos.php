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
        private $desconto_relacionado;
        private $marca;
        private $id_cor;
        private $estoque;
        private $estoque_baixo;
        private $tempo_fabricacao;
        private $descricao_curta;
        private $descricao_longa;
        private $url_video;
        private $peso;
        private $comprimento;
        private $largura;
        private $altura;
        private $imagens = array();
        private $cores = array();
        private $especificacoes_tecnicas = array();
        private $data;
        private $departamentos = array();
        private $categorias = array();
        private $subcategorias = array();
        private $relacionados = array();
        private $visualizacoes;
        private $status;
        private $produto_montado;
        protected $global_vars;
        protected $pew_functions;

        function __construct(){
            global $globalVars, $pew_functions;
            $this->global_vars = $globalVars;
            $this->pew_functions = $pew_functions;
            $this->produto_montado = false;
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
        
        function get_referencias($type = null, $condicao = 1){
            $tabela_departamentos = $this->global_vars["tabela_departamentos"];
            $tabela_categorias = $this->global_vars["tabela_categorias"];
            $tabela_subcategorias = $this->global_vars["tabela_subcategorias"];
            
            $retorno = false;
            $retorno = array();
            
            switch($type){
                case "departamento":
                    $query = mysqli_query($this->conexao(), "select departamento, descricao from $tabela_departamentos where $condicao");
                    $info = mysqli_fetch_array($query);
                    $retorno["titulo"] = $info["departamento"];
                    $retorno["descricao"] = $info["descricao"];
                    break;
                case "categoria":
                    $query = mysqli_query($this->conexao(), "select categoria, descricao from $tabela_categorias where $condicao");
                    $info = mysqli_fetch_array($query);
                    $retorno["titulo"] = $info["categoria"];
                    $retorno["descricao"] = $info["descricao"];
                    break;
                case "subcategoria":
                    $query = mysqli_query($this->conexao(), "select subcategoria, descricao from $tabela_subcategorias where $condicao");
                    $info = mysqli_fetch_array($query);
                    $retorno["titulo"] = $info["subcategoria"];
                    $retorno["descricao"] = $info["descricao"];
                    break;
            }
            
            return $retorno;
        }
        
        function search_departamentos_produtos($condicao){
            $tabela_departamentos = $this->global_vars["tabela_departamentos"];
            $tabela_departamentos_produtos = $this->global_vars["tabela_departamentos_produtos"];
            
            $condicao = str_replace("where", "", $condicao);
            $query = mysqli_query($this->conexao(), "select id from $tabela_departamentos where $condicao");
            $selectedProdutos = array();
            $ctrl = 0;
            while($array = mysqli_fetch_array($query)){
                $idDepatamento = $array["id"];
                $queryProds = mysqli_query($this->conexao(), "select id_produto from $tabela_departamentos_produtos where id_departamento = '$idDepatamento'");
                while($info = mysqli_fetch_array($queryProds)){
                    $selectedProdutos[$ctrl] = $info["id_produto"];
                    $ctrl++;
                }
            }
            
            return $selectedProdutos;
        }
        
        function search_categorias_produtos($condicao){
            $tabela_categorias = $this->global_vars["tabela_categorias"];
            $tabela_categorias_produtos = $this->global_vars["tabela_categorias_produtos"];
            
            $condicao = str_replace("where", "", $condicao);
            $query = mysqli_query($this->conexao(), "select id from $tabela_categorias where $condicao");
            $selectedProdutos = array();
            $ctrl = 0;
            while($array = mysqli_fetch_array($query)){
                $idCategoria = $array["id"];
                $queryProds = mysqli_query($this->conexao(), "select id_produto from $tabela_categorias_produtos where id_categoria = '$idCategoria'");
                while($info = mysqli_fetch_array($queryProds)){
                    $selectedProdutos[$ctrl] = $info["id_produto"];
                    $ctrl++;
                }
            }
            
            return $selectedProdutos;
        }
        
        function search_subcategorias_produtos($condicao){
            $tabela_subcategorias = $this->global_vars["tabela_subcategorias"];
            $tabela_subcategorias_produtos = $this->global_vars["tabela_subcategorias_produtos"];
            
            $condicao = str_replace("where", "", $condicao);
            $query = mysqli_query($this->conexao(), "select id from $tabela_subcategorias where $condicao");
            $selectedProdutos = array();
            $ctrl = 0;
            while($array = mysqli_fetch_array($query)){
                $idSubcategoria = $array["id"];
                $queryProds = mysqli_query($this->conexao(), "select id_produto from $tabela_subcategorias_produtos where id_subcategoria = '$idSubcategoria'");
                while($info = mysqli_fetch_array($queryProds)){
                    $selectedProdutos[$ctrl] = $info["id_produto"];
                    $ctrl++;
                }
            }
            
            return $selectedProdutos;
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
                $this->desconto_relacionado = $this->pew_functions->custom_number_format($info["desconto_relacionado"]);
                $this->marca = $info["marca"];
                $this->id_cor = $info["id_cor"];
                $this->estoque = $info["estoque"];
                $this->estoque_baixo = $info["estoque_baixo"];
                $this->tempo_fabricacao = $info["tempo_fabricacao"];
                $this->descricao_curta = $info["descricao_curta"];
                $this->descricao_longa = $info["descricao_longa"];
                $this->url_video = $info["url_video"];
                $this->peso = $info["peso"];
                $this->comprimento = $info["comprimento"];
                $this->largura = $info["largura"];
                $this->altura = $info["altura"];
                $this->data = $info["data"];
                $this->visualizacoes = $info["visualizacoes"];
                $this->status = $info["status"];
                $this->produto_montado = true;
                $info_produto = array();
                if($this->pew_functions->contar_resultados($tabela_imagens_produtos, "where id_produto = '$idProduto'") > 0){
                    $queryImagens = mysqli_query($this->conexao(), "select id, imagem from $tabela_imagens_produtos where id_produto = '$idProduto'");
                    $ctrlImagens = 0;
                    while($infoImagens = mysqli_fetch_array($queryImagens)){
                        $this->imagens[$ctrlImagens] = array();
                        $this->imagens[$ctrlImagens]["id_imagem"] = $infoImagens["id"];
                        $this->imagens[$ctrlImagens]["src"] = $infoImagens["imagem"];
                        $ctrlImagens++;
                    }
                }
                return true;
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
        public function get_desconto_relacionado(){
            return $this->desconto_relacionado;
        }
        public function get_marca_produto(){
            return $this->marca;
        }
        public function get_id_cor_produto(){
            return $this->id_cor;
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
        public function get_url_video_produto(){
            return $this->url_video;
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
        public function get_especificacoes_produto(){
            $condicao = "id_produto = '".$this->id."'";
            $tabela_especificacoes = $this->global_vars["tabela_especificacoes"];
            $tabela_especificacoes_produtos = $this->global_vars["tabela_especificacoes_produtos"];
            $totalEspecificacoes = $this->pew_functions->contar_resultados($tabela_especificacoes_produtos, $condicao);
            $return = false;
            if($totalEspecificacoes > 0){
                $return = array();
                $ctrlEspecificacoes = 0;
                $queryDepartamentos = mysqli_query($this->conexao(), "select id_especificacao, descricao from $tabela_especificacoes_produtos where $condicao");
                while($infoEspecProd = mysqli_fetch_array($queryDepartamentos)){
                    $condition = "id = '".$infoEspecProd["id_especificacao"]."'";
                    $totalEspec = $this->pew_functions->contar_resultados($tabela_especificacoes, $condition);
                    if($totalEspec > 0){
                        $queryEspec = mysqli_query($this->conexao(), "select titulo from $tabela_especificacoes where $condition");
                        $infoEspecificacao = mysqli_fetch_array($queryEspec);
                        $return[$ctrlEspecificacoes] = array();
                        $return[$ctrlEspecificacoes]["id"] = $infoEspecProd["id_especificacao"];
                        $return[$ctrlEspecificacoes]["descricao"] = $infoEspecProd["descricao"];
                        $return[$ctrlEspecificacoes]["titulo"] = $infoEspecificacao["titulo"];
                        $ctrlEspecificacoes++;
                    }
                }
            }
            return $return;
        }
        public function get_data_produto(){
            return $this->data;
        }
        public function get_departamentos_produto(){
            $condicao = "id_produto = '".$this->id."'";
            $tabela_departamentos = $this->global_vars["tabela_departamentos"];
            $tabela_departamentos_produtos = $this->global_vars["tabela_departamentos_produtos"];
            $totalDepartamentos = $this->pew_functions->contar_resultados($tabela_departamentos_produtos, $condicao);
            $return = false;
            if($totalDepartamentos > 0){
                $return = array();
                $ctrlDepartamentos = 0;
                $queryDepartamentos = mysqli_query($this->conexao(), "select id_departamento from $tabela_departamentos_produtos where $condicao");
                while($infoDepartamentoProd = mysqli_fetch_array($queryDepartamentos)){
                    $condition = "id = '".$infoDepartamentoProd["id_departamento"]."'";
                    $totalDepart = $this->pew_functions->contar_resultados($tabela_departamentos, $condition);
                    if($totalDepart > 0){
                        $queryDepart = mysqli_query($this->conexao(), "select departamento, ref from $tabela_departamentos where $condition");
                        $infoDepartamento = mysqli_fetch_array($queryDepart);
                        $return[$ctrlDepartamentos] = array();
                        $return[$ctrlDepartamentos]["id"] = $infoDepartamentoProd["id_departamento"];
                        $return[$ctrlDepartamentos]["titulo"] = $infoDepartamento["departamento"];
                        $return[$ctrlDepartamentos]["ref"] = $infoDepartamento["ref"];
                        $ctrlDepartamentos++;
                    }
                }
            }
            return $return;
        }
        public function get_categorias_produto(){
            $condicao = "id_produto = '".$this->id."'";
            $tabela_categorias = $this->global_vars["tabela_categorias"];
            $tabela_categorias_produtos = $this->global_vars["tabela_categorias_produtos"];
            $totalCategorias = $this->pew_functions->contar_resultados($tabela_categorias_produtos, $condicao);
            $return = false;
            if($totalCategorias > 0){
                $return = array();
                $ctrlCategorias = 0;
                $queryCategorias = mysqli_query($this->conexao(), "select id_categoria from $tabela_categorias_produtos where $condicao");
                while($infoCategoriaProd = mysqli_fetch_array($queryCategorias)){
                    $condition = "id = '".$infoCategoriaProd["id_categoria"]."'";
                    $totalCategoria = $this->pew_functions->contar_resultados($tabela_categorias, $condition);
                    if($totalCategoria > 0){
                        $queryCategoria = mysqli_query($this->conexao(), "select categoria, ref from $tabela_categorias where $condition");
                        $infoCategoria = mysqli_fetch_array($queryCategoria);
                        $return[$ctrlCategorias] = array();
                        $return[$ctrlCategorias]["id"] = $infoCategoriaProd["id_categoria"];
                        $return[$ctrlCategorias]["titulo"] = $infoCategoria["categoria"];
                        $return[$ctrlCategorias]["ref"] = $infoCategoria["ref"];
                        $ctrlCategorias++;
                    }
                }
            }
            return $return;
        }
        public function get_subcategorias_produto(){
            $condicao = "id_produto = '".$this->id."'";
            $tabela_subcategorias = $this->global_vars["tabela_subcategorias"];
            $tabela_subcategorias_produtos = $this->global_vars["tabela_subcategorias_produtos"];
            $totalSubcategorias = $this->pew_functions->contar_resultados($tabela_subcategorias_produtos, $condicao);
            $return = false;
            if($totalSubcategorias > 0){
                $return = array();
                $ctrlSubcategorias = 0;
                $querySubcategorias = mysqli_query($this->conexao(), "select id_subcategoria from $tabela_subcategorias_produtos where $condicao");
                while($infoSubcategoriaProd = mysqli_fetch_array($querySubcategorias)){
                    $condition = "id = '".$infoSubcategoriaProd["id_subcategoria"]."'";
                    $totalSubcategoria = $this->pew_functions->contar_resultados($tabela_subcategorias, $condition);
                    if($totalSubcategoria > 0){
                        $querySubcategoria = mysqli_query($this->conexao(), "select subcategoria, id_categoria, ref from $tabela_subcategorias where $condition");
                        $infoSubcategoria = mysqli_fetch_array($querySubcategoria);
                        $return[$ctrlSubcategorias] = array();
                        $return[$ctrlSubcategorias]["id_subcategoria"] = $infoSubcategoriaProd["id_subcategoria"];
                        $return[$ctrlSubcategorias]["id_categoria"] = $infoSubcategoria["id_categoria"];
                        $return[$ctrlSubcategorias]["titulo"] = $infoSubcategoria["subcategoria"];
                        $return[$ctrlSubcategorias]["ref"] = $infoSubcategoria["ref"];
                        $ctrlSubcategorias++;
                    }
                }
            }
            return $return;
        }
        public function get_relacionados_produto($idProduto = null, $condicao = null){
            $idProduto = $idProduto == null ? $this->id : $idProduto;
            $condicao = $condicao == null ? "id_produto = '$idProduto'" : $condicao;
            $tabela_produtos = $this->global_vars["tabela_produtos"];
            $tabela_produtos_relacionados = $this->global_vars["tabela_produtos_relacionados"];
            $totalEspecificacoes = $this->pew_functions->contar_resultados($tabela_produtos_relacionados, $condicao);
            $return = false;
            if($totalEspecificacoes > 0){
                $return = array();
                $ctrlEspecificacoes = 0;
                $queryRelacionados = mysqli_query($this->conexao(), "select id_relacionado, id_produto from $tabela_produtos_relacionados where $condicao");
                while($infoRelacionado = mysqli_fetch_array($queryRelacionados)){
                    $condition = "id = '".$infoRelacionado["id_relacionado"]."'";
                    $totalProdRelacionado = $this->pew_functions->contar_resultados($tabela_produtos, $condition);
                    if($totalProdRelacionado > 0){
                        $return[$ctrlEspecificacoes] = array();
                        $return[$ctrlEspecificacoes]["id_relacionado"] = $infoRelacionado["id_relacionado"];
                        $return[$ctrlEspecificacoes]["id_produto"] = $infoRelacionado["id_produto"];
                        $ctrlEspecificacoes++;
                    }
                }
            }
            return $return;
        }
            
        public function get_cores_relacionadas(){
            $condicao = "id_produto = '".$this->id."'";
            $tabela_produtos = $this->global_vars["tabela_produtos"];
            $tabela_cores_relacionadas = $this->global_vars["tabela_cores_relacionadas"];
            $totalCoresRelacionadas = $this->pew_functions->contar_resultados($tabela_cores_relacionadas, $condicao);
            $return = false;
            if($totalCoresRelacionadas > 0){
                $return = array();
                $ctrlCoresRelacionadas = 0;
                $queryRelacionados = mysqli_query($this->conexao(), "select id_relacao from $tabela_cores_relacionadas where $condicao");
                while($infoRelacionado = mysqli_fetch_array($queryRelacionados)){
                    $condition = "id_relacao = '{$infoRelacionado["id_relacao"]}'";
                    $totalProdRelacionado = $this->pew_functions->contar_resultados($tabela_cores_relacionadas, $condition);
                    if($totalProdRelacionado > 0){
                        $return[$ctrlCoresRelacionadas] = array();
                        $return[$ctrlCoresRelacionadas]["id_relacao"] = $infoRelacionado["id_relacao"];
                        $ctrlCoresRelacionadas++;
                    }
                }
            }
            return $return;
        }
        
        public function get_preco_relacionado($id){
            $condicao = "id = $id";
            $tabela_produtos = $this->global_vars["tabela_produtos"];
            
            $total = $this->pew_functions->contar_resultados($tabela_produtos, $condicao);
            if($total > 0){
                $this->montar_produto($id);
                
                $intPorcentoDesconto = 5;
                $multiplicador = $intPorcentoDesconto * 0.01;

                if($this->promocao_ativa == 1 && $this->preco_promocao > 0 && $this->preco_promocao < $this->preco){
                    $desconto = $this->preco_promocao * $multiplicador;
                    $precoCompreJunto = $this->preco_promocao - $desconto;
                }else{
                    $desconto = $this->preco * $multiplicador;
                    $precoCompreJunto = $this->preco - $desconto;
                }
                
                $retorno = array();
                $retorno["valor"] = $precoCompreJunto;
                $retorno["desconto"] = $intPorcentoDesconto;
                
                return $retorno;
            }else{
                return false;
            }
        }
        
        public function get_visualizacoes_produto(){
            return $this->visualizacoes;
        }
        public function get_status_produto(){
            return $this->status;   
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
                $infoProduto["desconto_relacionado"] = $this->get_desconto_relacionado();
                $infoProduto["marca"] = $this->get_marca_produto();
                $infoProduto["id_cor"] = $this->get_id_cor_produto();
                $infoProduto["estoque"] = $this->get_estoque_produto();
                $infoProduto["estoque_baixo"] = $this->get_estoque_baixo_produto();
                $infoProduto["tempo_fabricacao"] = $this->get_tempo_fabricacao_produto();
                $infoProduto["descricao_curta"] = $this->get_descricao_curta_produto();
                $infoProduto["descricao_longa"] = $this->get_descricao_longa_produto();
                $infoProduto["url_video"] = $this->get_url_video_produto();
                $infoProduto["peso"] = $this->get_peso_produto();
                $infoProduto["comprimento"] = $this->get_comprimento_produto();
                $infoProduto["largura"] = $this->get_largura_produto();
                $infoProduto["altura"] = $this->get_altura_produto();
                $infoProduto["imagens"] = $this->get_imagens_produto();
                $infoProduto["data"] = $this->get_data_produto();
                $infoProduto["visualizacoes"] = $this->get_visualizacoes_produto();
                $infoProduto["status"] = $this->get_status_produto();
                return $infoProduto;
            }else{
                return false;
            }
        }
    }
?>
