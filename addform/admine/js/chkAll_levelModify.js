function chkAll_levelModify(frm,level,levelModifylevel,msg)			//삭제시 선택개수 체크 함수
{									
	    
	if(level >  levelModifylevel)									//권한이 없다면
	{
	   
		alert(msg);		
	}
	else
	{	
		var frm = frm;												//넘겨받은 폼 인자
		var total = 0;
		var field=document.getElementsByTagName('input');			//input 태그 배열
		var max = field.length;										//input 태그 갯수
		for (var idx = 0; idx < max; idx++) {						//input 태그 갯수만큼 루프
			if(field[idx].className=='c'){							//클래스명이 c인 체크박스가 있을때
				if (eval("field[" + idx + "].checked") == true) {
				total += 1;
				}
			}
		}

		if(total < 1){
			alert("사원을 1명 이상 선택하십시오.\n\n please select at least one item");
		}
		else{
			chk_modify(frm);
		}
	}
}


function chk_modify(f) {	                                            
		if (f.combolevelFoot.options[0].selected) {					//선택행위가 없을 경우 중지
			alert("등급을 선택하여 주십시오.\n\n please select level");
			return false; 
			}
		else{ 														//선택하였을 경우 히든필드에 값입력
			f.change_no.value = f.combolevelFoot.options[f.combolevelFoot.selectedIndex].value;
			f.mode.value="Modify";
			f.submit();												//폼전송
	}
}
