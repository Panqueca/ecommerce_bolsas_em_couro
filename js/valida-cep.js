var objRua = null;
var objBairro = null;
var objCidade = null;
var objEstado = null;

function retorno_cep(conteudo){
    if(!("erro" in conteudo)){
        //Atualiza os campos com os valores.
        objRua.val(conteudo.logradouro);
        objBairro.val(conteudo.bairro);
        objCidade.val(conteudo.localidade);
        objEstado.val(conteudo.uf);
    }
    else{
        //CEP não Encontrado.
        limpa_formulario();
        notificacaoPadrao("CEP não encontrado");
    }
}

function limpa_formulario(){
    //Limpa valores do formulário de cep.
    objRua.val("");
    objBairro.val("");
    objCidade.val("");
    objEstado.val("");

}

function buscarCEP(cep, rua, estado, cidade, bairro){
    
    objRua = rua;
    objBairro = bairro;
    objCidade = cidade;
    objEstado = estado;

    function pesquisa_cep(){

        //Verifica se campo cep possui valor informado.
        if (cep != ""){

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)){

                //Preenche os campos com "..." enquanto consulta webservice.
                objRua.val("...");
                objBairro.val("...");
                objCidade.val("...");
                objEstado.val("...");


                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = '//viacep.com.br/ws/'+ cep + '/json/?callback=retorno_cep';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            }else{
                limpa_formulario();
                notificacaoPadrao("Formato de CEP inválido");
            }
        }else{
            //cep sem valor, limpa formulário.
            limpa_formulario();
        }
    }
    pesquisa_cep();
}
function IsCEP(strCEP){
    strCEP = String(strCEP);
    
    function Trim(strTexto){
        return strTexto.replace(/^s+|s+$/g, '');
    }
    
    var valida1 = /^[0-9]{5}-[0-9]{3}$/;
    var valida2 = /^[0-9]{5}[0-9]{3}$/;
    strCEP = Trim(strCEP)
    if(strCEP.length > 0){
        if(valida1.test(strCEP) || valida2.test(strCEP)){
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}