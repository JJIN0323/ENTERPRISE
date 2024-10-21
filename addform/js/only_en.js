function only_en(frm,fval){

    var pattern = /(^[a-zA-Z0-9\-_]+$)/;
    if(!pattern.test(fval) || fval.length > 10 || fval.length < 1){
        alert('영문과 숫자의 조합으로만 입력하여 주십시오. \n\n Please enter the English and only a combination of numbers.');
		frm.focus();
		frm.value=""; 
		return false;        
    }
	else{
        return;
    }
}
