function validarCPF(strCPF) {
    var Soma;
    var Resto;
    
    String.prototype.replaceAll = String.prototype.replaceAll || function(needle, replacement) {
        var str = this,
            i = 0,
            l = needle.length;
        while (~(i = str.indexOf(needle, i))) {
            str = str.substr(0, i) + str.substr(i+l);
        }
        return str;
    };
    
    strCPF = strCPF.replaceAll(".", "");
    
    Soma = 0;
	if (strCPF == "00000000000") return false;
    
	for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
	Resto = (Soma * 10) % 11;
	
    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;
	
	Soma = 0;
    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
    Resto = (Soma * 10) % 11;
	
    if ((Resto == 10) || (Resto == 11))  Resto = 0;
    if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
    return true;
}