<!--##################################################################################-->
<!--#################################	자바스크립트 start	##########################-->
<!--##################################################################################-->
<?php 
function get_dummy6() 											 //이 함수는 자바스크립트문에서 출력할것임
	{
	   global $af_TABLE5;
	   if(!$af_TABLE5["dummy6"]) $dummy6 = 0;					 //값이 없을 때는 0 으로(오류방지)...
       $buffer="var js_dummy6=$dummy6;\n";						 //부가세반영설정 변수(아니오0,예1)
	   return $buffer;
    }
    
?>
<script type="text/javascript" src='js/pop_center.js'></script>
<script type="text/javascript" src='js/chk_checkBox.js'></script>
<script type="text/javascript" src='js/only_en.js'></script>
<script type="text/javascript" src='js/check_input.js'></script>
<script type="text/javascript" src='js/chk_null.js'></script>
<script type="text/javascript" src='js/number_format.js'></script>
<script type="text/javascript" src='js/money_kr.js'></SCRIPT>
<script type="text/javascript" src='js/money_china.js'></SCRIPT>
<script type="text/javascript" src='js/roll_table.js'></script>
<script type="text/javascript" src='js/formmail_mixdata.js'></script>
<script type="text/javascript" src='js/estimate_calculator.js'></script>
<script type="text/javascript" src='js/formmail_calculator.js'></script>
<script type="text/javascript" src='js/formmail_onloadSum.js'></script>
<script type="text/javascript" src='js/dummys_input.js'></script>
<script type="text/javascript" src='js/eq_client.js'></script>
<script type="text/javascript" src='js/mix_shipTo.js'></script>
<script type="text/javascript" src='plugin/calendar/calendar_pop.js'></script>
<script type="text/javascript" src='js/display_upload.js'></script>
<script type="text/javascript" src='js/chk_all_item.js'></script>
<script type="text/javascript">
<!--
		 // submit 버튼 클릭시 첫이벤트 스크립트 다음에 실행될 스크립트를 정의/배열
		 var nextScript = new Array("chk_selectOpt(frm,dummy)");
 -->
</script>


<!-- #######  체크항목/선택옵션/주문수량 행별 소계와 합계 스크립트 start  ########### -->
<script type="text/javascript">
<!--
<?php echo get_dummy6();?>

function subtotal(frm,i)										 //각행의 소계구하기 함수
{

	var chkbox = frm["chk_list["+i+"]"];						 //체크항목 객체
	//가격정보
	var chkboxPrice = parseFloat(frm["chk_list["+i+"]"].value);	 //체크항목 품목가격		
	var hiddenOpt = parseFloat(frm["hiddenOpt["+i+"]"].value);	 //선택한 옵션 값
	var it_num = frm["it_num["+i+"]"].value;					 //주문량 필드 값(문자형으로 할것)

	if(!it_num || it_num == 0) 									 //주문량에 값이 없거나 0일 때
	{
		chkbox.checked = false;									 //숫자형이면 즉시 반영안되므로 위에서 문자형으로
		subtotal_sum();		
	}




	if(chkboxPrice == "0" && hiddenOpt)							 //체크항목 품목의 값이 0원이고, 선택한 옵션이 있는 경우는
	{
																 //소계를 위한 곱셈 연산자를 선택된 옵션의 값으로 대체
																 //Math.round(int * 1000)/1000 소수점3자리에서 반올림
		frm["it_sumPrice["+i+"]"].value = Math.round(hiddenOpt * it_num *100)/100;
																//품목 세금
		frm["it_price_tax["+i+"]"].value = Math.round(frm["it_sumPrice["+i+"]"].value * frm["it_price_taxDB["+i+"]"].value /100 * 100)/100;
		subtotal_sum();	
		frm["price["+i+"]"].value = hiddenOpt;					//단가란 필드값 재정의(후기능 없음)
	}

	else														 //품목의 값이 0원이 아닐경우엔...
	{
	
		if(!hiddenOpt && chkbox.checked == true) 				 //품목만 체크하였을 때 소계
		{
			frm["it_sumPrice["+i+"]"].value = Math.round(chkboxPrice * it_num *100)/100;
																 //품목 세금
			frm["it_price_tax["+i+"]"].value = Math.round(frm["it_sumPrice["+i+"]"].value * frm["it_price_taxDB["+i+"]"].value /100 * 100)/100;
			subtotal_sum();		
		}

		if(hiddenOpt && chkbox.checked == true) 				 //체크한 품목이 옵션까지 선택되었을 때 소계
		{
			frm["it_sumPrice["+i+"]"].value = Math.round((chkboxPrice * it_num + hiddenOpt) *100)/100;
																 //품목 세금
			frm["it_price_tax["+i+"]"].value = Math.round(frm["it_sumPrice["+i+"]"].value * frm["it_price_taxDB["+i+"]"].value /100 * 100)/100;
			subtotal_sum();		
		}
	}



	if(chkbox.checked == false) 								 //체크를 해제하였을 때 
	{
		frm["it_sumPrice["+i+"]"].value = 0;
		frm["it_price_tax["+i+"]"].value = 0;
		subtotal_sum();		
	}


}


function subtotal_sum()											 //합계구하기 함수
{
		
		var z = 0;												 //DB 입력될 합계(부가세제외금액)
		var t = 0;												 //세액 합계(DB입력안함)
		var field=document.getElementsByTagName('input');		

		for (var i=0; i < field.length;i++)
			{		
			if(field[i].className=='subTotal')
				{				
				//z+= parseInt(field[i].value);					 //정수로 파서하지 않으면 문자열이 됨																
				z+= parseFloat(field[i].value) ;				 //실수로 파서하지 않으면 소숫점표현안됨
					
				}									
			}					
				

		for (var i=0; i < field.length;i++)
			{				
			if(field[i].className=='subTax')
				{				
				t+= parseFloat(field[i].value);					//실수로 파서하지 않으면 소숫점표현안됨					
				}									
			}	
z = Math.round(z * 100)/100;									//소수점 두자리에서 반올림			
t = Math.round(t * 100)/100;									//소수점 두자리에서 반올림
comma(z,t)														//숫자에 콤마찍기 함수 호출
 }

function formmail_sum()											 //폼메일 합계구하기 함수
{
		
		var z = 0;												 //폼메일 항목 소계		
		var field=document.getElementsByTagName('input');		

		for (var i=0; i < field.length;i++)
			{		
			if(field[i].className=='formmail_subtotal')
				{	
				if(field[i].value > 0)							//0원보다 클 경우로 해야 Nan 에러 안남
					{
					z+= parseFloat(field[i].value) ;			//실수로 파서하지 않으면 소숫점표현안됨		
					}							
				}									
			}		
z = Math.round(z * 100)/100;									//소수점 두자리에서 반올림			
document.form1.total_sum.value = z;
comma_formmail(z);
 }

