function calendar_pop(inputId,dummyId)
{
    var dummyDate = document.getElementById(dummyId).value;	
    if(dummyDate)
		{		
        dummyDate = dummyDate.split('/');
		}
	else
		{
        NewD = new Date();
		//***  던져줄 값이 없을 때 여기서 조정   ***//
        dummyDate = new Array(NewD.getFullYear(), NewD.getMonth()+1, NewD.getDate());
		}
	window.open(
		"plugin/calendar/calendar.php?w=250&h=220&getY="+dummyDate[0]+"&getM="+dummyDate[1]+"&getD="+dummyDate[2]+"&inputId="+inputId+"&dummyId="+dummyId+""
		,"calendar_pop"
		,"scrollbars=no,toolbar=no,menubar=no");        
		
}

function Date_in(D, M, Y,inputId,dummyId)
{
	document.getElementById(inputId).value = "";				//실제입력 필드 초기화
	var field=document.getElementsByTagName('*');				//태그갯수만큼 
	var dummyIdSlice = dummyId.slice(0,-1);						//공통가상필드 이름 추출
	
		for (var i=0; i < field.length;i++)						//for문 start
			{						
			if(field[i].id.match(dummyIdSlice)!= null)			//객체이름에서 공통가상필드의 이름이 검색된다면
				{
	
				if(field[i].id == dummyId )						//선택된 가상필드라면...
					{															
					field[i].value = Y + '/' + M + '/' + D;		//선택된 가상필드 값셋팅				
					}

				
																//문자열 더하기				
				document.getElementById(inputId).value += field[i].value + "~";			
								
				}
			}													//for문 end
																//실제입력필드 셋팅
	document.getElementById(inputId).value = document.getElementById(inputId).value.slice(0,-1);
	
} 















































/*function Date_in(D, M, Y,inputId)
{
	var targetId = inputId;									//실제입력필드 = 더미입력필드	
	
	for (i=1;i < 3 ; i++ )									//더미입력필드의 수만큼 루프
	{
		targetId =  targetId.replace("dummy"+i,"");			//실제입력필드 이름 추출
	}
															//더미입력필드 값셋팅
    document.getElementById(inputId).value = D + '/' + M + '/' + Y;
															//실제입력필드 값 초기화
	document.getElementById(targetId).value = "";

	for (i=1;i < 3 ; i++ )									//실제입력필드 값 셋팅
	{
	document.getElementById(targetId).value += document.getElementById(targetId+"dummy"+i).value + "~";
	}

	document.getElementById(targetId).value = document.getElementById(targetId).value.slice(0,-1);
	
} 


var field=document.getElementsByTagName('*');				
		for (var i=0; i < field.length;i++)
			{						
			if(field[i].className=='ess')
				{						
				var essent = field[i].value;						
				if(essent == "")
					{									
					alert("필수입력항목을 입력하여 주십시오");			
					field[i].focus();								
					return false;										
					}													
				}														
			}*/					