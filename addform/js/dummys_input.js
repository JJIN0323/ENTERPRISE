function dummys_input(inputId,dummyId)
{
	document.getElementById(inputId).value = "";				//실제입력 필드 초기화
	var field=document.getElementsByTagName('input');			//태그갯수만큼 
	var dummyIdSlice = dummyId.slice(0,-1);						//공통가상필드 이름 추출
	
		for (var i=0; i < field.length;i++)						//for문 start
			{						
			if(field[i].id.match(dummyIdSlice)!= null)			//객체이름에서 공통가상필드의 이름이 검색된다면
				{				
																//문자열 더하기				
				document.getElementById(inputId).value += field[i].value + "-";			
								
				}
			}													//for문 end
																//실제입력필드 셋팅
	document.getElementById(inputId).value = document.getElementById(inputId).value.slice(0,-1);
	
} 