function comma_formmail(z)
{
/*-------------------------------------------------------------------------------------*/
/*						DB입력위한 합계와 문자화합계								   */
/*-------------------------------------------------------------------------------------*/
	var y = String(z);											 //숫자를 문자화	 

		while(y.match(/^(-?\d+)(\d{3})/))
		{
		y = y.replace(/^(-?\d+)(\d{3})/,'$1,$2');
		}		
	
	document.form1.total_sum_comma.value = y;	
}



 function comma(z,t)
{
/*-------------------------------------------------------------------------------------*/
/*						DB입력위한 합계와 문자화합계								   */
/*-------------------------------------------------------------------------------------*/
	 var x = document.form1.total_sum;							 //합계::콤마찍어 표현 후, db입력시엔 콤마제거함
	 var x3 = document.form1.total_sum3;						 //한자, 한글 금액입력위한 가상필드(콤마안찍고) => total_sum2에 입력
	 var y = String(z);											 //숫자를 문자화	 

		while(y.match(/^(-?\d+)(\d{3})/))
		{
		y = y.replace(/^(-?\d+)(\d{3})/,'$1,$2');
		}		
	
	x.value = y;												
	x3.value = z;
/*-------------------------------------------------------------------------------------*/
/*						부가세합계와 TOTAL 표시(보이기위함의 용도)					   */
/*-------------------------------------------------------------------------------------*/
	t2= String(t);												 //부가세합계를 문자화

	while(t2.match(/^(-?\d+)(\d{3})/))
		{
		t2 = t2.replace(/^(-?\d+)(\d{3})/,'$1,$2');
		}
	
	document.form1.sumTax.value = t2;							 //부가세합계 콤마


	var dummy_total =  Math.round((z + t) * 100)/100;
	var dummy_total = String(z + t);							 //소계합 + 부가세를 문자화

	while(dummy_total.match(/^(-?\d+)(\d{3})/))
		{
		dummy_total = dummy_total.replace(/^(-?\d+)(\d{3})/,'$1,$2');
		}

	document.form1.taxPlusTotal.value = dummy_total;			 //TOTAL 콤마
}

-->
</script>


<script type="text/javascript">
<!--
//#######################  수량 가감 버튼 클릭시 실행함수   ###############################//
function it_num_decrease(frm,i,type,extra1,extra2){					//배열번호, 가감타입, 여분1,여분2
	if (frm["it_num["+i+"]"].value <= 0 && type == "down"){
		alert('수량이 0 보다 작을 수는 없습니다');		
	}
	else{
	
		if(type == "up"){
			frm["it_num["+i+"]"].value++;
			frm["chk_list["+i+"]"].checked=true;
			subtotal(frm,i);		
		}
		if(type == "down"){
			frm["it_num["+i+"]"].value--;
			frm["chk_list["+i+"]"].checked=true;
			subtotal(frm,i);		
		}
	}
}

-->
</script>

<script type="text/javascript">
<!--
//#######################  주문서/견적일 경우 전송 함수 ###############################//

function chk_selectOpt(frm,dummy)								//필수선택 옵션 체크 스크립트
{
	var frm = frm;		
	var field=document.getElementsByTagName('input');		//input 태그 갯수 검사	

	for (var i=0; i < field.length;i++)						//input 태그 갯수만큼 루프			
		{
		if(field[i].className=='essSelect' && field[i].checked == true)
			{
			var name = field[i].name;
			var select_name = name.replace("t","");			//체크상자이름에서 t를제거(선택상자이름과 같게하기위해)

			if(frm[select_name].type == "select-one")		//펼침목록메뉴일 때
				{
			//select_name에 대입된 선택상자 이름이 배열이므로 폼이름["객체배열"] 과 같이 하였음				
				if(frm[select_name].options[frm[select_name].selectedIndex].value == "")
					{
					alert("<?php echo af_txt_skin_function_skin_1;?>");//필수 선택옵션을 선택하여 주십시오			
					frm[select_name].focus();									
					return false;
					}
				}
			else
				{

				if(frm[select_name][1])						//옵션이 둘 이상이라면
					{
															//체크박스이거나 라디오버튼일 때
					if(frm[select_name][0].type == "checkbox" || frm[select_name][0].type == "radio")					
						{
			
						var x = 0;							//체크수 파악위한 변수
						for (var q=0; q < frm[select_name].length;q++)	
							{								//옵션수 만큼 루프
							if(frm[select_name][q].checked==true)
								{
								x++;							
								}
							}
							
						if(x == 0)
							{					
							alert("<?php echo af_txt_skin_function_skin_2;?>");//필수 선택사항을 체크하여 주십시오			
							frm[select_name][0].focus();									
							return false;					
							}
					
						}
															//글상자일 때
					if(frm[select_name][0].type == "text" || frm[select_name][0].type == "textarea")					
					{
			
						var x = 0;							//체크수 파악위한 변수
						for (var q=0; q < frm[select_name].length;q++)	
							{								//옵션수 만큼 루프
							if(frm[select_name][q].value)
								{
								x++;							
								}
							}
							
						if(x != frm[select_name].length)
							{
							for (var q=0; q < frm[select_name].length;q++)	
								{							//옵션수 만큼 루프
								if(!frm[select_name][q].value)
									{
									alert("<?php echo af_txt_skin_function_skin_4;?>");//필수 입력사항을 입력하여 주십시오		
									frm[select_name][q].focus();									
									return false;						
									}
								}												
							}						
						}
					}
															
				else										//옵션이 하나 일 때
					{
															//체크박스이거나 라디오버튼일 때
					if(frm[select_name].type == "checkbox" || frm[select_name].type == "radio")					
						{				
												
							if(frm[select_name].checked==false)
								{
								alert("<?php echo af_txt_skin_function_skin_2;?>");	//필수 선택사항을 체크하여 주십시오		
								frm[select_name].focus();									
								return false;							
								}						
						}
															//글상자일 때
					if(frm[select_name].type == "text" || frm[select_name].type == "textarea")					
						{			
												
							if(!frm[select_name].value)
								{
								alert("<?php echo af_txt_skin_function_skin_4;?>");//필수 입력사항을 입력하여 주십시오		
								frm[select_name].focus();									
								return false;								
								}								
						
						}
					}

				}					
															
			}													
		}													//for문 end	
	
	if(dummy == "pop")										//견적서 보기 일 때
	{
			var nextScript = "submit_data(frm,dummy)";
	}
	else													//주문일 때
	{
		//신용카드결제연동일때와 아닐 때 구별하여 스크립트 실행 start
		var yesorno_pay = "<?php echo $af_TABLE5[yesorno_pay];?>";
		if(yesorno_pay == "on") 
		{
			var nextScript = "popup_pay2()";
		}
		else
		{	
			var nextScript = "submit_data(frm,dummy)";
		}
	}
	chk_null(frm,nextScript,dummy);
	//신용카드결제연동일때와 아닐 때 구별하여 스크립트 실행 end
}	

function popup_pay2()
{	
	var pgname = "<?php echo $af_TABLE5[res_dummy1];?>";							 //PG 이름
	//var res_mny = document.form1.total_sum.value;	//090413 주문폼에서 부가세 결제반영위해 아래 taxPlusTotal로 교체
	var res_mny = document.form1.taxPlusTotal.value;								 //총합계(소계+부가세합)	
	var fname = "<?php echo $af_TABLE5[name];?>";									 //폼이름
	if(document.form1.client_name) var cname = document.form1.client_name.value;	 //고객이름
	else var cname = "";
	if(document.form1.client_email) var cemail = document.form1.client_email.value;  //고객이메일
	else var cemail = "";
	if(document.form1.client_tel) var ctel = document.form1.client_tel.value;		 //고객전화
	else var ctel = "";
	if(document.form1.client_hp) var chp = document.form1.client_hp.value;			 //고객휴대폰
	else var chp = "";
	kcpwin = window.open('plugin/PG/'+pgname+'/index.php?w=600&h=700&fname='+fname+'&cname='+cname+'&cemail='+cemail+'&ctel='+ctel+'&chp='+chp+'&res_mny='+res_mny+'&type=order','pay','width=600,height=700,status=yes,scrollbars=yes,toolbar=no,location=no,resizable=yes');	
}

				

