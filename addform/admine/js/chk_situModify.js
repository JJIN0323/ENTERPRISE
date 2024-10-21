//폼객체,루프번호,선택상자의값,,현재접속자레벨,권한레벨,메시지
function chk_situModify(f,no,selText,selVal,level,situModifylevel,msg) 					
{
	
	if(level >  situModifylevel)							//권한이 없다면
	{
	   
		alert(msg);		
	}
	else
	{		
		checking=confirm('선택한 접수내역을 '+selText+' 상황으로 변경하시겠습니까?\n\n Do you want to change the situation?');
		if (checking==true && selVal > 0)
		{					
			var field=document.getElementsByTagName('input');
			for (i = 0; i < field.length;i++)				//input 태그 갯수만큼 루프
			{				
			if(field[i].id=='checkbox'+no)					//id 명이 일치하면
				{					
				field[i].checked = true;					//체킹
				}
			}					
			
			f.mode.value="situModify";						//모드 변경
			f.submit();										//폼전송
		}
		else document.location.reload();
	}
}


