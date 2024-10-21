<?php	
#---------------------------------------------------------------------------------------#			
#	폼형식이 폼메일일 때, 접수항목을 루핑하는 파일입니다.								#
#---------------------------------------------------------------------------------------#
if($input_data)											//090105 if~else 문으로 $default_opt 히든입력값 구분
{
	$default_opt = $default_text;
}
else
{
	if($opt_type == "3" or $opt_type == "4")			//옵션타입이 한줄글상자나 스크롤일 때는 옵션초기선택값 적용안되게
	{
		$default_opt = "";
		$style = "style='padding:0;padding-right:0;margin-left:0;margin-right:0;'";
	}
	else 
	{
		$default_opt = $default_opt;
		$style = "";
	}
}

echo("
	$md_clientTop
	$trStart
		<td class='item' nowrap>
		$essMark $name_it					
		</td>
		<td class='val' $colspan $style>			
		");
		//간단설명 있을 경우 출력						
		if($dummy7) $dummy7 = "<span class='item_tip'>$dummy7</span>";
		else $dummy7 = "";
//옵션이 있을 경우 선택상자 출력						
		if($opt) //090105 옵션일 경우엔, 위 f_mkOptArr 각 타입에서 접수화면과 접수완료화면의 value 셀을 디자인하고...
			{    				
				echo f_mkOptArr($no,$i,$af_TABLE5["coin_unit"],$opt_type,'')."<input type='hidden' name='hiddenOpt[$i]' readonly class='formmail_subtotal'><input type='hidden' name='input_data$i' id='input_data$i' value='$default_opt'><input type='hidden' name='name_it$i' id='name_it$i' value='$name_it'>";								
			}
//옵션이 없을 경우, 항목입력을 dummy2필드 참조하여 출력(한줄글상자,스크롤글상자,날짜선택)
		else     //옵션이 아닐 경우엔, 접수화면과 접수완료화면의 value 셀을 아래, 각 입력형식별로 if 문 처리
			{
			if($dummy2 == 4)		//항목입력형식을 스크롤글상자로 하였을 경우
				{
				if($input_data and $_GET["mode2"] == "normal")//090105
					{
					echo $default_text;
					}
				else
					{
					echo "<textarea name='input_data$i' id='input_data$i' $onblur $class_ess style='width:100%' rows='".$textarea_rows."'>$default_text</textarea><input type='hidden' name='name_it$i' id='name_it$i' value='$name_it'>";
					}
				}

			else if($dummy2 == 5)	//항목입력형식을 날짜선택1형으로 하였을 경우
				{
				if($input_data and $_GET["mode2"] == "normal")//090105
					{
					echo $default_text;
					}
				else
					{
					echo "<input type='text' name='dummy_data$i".dummy1."' id='dummy_data$i".dummy1."' $onblur $class_ess readonly value='$default_text' $field_width style='text-align:center;color:#669999;'>&nbsp;
					  <img src='plugin/calendar/icon_calendar.gif' style='cursor:hand;vertical-align:top;margin-top:3px;' alt='날짜선택' onclick=\"calendar_pop('input_data$i','dummy_data$i".dummy1."');\">				  
					  <input type='hidden' name='input_data$i' id='input_data$i' value='$default_text'>
					  <input type='hidden' name='name_it$i' id='name_it$i' value='$name_it'>
					  ";
					}								
				}

			else if($dummy2 == 6)	//항목입력형식을 날짜선택2형으로 하였을 경우
				{								
				if($input_data)		//090105 if else 추가 후, value=$default_text0 과 $default_text1 로 구분
					{
						$arr_default_text = explode("~",$default_text);
						$default_text0 = $arr_default_text[0];
						$default_text1 = $arr_default_text[1];
					}
				else{
						$default_text0 = $default_text;
						$default_text1 = $default_text;
					}
				if($input_data and $_GET["mode2"] == "normal")//090105
					{
					echo $default_text;
					}
				else
					{									
					echo "<input type='text' name='dummy_data$i".dummy1."' id='dummy_data$i".dummy1."' $onblur $class_ess readonly value='$default_text0' $field_width style='text-align:center;color:#669999;'>&nbsp;
						  <img src='plugin/calendar/icon_calendar.gif' style='cursor:hand;vertical-align:top;margin-top:3px;' alt='날짜선택' onclick=\"calendar_pop('input_data$i','dummy_data$i".dummy1."');\">&nbsp;&nbsp;~&nbsp;&nbsp;									
						  <input type='text' name='dummy_data$i".dummy2."' id='dummy_data$i".dummy2."' $onblur $class_ess readonly value='$default_text1' $field_width style='text-align:center;color:#669999;'>&nbsp;
						  <img src='plugin/calendar/icon_calendar.gif' style='cursor:hand;vertical-align:top;margin-top:3px;' alt='날짜선택' 
						  onclick=\"calendar_pop('input_data$i','dummy_data$i".dummy2."');\" $field_width>
						  <input type='hidden' name='input_data$i' id='input_data$i' value='$default_text'>
						  <input type='hidden' name='name_it$i' id='name_it$i' value='$name_it'>
						  ";
					}
				}

			else if($dummy2 == 7)	//항목입력형식을 한줄글상자2개로 하였을 경우
				{
				if($input_data)		//090105 if else 추가 후, value=$default_text0 과 $default_text1 로 구분
					{
						$arr_default_text = explode("-",$default_text);
						$default_text0 = $arr_default_text[0];
						$default_text1 = $arr_default_text[1];
					}
				else{
						$default_text0 = $default_text;
						$default_text1 = "";
					}
				if($input_data and $_GET["mode2"] == "normal")//090105
					{
					echo $default_text;
					}
				else
					{	
					echo "<input type='text' name='dummy_data$i".dummy1."' id='dummy_data$i".dummy1."' $onblur $class_ess value='$default_text0' onkeyup=\"dummys_input('input_data$i','dummy_data$i".dummy1."');\"
							onmouseout=\"dummys_input('input_data$i','dummy_data$i".dummy1."');\" $field_width> - 
						  <input type='text' name='dummy_data$i".dummy2."' id='dummy_data$i".dummy2."' $onblur $class_ess value='$default_text1' onkeyup=\"dummys_input('input_data$i','dummy_data$i".dummy2."');\"
							onmouseout=\"dummys_input('input_data$i','dummy_data$i".dummy2."');\" $field_width>

						  <input type='hidden' name='input_data$i' id='input_data$i' value='$default_text'>
						  <input type='hidden' name='name_it$i' id='name_it$i' value='$name_it'>
						  ";
					}
				}
		
			else if($dummy2 == 8)   //항목입력형식을 한줄글상자3개로 하였을 경우
				{
				if($input_data)		//090105 if else 추가 후, value=$default_text0 ~ $default_text2 로 구분
					{
						$arr_default_text = explode("-",$default_text);
						$default_text0 = $arr_default_text[0];
						$default_text1 = $arr_default_text[1];
						$default_text2 = $arr_default_text[2];
					}
				else{
						$default_text0 = $default_text;
						$default_text1 = "";
						$default_text2 = "";
					}
				if($input_data and $_GET["mode2"] == "normal")//090105
					{
					echo $default_text;
					}
				else
					{	
					echo "<input type='text' name='dummy_data$i".dummy1."' id='dummy_data$i".dummy1."' $onblur $class_ess value='$default_text0' onkeyup=\"dummys_input('input_data$i','dummy_data$i".dummy1."');\"
							onmouseout=\"dummys_input('input_data$i','dummy_data$i".dummy1."');\" $field_width> - 
						  <input type='text' name='dummy_data$i".dummy2."' id='dummy_data$i".dummy2."' $onblur $class_ess value='$default_text1' onkeyup=\"dummys_input('input_data$i','dummy_data$i".dummy2."');\"
							onmouseout=\"dummys_input('input_data$i','dummy_data$i".dummy2."');\" $field_width> - 
						  <input type='text' name='dummy_data$i".dummy3."' id='dummy_data$i".dummy3."' $onblur $class_ess value='$default_text2' onkeyup=\"dummys_input('input_data$i','dummy_data$i".dummy3."');\"
							onmouseout=\"dummys_input('input_data$i','dummy_data$i".dummy3."');\" $field_width> 

						  <input type='hidden' name='input_data$i' id='input_data$i' value='$default_text'>
						  <input type='hidden' name='name_it$i' id='name_it$i' value='$name_it'>
						  ";
					}
				}

			else if($dummy2 == 9)	//항목입력형식을 한줄글상자4개로 하였을 경우
				{
				if($input_data)		//090105 if else 추가 후, value=$default_text0 ~ $default_text3 로 구분
					{
						$arr_default_text = explode("-",$default_text);
						$default_text0 = $arr_default_text[0];
						$default_text1 = $arr_default_text[1];
						$default_text2 = $arr_default_text[2];
						$default_text3 = $arr_default_text[3];
					}
				else{
						$default_text0 = $default_text;
						$default_text1 = "";
						$default_text2 = "";
						$default_text3 = "";
					}
				if($input_data and $_GET["mode2"] == "normal")//090105
					{
					echo $default_text;
					}
				else
					{
					echo "<input type='text' name='dummy_data$i".dummy1."' id='dummy_data$i".dummy1."' $onblur $class_ess value='$default_text0' onkeyup=\"dummys_input('input_data$i','dummy_data$i".dummy1."');\"
							onmouseout=\"dummys_input('input_data$i','dummy_data$i".dummy1."');\" $field_width> - 
						  <input type='text' name='dummy_data$i".dummy2."' id='dummy_data$i".dummy2."' $onblur $class_ess value='$default_text1' onkeyup=\"dummys_input('input_data$i','dummy_data$i".dummy2."');\"
							onmouseout=\"dummys_input('input_data$i','dummy_data$i".dummy2."');\" $field_width> - 
						  <input type='text' name='dummy_data$i".dummy3."' id='dummy_data$i".dummy3."' $onblur $class_ess value='$default_text2' onkeyup=\"dummys_input('input_data$i','dummy_data$i".dummy3."');\"
							onmouseout=\"dummys_input('input_data$i','dummy_data$i".dummy3."');\" $field_width> -
						  <input type='text' name='dummy_data$i".dummy4."' id='dummy_data$i".dummy4."' $onblur $class_ess value='$default_text3' onkeyup=\"dummys_input('input_data$i','dummy_data$i".dummy4."');\"
							onmouseout=\"dummys_input('input_data$i','dummy_data$i".dummy4."');\" $field_width>		

						  <input type='hidden' name='input_data$i' id='input_data$i' value='$default_text'>
						  <input type='hidden' name='name_it$i' id='name_it$i' value='$name_it'>
						  ";
					}
				}
			
			else if($dummy2 == 10)	//항목입력형식을 한줄글상자5개로 하였을 경우
				{
				if($input_data)		//090105 if else 추가 후, value=$default_text0 ~ $default_text4 로 구분
					{
						$arr_default_text = explode("-",$default_text);
						$default_text0 = $arr_default_text[0];
						$default_text1 = $arr_default_text[1];
						$default_text2 = $arr_default_text[2];
						$default_text3 = $arr_default_text[3];
						$default_text4 = $arr_default_text[4];
					}
				else{
						$default_text0 = $default_text;
						$default_text1 = "";
						$default_text2 = "";
						$default_text3 = "";
						$default_text4 = "";
					}
				if($input_data and $_GET["mode2"] == "normal")//090105
					{
					echo $default_text;
					}
				else
					{
					echo "<input type='text' name='dummy_data$i".dummy1."' id='dummy_data$i".dummy1."' $onblur $class_ess value='$default_text0' onkeyup=\"dummys_input('input_data$i','dummy_data$i".dummy1."');\"
							onmouseout=\"dummys_input('input_data$i','dummy_data$i".dummy1."');\" $field_width> - 
						  <input type='text' name='dummy_data$i".dummy2."' id='dummy_data$i".dummy2."' $onblur $class_ess value='$default_text1' onkeyup=\"dummys_input('input_data$i','dummy_data$i".dummy2."');\"
							onmouseout=\"dummys_input('input_data$i','dummy_data$i".dummy2."');\" $field_width> - 
						  <input type='text' name='dummy_data$i".dummy3."' id='dummy_data$i".dummy3."' $onblur $class_ess value='$default_text2' onkeyup=\"dummys_input('input_data$i','dummy_data$i".dummy3."');\"
							onmouseout=\"dummys_input('input_data$i','dummy_data$i".dummy3."');\" $field_width> -
						  <input type='text' name='dummy_data$i".dummy4."' id='dummy_data$i".dummy4."' $onblur $class_ess value='$default_text3' onkeyup=\"dummys_input('input_data$i','dummy_data$i".dummy4."');\"
							onmouseout=\"dummys_input('input_data$i','dummy_data$i".dummy4."');\" $field_width>	-
						  <input type='text' name='dummy_data$i".dummy5."' id='dummy_data$i".dummy5."' $onblur $class_ess value='$default_text4' onkeyup=\"dummys_input('input_data$i','dummy_data$i".dummy5."');\"
							onmouseout=\"dummys_input('input_data$i','dummy_data$i".dummy5."');\" $field_width>	

						  <input type='hidden' name='input_data$i' id='input_data$i' value='$default_text'>
						  <input type='hidden' name='name_it$i' id='name_it$i' value='$name_it'>
						  ";
					  }
				}
			else if($dummy2 == 11) //항목입력형식을 전화번호로 하였을 경우
				{
				if($input_data)	   //090105 if else 추가 후, value=$default_text0 ~ $default_text2 로 구분(원래는 value값 없었음)
					{
						$arr_default_text = explode("-",$default_text);
						$default_text0 = $arr_default_text[0];
						$default_text1 = $arr_default_text[1];
						$default_text2 = $arr_default_text[2];
						if($default_text0 == "02") $tel_selected1 = "selected";
						if($default_text0 == "031") $tel_selected2 = "selected";
						if($default_text0 == "032") $tel_selected3 = "selected";
						if($default_text0 == "033") $tel_selected4 = "selected";
						if($default_text0 == "041") $tel_selected5 = "selected";
						if($default_text0 == "042") $tel_selected6 = "selected";
						if($default_text0 == "043") $tel_selected7 = "selected";
						if($default_text0 == "051") $tel_selected8 = "selected";
						if($default_text0 == "052") $tel_selected9 = "selected";
						if($default_text0 == "053") $tel_selected10 = "selected";
						if($default_text0 == "054") $tel_selected11 = "selected";
						if($default_text0 == "055") $tel_selected12 = "selected";
						if($default_text0 == "061") $tel_selected13 = "selected";
						if($default_text0 == "062") $tel_selected14 = "selected";
						if($default_text0 == "063") $tel_selected15 = "selected";
						if($default_text0 == "064") $tel_selected16 = "selected";
						if($default_text0 == "060") $tel_selected17 = "selected";
						if($default_text0 == "070") $tel_selected18 = "selected";
						if($default_text0 == "080") $tel_selected19 = "selected";
						if($default_text0 == "0502") $tel_selected20 = "selected";
						if($default_text0 == "1544") $tel_selected21 = "selected";
						if($default_text0 == "1644") $tel_selected22 = "selected";
						if($default_text0 == "1588") $tel_selected23 = "selected";
						if($default_text0 == "1577") $tel_selected24 = "selected";																			
					}
				else{
						$default_text0 = "";
						$default_text1 = "";
						$default_text2 = "";										
					}
				if($input_data and $_GET["mode2"] == "normal")//090105
					{
					echo $default_text;
					}
				else
					{
					echo"<select name='sel_kr_tel$i' id='sel_kr_tel$i'								onchange='this.form[\"dummy_data$i".dummy1."\"].value=this.options[this.selectedIndex].value;dummys_input(\"input_data$i\",\"dummy_data$i".dummy1."\");'>
							<option value='' $tel_selected0>지역번호
							<option value='02' $tel_selected1>	 02 서울
							<option value='031' $tel_selected2>031 경기
							<option value='032' $tel_selected3>032 인천
							<option value='033' $tel_selected4>033 강원
							<option value='041' $tel_selected5>041 충남
							<option value='042' $tel_selected6>042 대전
							<option value='043' $tel_selected7>043 충북
							<option value='051' $tel_selected8>051 부산
							<option value='052' $tel_selected9>052 울산
							<option value='053' $tel_selected10>053 대구
							<option value='054' $tel_selected11>054 경북
							<option value='055' $tel_selected12>055 경남
							<option value='061' $tel_selected13>061 전남
							<option value='062' $tel_selected14>062 광주
							<option value='063' $tel_selected15>063 전북
							<option value='064' $tel_selected16>064 제주
							<option value='060' $tel_selected17>060
							<option value='070' $tel_selected18>070
							<option value='080' $tel_selected19>080
							<option value='0502' $tel_selected20>0502
							<option value='1544' $tel_selected21>1544
							<option value='1644' $tel_selected22>1644
							<option value='1588' $tel_selected23>1588
							<option value='1577' $tel_selected24>1577
						</select>
						<input type='hidden' name='dummy_data$i".dummy1."' id='dummy_data$i".dummy1."' $onblur $class_ess value='$default_text0' onkeyup=\"Numbering2(this);dummys_input('input_data$i','dummy_data$i".dummy1."');\"
							onmouseout=\"Numbering2(this);dummys_input('input_data$i','dummy_data$i".dummy1."');\" style='width:30px;'> - 
						<input type='text' name='dummy_data$i".dummy2."' id='dummy_data$i".dummy2."' $onblur $class_ess value='$default_text1' onkeyup=\"Numbering2(this);dummys_input('input_data$i','dummy_data$i".dummy2."');\"
							onmouseout=\"Numbering2(this);dummys_input('input_data$i','dummy_data$i".dummy2."');\" style='width:30px;'> - 
						<input type='text' name='dummy_data$i".dummy3."' id='dummy_data$i".dummy3."' $onblur $class_ess value='$default_text2' onkeyup=\"Numbering2(this);dummys_input('input_data$i','dummy_data$i".dummy3."');\"
							onmouseout=\"Numbering2(this);dummys_input('input_data$i','dummy_data$i".dummy3."');\" style='width:30px;'> 

						<input type='hidden' name='input_data$i' id='input_data$i' value='$default_text'>
						<input type='hidden' name='name_it$i' id='name_it$i' value='$name_it'>
						";
					}
				}

			else if($dummy2 == 12) //항목입력형식을 휴대폰으로 하였을 경우
				{
				if($input_data)	   //090105 if else 추가 후, value=$default_text0 ~ $default_text2 로 구분(원래는 value값 없었음)
					{
						$arr_default_text = explode("-",$default_text);
						$default_text0 = $arr_default_text[0];
						$default_text1 = $arr_default_text[1];
						$default_text2 = $arr_default_text[2];
						if($default_text0 == "010") $hp_selected1 = "selected";
						if($default_text0 == "011") $hp_selected2 = "selected";
						if($default_text0 == "016") $hp_selected3 = "selected";
						if($default_text0 == "017") $hp_selected4 = "selected";
						if($default_text0 == "018") $hp_selected5 = "selected";
						if($default_text0 == "019") $hp_selected6 = "selected";																										
					}
				else{
						$default_text0 = "";
						$default_text1 = "";
						$default_text2 = "";										
					}
				if($input_data and $_GET["mode2"] == "normal")//090105
					{
					echo $default_text;
					}
				else
					{
					echo"<select name='sel_kr_tel$i' id='sel_kr_tel$i'								onchange='this.form[\"dummy_data$i".dummy1."\"].value=this.options[this.selectedIndex].value;dummys_input(\"input_data$i\",\"dummy_data$i".dummy1."\");'>
							<option value=''>선 택
							<option value='010' $hp_selected1>010
							<option value='011' $hp_selected2>011
							<option value='016' $hp_selected3>016
							<option value='017' $hp_selected4>017
							<option value='018' $hp_selected5>018
							<option value='019' $hp_selected6>019	
						</select>
						<input type='hidden' name='dummy_data$i".dummy1."' id='dummy_data$i".dummy1."' $onblur $class_ess value='$default_text0' onkeyup=\"Numbering2(this);dummys_input('input_data$i','dummy_data$i".dummy1."');\"
							onmouseout=\"Numbering2(this);dummys_input('input_data$i','dummy_data$i".dummy1."');\" style='width:30px;'> - 
						<input type='text' name='dummy_data$i".dummy2."' id='dummy_data$i".dummy2."' $onblur $class_ess value='$default_text1' onkeyup=\"Numbering2(this);dummys_input('input_data$i','dummy_data$i".dummy2."');\"
							onmouseout=\"Numbering2(this);dummys_input('input_data$i','dummy_data$i".dummy2."');\" style='width:30px;'> - 
						<input type='text' name='dummy_data$i".dummy3."' id='dummy_data$i".dummy3."' $onblur $class_ess value='$default_text2' onkeyup=\"Numbering2(this);dummys_input('input_data$i','dummy_data$i".dummy3."');\"
							onmouseout=\"Numbering2(this);dummys_input('input_data$i','dummy_data$i".dummy3."');\" style='width:30px;'> 

						<input type='hidden' name='input_data$i' id='input_data$i' value='$default_text'>
						<input type='hidden' name='name_it$i' id='name_it$i' value='$name_it'>
						";
					}
				}

			else if($dummy2 == 13) //090402 항목입력형식을 우편번호와주소검색으로 하였을 경우
				{	
				if($input_data and $_GET["mode2"] == "normal")
					{
					echo $default_text;
					}
				else
					{	
						$onclick_zipcode = "onclick=\"javascript:void(window.open('zipcode_search.php?w=500&amp;h=380&amp;id1=client".$i."_zipcode1&amp;id2=client".$i."_zipcode2&amp;id3=client".$i."_zipcode3&amp;id4=client".$i."_zipcode4&amp;formname=form1','zipcode','width=500,height=380,statusbar=no,scrollbars=yes,toolbar=no'))\"";

						if(addform_rang == "korean")		 //090402(설정이 한국일 때)
						{
							if($input_data)					 //관리자모드일 때는, 주소입력을 일반 text모드로...	  
							{
								$md_client_display = "style='display:none;'";
								$md_client_hidden = "text";
							}
							else							 //접수시에는, 주소입력을 우편번호검색으로...
							{
								$md_client_display = "";
								$md_client_hidden = "hidden";
							}
							echo("
							<table class='c_address' ".$md_client_display.">
								<tr>
									<td>
										<input type='text' name='client".$i."_zipcode1' id='client".$i."_zipcode1' value='' size='5' style='text-align:center;font-weight:bold;' readonly ".$onclick_zipcode."> -
										<input type='text' name='client".$i."_zipcode2' id='client".$i."_zipcode2' value='' size='5' style='text-align:center;font-weight:bold;' readonly ".$onclick_zipcode.">				
										<img src='skins/$af_TABLE5[skin_name]/img/btn_zipcode.gif' alt='우편번호찾기' ".$onclick_zipcode." style='cursor:hand;vertical-align:top;margin-top:1px;'>
									</td>
								</tr>
								<tr>
									<td colspan='2'>
										<input type='text' name='client".$i."_zipcode3' id='client".$i."_zipcode3' value='' size='50' readonly ".$onclick_zipcode.">
									</td>
								</tr>
								<tr>
									<td colspan='2'>
										<input type='text' name='client".$i."_zipcode4' id='client".$i."_zipcode4' value='' size='42' onblur='this.form.input_data".$i.".value=\"[\"+this.form.client".$i."_zipcode1.value+\"-\"+this.form.client".$i."_zipcode2.value+\"] \"+this.form.client".$i."_zipcode3.value+\" \"+this.form.client".$i."_zipcode4.value;quot_Del(this);this.style.backgroundColor=\"white\";' style='ime-mode:active;'>
										<img src='skins/$af_TABLE5[skin_name]/img/address.png' alt='상세주소' style='vertical-align:middle;'>
									</td>
								</tr>
							</table>
							<input type='".$md_client_hidden."' name='input_data".$i."' id='input_data".$i."' value='$default_text' $class_ess style='width:100%;ime-mode:active;' onblur='quot_Del(this)'><input type='hidden' name='name_it".$i."' id='name_it".$i."' value='$name_it'>
							   ");							
						}
						else								//090402(설정이 한국이 아닐 때는 주소입력을 일반  text모드로)
						{
								echo "<input type='text' name='input_data".$i."' id='input_data".$i."' value='$default_text' $class_ess style='width:100%;ime-mode:active;' onblur='quot_Del(this)'><input type='hidden' name='name_it".$i."' id='name_it".$i."' value='$name_it'>";
						}
					}	
				}

					
			else //한줄글상자일 경우
				{
				if($input_data and $_GET["mode2"] == "normal")//090105
					{
					echo $default_text;
					}
				else
					{
					echo "<input type='text' name='input_data$i' id='input_data$i' value='$default_text' $onblur $class_ess $field_width><input type='hidden' name='name_it$i' id='name_it$i' value='$name_it'>";
					}
				}
			}						
		echo("
		".$dummy7."
		</td>
		$trEnd						
		$md_clientBottom
		$md_client_ess						
	   ");					   

?>