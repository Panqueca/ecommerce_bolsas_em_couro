$(document).ready(function(){
    var refreshRate = 500;
    // HTML OBJ
    var mainDiv = null;
    var mainOptions = null;
    var buttons = null;
    var displayPaineis = null;
    var paineis = null;
    var opcoesFrete = null;
    var loadingIcon = "<i class='fas fa-spinner fa-spin icone-loading icon-button'></i>";
    
    var btnCheckoutCreditCard = null;
    var btnCheckoutBoleto = null;
    var btnCheckoutDefaultText = null;
    
    var filaMascaras = ["#ccHolderCpf", "#ccHolderBirthDate", "#ccHolderPhone"];
    // END HTML OBJ
    
    // STANDARD FORM
    var sendDataForm = new Object();
    sendDataForm.processCheckout = null;
    sendDataForm.paymentMethod = null;
    sendDataForm.senderHash = null;
    sendDataForm.shippingPrice = null;
    sendDataForm.shippingCode = null;
    sendDataForm.shippingAddressPostalCode = null;
    sendDataForm.shippingAddressStreet = null;
    sendDataForm.shippingAddressNumber = null;
    sendDataForm.shippingAddressDistrict = null;
    sendDataForm.shippingAddressState = null;
    sendDataForm.shippingAddressCity = null;
    sendDataForm.shippingAddressComplement = null;
    sendDataForm.jsonProdutos = null;
    sendDataForm.cartTotalPrice = null;
    // END STANDARD FORM
    
    // INITIALIZE FUNCTIONS
    var CheckoutPagseguro = new Object();
    CheckoutPagseguro.folder = "checkout/";
    CheckoutPagseguro.controller_url = CheckoutPagseguro.folder+"@controller-checkout.php";
    CheckoutPagseguro.session_id = null;
    function set_ps_session_id(){
        if(CheckoutPagseguro.session_id == null){

            $.ajax({
                type: "POST",
                url: CheckoutPagseguro.controller_url,
                data: {acao: "get_session_id"},
                error: function(){
                    mensagemAlerta("Ocorreu um erro ao carregar os dados da compra. Recarregue a página e tente novamente.");
                },
                success: function(id){
                    CheckoutPagseguro.session_id = id;
                    PagSeguroDirectPayment.setSessionId(CheckoutPagseguro.session_id);
                    console.log("ID SESSAO: " + CheckoutPagseguro.session_id);
                },
            });
        }
    }
    
    function set_json_produtos(){
        sendDataForm.jsonProdutos = [];
        $(".info-frete").each(function(){
            var idProduto = $(this).children("#freteIdProduto").val();
            var tituloProduto = $(this).children("#freteTituloProduto").val();
            var precoProduto = $(this).children("#fretePrecoProduto").val();
            var comprimentoProduto = $(this).children("#freteComprimentoProduto").val();
            var larguraProduto = $(this).children("#freteLarguraProduto").val();
            var alturaProduto = $(this).children("#freteAlturaProduto").val();
            var pesoProduto = $(this).children("#fretePesoProduto").val();
            var quantidadeProduto = $(this).children("#freteQuantidadeProduto").val();
            var index_controller = sendDataForm.jsonProdutos.length;
            sendDataForm.jsonProdutos[index_controller] = {"id": idProduto, "titulo": tituloProduto, "preco": precoProduto, "comprimento": comprimentoProduto, "largura": larguraProduto, "altura": alturaProduto, "peso": pesoProduto, "quantidade": quantidadeProduto};
        });
    }
    
    set_ps_session_id();
    set_json_produtos();
    
    var ctrlAddedMascaras = 0;
    function set_mascaras(){
        if(ctrlAddedMascaras <= filaMascaras.length){
            switch(filaMascaras[ctrlAddedMascaras]){
                case "#ccHolderCpf":
                    if(typeof $("#ccHolderCpf").val() != "undefined"){
                        input_mask("#ccHolderCpf", "999.999.999-99");
                        filaMascaras[ctrlAddedMascaras] = "added";
                        ctrlAddedMascaras++;
                    }
                    break;
                case "#ccHolderBirthDate":
                    if(typeof $("#ccHolderBirthDate").val() != "undefined"){
                        input_mask("#ccHolderBirthDate", "99/99/9999");
                        filaMascaras[ctrlAddedMascaras] = "added";
                        ctrlAddedMascaras++;
                    }
                    break;
                case "#ccHolderPhone":
                    if(typeof $("#ccHolderPhone").val() != "undefined"){
                        phone_mask("#ccHolderPhone");
                        filaMascaras[ctrlAddedMascaras] = "added";
                        ctrlAddedMascaras++;
                    }
                    break;
            }
        }else{
            console.log(typeof $(filaMascaras[ctrlAddedMascaras]));
        }
    }
    
    function set_transport_info(){
        if(sendDataForm.shippingPrice == null){
            sendDataForm.shippingPrice = $("#checkoutTotalFrete").val();
        }
        if(sendDataForm.shippingCode == null){
            sendDataForm.shippingCode = $("#checkoutCodigoFrete").val();
        }
    }
    
    function set_shipping_info(){
        sendDataForm.shippingAddressPostalCode = $("#cepDestino").val();
        sendDataForm.shippingAddressStreet = $("#ruaDestino").val();
        sendDataForm.shippingAddressNumber = $("#numeroDestino").val();
        sendDataForm.shippingAddressDistrict = $("#bairroDestino").val();
        sendDataForm.shippingAddressState = $("#estadoDestino").val();
        sendDataForm.shippingAddressCity = $("#cidadeDestino").val();
        sendDataForm.shippingAddressComplement = $("#complementoDestino").val();
    }
    
    // END INITIALIZE FUNCTIONS
    
    // STANDARD CHECKOUT FUNCTIONS
    function set_sender_hash(next_function){
        if(CheckoutPagseguro.session_id != null){
            PagSeguroDirectPayment.getSenderHash();
            PagSeguroDirectPayment.onSenderHashReady(function(response){
                if(response.status == 'error') {
                    console.log(response.message);
                    return false;
                }

                sendDataForm.senderHash = response.senderHash;
                
                next_function(); // CHAMADA DA FUNÇÃO CALLBACK
            });
        }
    }
    
    function set_brand(card_bin, next_function = false){
        var objNumber = $("#ccNumber");
        var objBrandDisplay = $(".brand-name-display");
        
        function set_brand_name(str){
            str = str.toLowerCase().replace(/\b[a-z]/g, function(letter){
                return letter.toUpperCase();
            });
            objBrandDisplay.html(str);
        }
                    
        PagSeguroDirectPayment.getBrand({
            cardBin: card_bin,
            success: function(objResponse){
                var getBrand = typeof objResponse.brand.name != "undefined" ? objResponse.brand.name : null;
                if(getBrand != null){
                    sendDataForm.creditCardBrand = getBrand;
                    set_brand_name(getBrand);
                    if(next_function != false){
                        next_function();
                    }
                }else{
                    set_brand_name(null);
                    mensagemAlerta("O número do cartão está incorreto");
                }
            },
            error: function(){
                set_brand_name(null);
                mensagemAlerta("O número do cartão está incorreto");
            }
        });

    }
    
    function set_token(next_function = false){
        if(sendDataForm.creditCardBrand != null){
            PagSeguroDirectPayment.createCardToken({
                cardNumber: sendDataForm.creditCardBin,
                brand: sendDataForm.creditCardBrand,
                cvv: sendDataForm.creditCardCvv,
                expirationMonth: sendDataForm.creditCardExpirationMonth,
                expirationYear: sendDataForm.creditCardExpirationYear,
                success: function(objResponse){
                    var getToken = typeof objResponse.card.token != "undefined" ? objResponse.card.token : null;
                    if(getToken != null){
                        sendDataForm.creditCardToken = getToken;
                        if(next_function != false){
                            next_function();
                        }
                    }else{
                        mensagemAlerta("Dados do cartão incorretos");
                        sendDataForm.creditCardBrand = null;
                        refresh_checkout(btnCheckoutCreditCard);
                    }
                },
                error: function(response){
                    mensagemAlerta("Dados do cartão incorretos");
                    sendDataForm.creditCardBrand = null;
                    refresh_checkout(btnCheckoutCreditCard);
                }
            });
        }else{
            mensagemAlerta("Verifique se o número do cartão está correto");
            refresh_checkout(btnCheckoutCreditCard);
        }
    }
    
    function set_total_price(){
        if(sendDataForm.cartTotalPrice == null){
            sendDataForm.cartTotalPrice = $("#checkoutTotalPrice").val() > 0 ? $("#checkoutTotalPrice").val() : null;
        }
    }
    
    function play_button_loading(btn){
        btn.html(loadingIcon + " VALIDANDO");
    }
    
    setInterval(function(){
        
        set_total_price();
        
        set_transport_info();
        
        set_mascaras();
        
        mainDiv = $(".display-checkout");
        mainOptions = mainDiv.children(".main-options");
        buttons = mainOptions.children(".option-buttons");
        displayPaineis = mainDiv.children(".display-options");
        paineis = displayPaineis.children(".checkout-painel");

        btnCheckoutCreditCard = $("#buttonCheckoutCreditCard");
        btnCheckoutBoleto = $("#buttonCheckoutBoleto");
        btnCheckoutDefaultText = btnCheckoutDefaultText == null ? btnCheckoutCreditCard.html() : btnCheckoutDefaultText;
        
        buttons.each(function(){
            var button = $(this);
            var target = button.attr("option-target");
            var code = button.attr("option-code");
            button.off().on("click", function(){
                buttons.each(function(){
                    $(this).removeClass("selected-option");
                });
                paineis.each(function(){
                    $(this).removeClass("selected-painel");
                });
                button.addClass("selected-option");
                $("#"+target).addClass("selected-painel");
            });
        });
        
        $("#ccNumber").off().on("change", function(){
            var obj = $(this)
            var card_number = obj.val().replace(/\s/g, "X");
            var defaultOption = "<option value=''>DIGITE O N° DO CARTÃO</option>";
            
            
            var objInstallments = $("#ccInstallments");
            
            function reset_installments(replace){
                objInstallments.html("");
                if(replace){
                    objInstallments.html(defaultOption);
                }
            }
            
            function set_installments(){
                var parcelasSemJuros = 6;
                var maxParcelas = 8;
                
                var reset_function = reset_installments;
                
                var objInstallments = $("#ccInstallments");
                
                sendDataForm.arrayInstallments = [];
                
                PagSeguroDirectPayment.getInstallments({
                    amount: sendDataForm.cartTotalPrice,
                    brand: sendDataForm.creditCardBrand,
                    maxInstallmentNoInterest: parcelasSemJuros,
                    success: function(objResponse){
                        var brand = sendDataForm.creditCardBrand;
                        var getInstallments = objResponse.installments;
                        var ctrlAddInstallments = 0;
                        $.each(getInstallments, function(index, jsObjBrandInstallment){
                            $.each(jsObjBrandInstallment, function(index, eachInstallment){
                                var quantity = eachInstallment.quantity;
                                var installmentAmount = eachInstallment.installmentAmount;
                                var totalAmount = eachInstallment.totalAmount;
                                if(ctrlAddInstallments == 0){
                                    reset_function(false);
                                }
                                if(quantity <= maxParcelas){
                                    sendDataForm.arrayInstallments[ctrlAddInstallments] = new Object();
                                    sendDataForm.arrayInstallments[ctrlAddInstallments]["quantity"] = quantity;
                                    sendDataForm.arrayInstallments[ctrlAddInstallments]["amount"] = installmentAmount.toFixed(2);
                                    objInstallments.append("<option value='" + quantity + "'>" + quantity + "x de R$ " + installmentAmount.toFixed(2) + "</option>");
                                    ctrlAddInstallments++;
                                }

                            });
                        });
                    },
                    error: function(){
                        mensagemAlerta("Verifique o número do cartão");
                    }
                });
            }
            
            reset_installments(true);
            
            set_brand(card_number, set_installments);
        });
        
    }, refreshRate);

    // VALIDATION FUNCTIONS
    function check_pagseguro_auth(){
        sendDataForm.processCheckout = true;
        $.ajax({
            type: "POST",
            data: JSON.stringify(sendDataForm),
            contentType: "application/json",
            url: CheckoutPagseguro.folder+"@controller-checkout.php",
            error: function(){
                mensagemAlerta("Ocorreu um erro ao processar a compra. O Pagamento NÃO foi efetuado. Recarregue a página e tente novamente.");
            },
            success: function(response){
                //console.log(response);
                switch(sendDataForm.paymentMethod){
                    case "creditCard":
                        var buttonCheckout = btnCheckoutCreditCard;
                        break;
                    case "boleto":
                        var buttonCheckout = btnCheckoutBoleto;
                        break;
                }
                
                if(response == "aguardando"){
                    var redirect = "finalizar-compra.php?clear=true";
                    mensagemAlerta("Sua compra foi finalizada com sucesso! Assim que o pagamento for confirmado novas informações estarão disponíveis.", false, "limegreen", redirect);
                }else if(response == "pago"){
                    mensagemAlerta("Seu pagamento foi confirmado com sucesso! Logo informações sobre o rastreamento de sua compra serão adicionadas no seu pedido.", false, "limegreen", redirect);
                }else if(typeof JSON.parse(response) != "undefined"){
                    // CUSTOMIZE FINISH
                    var json_response = JSON.parse(response);
                    
                    if(typeof json_response.paymentLink != "undefined"){
                        var paymentLink = json_response.paymentLink;
                        refresh_checkout(buttonCheckout, false);
                        
                        function imprimirBoleto(){
                            window.open(paymentLink);
                        }
                        
                        function voltar(){
                            window.location.href = "finalizar-compra.php?clear=true";
                        }
                        
                        mensagemConfirma("Sua compra foi finalizada com sucesso! Deseja imprimir o boleto agora?", imprimirBoleto, voltar);
                    }
                    // END CUSTOMIZE FINISH
                }else{
                    refresh_checkout(buttonCheckout);
                    mensagemAlerta("Verifique se os dados do cartão estão corretos.");
                }
            }
        });
    }
    
    function valid_checkout_credit_card(objHolderName, objHolderCpf, objHolderBirthDate, objNumber, objCvv, objExpireMonth, objExpireYear, objInstallments){

        if(objHolderName.val().length < 1){
            mensagemAlerta("O campo Nome Proprietário deve conter no mínimo 1 caracter", objHolderName);
            return false;
        }

        if(objHolderCpf.val().length < 14){
            mensagemAlerta("O campo CPF deve conter no mínimo 14 caracteres", objHolderCpf);
            return false;
        }

        if(objHolderBirthDate.val().length < 10){
            mensagemAlerta("O campo Data de Nascimento deve conter no mínimo 10 caracteres", objHolderBirthDate);
            return false;
        }

        if(objNumber.val().length < 12){
            mensagemAlerta("O campo Número do Cartão deve conter no mínimo 12 caracteres", objNumber);
            return false;
        }

        if(objCvv.val().length < 3){
            mensagemAlerta("O campo CVV deve conter no mínimo 3 caracteres", objCvv);
            return false;
        }

        if(objExpireMonth.val().length < 1){
            mensagemAlerta("O campo Mês de Validade deve ser preenchido", objExpireMonth);
            return false;
        }

        if(objExpireYear.val().length < 1){
            mensagemAlerta("O campo Ano de Validade deve ser preenchido", objExpireYear);
            return false;
        }

        if(objInstallments.val().length < 1){
            mensagemAlerta("O campo Parcelas deve ser preenchido", objInstallments);
            return false;
        }

        return true;
    }
    
    function refresh_checkout(checkout_button, restart = true){
        checkout_button.html(btnCheckoutDefaultText);
        if(restart){
            validandoCheckout = false;
        }
    }
    // END VALIDATE FUNCTIONS
    
    // CONTROLL FUNCTIONS
    function checkout_credit_card(){
        var objHolderName = $("#ccHolderName");
        var objHolderCpf = $("#ccHolderCpf");
        var objHolderPhone = $("#ccHolderPhone");
        var objHolderBirthDate = $("#ccHolderBirthDate");
        var objNumber = $("#ccNumber");
        var objCvv = $("#ccCvv");
        var objExpireMonth = $("#ccExpireMonth");
        var objExpireYear = $("#ccExpireYear");
        var objInstallments = $("#ccInstallments");
        
        var startDelay = 500;
        
        play_button_loading(btnCheckoutCreditCard);

        setTimeout(function(){
            
            if(valid_checkout_credit_card(objHolderName, objHolderCpf, objHolderBirthDate, objNumber, objCvv, objExpireMonth, objExpireYear, objInstallments) == true){
                
                sendDataForm.paymentMethod = "creditCard";
                sendDataForm.creditCardHolderName = objHolderName.val();
                sendDataForm.creditCardHolderCPF = objHolderCpf.val();
                sendDataForm.creditCardHolderPhone = objHolderPhone.val();
                sendDataForm.creditCardHolderBirthDate = objHolderBirthDate.val();
                sendDataForm.creditCardBin = objNumber.val();
                sendDataForm.creditCardCvv = objCvv.val();
                sendDataForm.creditCardExpirationMonth = objExpireMonth.val();
                sendDataForm.creditCardExpirationYear = objExpireYear.val();
                sendDataForm.selectedInstallment = objInstallments.val();

                function verify_checkout_auth(){
                    if(sendDataForm.creditCardToken.length > 0){
                        set_sender_hash(check_pagseguro_auth);
                    }else{
                        mensagemAlerta("Não foi possível processar a compra. Verifique os dados do Cartão de Crédito.");
                        refresh_checkout(btnCheckoutCreditCard);
                    }
                }

                if(sendDataForm.creditCardBrand != null){
                    set_token(verify_checkout_auth);
                }else{
                    mensagemAlerta("Verifique se o Número do Cartão está correto");
                    refresh_checkout(btnCheckoutCreditCard);
                }

            }else{
                refresh_checkout(btnCheckoutCreditCard);
            }
            
        }, startDelay);
    }

    function checkout_boleto(){
        sendDataForm.paymentMethod = "boleto";
        
        play_button_loading(btnCheckoutBoleto);
        
        set_sender_hash(check_pagseguro_auth);
        
    }

    var validandoCheckout = false;
    function execute_checkout(type){
        
        set_shipping_info();
        
        if(!validandoCheckout){
            validandoCheckout = true;
            switch(type){
                case "creditCard":
                    checkout_credit_card();
                    break;
                case "boleto":
                    checkout_boleto();
                    break;
            }
        }
    }

    setInterval(function(){
        btnCheckoutCreditCard.off().on("click", function(event){
            event.preventDefault();
            if(!validandoCheckout){
                execute_checkout("creditCard");
            }
        });
        btnCheckoutBoleto.off().on("click", function(event){
            event.preventDefault();
            if(!validandoCheckout){
                execute_checkout("boleto");
            }
        });
    }, refreshRate);
    // END CONTROLL FUNCTIONS
});