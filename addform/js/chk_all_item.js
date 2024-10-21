function chk_all_item(frm,th,dummy) 				//폼,객체,여분
{
	var items = frm.chk_dummy1.length;
	
	for (i = 0; i < items;i++)							
	{
		var chkbox = frm["chk_list["+i+"]"];
		if(th.checked == true)
		{
			chkbox.checked = true;
		}
		if(th.checked == false)
		{
			chkbox.checked = false;
		}
	}
			
	if(items > 0)
	{		
		for (i = 0; i < items;i++)							
		{
			subtotal(frm,i);
		}
	}	

}