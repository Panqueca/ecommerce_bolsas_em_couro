<?php
    class Empacotamento{
        public $caixas = array();
        public $produtos = array();
        public $produtos_configurados = 0;
        public $produtos_empacotados = array();
        public $ctrl_produtos_empacotados = 0;
        
        public function add_produto($id, $title, $preco, $comprimento, $largura, $altura, $peso_produto, $quantidade = 1){
            for($i = 1; $i <= $quantidade; $i++){
                $this->produtos[$this->produtos_configurados] = array();
                $this->produtos[$this->produtos_configurados]["id"] = $id;
                $this->produtos[$this->produtos_configurados]["title"] = $title;
                $this->produtos[$this->produtos_configurados]["preco"] = $preco;
                $this->produtos[$this->produtos_configurados]["comprimento"] = $this->custom_number_format($comprimento);
                $this->produtos[$this->produtos_configurados]["largura"] = $this->custom_number_format($largura);
                $this->produtos[$this->produtos_configurados]["altura"] = $this->custom_number_format($altura);
                $this->produtos[$this->produtos_configurados]["peso"] = $this->custom_number_format($peso_produto);
                $this->produtos[$this->produtos_configurados]["empacotado"] = false;            
                $this->produtos_configurados++;
            }
        }
        
        public function configurar(){
            $carrinho = array();
            $ctrl = 0;
            foreach($this->produtos as $indice => $infoProduto){
                $empacotado = $infoProduto["empacotado"];
                if($empacotado == false){
                    $carrinho[$ctrl] = array();
                    $carrinho[$ctrl]["title"] = $infoProduto["title"];
                    $carrinho[$ctrl]["id"] = $infoProduto["id"];
                    $carrinho[$ctrl]["peso"] = $infoProduto["peso"];
                    $carrinho[$ctrl]["preco"] = $infoProduto["preco"];
                    $carrinho[$ctrl]["A"] = $infoProduto["altura"];
                    $carrinho[$ctrl]["L"] = $infoProduto["largura"];
                    $carrinho[$ctrl]["C"] = $infoProduto["comprimento"];
                    $carrinho[$ctrl]["empacotado"] = false;
                    
                    $ctrl++;
                }
            }
            return $carrinho;
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
                $decimal = strlen($explodedVal[$indiceLastExplode]) <= 2 && strlen($explodedVal[$indiceLastExplode]) > 0 ? true : false;
                $shortDecimal = strlen($explodedVal[$indiceLastExplode]) == 1 ? true : false;
                $startingVal = $explodedVal[0];

                $caracteresStrCleaned = strlen($cleanedVal);
                $totalCaractesMilhar = $caracteresStrCleaned - 2;
                $milharVal = substr($cleanedVal, 0, $totalCaractesMilhar);
                $decimalsVal = substr($cleanedVal, $totalCaractesMilhar, 2);

                $sepStartVal = preg_split("//", $startingVal, -1, PREG_SPLIT_NO_EMPTY);
                $somaStart = 0;
                foreach($sepStartVal as $number){
                    $somaStart += $number;
                }
                $is_under_one = $somaStart == 0 ? true : false;

                $sep = $sep == "." || $sep ==  "," ? $sep : ".";
                if($is_under_one){
                    if(strlen($cleanedVal) == 2){
                        $formatedVal = "0".$sep.$cleanedVal;
                    }else{
                        $final = strlen($explodedVal[1]) == 2 ? $explodedVal[1] : $explodedVal[1]."0";
                        $formatedVal = "0".$sep.$final;
                    }
                }else{
                    switch($decimal){
                        case true:
                            if($shortDecimal){
                                $ctrlCaracteres = strlen($cleanedVal);
                                $decimal = strlen($explodedVal[$totalExplodes - 1]) == 1 ? $explodedVal[$totalExplodes - 1]."0" : $explodedVal[$totalExplodes - 1];
                                $formatedVal = substr($cleanedVal, 0, $ctrlCaracteres - 1) . $sep . $decimal;
                            }else{
                                $formatedVal = $milharVal.$sep.$decimalsVal;
                            }
                            break;
                        case false:

                            // Verifica se é um decimal de mais de 3 números
                            if($totalExplodes == 2 && strlen($explodedVal[1]) >= 3){ 
                                $valorMilhar = $explodedVal[0];
                                $valorDecimal = $explodedVal[1];
                                $decimalFinal = substr($valorDecimal, 0, 2);
                                $formatedVal = $valorMilhar.$sep.$decimalFinal;
                            }else{
                                $formatedVal = $cleanedVal.$sep."00";
                            }

                            break;
                    }
                }

                return $formatedVal;
            }else{
                return $cleanedVal.".00";
            }
        }
    }
?>