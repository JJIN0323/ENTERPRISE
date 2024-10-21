//자바스크립트로 객체 display 스타일제어
//(폼이름,선택한라디오버튼값,변경대상라디오버튼,클래스이름,태그이름,여분)
function dispaly_css(frm,choiceObj,targetObj,cName,tag,extra)
	{	
	var obj=document.getElementsByTagName(tag);		

		for (var i=0; i < obj.length;i++)
			{			
			if(obj[i].className==cName)
				{
				if (choiceObj.value == "0")	
					{
					//obj[i].style.display="inline";	
					frm.secret_price[0].checked=true;
					}
				if (choiceObj.value == "1")	
					{
					//obj[i].style.display="none";
					frm.secret_price[1].checked=true;
					}			 				
					
				}									
			}				
				
	}	