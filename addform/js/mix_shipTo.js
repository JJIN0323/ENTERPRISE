 function mix_shipTo(frm)
{
	if(frm.shipTo)
	{
	//수취인 필드값을 배열화
	frm.shipTo.value = "";
	if(frm.client_ship) 
		{
		frm.shipTo.value += frm.client_ship.value + "|";
		}
	else{
		frm.shipTo.value += "|";
		}

	if(frm.client_email_ship) 
		{
		frm.shipTo.value += frm.client_email_ship.value + "|";
		}
	else{
		frm.shipTo.value += "|";
		}

	if(frm.client_hp_ship) 
		{
		frm.shipTo.value += frm.client_hp_ship.value + "|";
		}
	else{
		frm.shipTo.value += "|";
		}

	if(frm.client_tel_ship) 
		{
		frm.shipTo.value += frm.client_tel_ship.value + "|";
		}
	else{
		frm.shipTo.value += "|";
		}
	
	if(frm.client_fax_ship) 
		{
		frm.shipTo.value += frm.client_fax_ship.value + "|";
		}
	else{
		frm.shipTo.value += "|";
		}

	if(frm.client_address_ship) 
		{
		frm.shipTo.value += frm.client_address_ship.value + "|";
		}
	else{
		frm.shipTo.value += "|";
		}
		

	//마지막 구분자 제거
	frm.shipTo.value = frm.shipTo.value.slice(0,-1);
	}
}