function submit_data(frm,dummy)
{
	var dummy = dummy;											//여유인자
	
	var it_name = "";											//품목이름 지역변수로 선언
	var opt_text = "";											//옵션이름 지역변수로 선언	
	var opt_price = "";											//옵션가격 지역변수로 선언
	var it_unit = "";											//품목단위 지역변수로 선언
	var it_num = "";											//주문수량 지역변수로 선언
	var it_price = "";											//품목가격 지역변수로 선언
	var it_sumPrice = "";										//소	계 지역변수로 선언
	var it_price_taxDB = "";									//세	율 지역변수로 선언

	var field=document.getElementsByTagName('input');			//input 태그 갯수 검사	

		for (var i=0; i < field.length;i++)						//input 태그 갯수만큼 루프	
			{
			var fieldName = field[i].name;						//input 객체의 이름을 fieldName에 대입
			var rexp = /chk_list/;								//매치검색을 위한 정규표현식
			
		   if(rexp.test(fieldName) && field[i].checked == true)//input 객체이름에서 chk_list가 검색되고 체크되어있다면
				{
				var noarr = fieldName.split("[");				//체크항목 fieldName에서 [를 구분자로 배열			
				var no = noarr[1].replace("]","");				//체크항목 name에서 배열번호만 추출	
				var select_name = fieldName.replace("t","");	//체크상자이름에서 t를제거(선택상자이름과 같게하기위해)
												
				it_name+=frm["it_name["+no+"]"].value+";";		//체크항목 배열번호와같은 같은배열 번호를 가진 it_name필드의 값


			  //#######################################################################//
			  //########################	  옵션처리 start	   ####################//
			  //#######################################################################//
			  if(frm[select_name])										//체크된 품목에서 chk_lis로 시작하는 옵션이 있다면
				{
					
				
				//*******	펼침목록일 때 옵션처리   *******//
				if(frm[select_name].type == "select-one")
					{
					if(!frm[select_name].options[0].selected)
						{												//선택을 한경우
						var OPtextarr = frm[select_name].options[frm[select_name].selectedIndex].text; //옵션의 선택된 text
						var OPtext = OPtextarr.split("+");				//옵션선택 text에서 + 를 구분자로 배열				
						opt_text+=OPtext[0]+";";						//선택된 옵션의 text에서 가격정보를 뺀 값
						opt_price+=frm[select_name].options[frm[select_name].selectedIndex].value+";";//선택된 옵션의 가격값			
						}
					else 
						{												//배열에 맞추기 위해 미선택시 옵션텍스트와 가격처리
						opt_text+=";";												
						opt_price+="0"+";";
						}
					}
				
				//*******	체크박스, 라디오버튼일 때 옵션처리   *******//
				else
					{													//옵션이 둘 이상일 경우
					if(frm[select_name][1]) 					
						{	
						var bed0 = "";									//사용하고 바로 버릴 임시옵션이름
						var bed1 = 0;									//사용하고 바로 버릴 임시옵션가격
						for (var q=0; q < frm[select_name].length;q++)	
							{											//옵션수 만큼 루프
							if(frm[select_name][q].checked==true)
								{										//체크를 하였을 경우								
								var OPtextarr = frm[select_name][q].value;//체크한 객체의 값
								var OPtext = OPtextarr.split("|");		//쉼표를 구분자로 배열
								bed0 +=OPtext[0]+" ￦"+OPtext[1]+"#";
								bed1 +=parseFloat(OPtext[1]);										
								}
							else 
								{										//배열에 맞추기 위해 미선택시 옵션텍스트와 가격처리
								bed0+="";							
								}	
							}
							bed0 = bed0.slice(0,-1);							
							opt_text+=bed0+";";							//text
							opt_price+=Math.round(bed1 *100)/100 +";";	//옵션가격
						}
					else												//옵션이 하나일 경우
						{												//(희박하나 만일에 대비한것임)
						if(frm[select_name].type == "checkbox" || frm[select_name].type == "radio")	
							{
							if(frm[select_name].checked==true)
								{										//체크를 하였을 경우
								var OPtextarr = frm[select_name].value; //체크한 객체의 값
								var OPtext = OPtextarr.split("|");		//쉼표를 구분자로 배열				
								opt_text+=OPtext[0]+";";				//text
								opt_price+=OPtext[1]+";";				//옵션가격		
								}
							else 
								{										//배열에 맞추기 위해 미체크시 옵션텍스트와 가격처리
								opt_text+=";";												
								opt_price+="0"+";";
								}
							}
						//***주문견적의 경우 품목을 사용자입력으로 한 경우 옵션으로 처리***//
						if(frm[select_name].type == "text" || frm[select_name].type == "textarea")					
							{			
													
							if(frm[select_name].value)
								{								
								var OPtext = frm[select_name].value;	//한줄글상자에 입력한 값								
								opt_text+=OPtext+";";					//text												
								opt_price+="0"+";";						//옵션가격				
								}
							else 
								{										//배열에 맞추기 위해 미입력시 옵션텍스트와 가격처리
								opt_text+=";";												
								opt_price+="0"+";";
								}
							
							}		
						}
								
					}
				  
				}


			  else
				{														//옵션이 없다면...
				 opt_text+=";";												
				 opt_price+="0"+";";
				}
              //#######################################################################//
			  //########################	  옵션처리 end	       ####################//
			  //#######################################################################//


							
				
				it_unit+=frm["it_unit["+no+"]"].value+";";		//체크항목 배열번호와같은 배열번호를가진 품목단위필드의 값
				it_num+=frm["it_num["+no+"]"].value+";";		
				it_price+=field[i].value+";";																
				it_sumPrice+=frm["it_sumPrice["+no+"]"].value+";";																
				it_price_taxDB+=frm["it_price_taxDB["+no+"]"].value+";";
					
					
			}													//if문 end	
					
		}														//for문 end	 

	var it_name = it_name.slice(0,-1);							//문자열 끝의 배열에 필요없는 쉼표, 제거
	var opt_text = opt_text.slice(0,-1);											
	var opt_price = opt_price.slice(0,-1);	
	var it_unit = it_unit.slice(0,-1);
	var it_num = it_num.slice(0,-1);											
	var it_price = it_price.slice(0,-1);											
	var it_sumPrice = it_sumPrice.slice(0,-1);
	var it_price_taxDB = it_price_taxDB.slice(0,-1);

	frm.total_data.value = it_name+"|*|"+opt_text+"|*|"+opt_price+"|*|"+it_unit+"|*|"+it_num+"|*|"+it_price+"|*|"+it_sumPrice+"|*|"+it_price_taxDB;	
																//한자,한글 합계입력을 위한...
	var moneyKr = money_kr(frm.total_sum3.value);				//한글화
	var moneyChina = money_china(frm.total_sum3.value);			//한자화
	frm.total_sum2.value = moneyKr+"|"+moneyChina;				//한글금액|한자금액

	

if(dummy == "pop")
	{															//여유인자가 pop 일 때는 새창견적으로 처리
	javascript:void(window.open('','popup_est','width=730,height=750,status=no,scrollbars=yes,toolbar=no'));
	frm.target="popup_est";
	frm.action="estimate.php?w=730&h=750"; 
	frm.submit();
	}
else
	{															//여유인자가 없을때는 주문으로 처리
	frm.target="_self";						
	frm.action="order.php";
	frm.submit();
	frm.ok.disabled=true;
	}

}

