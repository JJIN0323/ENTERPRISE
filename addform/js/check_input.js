//숫자를 제외한 문자를 제거
function Numbering(obj) {
	obj.value=obj.value.replace(/\D/g,'');
	
}

//숫자와 도트를 제외한 문자를 제거
function NumberDot(obj) {	
	obj.value=obj.value.replace(/[^\.1234567890]/g,'');	
}


//숫자만 입력받음 2
function Numbering2(obj) {
	if(isNaN(obj.value)){
		alert("숫자만 입력해 주십시오\n\n Please only numeral");
		obj.value = 1;
		obj.focus();
		return;
	}
}

//엔터키 사용판단
function checkKey(obj) {
	if (event.keyCode==13) obj.click();
}
//입력필터링(인용부호:따옴표 제거)
function quot_Del(obj5str) {
	var temp;
	var type=typeof(obj5str);
	var oval=type=="string" ? obj5str : obj5str.value;
	var temp=oval.replace(/'|"/g,'');
	if (type=="string") return temp;
	else obj5str.value=temp;
}

//이메일 유효성 검사
function chk_email(obj)
{
 if(obj)
	{
	if ( obj.value.length <= 6 ||
	obj.value.indexOf ('@', 0) == -1 ||
	obj.value.indexOf ('.', 0) == -1)
		{
		alert("" + obj.value + " 는 바른 이메일주소가 아닙니다\n\n Incorrect email address");
		obj.value="";
		obj.focus();
		return false;
		}
	}
}