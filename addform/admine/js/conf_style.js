function conf_style(frm) 
{															//확인창 팝업
	checking=confirm('기본스타일로 입력 또는 복구하시겠습니까?');
	if (checking==true)
		{			  
			frm.formStyle.value=frm.formStyleOrign.value;
		}
	else return false;	
}