<?php
    
    require_once "@classe-metodos-pagamento.php";

    class Checkout{
        public $pagseguro_folder;
        
        function __construct(){
            $this->pagseguro_folder = "../pagseguro/";
        }
        
        function set_pagseguro_session(){
            $response_file = "ws-pagseguro-set-session.php";
            require_once $this->pagseguro_folder.$response_file;
            return $responseSessionID;
        }
        
        function view_checkout($totalCompra, $totalFrete, $codigoFrete){
            if($totalCompra != null && $totalCompra > 0){
                $cls_metodos_pagamento = new MetodosPagamento();
            
                $cls_metodos_pagamento->set_cartao_credito();
                $infoMetodoCartaoCredito = $cls_metodos_pagamento->get_info();

                $cls_metodos_pagamento->set_boleto();
                $infoMetodoBoleto = $cls_metodos_pagamento->get_info();

                $dirImagens = "images/cardBrands";

                $arrayMeses = array();
                $arrayMeses[0] = "Janeiro";
                $arrayMeses[1] = "Fevereiro";
                $arrayMeses[2] = "Março";
                $arrayMeses[3] = "Abril";
                $arrayMeses[4] = "Maio";
                $arrayMeses[5] = "Junho";
                $arrayMeses[6] = "Julho";
                $arrayMeses[7] = "Outubro";
                $arrayMeses[8] = "Setembro";
                $arrayMeses[9] = "Agosto";
                $arrayMeses[10] = "Novembro";
                $arrayMeses[11] = "Dezembro";

                $anoAtual = date("Y");
                $maxPlusValidade = 6;
                $maxParcelas = 6;
                
                $totalCompra = $totalCompra + $totalFrete;

                echo "<div class='display-checkout'>";

                    echo "<div class='main-options'>";
                        echo "<div class='option-buttons selected-option' option-target='checkoutCartaoCredito' option-code='{$infoMetodoCartaoCredito["codigo"]}'>{$infoMetodoCartaoCredito["icone"]} <span class='hidden-mobile'>Cartão de Crédito</span></div>";
                        echo "<div class='option-buttons' option-target='checkoutBoleto' option-code='{$infoMetodoBoleto["codigo"]}'>{$infoMetodoBoleto["icone"]} <span class='hidden-mobile'>Boleto</span></div>";
                    echo "</div>";

                    echo "<div class='display-options'>";
                
                        echo "<input type='hidden' id='checkoutTotalPrice' value='$totalCompra'>";
                        echo "<input type='hidden' id='checkoutTotalFrete' value='$totalFrete'>";
                        echo "<input type='hidden' id='checkoutCodigoFrete' value='$codigoFrete'>";

                        echo "<div class='checkout-painel selected-painel' id='checkoutCartaoCredito'>";
                            echo "<div class='full'>";
                                echo "<h3 class='title'>Pagar com Cartão de Crédito</h3>";
                            echo "</div>";
                            echo "<form class='checkout-form' id='formInfoCreditCard'>";
                                echo "<div class='half'>";
                                    echo "<input type='text' class='form-input' id='ccHolderName' placeholder='NOME PROPRIETÁRIO' maxlength='50'>";
                                echo "</div>";
                                echo "<div class='half'>";
                                    echo "<input type='text' class='form-input' id='ccHolderCpf' placeholder='CPF PROPRIETÁRIO' maxlength='14'>";
                                echo "</div>";
                                echo "<div class='medium'>";
                                    echo "<input type='text' class='form-input' id='ccHolderBirthDate' placeholder='DATA NASCIMENTO' maxlength='10'>";
                                echo "</div>";
                                echo "<div class='half label-plus'>";
                                    echo "<input type='text' class='form-input' id='ccNumber' placeholder='NÚMERO CARTÃO' maxlength='19'>";
                                    echo "<h6 class='complement-label brand-name-display'></h6>";
                                echo "</div>";
                                echo "<div class='xsmall'>";
                                    echo "<input type='text' class='form-input' id='ccCvv' placeholder='CVV' maxlength='3'>";
                                echo "</div>";
                                echo "<div class='medium'>";
                                    echo "<select class='form-input' id='ccExpireMonth'>";
                                        echo "<option value=''>MÊS VALIDADE</option>";
                                        $ctrlMeses = 1;
                                        foreach($arrayMeses as $tituloMes){
                                            echo "<option value='$ctrlMeses'>$tituloMes</option>";
                                            $ctrlMeses++;
                                        }
                                    echo "</select>";
                                echo "</div>";
                                echo "<div class='medium'>";
                                    echo "<select class='form-input' id='ccExpireYear'>";
                                        echo "<option value=''>ANO VALIDADE</option>";
                                        for($i = 0; $i <= $maxPlusValidade; $i++){
                                            $anoValidade = $anoAtual + $i;
                                            echo "<option>$anoValidade</option>";
                                        }
                                    echo "</select>";
                                echo "</div>";
                                echo "<div class='medium'>";
                                    echo "<input type='text' class='form-input' id='ccHolderPhone' placeholder='(41) 99999-9999' maxlength='14'>";
                                echo "</div>";
                                echo "<div class='half'>";
                                    echo "<select class='form-input' id='ccInstallments'>";
                                        /*for($i = 1; $i <= $maxParcelas; $i++){
                                            $valorParcela = $totalCompra / $i;
                                            $valorParcela = number_format($valorParcela, 2, ",", ".");
                                            echo "<option value='$i'>{$i}x de R$ $valorParcela</option>";
                                        }*/
                                        echo "<option value='teste'>DIGITE O N° DO CARTÃO</option>";
                                    echo "</select>";
                                echo "</div>";
                                echo "<div class='half'>";
                                    echo "<button class='form-input button-checkout' type='button' id='buttonCheckoutCreditCard'   >FINALIZAR <i class='fas fa-check'></i></button>";
                                echo "</div>";
                                echo "<br class='clear'>";
                            echo "</form>";
                        echo "</div>";

                        echo "<div class='checkout-painel' id='checkoutBoleto'>";
                            echo "<div class='full'>";
                                echo "<h3 class='title'>Pagar com Boleto</h3>";
                                echo "<article class='description'>A confirmação do pagamento via boleto pode levar entre <b>48 e 72 horas</b></article>";
                            echo "</div>";
                            echo "<div class='half'>";
                                echo "<button class='form-input button-checkout' type='button' id='buttonCheckoutBoleto'   >FINALIZAR <i class='fas fa-check'></i></button>";
                            echo "</div>";
                                echo "<br class='clear'>";
                        echo "</div>";


                    echo "</div>";


                echo "</div>";
            }else{
                echo "false";
            }
        }
    }