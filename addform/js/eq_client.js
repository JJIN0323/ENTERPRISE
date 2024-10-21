 function eq_client(frm,th)
{	
	//체크시 구매자필드값과 수취인 필드값 동일하게
	if(th.checked == true)
	{
		if(frm.client_name) frm.client_ship.value = frm.client_name.value;				
		if(frm.client_email) frm.client_email_ship.value = frm.client_email.value;

		if(frm.client_tel) 
		{
			frm.client_tel1_ship.value = frm.client_tel1.value;
			frm.client_tel2_ship.value = frm.client_tel2.value;
			frm.client_tel3_ship.value = frm.client_tel3.value;
			frm.client_tel_ship.value = frm.client_tel.value;
		}
		if(frm.client_hp) 
		{
			frm.client_hp1_ship.value = frm.client_hp1.value;
			frm.client_hp2_ship.value = frm.client_hp2.value;
			frm.client_hp3_ship.value = frm.client_hp3.value;
			frm.client_hp_ship.value = frm.client_hp.value;
		}

		if(frm.client_fax) 
		{
			frm.client_fax1_ship.value = frm.client_fax1.value;
			frm.client_fax2_ship.value = frm.client_fax2.value;
			frm.client_fax3_ship.value = frm.client_fax3.value;
			frm.client_fax_ship.value = frm.client_fax.value;
		}

		if(frm.client_address) 
		{
			frm.client_ship_zipcode1.value = frm.client_zipcode1.value;
			frm.client_ship_zipcode2.value = frm.client_zipcode2.value;
			frm.client_ship_zipcode3.value = frm.client_zipcode3.value;
			frm.client_ship_zipcode4.value = frm.client_zipcode4.value;
			frm.client_address_ship.value = frm.client_address.value;
		}
	}
	else
	{
		if(frm.client_ship) frm.client_ship.value = "";	
		if(frm.client_email_ship) frm.client_email_ship.value = "";

		if(frm.client_tel_ship) 
		{
			frm.client_tel1_ship.value = "";
			frm.client_tel2_ship.value = "";
			frm.client_tel3_ship.value = "";
			frm.client_tel_ship.value = "";
		}

		if(frm.client_hp_ship) 
		{
			frm.client_hp1_ship.value = "";
			frm.client_hp2_ship.value = "";
			frm.client_hp3_ship.value = "";
			frm.client_hp_ship.value = "";
		}

		if(frm.client_fax_ship) 
		{
			frm.client_fax1_ship.value = "";
			frm.client_fax2_ship.value = "";
			frm.client_fax3_ship.value = "";
			frm.client_fax_ship.value = "";
		}

		if(frm.client_address_ship)  
		{
			frm.client_ship_zipcode1.value = "";
			frm.client_ship_zipcode2.value = "";
			frm.client_ship_zipcode3.value = "";
			frm.client_ship_zipcode4.value = "";
			frm.client_address_ship.value = "";
		}

	}
	
}
