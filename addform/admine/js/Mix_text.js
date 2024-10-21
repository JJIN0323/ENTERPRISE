function Mix(f){
	var val_subject = document.form1.optBigName.value;   //옵션제목
	var val_name = "";								     //옵션항목제목
	var val_price = "";									 //옵셩항목가격
	var val_ess = document.form1.ess.value;		         //필수선택여부

	if(f.ess[0].checked) val_ess = "1";
	else val_ess = "0";

	var field=document.getElementsByTagName('input');	 //input 태그 갯수 검사
	
		for (i = 0; i < field.length;i++){				 //input 태그 갯수만큼 루프
										
			if(field[i].className=='class_name'){		 //일치하는 클래스명이 있을 때
				val_name+=field[i].value+",";		     //항목이름값들을 쉼표구분자로 합침
				}
			}

		for (i = 0; i < field.length;i++){				 //input 태그 갯수만큼 루프
										
			if(field[i].className=='class_price'){		 //일치하는 클래스명이 있을 때
				val_price+=field[i].value+",";		     //항목가격값들을 쉼표구분자로 합침
				}
			}
			
    if (val_name){										 //항목이 있을 때 각항목값들을 mix_data에 대입
	
		var mix_data ="" 
			+val_subject+"|"
			+val_name.slice(0,-1)+"|"
			+val_price.slice(0,-1)+"|"
			+val_ess;
		}
	else mix_data = "";									 //항목이 없을 때 mix_data

	if (!f['optBigName'].value) {						 //옵션제목 입력여부 체크
        alert('옵션의 제목을 입력하십시오.\n\n Enter the title of the options');
        return f['optBigName'].focus();
    }	
	
														 //조건을 통과시 부모창의 옵션필드에 입력
window.opener.document.form1["opt[<?=$opt_no?>]"].value = mix_data;
top.opener=top.window.close();
	
}		