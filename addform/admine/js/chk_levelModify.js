//폼객체,루프번호,선택상자의값,,현재접속자레벨,권한레벨,메시지
function chk_levelModify(f,no,selText,selVal,level,levelModifylevel,msg)
{						
	 if(level >  levelModifylevel)									//권한이 없다면
	{	   
		alert(msg);	
		
	}
	else
	{
	   
	   checking=confirm('선택한 사원을 '+selText+' 등급으로 변경하시겠습니까?');
		    	if (checking==true && selVal > 0){					
					var field=document.getElementsByTagName('input');
					for (i = 0; i < field.length;i++){				//input 태그 갯수만큼 루프
					if(field[i].id=='checkbox'+no){					//id 명이 일치하면
						field[i].checked = true;					//체킹
						}
					}					
                    
					f.mode.value="Modify";							//모드 변경
					f.submit();										//폼전송
				}
				else document.location.reload();
	}
}


