function chk_readN(frm,level,read_order_level,msg) 					//변경시 선택개수 체크 함수
{
	    
	if(level >  read_order_level)									//권한이 없다면
	{
	   
		alert(msg);		
	}
	else
	{		
		var frm = frm;												//넘겨받은 폼 인자
		var total = 0;
		var field=document.getElementsByTagName('input');			//input 태그 배열
		var max = field.length;										//input 태그 갯수
		for (var idx = 0; idx < max; idx++)							//input 태그 갯수만큼 루프
		{						
			if(field[idx].className=='c')							//클래스명이 c인 체크박스가 있을때
				{							
				if (eval("field[" + idx + "].checked") == true) {
				total += 1;
				}
			}
		}

		if(total < 1)
		{
			alert("읽은상태로 표시할 항목을 1개 이상 선택하십시오.\n\n please select at least one item");
		}
		else
		{
			chk_read(frm);
		}
	}
}


function chk_read(frm) 
{																	//확인창 팝업
	checking=confirm('선택한 항목을 읽은상태로 변경하시겠습니까?\n\n To display read the selected items?');
	if (checking==true)
	{			  
		frm.mode.value="read";										//모드 변경
		frm.submit();
	}
	else return false;	
}