function calendar1(f,mode)
{
	var Y1 = "<?php echo $Y1;?>";
	var M1 = "<?php echo $M1;?>";

	Y1 = Number(Y1);
	M1 = Number(M1);

	if(mode == "before")
	{
		if(M1 == 1) 
		{
			f.y.value = Y1-1;
			f.m.value = M1+11;
		}
		else 
		{
			f.y.value = Y1;
			f.m.value = M1-1;
		}
		
	}
	if(mode == "after")
	{
		if(M1 == 12) 
		{
			f.y.value = Y1+1;
			f.m.value = M1-11;
		}
		else 
		{
			f.y.value = Y1;
			f.m.value = M1+1;
		}			
	}
	f.submit();
}