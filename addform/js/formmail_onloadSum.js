function formmail_onloadSum()							
{
/////////////////////////////////////////////////////////////////////////////////////////
		
		var field=document.getElementsByTagName('input');	    //input 태그검사		

		for (var i=0; i < field.length;i++)
			{
			var optPrice = 0;										//옵션가격합계용변수
			var chkNum = 0;											//체크한 옵션수 
			var fieldName = field[i].name;						//input 객체의 이름을 fieldName에 대입
			var rexp = /chk_lis/;								//매치검색을 위한 정규표현식			
			
			if(rexp.test(fieldName))
				{	
				if(field[i].checked==true)						//체크박스와 라디오버튼이면서 체크되어 있을 때
					{
					var arr_name = field[i].name.split("[");					
					var no = arr_name[1].slice(0,-1);			//클래스 뒷번호					
					var val = field[i].value;					//체크상자의 값(항목이름,가격)
					var arr = val.split("|");					//쉼표로 구분하여 배열
																				
					optPrice+= parseFloat(arr[1]) ;				//실수로 파서하지 않으면 소숫점표현안됨
					chkNum++;
									
					}
				}
			
			optPrice = Math.round(optPrice * 100)/100;			//소수점 두자리에서 반올림

		if(chkNum > 0 )
				{												//옵션가격히든필드에 입력
																//090105 접수후화면에서 복수체크되어 있어도 합산되게 가격을  플러스 					
					document.form1["hiddenOpt["+no+"]"].value = Number(document.form1["hiddenOpt["+no+"]"].value)+optPrice;
				}	
			}													//for문 end					
		
		formmail_sum();											//소계와 합계 실행
		formmail_onloadSumSelectBox();
			
/////////////////////////////////////////////////////////////////////////////////////////
}

function formmail_onloadSumSelectBox()							
{
/////////////////////////////////////////////////////////////////////////////////////////	
		
		var field=document.getElementsByTagName('select');	    //input 태그검사		

		for (var i=0; i < field.length;i++)
			{			
			var optPrice = 0;									//옵션가격합계용변수
			var chkNum = 0;										//체크한 옵션수 
			var fieldName = field[i].name;						//input 객체의 이름을 fieldName에 대입
			var rexp = /chk_lis/;								//매치검색을 위한 정규표현식			
			
			if(rexp.test(fieldName))
				{	
				if(field[i].selectedIndex != 0)					//선택된 항목이 0 항목이 아니라면
					{
					var arr_name = field[i].name.split("[");					
					var no = arr_name[1].slice(0,-1);			//클래스 뒷번호	
					var val = field[i].options[field[i].selectedIndex].value;			
																				
					optPrice+= parseFloat(val) ;				//실수로 파서하지 않으면 소숫점표현안됨
					chkNum++;									
					}
				}
			
			optPrice = Math.round(optPrice * 100)/100;			//소수점 두자리에서 반올림

		if(chkNum > 0 )
				{												//옵션가격히든필드에 입력					
					document.form1["hiddenOpt["+no+"]"].value  = optPrice;
				}	
			}													//for문 end

			
		
		formmail_sum();											//소계와 합계 실행
			
/////////////////////////////////////////////////////////////////////////////////////////
}

