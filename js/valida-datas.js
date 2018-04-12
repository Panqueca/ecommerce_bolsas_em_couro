function getIdade(data) {
    var hoje = new Date();

    var splitData = data.split("-");
    var dataNascimento = new Date(splitData[0], splitData[1] - 1, splitData[2]);
    var timeDiff = Math.abs(dataNascimento.getTime() - hoje.getTime());
    var diffDays = Math.ceil(timeDiff / (1000 * 3600 * 24));
    var diffAnos = diffDays / 365;
    
    return diffAnos;
}

function maiorIdade(objData){
    var valorData = objData.val();
    
    if(getIdade(valorData) >= 18){
        return true;
    }else{
        return false;
    }
}

function validaData(objData){
    var getData = objData.val();
    if(getData !=""){
        var erro=0;
        var hoje = new Date();
        var anoAtual = hoje.getFullYear();
        var splitData = getData.split("-");
        if (splitData.length == 3){
            dia = splitData[2];
            mes = splitData[1] - 1;
            ano = splitData[0];
            resultado = (!isNaN(dia) && (dia > 0) && (dia < 32)) && (!isNaN(mes) && (mes > 0) && (mes < 13)) && (!isNaN(ano) && (ano.length == 4) && (ano <= anoAtual && ano >= 1900));
            if(!resultado){
                return false;
            }
        }else{
            return false;
        }	
        return true;
    }else{
        return false;
    }
}
