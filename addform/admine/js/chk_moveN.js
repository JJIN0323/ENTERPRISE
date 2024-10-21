function chk_moveN(frm) {											//이동시 선택개수 체크 함수
	    var frm = frm;												//넘겨받은 폼 인자
		var total = 0;
		var field=document.getElementsByTagName('input');			//input 태그 배열
		var max = field.length;										//input 태그 갯수
		for (var idx = 0; idx < max; idx++) {						//input 태그 갯수만큼 루프
			if(field[idx].className=='c'){							//클래스명이 c인 체크박스일 때
				if (eval("field[" + idx + "].checked") == true) {
				total += 1;
				}
			}
		}

		if(total < 1){
			alert("이동할 폼을 1개 이상 선택하십시오\n\n please select at least one item");
		}
		else{
			chk_move(frm);
		}
}
 

function chk_move(frm){												//이동시 새창으로 체크항목 값 전송
 var frm = frm;
 var input_id;
 var url = "move_Group.php?w=450&h=300&a=";							//팝업창 경로와 get 인자
 var field=document.getElementsByTagName('input');					//input 태그 배열
 var max = field.length;											//input 태그 갯수

 for (var idx = 0; idx < max; idx++) {								//input 태그 갯수만큼 루프
	if(field[idx].className=='c'){									//클래스명이 c인 체크박스이고

    if(field[idx].checked) {										//체크되어 있을 때

      input_id = field[idx].value;									//체크항목의 값을 input_id 에 대입

      url=url+"|"+input_id;											//팝업창 경로 get 인자에 배열로 사용할 구분자 삽입									

			}
		} 
	}
	
	javascript:void(window.open(url,'chk_move','width=450,height=300,statusbar=no,scrollbars=no,toolbar=no'));
 //win1=window.open(url,'chk_move','width=500, height=300, top=200, left=300, scrollbars=no, status=no, toolbar=no, location=no, resizable=no, directories=no, menubar=no');
}