//#######################  폼메일일 경우 전송 함수 ####################################//

 function chk_selectOpt_formmail(frm,dummy)						//필수선택 옵션 체크 스크립트
{
		var frm = frm;		
		var field=document.getElementsByTagName('*');			//모든 태그 검사	

		for (var i=0; i < field.length;i++)						//input 태그 갯수만큼 루프
		{
			
			if(field[i].className=='essSelect')					//옵션이 필수선택일 때
			{
				
			var select_name = field[i].name;

			 if(frm[select_name].type == "select-one")			//펼침목록메뉴일 경우
				{
					//select_name에 대입된 선택상자 이름이 배열이므로 폼이름["객체배열"] 과 같이 하였음				
					if(frm[select_name].options[frm[select_name].selectedIndex].value == "")
					{
					
						alert("<?php echo af_txt_skin_function_skin_1;?>");	//필수 선택사항을 선택하여 주십시오		
						frm[select_name].focus();									
						return false;
					
					}												
				}

			 else
				{

				if(frm[select_name][1])							//옵션이 둘 이상이라면
					{
																//체크박스이거나 라디오버튼일 때
					if(frm[select_name][0].type == "checkbox" || frm[select_name][0].type == "radio")					
						{
				
						var x = 0;								//체크수 파악위한 변수
						for (var q=0; q < frm[select_name].length;q++)	
							{									//옵션수 만큼 루프
							if(frm[select_name][q].checked==true)
								{
								x++;							
								}
							}
								
						if(x == 0)
							{					
							alert("<?php echo af_txt_skin_function_skin_2;?>");	//필수 선택사항을 체크하여 주십시오		
							frm[select_name][0].focus();									
							return false;					
							}
						
						}
																//글상자일 때
					if(frm[select_name][0].type == "text" || frm[select_name][0].type == "textarea")					
						{
				
						var x = 0;								//체크수 파악위한 변수
						for (var q=0; q < frm[select_name].length;q++)	
							{									//옵션수 만큼 루프
							if(frm[select_name][q].value)
								{
								x++;							
								}
							}
								
						if(x != frm[select_name].length)
							{
							for (var q=0; q < frm[select_name].length;q++)	
								{								//옵션수 만큼 루프
								if(!frm[select_name][q].value)
									{
									alert("<?php echo af_txt_skin_function_skin_4;?>");	//필수 입력사항을 입력하여 주십시오		
									frm[select_name][q].focus();									
									return false;						
									}
								}												
							}						
						}
					}
																
				else											//옵션이 하나 일 때
					{
																//체크박스이거나 라디오버튼일 때
					if(frm[select_name].type == "checkbox" || frm[select_name].type == "radio")					
						{				
													
							if(frm[select_name].checked==false)
								{
								alert("<?php echo af_txt_skin_function_skin_3;?>");	//필수 선택사항을 체크하여 주십시오		
								frm[select_name].focus();									
								return false;							
								}						
						}
																//글상자일 때
					if(frm[select_name].type == "text" || frm[select_name].type == "textarea")					
						{			
													
							if(!frm[select_name].value)
								{
								alert("<?php echo af_txt_skin_function_skin_4;?>");	//필수 입력사항을 입력하여 주십시오		
								frm[select_name].focus();									
								return false;								
								}								
							
						}
					}

				}
			}														
		}														//for문 end	
	
	//신용카드결제연동일때와 아닐 때 구별하여 스크립트 실행 start
	var yesorno_pay = "<?php echo $af_TABLE5[yesorno_pay];?>";
	var getmode = "<?php echo $_GET[mode];?>";
	if(yesorno_pay == "on") 
	{
		if(getmode != "admine")	{var nextScript = "popup_pay()";}
		else					{var nextScript = "submit_formmail(frm,dummy)";}
	}
	else
	{	
		var nextScript = "submit_formmail(frm,dummy)";
	}
	chk_null(frm,nextScript,dummy);
	//신용카드결제연동일때와 아닐 때 구별하여 스크립트 실행 end
}	

function popup_pay()
{	
	var pgname = "<?php echo $af_TABLE5[res_dummy1];?>";							 //PG 이름
	var res_mny = document.form1.total_sum.value;									 //총예약비용	
	var fname = "<?php echo $af_TABLE5[name];?>";									 //폼이름
	if(document.form1.client_name) var cname = document.form1.client_name.value;	 //고객이름
	else var cname = "";
	if(document.form1.client_email) var cemail = document.form1.client_email.value;  //고객이메일
	else var cemail = "";
	if(document.form1.client_tel) var ctel = document.form1.client_tel.value;		 //고객전화
	else var ctel = "";
	if(document.form1.client_hp) var chp = document.form1.client_hp.value;			 //고객휴대폰
	else var chp = "";
	kcpwin = window.open('plugin/PG/'+pgname+'/index.php?w=600&h=700&fname='+fname+'&cname='+cname+'&cemail='+cemail+'&ctel='+ctel+'&chp='+chp+'&res_mny='+res_mny+'&type=formmail','pay','width=600,height=700,status=yes,scrollbars=yes,toolbar=no,location=no,resizable=yes');	
}


function submit_formmail(frm,dummy){
	var dummy = dummy;											//여유인자
	
	var input_datas = "";										//고객입력값 지역변수로 선언
	var name_it	= "";											//항목 이름값 지역변수로 선언
	

	var field=document.getElementsByTagName('*');				//input 태그에서 모든태그 변경(080325)		

		for (var i=0; i < field.length;i++){					//태그 갯수만큼 루프	
		
			var fieldName = field[i].name;
			
			var rexp = /input_data/;							//매치검색을 위한 정규표현식
			var rexp2 = /name_it/;								//매치검색을 위한 정규표현식
			
			
			if(rexp.test(fieldName)){							//객체이름에서 input_data가 검색된다면	
			
				input_datas+=field[i].value+";";				//frm을 사용할 경우가 아니한 경우 주의				
				
				}												//if문 end

			if(rexp2.test(fieldName)){							//객체이름에서 input_data가 검색된다면	
			
				name_it+=field[i].value+";";					//frm을 사용할 경우가 아니한 경우 주의				
				
				}												//if문 end
	}															//for문 end

	var input_datas = input_datas.slice(0,-1);					//문자열 끝의 배열에 필요없는 쉼표, 제거
	tagfind = /</gi;											//090105 추가 정규식(입력값에서 < 를 모두 찾음)
	var input_datas = input_datas.replace(tagfind,"◐");		//(현재파일에서 출력때는 다시 치환)
	tagfind = />/gi;											//090105 추가 정규식(입력값에서 < 를 모두 찾음)
	var input_datas = input_datas.replace(tagfind,"◑");		//(현재파일에서 출력때는 다시 치환)
	
	var name_it = name_it.slice(0,-1);							//문자열 끝의 배열에 필요없는 쉼표, 제거


	frm.total_data.value = name_it+"|*|"+input_datas;

															
	frm.target="_self";						
	frm.action="formmail.php";
	frm.submit();
	frm.ok.disabled=true;
}

-->
</script>

<!--##################################################################################-->
<!--########################### 	자바스크립트 end	##############################-->
<!--##################################################################################-->


