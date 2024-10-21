 function chk_null(f)												//필수입력필드 검사 함수
{
	
		var field=document.getElementsByTagName('input');			//input 태그 갯수 검사
		for (var i=0; i < field.length;i++){						//input 태그 갯수만큼 루프
			if(field[i].className=='ess'){							//클래스명이 ess인 필드가 있을때
				var essent = field[i].value;						//필수 입력필드의 값
				if(essent == ""){									//입력값이 없을 때
				alert("필수입력항목을 입력하여 주십시오\n\n Please enter the essential items");			//메시지	
				field[i].focus();									//필수 공란 포커스	
				return false;										//실행 중지
				}													//if 문 끝			
			}														//if 문 끝
		}															//for문 끝
		f.submit();													//폼 전송	
	
}
