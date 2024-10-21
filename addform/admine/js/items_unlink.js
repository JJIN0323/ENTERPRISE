function items_unlink(n)								//n = initial 코드번호
	{	
		var x=n+1;										//x = initial 코드번호(n이 배열이므로 +1)
														//객체잘 인식못하여 id속성으로 참조
														//code_re() 후의 코드번호
		var y=document.getElementById("code["+n+"]").value;
		if(x != y)										//실제이동이 이루어져서 코드번호가 틀릴 때
		{
			var field=document.getElementsByTagName('*');		
			for (var i=0; i < field.length;i++)
			{			
			if(field[i].className=='linkbox')
				{				
				field[i].checked = false;
				field[i].style.visibility="hidden";
				}
			if(field[i].className=='linkimg')
				{				
				field[i].style.visibility="hidden";
				}			
			}		
		}		
	}