<?php
#########################################################################################
#######################     옵션 각 타입별 출력 함수 start      #########################
#########################################################################################

###############################  <select> 선택상자 구성	#################################
#//////////////// 아래  f_SelectBox()에 의해 호출되어	<option>  생성	////////////////#
function f_opt($val,$text,$default_opt="",$head="") 
{
	global $af_TABLE5;
	        $buf="<option value='$val'";
		if($af_TABLE5["form_type"] == "1")					 //폼메일일 경우에만 초기값 선택되게
			{
	        if ($default_opt&&$default_opt==$text) 
				{
	            $buf.="selected";
				}
			}
	        $buf.=">".$head;
	        return $buf;			
}


#/////////////////////////////   select 펼침목록메뉴 구성	////////////////////////////#
function f_SelectBox($arr,$subject,$coin_unit)
{
	global $af_TABLE5;										 //1 = 자동견적, 0 = 대외비
	global $af_sectionArr;									 //옵션 또는 규격 항목의 사용자설정 텍스트
	global $input_data;										 //090105 추가(접수인지 폼전송완료 화면인지 구분기준)
															 //자동견적일 때 옵션가격 함께표시할 때의 앞첨자
	if($af_TABLE5["secret_price"] == 1)	$attach_talil = "&nbsp;&nbsp;+ $coin_unit"; 


	if ($arr[name]) $arr[name]="name=$arr[name]";
    if ($arr[id]) $arr[id]="class=$arr[id]";			     //id=$arr[id]이나 id가 같을 경우 html엄격버전에서 에러 발생하므로 class로 대체
    if ($arr[style]) $arr[style]="style='$arr[style]'";	
    if ($arr[disable]) $arr[disable]="disable";

	if($input_data and $_GET["mode2"] == "normal")			 //090105 접수화면과 접수완료화면을 구분하여 value 셀을 따로 디자인
	{
		$buf.= $arr['default_opt']."\n";
	}
	else
	{    
		$buf="<select 
			$arr[name]
			$arr[id]
			$arr[style]
			$arr[script]
			$arr[disable]
			>
			<option value=''>".af_txt_selectBox_opt1."</option>
				
		\n";
		if ($arr["end"]>$arr[start]) {							 //숫자 범위 지정시
			for ($i=$arr[start];$i <= $arr["end"];$i++) {
				$buf.=opt($i,$arr["default"],$arr[head]).$i.$arr[tail]."\n";
			}
		} elseif (count($arr[text]) > 0) {						 //text 배열의요소가 1개이상일 경우
			for ($i=0;$i < count($arr[text]);$i++) {
				$buf.=f_opt($arr[optVal][$i],&$arr[text][$i],$arr["default_opt"],$arr[head]).$arr[text][$i].$attach_talil.$arr[tail][$i]."\n";
			}
		}
		$buf.="</select>\n";
	}

    
    
    return $buf;
}


###################################  checkbox 구성	#####################################
function f_CheckBox($arr,$subject,$coin_unit,$i) 
{
	global $af_TABLE5;										 //폼형식	
	global $input_data;										 //090105 추가(접수인지 폼전송완료 화면인지 구분기준)

	if ($arr[name]) $arr[name]="name=$arr[name]";

	if($af_TABLE5["form_type"] == "0") $arr[id]="class='chkCalculator$i'";//견적서일 때 class
	if($af_TABLE5["form_type"] == "1")									  //폼메일일 때 class
		{
			if ($arr[id]) $arr[id]="class=$arr[id]";		 //id=$arr[id]이나 id가 같을 경우 html엄격버전에서 에러 발생하므로 class로 대체
		}
	
	
  		 
    if ($arr[style]) $arr[style]="style='$arr[style]'";		 //스타일
    if ($arr[disable]) $arr[disable]="disable";				 
	//if ($arr[optVal]) $arr[optVal]="value=$arr[optVal]";	 //value 가격
	//if ($arr[text]) $arr[text]="$arr[text]";			     //옵션 이름

	
															
	if($af_TABLE5["form_type"] == "0"){						 //옵션 선택시 실행 스크립트 정의
		$script = "onclick='estimate_calculator(this.form,this,$i,\"checkbox\")'"; 
		}
	if($af_TABLE5["form_type"] == "1"){
		$script = "onclick='formmail_calculator(this.form,this,$i,\"checkbox\");formmail_mixdata(this.form,this,$i,\"checkbox\")'";
		} 
			
	      
    $buf="";
	$arri = $i;

	if (count($arr[text]) > 0) {							 //text 배열의요소가 1개이상일 경우
        for ($i=0;$i < count($arr[text]);$i++) 
		{			
			if($af_TABLE5["form_type"] == "1")				 //폼메일일 경우에만 초기값 선택되게
			{												 //090105 아래 for 문 추가
			$array_default_opt = explode("ⓘ",$arr['default_opt']);			
			for($x=0;$x < count($array_default_opt);$x++)
				{
				if($arr['default_opt']&&$array_default_opt[$x]==$arr[text][$i])
					{
						$checked = "checked";
						$x = count($array_default_opt);		 //일치한다면, 끝까지 돌지말고 for 문 종료			
					}
				else 
					{
						$checked = "";
					}
				}
			}
			if($input_data and $_GET["mode2"] == "normal")	 //090105 접수화면과 접수완료화면을 구분하여 value 셀을 따로 디자인
			{
				$buf.= str_replace("ⓘ"," , ",$arr['default_opt'])."\n";
				$i = count($arr[text]);
			}
			else
			{
				$buf.="<input type='checkbox' ".$arr[name]." ".$arr[id]." ".$script." value='".$arr[text][$i]."|".$arr[optVal][$i]."' style='border:0;' ".$checked." >".$arr[text][$i]."\n";
			}            
        }
    }

    
    $buf.="\n";
    return $buf;

}



###################################  radio 단추 구성	#####################################
function f_Radio($arr,$subject,$coin_unit,$i) 
{
	global $af_TABLE5;										 //폼형식
	global $input_data;										 //090105 추가(접수인지 폼전송완료 화면인지 구분기준)

	if ($arr[name]) $arr[name]="name=$arr[name]";

	if($af_TABLE5["form_type"] == "0") $arr[id]="class='radioCalculator$i'";//견적서일 때 class
	if($af_TABLE5["form_type"] == "1")										//폼메일일 때 class
		{
			if ($arr[id]) $arr[id]="class=$arr[id]";		 //id=$arr[id]이나 id가 같을 경우 html엄격버전에서 에러 발생하므로 class로 대체
		}
	

    if ($arr[style]) $arr[style]="style='$arr[style]'";		 //스타일
    if ($arr[disable]) $arr[disable]="disable";				 
	//if ($arr[optVal]) $arr[optVal]="value=$arr[optVal]";	 //value 가격
	//if ($arr[text]) $arr[text]="$arr[text]";			     //옵션 이름


	if($af_TABLE5["form_type"] == "0"){						 //옵션 선택시 실행 스크립트 정의
		$script = "onclick='estimate_calculator(this.form,this,$i,\"radio\")'"; 
		}
	if($af_TABLE5["form_type"] == "1"){
		$script = "onclick='formmail_calculator(this.form,this,$i,\"radio\");formmail_mixdata(this.form,this,$i,\"radio\")'";
		} 
	
	      
    $buf="";

	if (count($arr[text]) > 0) {							 //text 배열의요소가 1개이상일 경우
        for ($i=0;$i < count($arr[text]);$i++) 
		{
			if($af_TABLE5["form_type"] == "1")				 //폼메일일 경우에만 초기값 선택되게
			{ 
			if($arr['default_opt']&&$arr['default_opt']==$arr[text][$i])
				{
					$checked = "checked";
				}
			else $checked = "";
			}
			if($input_data and $_GET["mode2"] == "normal")	 //090105 접수화면과 접수완료화면을 구분하여 value 셀을 따로 디자인
			{
				 $buf.= $arr['default_opt']."\n";
				 $i = count($arr[text]);
			}
			else
			{
				 $buf.="<input type='radio' ".$arr[name]." ".$arr[id]." ".$script." value='".$arr[text][$i]."|".$arr[optVal][$i]."' style='border:0;' ".$checked.">".$arr[text][$i]."\n";
			}           
        }
    }

    
    $buf.="\n";
    return $buf;

}



