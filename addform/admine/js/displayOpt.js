//자바스크립트로 객체 display 스타일제어
//(폼이름,선택한라디오버튼값,클래스이름,태그이름,여분)
function displayOpt(choiceObj,cId)
{	

var token = "";

if (choiceObj.value == "속성/옵션")	
	{
		document.getElementById(cId).style.display="inline";
		token = "close";					
	}
if (choiceObj.value == "속성닫기")	
	{
		document.getElementById(cId).style.display="none";
		token = "open";					
	}			 				


if(token == "open")
	{
		choiceObj.value = "속성/옵션";
	}
	if(token == "close")
	{
		choiceObj.value = "속성닫기";
	}
			
}	