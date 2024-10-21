function change_cookie(f,val)
{		
	f.mode.value='change_linstN';
	document.cookie='af_odlistN='+val+'';
	f.submit();
}