###################################  한줄 글상자 구성	#####################################
function f_Text($arr,$subject,$coin_unit,$n,$field_width) 
{
	global $input_data;										 //090105 추가(접수인지 폼전송완료 화면인지 구분기준)

	if ($arr[name]) $arr[name]="name='$arr[name]'";
    if ($arr[id]) $arr[id]="class='$arr[id]'";			     //id=$arr[id]이나 id가 같을 경우 html엄격버전에서 에러 발생하므로 class로 대체
    if ($arr[style]) $arr[style]="style='$arr[style]'";		 //스타일
    if ($arr[disable]) $arr[disable]="disable";				 
	//if ($arr[optVal]) $arr[optVal]="value=$arr[optVal]";	 //value 가격
	//if ($arr[text]) $arr[text]="$arr[text]";			     //옵션 이름
	      
    $buf="<table width='100%'>";
	$and="@";

	if (count($arr[text]) > 0)								 //text 배열의요소가 1개이상일 경우
	{														
	for ($i=0;$i < count($arr[text]);$i++) 
		{
		$value = "";										 //090105 추가하고 아래 if문과 for 문 추가	
		if($input_data)										
			{
			$array_default_opt = explode("ⓘ",$arr['default_opt']);
			for($x=0;$x < count($array_default_opt);$x++)
				{
				$array_opt_val =  explode(" - ",$array_default_opt[$x]);
				if($array_opt_val[0]==$arr[text][$i])
					{
						$value = $array_opt_val[1];
						$x = count($array_default_opt);		 //일치한다면, 끝까지 돌지말고 for 문 종료			
					}
				else 
					{
						$value = "";
					}
				}
			}
		if($input_data and $_GET["mode2"] == "normal")		 //090105 접수화면과 접수완료화면을 구분하여 value 셀을 따로 디자인
			{
			$buf.="<tr><td style='width:80px;border-top:0;border-left:0;'>".$arr[text][$i]."</td><td style='text-align:left;border-top:0;border-right:0;'>
			".$value."		
			</td></tr> \n";
			}
		else
			{
			$buf.="<tr><td style='width:100px;border-top:0;border-left:0;'  nowrap>".$arr[text][$i]."</td><td style='text-align:left;border-top:0;border-right:0;'>
			<input type='hidden' name='textHidden".$n."zz".$i."' id='textHidden".$n."zz".$i."' value='".$arr[text][$i]."'>
			<input type='text' ".$arr[name]." id='textType".$n."zz".$i."' ".$arr[id]." onblur=\"formmail_mixdata(this.form,this,'".$n."zz".$i."','text');quot_Del(this);\" value='".$value."' ".$field_width.">			
			</td></tr> \n";
			}	
		}
    }

    
    $buf.="</table>\n";
    return $buf;

}



###################################  스크롤 글상자 구성	#####################################
function f_TextArea($arr,$subject,$coin_unit,$n,$textarea_rows) 
{
	global $input_data;										 //090105 추가(접수인지 폼전송완료 화면인지 구분기준)

	if ($arr[name]) $arr[name]="name='$arr[name]'";
    if ($arr[id]) $arr[id]="class='$arr[id]'";			     //id=$arr[id]이나 id가 같을 경우 html엄격버전에서 에러 발생하므로 class로 대체
    if ($arr[style]) $arr[style]="style='$arr[style]'";		 //스타일
    if ($arr[disable]) $arr[disable]="disable";				 
	//if ($arr[optVal]) $arr[optVal]="value=$arr[optVal]";	 //value 가격
	//if ($arr[text]) $arr[text]="$arr[text]";			     //옵션 이름
	      
    $buf="<table width='100%'>";
	$and="@";

	if (count($arr[text]) > 0)								 //text 배열의요소가 1개이상일 경우
	{							 
        for ($i=0;$i < count($arr[text]);$i++) 
		{
		$value = "";										 //090105 추가하고 아래 if문과 for 문 추가	
		if($input_data)										
			{
			$array_default_opt = explode("ⓘ",$arr['default_opt']);
			for($x=0;$x < count($array_default_opt);$x++)
				{
				$array_opt_val =  explode(" - ",$array_default_opt[$x]);
				if($array_opt_val[0]==$arr[text][$i])
					{
						$value = $array_opt_val[1];
						$x = count($array_default_opt);		 //일치한다면, 끝까지 돌지말고 for 문 종료			
					}
				else 
					{
						$value = "";
					}
				}
			}
		if($input_data and $_GET["mode2"] == "normal")		 //090105 접수화면과 접수완료화면을 구분하여 value 셀을 따로 디자인
			{
			$buf.="<tr><td style='width:80px;border-top:0;border-left:0;'>".$arr[text][$i]."</td><td style='text-align:left;border-top:0;border-left:0;'>			
			".$value."	
			</td></tr> \n";			
			}
		else
			{
			$buf.="<tr><td style='width:100px;border-top:0;border-left:0;' nowrap>".$arr[text][$i]."</td><td style='text-align:left;border-top:0;border-left:0;'>
			<input type='hidden' name='textAreaHidden".$n."zz".$i."' id='textAreaHidden".$n."zz".$i."' value='".$arr[text][$i]."'>
			<TEXTAREA ".$arr[name]." id='textAreaType".$n."zz".$i."' ".$arr[id]." style='width:100%;' onblur=\"formmail_mixdata(this.form,this,'".$n."zz".$i."','textArea');quot_Del(this);\" rows='".$textarea_rows."'>".$value."</TEXTAREA>			
			</td></tr> \n";
			}		
        }
    }

    
    $buf.="</table>\n";
    return $buf;

}


#######   selectBox Part2: DB에서 옵션필드의 정보 가져와서 연관배열 만들기 start  #######


