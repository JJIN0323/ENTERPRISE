function code_re()
{
	var field=document.getElementsByTagName('input');		
		var x = 1;
		for (var i=0; i < field.length;i++)
			{			
			if(field[i].className=='code_re')
				{				
				field[i].value = x++;					
				}
			}			
}