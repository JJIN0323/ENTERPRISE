function only_en(frm,fval){

    var pattern = /(^[a-zA-Z0-9\-_]+$)/;
    if(!pattern.test(fval) || fval.length > 10 || fval.length < 1){
        alert('폼이름을 10자이하의 영문과 숫자의 조합으로 입력하여 주십시오.\n\n Enter a few characters,10');
		frm.focus();
		frm.value=""; 
		return false;        
    }
	else{
        return;
    }
}