function f_mkOptArr($no,$i,$coin_unit,$opt_type,$style){	//$no= 품목의 고유번호,$i=배열번호,$coin_unit는 통화단위,$opt_type=옵션입력형식,스타일
global $DBconn;
global $af_TABLE5;
global $input_data;											//090105추가(고객입력배열)
															
	if($af_TABLE5["form_type"] == "0"){						//옵션 선택시 실행 스크립트 정의
		$script="onchange='this.form[\"hiddenOpt[$i]\"].value=this.options[this.selectedIndex].value;this.form[\"chk_list[$i]\"].checked=true;subtotal(this.form,$i);'"; 
		}
		if($af_TABLE5["form_type"] == "1"){
		$script="onchange='this.form[\"hiddenOpt[$i]\"].value=this.options[this.selectedIndex].value;formmail_sum();this.form[\"input_data$i\"].value=this.options[this.selectedIndex].text;'"; 
		} 

$where = "where no=$no" ;
$res=$DBconn->f_selectDB("*",TABLE,$where);					//필드, 테이블, 조건절

$res_count=mysql_num_rows($res[result]);                    //리턴된 행의 개수
	
        $row=mysql_fetch_array($res[result]);               //배열의 요소들을 $row에 대입
		$default_text=htmlspecialchars(stripslashes($row[default_text]));//초기값
		$default_opt=htmlspecialchars(stripslashes($row[default_opt]));	 //옵션초기값
		$opt=htmlspecialchars(stripslashes($row[opt]));
		$dummy1=htmlspecialchars(stripslashes($row[dummy1]));
		if(!$dummy1 or $dummy1 == null)						//dummy1이 null 이거나 값이 없을 때
		{
		$field_width="";							
		$textarea_rows="5";
		}
															//값이 100일 때
	else if($dummy1 == "100") 
		{
		$field_width="style='width:100%;'";
		$textarea_rows="100";
		}
	else 
		{
		$field_width = "size='$dummy1'";					//100 외의 값이 있을 때	
		$textarea_rows="$dummy1";
		}

		
		$opt = explode("|",$opt);						    //db opt 필드의 구분자로 부터 배열화
			$subject			= $opt[0];					//첫번째 배열요소를 옵션 제목으로...
			$subject_optExist   = $opt[1];					//항목제목의 존재여부를 판단하기 위한 변수
			$subject_opt		= $opt[1];					//두번째 배열요소를 항목제목으로...
			$price				= $opt[2];				    //세번째 배열요소를 항목가격으로...
			$ess				= $opt[3];					//네번째 배열요소를 선택필수여부로...

			$subject_opt = explode("ⓘ",$subject_opt);		//제목들에서 쉼표로 다시 구분하여 배열화
			$price = explode(",",$price);				    //가격들에서 쉼표로 다시 구분하여 배열화
			if($ess == "1") $class = "essSelect";			//옵션선택이 필수일 경우 select 태그에 클래스를 부여
			else $class = "";

		

		/* 테이블 행이 복수일 경우엔 아래와 같이 for문으로 연관배열처리(그룹실렉트의 경우예)
		$no=array();                                                 //배열변수 정의(그룹고유번호)
		$na=array();                                                 //배열변수 정의(그룹이름)
		for ($i=0;$i < $res_count;$i++) {							 //불러온 레코드의 수만큼 루프        
			$row=mysql_fetch_array($res[result]);                    //배열의 요소들을 $row에 대입	
			$na[$i]=htmlspecialchars(stripslashes($row[name]));                    //연관배열 만듬  
			$no[$i]=htmlspecialchars(stripslashes($row[no]));                      //연관배열 만듬    
		}	
		*/


 	
	//$arr=array("name"=>"optBox","id"=>"selectGroup","text"=>&$a);//연관배열 정의 방법1
	$arr=array();                                           //연관배열 정의 방법2
		$arr[head]="";
		if($af_TABLE5["secret_price"] == 0)	$arr[tail]="";
		if($af_TABLE5["secret_price"] == 1)	$arr[tail]=$price;
		$arr[start]="";
		$arr['end']="";
		$arr['default']=$default_text;                       //디폴트로 선택될 text
		if(!$input_data)									 //접수화면일 때 디폴트로 선택될 옵션
			{
				$arr['default_opt']=$default_opt;
			}  
		if($input_data)										 //접수후 화면일때 디폴트로 선택될 옵션
			{
				$arr['default_opt']=str_replace("◐","<",$input_data[$i]);
				$arr['default_opt']=str_replace("◑",">",$arr['default_opt']);
			}
		$arr[name]="chk_lis[".$i."]";						 //체크상자와 필수선택옵션 연동하기위해 체크상자와 연관성있는이름으로...
		$arr[id]=$class;                                     //선택상자 객체 구분 아이디
		$arr[style]=$style;									 //선택상자 스타일
															 //실행할 스크립트
															 //이벤트발생시 히든폼에 값인풋 + 체크항목 체크되게 + 소계계산
		
	
		$arr[script]=$script;								 //옵션 선택시 실행 스크립트					
		$arr[optVal]=$price;								 //옵션 value 배열
		$arr[text]=$subject_opt;                             //실렉트 text 항목 배열
															
															 
if($af_TABLE5["form_type"] == "0") {						 //폼형식이 주문/견적일 경우엔 옵션출력을 3가지로...
	if($opt_type == "" or $opt_type > 2) echo f_SelectBox ($arr,$subject,$coin_unit,$i);
	if($opt_type == "0") echo f_SelectBox ($arr,$subject,$coin_unit,$i);
	if($opt_type == "1") echo f_CheckBox ($arr,$subject,$coin_unit,$i);
	if($opt_type == "2") echo f_Radio ($arr,$subject,$coin_unit,$i);	
}	
else {														 //폼형식이 폼메일일 경우엔 옵션출력을 5가지로...
	if($opt_type == "") echo f_SelectBox ($arr,$subject,$coin_unit,$i);
	if($opt_type == "0") echo f_SelectBox ($arr,$subject,$coin_unit,$i);
	if($opt_type == "1") echo f_CheckBox ($arr,$subject,$coin_unit,$i);
	if($opt_type == "2") echo f_Radio ($arr,$subject,$coin_unit,$i);
	if($opt_type == "3") echo f_Text ($arr,$subject,$coin_unit,$i,$field_width);
	if($opt_type == "4") echo f_TextArea ($arr,$subject,$coin_unit,$i,$textarea_rows);
}


}
#########################################################################################
#######################     옵션 각 타입별 출력 함수 end      ###########################
#########################################################################################

#---------------------------------------------------------------------------------------#

#########################################################################################
#############			품목 테이블에서 데이타 가져오는 함수 start			#############
#########################################################################################

