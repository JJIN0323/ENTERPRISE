//자바스크립트로 객체 display 스타일제어
//(폼이름,선택한라디오버튼값,클래스이름,태그이름,여분)
function displayOpt_all(choiceObj,cName,tag)
{	
var obj=document.getElementsByTagName(tag);		
var token = "";
var ea = 0;

	for (var i=0; i < obj.length;i++)
		{			
		if(obj[i].className==cName)
			{
			if (choiceObj.value == "전체항목속성/옵션 열기")	
				{
					obj[i].style.display="inline";
					token = "close";
					ea++;
				}
			if (choiceObj.value == "전체항목속성/옵션 닫기")	
				{
					obj[i].style.display="none";
					token = "open";
					ea++;
				}			 				
				
			}									
		}
	
	if(ea == 0) alert("추가한 품목/항목이 없습니다.");

	if(token == "open")
	{
		choiceObj.value = "전체항목속성/옵션 열기";
	}
	if(token == "close")
	{
		choiceObj.value = "전체항목속성/옵션 닫기";
	}
			
}	