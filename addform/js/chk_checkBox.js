/////////////////////	함수를 배열인자로 받아서 일괄처리 하기	//////////////////////////////

function chk_checkBox(frm,nextScript,dummy) {		//체크박스 하나이상 체크하였는지 검사
	    var frm = frm;								//넘겨받은 폼 인자		
		var nextScript_len = nextScript.length;		//인자로 받은 nextScript 배열의 길이		
		
		var total = 0;
		var field=document.getElementsByTagName('input');//input 태그 배열
		var max = field.length;

		
		for (var i = 0; i < max; i++) {				//input 태그 갯수만큼 루프

			var fieldName = field[i].name;			//input 객체의 이름을 fieldName에 대입
			var rexp = /chk_list/;					//매치검색을 위한 정규표현식
			//input 객체이름에서 chk_list가 검색되고 체크되어있다면
			if(rexp.test(fieldName) && field[i].checked == true){	
			
				total += 1;
			}										//if문 끝
				
		}											//for 문 끝

		if(total < 1){								//체크한 항목이 없을 때
			alert("품목을 1 개 이상 선택하십시오\n\n Please choose items one or more");
			return false;
		}
		
		else{										//항목을 하나 이상 체크하였고
			if(nextScript_len > 0){					//다음 실행할 스크립트가 하나 이상일 때
				for(var i = 0; i < nextScript_len; i++){
				eval(nextScript[i]);
				//eval 함수로 인자에 할당된 문자열 배열함수들을 실행
				}			
			}		
		}

}