function af_get_dbTable_recode()							//이 함수는 자바스크립트문에서 출력할것임
{								
    global $DBconn;										    //$DBconn 글로벌변수 참조
	global $af_TABLE5;	
	global $af_sectionArr;									//옵션 또는 규격의 구분이름
	global $af_client_itemsArr;								//고객항목
	global $af_kr_areaCode;									//한국 지역번호
	global $af_kr_hpNum;									//한국 휴대폰국번
	global $input_data;										//090105 추가(고객입력 배열=$re[cnt])
	global $af_TABLE4;										//090105 추가(고객기본정보 가져오기위해)
	global $clean;											//090105 추가(고객기본정보 가져오기위해)
	$dummy5N = 0;											//전항목을 걸쳐서 dummy5가 있는지검사용

    $re=$DBconn->f_selectDB("*",TABLE,"order by code");		//C_CONNECT 클래스 멤버함수인 f_selectDB($field="*",$table,$where="")를 실행하여
															//$re[result]에 저장하고 불러온 레코드 수를 $re[cnt]에 저장

	if($re[cnt] < 1) die("<p>".af_txt_skin_function_skin_5."</p>");
    
    for ($i=0;$i<$re[cnt];$i++) 
	{							
        $row=mysql_fetch_array($re[result]);				

			$no = htmlspecialchars(stripslashes($row["no"]));             
			$code = htmlspecialchars(stripslashes($row["code"]));         
			$name_it = htmlspecialchars(stripslashes($row["name_it"]));  
			$price = htmlspecialchars(stripslashes($row["price"]));
			$opt = htmlspecialchars(stripslashes($row["opt"]));                 
			$unit = htmlspecialchars(stripslashes($row["unit"]));							
			$chk_input = htmlspecialchars(stripslashes($row["chk_input"]));
			$chk_filter = htmlspecialchars(stripslashes($row["chk_filter"]));
			$chk_etc = htmlspecialchars(stripslashes($row["chk_etc"]));

			if(!$input_data)//090105 if 문으로 구분
				{//접수화면일 때
				$default_text = $row["default_text"];
				}
			if($input_data) 
				{//접수후 화면일 때
				$default_text =  str_replace("◐","<",$input_data[$i]);	  
				$default_text =  str_replace("◑",">",$default_text);
				}
						
			$default_opt = htmlspecialchars(stripslashes($row["default_opt"]));
			$discount = htmlspecialchars(stripslashes($row["discount"]));		 //현재 사용하지 않음
			
			$dummy1 = htmlspecialchars(stripslashes($row["dummy1"]));		
			if(!$dummy1 or $dummy1 == null)
				{
				$field_width="";							//dummy1이 null 이거나 값이 없을 때
				$textarea_rows="5";
				}
															//값이 100일 때
			else if($dummy1 == "100") 
				{
				$field_width="style='width:100%;'";
				$textarea_rows="100";
				}
			else 
				{
				$field_width = "size='$dummy1'";			//100 외의 값이 있을 때	
				$textarea_rows="$dummy1";
				}



			$dummy2 = htmlspecialchars(stripslashes($row["dummy2"]));		//항목입력형식
			$dummy3 = htmlspecialchars(stripslashes($row["dummy3"]));		//사용자입력형 여부(yes,null(""))
			$dummy4 = htmlspecialchars(stripslashes($row["dummy4"]));		//가로짝짓기여부(yes,null(""))
			$dummy5 = htmlspecialchars(stripslashes($row["dummy5"]));		//고객정보입력모듈위치(1,null(""))
			$dummy6 = htmlspecialchars(stripslashes($row["dummy6"]));		//부가세율
			$dummy7 = stripslashes($row["dummy7"]);							//픔목 간단설명(줄바꿈은 태그로만 가능하게)
			$dummy8 = htmlspecialchars(stripslashes($row["dummy8"]));		//주문폼 썸네일 이미지 경로(ver 5.1~)
			$dummy9 = stripslashes($row["dummy9"]);							//내용이 있다면, 항목 단 끊고 출력(ver 6.0~)
			$dummy10 = htmlspecialchars(stripslashes($row["dummy10"]));

			$opt_arr = explode("|",$opt);					//db opt 필드의 구분자로 부터 배열화							
			if($opt == "") $opt_type = "0";					//옵션이 없을 때, 펼침목록
			else $opt_type = $opt_arr[4];					//다섯번째 배열요소를 옵션 입력형식으로...			
			
											
			$class_ess = "";
			if($chk_input == "1" or $opt_arr[3] == "1")		//품목이나 옵션을 필수로 체크하였을 때
				{
				$class_ess="class='ess'";					//필수입력필드일 경우 ess 클래스
				$essMark="<span style='color:red'>*</span>";
				}
			else $essMark="&nbsp;";

			$onblur = "onblur='quot_Del(this);";			//기본 필터링
															//영어와 숫자만 입력일 경우(한글입력금지)	
			if($chk_filter == "1") $onblur.="only_en(this,this.value);";
															//숫자만 입력일 경우
			if($chk_filter == "2") $onblur.="Numbering2(this);";
		
			$onblur.="'";


			$opts = explode("|",$opt);						//db opt 필드의 구분자로 부터 배열화			
			$ess = $opts[3];								//네번째 배열요소를 선택필수여부로...			
			if($ess == "1") $class = "class='essSelect'";	//옵션선택이 필수일 경우 체크박스 태그에 클래스를 부여
			else $class = "";
			
			
			#---------------------------------------------------------------------------#
			#	폼메일에서 사용되는 기본고객정보입력모듈 인클루드(_once 하지말것)		#			
			#---------------------------------------------------------------------------#	
			include("client_formmail.php");
		
												
			if($dummy5 == "1")
				{
				$dummy5N++;									//전항목을 걸쳐서 dummy5가 있는지검사용
				$md_client = $md_client;					
				$md_client_ess = "";			
				}
			else 
				{
				if($i == $re[cnt]-1 and $dummy5N == 0)
					{
					$md_client_ess = $md_client;			//마지막항목까지 고객기본정보가 없다면 강제로 표시					
					}
				$md_client = "";
				}			
			
			
			if($af_TABLE5["secret_price"] == "1")			//자동견적 사용여부에 따른 오른쪽 스타일정의
					{										
					$right_tdStyle = "border-right:1px solid #cccccc;";
					}
			else    {
					$right_tdStyle = "border-right-width:2px;";
					}

			if($i == $re[cnt]-1)
					{										//마지막 일 경우, 아래라인 두껍게	
					$end_tdStyle = "border-bottom-width:2px;";							
					}
			else    $end_tdStyle = "border-bottom:1px solid #cccccc;";		


			#---------------------------------------------------------------------------#
			#	1행에 2항목을 짝짓기 위한 설정											#
			#	짝을 지어놓고 항목을 삭제시,짝짓기 사이에 행간구분이나, 기본고객정보를  #
			#   설정시 표가 깨질수있으므로, 이부분 사용자교육이필요!					#
			#   표가 깨진다면 짝지을 항목을 다시 재설정하면 됨							#
			#---------------------------------------------------------------------------#
			if($dummy9)										//항목 단 끊기에 내용이 있을 때
				{
					$af_divi = "<tr><td class='af_divi' colspan='4'>".$dummy9."</td></tr>";
				}
			else
				{
					$af_divi = "";					
				}
			
			if($i%2 == 0)									//홀수행일 때 처리								
				{
					$trStart = $md_client.$af_divi."<tr>";
					$trEnd = "";					
				}
			else											//짝수행일 때 처리
				{
				if($dummy4 == "yes")						//가로짝짓기 여부가 yes 일 때
					{
						$trStart = $md_client.$af_divi."";						//짝짓기일 때는, 행간구분 $af_divi 내용있어도 생략,기본고객정보도 생략											
					}
				else										//가로짝짓기 여부가 없을 때
					{
						$trStart = "</tr>".$md_client.$af_divi."<tr>";						
					}
						$trEnd = "</tr>";
				}			


			if($dummy4 == "yes")
				{
					$colspan = "";
				}
			else 
				{
					$colspan = "colspan='3'";
				}
			
			
#---------------------------------------------------------------------------------------#	
# 폼형식이 주문폼일 때 고객접수폼 디자인 파일 인클루드(반복이므로 include_once 하지말것)#
#---------------------------------------------------------------------------------------#
			if($af_TABLE5["form_type"] == "0") include("item_loop_orderform.php");
#---------------------------------------------------------------------------------------#			
# 폼형식이 폼메일일 때 고객접수폼 디자인 파일 인클루드(반복이므로 include_once 하지말것)#
#---------------------------------------------------------------------------------------#	
			if($af_TABLE5["form_type"] == "1") include("item_loop_formmail.php");		
		
    }						//for 문 끝
echo $md_client_memo;		//고객메모입력란 표시
}							//af_get_dbTable_recode() 함수 끝

#########################################################################################
##########				품목 테이블에서 데이타 가져오는 함수 end				#########
#########################################################################################
?>
