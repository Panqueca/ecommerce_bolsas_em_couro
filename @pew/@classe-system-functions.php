<?php
    require_once 'PHPMailer/vendor/autoload.php';
    require_once 'PHPMailer/PHPMailer/src/Exception.php';
    require_once 'PHPMailer/PHPMailer/src/PHPMailer.php';
    require_once 'PHPMailer/PHPMailer/src/SMTP.php';


    require_once "pew-system-config.php";

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    if(!class_exists("systemFunctions")){
        class systemFunctions{
            protected $global_vars;

            function __construct(){
                global $globalVars;
                $this->global_vars = $globalVars;
            }

            private function conexao(){
                global $conexao;
                return $conexao;
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

            public function validar_email($mail){
                if(preg_match("/^([[:alnum:]_.-]){3,}@([[:lower:][:digit:]_.-]{3,})(.[[:lower:]]{2,3})(.[[:lower:]]{2})?$/", $mail)) {
                    return true;
                }else{
                    return false;
                }
            }

            public function mask($val, $mask){
                $maskared = '';
                $k = 0;
                for($i = 0; $i<=strlen($mask)-1; $i++){
                    if($mask[$i] == '#'){

                        if(isset($val[$k]))
                        $maskared .= $val[$k++];
                    }else{
                        if(isset($mask[$i]))
                        $maskared .= $mask[$i];
                    }
                }

                return $maskared;
            }
            
            function enviar_email($assunto, $body, $destinatarios, $senderEmail = null, $senderPass = null, $anexos = null, $altBody = null){
                $nomeLoja = "Bolsas em Couro";
                
                $senderEmail = $senderEmail == null ? "dev@efectusdigital.com.br" : $senderEmail;
                $senderPass = $senderPass == null ? "3f3ctu5d1g1t4l" : $senderPass;
                $altBody = $altBody == null ? "E-mail enviado por $nomeLoja" : $altBody;
                
                
                $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
                try {
                    //Server settings
                    $mail->SMTPDebug = 2;
                    /*$mail->isSMTP();*/
                    $mail->Host = 'mail.efectusdigital.com.br';  // Specify main and backup SMTP servers
                    $mail->SMTPAuth = true;
                    $mail->Username = $senderEmail;
                    $mail->Password = $senderPass;
                    $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
                    $mail->Port = 587;

                    //Informações para envio
                    $mail->setFrom($senderEmail, $nomeLoja);
                    if(isset($destinatarios) && is_array($destinatarios) && count($destinatarios) > 0){
                        foreach($destinatarios as $infoDestinatario){
                            $receiverEmail = $infoDestinatario["email"];
                            $receiverName = $infoDestinatario["nome"];
                            $mail->addAddress($receiverEmail, $receiverName);
                        }
                    }

                    //Anexos
                    if(isset($anexos) && is_array($anexos) && count($anexos) > 0){
                        foreach($anexos as $infoAnexo){
                            $diretorio = $infoAnexo["dir"];
                            $novoNome = $infoAnexo["nome"];
                            $mail->addAttachment($diretorio, $novoNome);
                        }
                    }

                    
                    //Content
                    $mail->isHTML(true);
                    $mail->Subject = $assunto;
                    $mail->Body    = $body;
                    $mail->AltBody = $altBody;
                    $mail->CharSet = "UTF-8";

                    $mail->send();
                    
                    return true;
                                      
                } catch (Exception $e) {
                    //$mail->ErrorInfo;
                    return false;
                }
                
            }

        } 
    }

    $pew_functions = new systemFunctions();
?>