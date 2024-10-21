function client_position(ths,i)
	{
	var len = document.form1.client_positionBtn.length;		//client_positionBtn 개체수 
	
	for(n = 0; n < len ; n++)								//개체수만큼 루프
		{
		if(n == i)											//인자로 받은 배열번호와 같다면
			{
			if(ths.checked == true)	document.form1["dummy5["+i+"]"].value = "1"; 
			else document.form1["dummy5["+n+"]"].value = "";
			}
		else document.form1["dummy5["+n+"]"].value = "";
			
		}
			
	}	