//자바스크립트로 객체 display 스타일제어
//(폼이름,객체,이미지name,윗체크박스배열번호)
function link_itemDisplay(frm,x,preimgName,preChkBoxN)
	{
	var nextN = preChkBoxN+1;						//다음 배열번호
	var nextImg = "link_item"+nextN;				//다음 이미지

	var obj=document.getElementsByTagName("img");	//이미지태그 검사	

		for (var i=0; i < obj.length;i++)			//이미지 태그수만큼 루프
			{			
			if(obj[i].name==preimgName)				//이미지 name 속성이 인자와같을때
				{
				if(x.checked==true)					//밑 체크박스가 체크되었을 때		
					{								//이미지 보이게
					obj[i].style.visibility = "visible";
													//밑 이미지도 함께 보이게
					document[nextImg].style.visibility = "visible";
													//해당열 체크박스도 체크되게
					document.form1["dummy4["+preChkBoxN+"]"].checked = true;
					}
				else
					{
					obj[i].style.visibility = "hidden";
					document[nextImg].style.visibility = "hidden";					
					document.form1["dummy4["+preChkBoxN+"]"].checked = false;
					}				
					
				}
										
			}				
				
	}	