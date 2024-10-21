var tag = "false";
function chk_all(frm) {
	var field=document.getElementsByTagName('input');				//input 태그 갯수 검사
	if (tag == "false") {
		for (i = 0; i < field.length;i++){							//input 태그 갯수만큼 루프
			if(field[i].className=='c'){							//클래스명이 c인 체크박스가 있을때
				field[i].checked = true;							//모두 선택
				}
			}
			tag = "true";
			return "all"; 
		}
	else {
		for (i = 0; i < field.length;i++){							//input 태그 갯수만큼 루프
			if(field[i].className=='c'){							//클래스명이 c인 체크박스가 있을때
				field[i].checked = false;							//모두 해제
				}
			}
			tag = "false";
			return "all"; 
		}
}