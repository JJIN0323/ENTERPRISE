//옵션타입별 견적서 계산 (폼이름,객체,행배열번호,옵션타입)
function estimate_calculator(frm,obj,n,opt_type)							
{
/////////////////////////////////////////////////////////////////////////////////////////

	if (opt_type == "checkbox")									//체크박스일 때
	{
		var optPrice = 0;										//옵션가격합계용변수
		var chkNum = 0;											//체크한 옵션수 
		
		var field=document.getElementsByTagName('input');	    //input 태그검사		

		for (var i=0; i < field.length;i++)
			{			
			if(field[i].className=='chkCalculator'+n)
				{
				if(field[i].checked==true)						//체크되어 있다면
					{
					var val = field[i].value;					//체크상자의 값(항목이름,가격)
					var arr = val.split("|");					//쉼표로 구분하여 배열)
																				
					optPrice+= parseFloat(arr[1]) ;				//실수로 파서하지 않으면 소숫점표현안됨
					chkNum++;
					}				
				}									
			}													//for문 end		


		optPrice = Math.round(optPrice * 100)/100;				//소수점 두자리에서 반올림

		if(chkNum == 0 )
					{
					frm["chk_list"+n+""].checked = false;		//체크한옵션이 없을 때 품목체크해제	
					frm["hiddenOpt["+n+"]"].value  = "";		//옵션가격히든필드 비움
					}
				else
					{
					frm["chk_list"+n+""].checked = true;		//체크한옵션이 있을 때 품목체크
					frm["hiddenOpt["+n+"]"].value  = optPrice;	//옵션가격히든필드에 입력
					}
		
		
		subtotal(frm,n);										//소계와 합계 실행	
	}	





	if (opt_type == "radio")									//라디오버튼일 때
	{
		var optPrice = 0;										//옵션가격합계용변수
		var chkNum = 0;											//체크한 옵션수 
		
		var field=document.getElementsByTagName('input');	    //input 태그검사		

		for (var i=0; i < field.length;i++)
			{			
			if(field[i].className=='radioCalculator'+n)
				{
				if(field[i].checked==true)						//체크되어 있다면
					{
					var val = field[i].value;					//체크상자의 값(항목이름,가격)
					var arr = val.split("|");					//쉼표로 구분하여 배열)
																				
					optPrice+= parseFloat(arr[1]) ;				//실수로 파서하지 않으면 소숫점표현안됨
					chkNum++;
					}				
				}									
			}													//for문 end		


		optPrice = Math.round(optPrice * 100)/100;				//소수점 두자리에서 반올림

		if(chkNum == 0 )
					{
					frm["chk_list"+n+""].checked = false;		//체크한옵션이 없을 때 품목체크해제	
					frm["hiddenOpt["+n+"]"].value  = "";		//옵션가격히든필드 비움
					}
				else
					{
					frm["chk_list"+n+""].checked = true;		//체크한옵션이 있을 때 품목체크
					frm["hiddenOpt["+n+"]"].value  = optPrice;	//옵션가격히든필드에 입력
					}
		
		
		subtotal(frm,n);										//소계와 합계 실행	
	}	


/////////////////////////////////////////////////////////////////////////////////////////
}