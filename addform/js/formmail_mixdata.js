//옵션타입별 폼메일 입력믹싱 (폼이름,객체,행배열번호,옵션타입)
function formmail_mixdata(frm,obj,n,opt_type)							
{
/////////////////////////////////////////////////////////////////////////////////////////

	if (opt_type == "checkbox")									//체크박스일 때
	{
		var val = obj.value;									//체크상자의 값(항목이름,가격)
		var arr = val.split("ⓘ");								//쉼표로 구분하여 배열
		var price = "";
		frm["input_data"+n+""].value = "";						//해당 항목 최종 입력필드
		
		if (arr[1] > 0)											//가격이 0보다 크면
		{
			price = "("+arr[1]+")";								//항목(가격)으로 표시(폼메일에서 사용안함)
		}
		//해당항목의 옵션이 체크되어 있는지 확인 후, 최종 입력
		var field=document.getElementsByTagName('input');		
																
		for (var i=0; i < field.length;i++)
			{		
			if(field[i].name=="chk_lis["+n+"]" && field[i].checked == true)
				{	
				var field_val = field[i].value.split("|");
				frm["input_data"+n+""].value += field_val[0]+"ⓘ";//090105 쉼표에서 ⓘ 로 변경 					
				}									
			}
		frm["input_data"+n+""].value = frm["input_data"+n+""].value.slice(0,-1);
	}



	if (opt_type == "radio")									 //라디오 단추일 때
	{
		var val = obj.value;						
		var arr = val.split("|");					
		var price = "";		
		
		if (arr[1] > 0)								
		{
			price = "("+arr[1]+")";					
		}

		if(obj.checked==true){		
			frm["input_data"+n+""].value = arr[0];
		}
	}



	if (opt_type == "text")										//한줄글상자일 때
	{
		var n_arr = n.split("zz");								//zz를 구분자로 배열화
		frm["input_data"+n_arr[0]+""].value = "";				//매번 호출때마다 다시 계산위해 초기화		
		
		var field=document.getElementsByTagName('input');		//input 태그 갯수만큼 루프
			for (i = 0; i < field.length;i++)
				{			
				var id_origin = field[i].id;					//각 필드들의 아이디 참조				
				var id_arr = id_origin.split("zz");				//zz 구분자로 부터 배열화
				var id = id_arr[0];								
				var divi = "";									//input_data에 넣기위한 항목들 구분자정의
																
				if(id == 'textType'+n_arr[0])					//검색한 필드id와 이벤트호출한 필드id 명이 일치하면
					{
					if(field[i].value)						    //필드에 값이 있을 경우
						{
						if(frm["input_data"+n_arr[0]+""].value)	//최종입력 input_data 필드에 값이있다면
							{
							divi = "ⓘ";						//항목 구분자 정의
							}						 
																//검색한 필드id에서 textType 제거
						 var tail = id_origin.replace("textType","");	
																//최종 입력필드 input_data 구성
						 frm["input_data"+n_arr[0]+""].value += divi+frm["textHidden"+tail+""].value+" - "+field[i].value;

						}
						
					}
				}
				
	}



	if (opt_type == "textArea")									//스크롤 글상자일 때
	{
		var n_arr = n.split("zz");								//zz를 구분자로 배열화
		frm["input_data"+n_arr[0]+""].value = "";				//매번 호출때마다 다시 계산위해 초기화		
		
		var field=document.getElementsByTagName('TEXTAREA');	//textarea 태그 갯수만큼 루프
			for (i = 0; i < field.length;i++)
				{			
				var id_origin = field[i].id;					//각 필드들의 아이디 참조				
				var id_arr = id_origin.split("zz");				//zz 구분자로 부터 배열화
				var id = id_arr[0];								
				var divi = "";									//input_data에 넣기위한 항목들 구분자정의
																
				if(id == 'textAreaType'+n_arr[0])				//검색한 필드id와 이벤트호출한 필드id 명이 일치하면
					{
					if(field[i].value)
						{
						if(frm["input_data"+n_arr[0]+""].value)	//최종입력 input_data 필드에 값이있다면
							{
							divi = "ⓘ";						//항목 구분자 정의
							}						 
																//검색한 필드id에서 textAreaType 제거
						 var tail = id_origin.replace("textAreaType","");	
																//최종 입력필드 input_data 구성							
							 frm["input_data"+n_arr[0]+""].value += divi+frm["textAreaHidden"+tail+""].value+" - "+field[i].value;

						}
						
					}
				}
				
	}



/////////////////////////////////////////////////////////////////////////////////////////
}