//자바스크립트로 객체 display 스타일제어
//(폼이름,선택한라디오버튼값,클래스이름,태그이름,여분)
function display_sms(frm,choiceObj,cName,tag)
	{	
	var obj=document.getElementsByTagName(tag);		

		for (var i=0; i < obj.length;i++)
			{			
			if(obj[i].className==cName)
				{
				if (choiceObj.value == "1")	
					{
					obj[i].style.display="inline";					
					}
				if (choiceObj.value == "0")	
					{
					obj[i].style.display="none";					
					}
				if (choiceObj.value == "on")	
					{
					obj[i].style.display="inline";					
					}
				if (choiceObj.value == "off")	
					{
					obj[i].style.display="none";					
					}			
					
				}									
			}				
				
	}	