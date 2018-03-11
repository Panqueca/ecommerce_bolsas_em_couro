<?php
    require_once "@include-global-vars.php";
    class systemFunctions{
        protected $global_vars;

        function __construct(){
            global $globalVars;
            $this->global_vars = $globalVars;
        }

        private function conexao(){
            return $this->global_vars["conexao"];
        }

        public function contar_resultados($table, $condicao = ""){
            $condicao = str_replace("where", "", $condicao);
            $contar = mysqli_query($this->conexao(), "select count(id) as total from $table where $condicao") or die("Não foi possível buscar os dados");
            $contagem = mysqli_fetch_assoc($contar);
            $total = $contagem["total"];
            return $total;
        }

        public function custom_number_format($val, $sep = "."){
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

        public function url_format($string){
            $string = str_replace("Ç", "c", $string);
            $string = str_replace("ç", "c", $string);
            $string = preg_replace(array("/(á|à|ã|â|ä)/","/(Á|À|Ã|Â|Ä)/","/(é|è|ê|ë)/","/(É|È|Ê|Ë)/","/(í|ì|î|ï)/","/(Í|Ì|Î|Ï)/","/(ó|ò|õ|ô|ö)/","/(Ó|Ò|Õ|Ô|Ö)/","/(ú|ù|û|ü)/","/(Ú|Ù|Û|Ü)/","/(ñ)/","/(Ñ)/"),explode(" ","a A e E i I o O u U n N"), $string);
            $string = strtolower($string);
            $string = str_replace("/", "-", $string);
            $string = str_replace("|", "-", $string);
            $string = str_replace(" ", "-", $string);
            $string = str_replace(",", "", $string);
            return $string;
        }

        public function sqli_format($string){
            //remove tudo que contenha sintaxe sql
            $valCampos = array("'", '"', "update", "from", "select", "insert", "delete", "where", "drop table", "show tables", "#", "*", "--");
            foreach($valCampos as $validacao){
                $string = str_replace($validacao, "", $string);
            }
            $string = trim($string);//limpa espaços vazio
            $string = strip_tags($string);//tira tags html e php
            return $string;
        }

        public function inverter_data($data){
            if(count(explode("-",$data)) > 1){
                return implode("/",array_reverse(explode("-",$data)));
            }elseif(count(explode("/",$data)) > 1){
                return implode("-",array_reverse(explode("/",$data)));
            }
        }
    }
    $pew_functions = new systemFunctions();
    global $pew_functions;
?>
