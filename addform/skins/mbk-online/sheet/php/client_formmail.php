<?php
$md_client = "";
if($af_TABLE5['dummy10'])						//기본고객정보입력 타이틀내용 있을 때
{
	$md_client = "<tr><td class='af_divi' colspan='4'>".$af_TABLE5['dummy10']."</td></tr>";
}
else
{
	$md_client = "";
}


if($af_client_itemsArr[0] && $af_client_itemsArr[1]) 
{												//이름과 이메일 동시사용일 때
	$c1_trEnd = "";
	$c2_trStart = "";
	$c_colspan = "1";
}
else 
{	
	$c1_trEnd = "</tr>";
	$c2_trStart = "<tr>";
	$c_colspan = "3";
}			

if($af_client_itemsArr[0])
{
$md_client .= "	
		<!--	고객 이름	-->
		<tr>					
		<td class='item' nowrap>
			<span style='color:red;'>*</span> ".$af_TABLE5["client_text_name"]."
		</td>
		<td class='val' colspan='3'>";
		if($input_data and $_GET["mode2"] == "normal")//090105
			{
			$md_client .= $clean['client_name'].$af_TABLE4['client_name'];
			}
		else
			{
			$md_client .= "<input type='text' name='client_name' id='h-name' placeholder=' 이름' value='".$clean['client_name'].$af_TABLE4['client_name']."' onblur='quot_Del(this)' class='ess' style='ime-mode:active;'>";
			}
$md_client .= "	
		</td>
		</tr>
		$c1_trEnd
		";
}
		
		
if($af_client_itemsArr[1])
{
$md_client .= "
		<!--	고객 이메일	-->
		<tr>
		<td class='item' nowrap>
			<span style='color:red;'>*</span> ".$af_TABLE5["client_text_email"]."
		</td>
		<td class='val' colspan='3'>";
		if($input_data and $_GET["mode2"] == "normal")//090105
			{
			$md_client .= $clean['client_email'].$af_TABLE4['client_email'];
			}
		else
			{
			$md_client .= "<input type='text' name='client_email' value='".$clean['client_email'].$af_TABLE4['client_email']."' class='ess' style='ime-mode:inactive;'>";
			}
$md_client .= "	
		</td>
		</tr>
		";
}

if($af_client_itemsArr[2] && $af_client_itemsArr[3]) 
{												//휴대폰과 전화번호 동시사용일 때
	$c1_trEnd = "";
	$c2_trStart = "";
	$c_colspan = "1";
}
else 
{	
	$c1_trEnd = "</tr>";
	$c2_trStart = "<tr>";
	$c_colspan = "3";
}

if($af_client_itemsArr[2])
{
if($input_data)	   //090105 if else 추가 후, value=$c_hp0 ~ $c_hp2 로 구분(원래는 value값 없었음)
	{
		$arr_c_hp = explode("-",$clean['client_hp'].$af_TABLE4['client_hp']);
		$c_hp0 = $arr_c_hp[0];
		$c_hp1 = $arr_c_hp[1];
		$c_hp2 = $arr_c_hp[2];
		if($c_hp0 == "010") $c_hp_selected1 = "selected";
		if($c_hp0 == "011") $c_hp_selected2 = "selected";
		if($c_hp0 == "016") $c_hp_selected3 = "selected";
		if($c_hp0 == "017") $c_hp_selected4 = "selected";
		if($c_hp0 == "018") $c_hp_selected5 = "selected";
		if($c_hp0 == "019") $c_hp_selected6 = "selected";																										
	}
else{
		$c_hp0 = "";
		$c_hp1 = "";
		$c_hp2 = "";										
	}

	if(addform_rang == "korean")
	{//한국어 설정일 때
	$md_client .= "			
		<!--	고객 휴대폰	-->
		<tr>
		<td class='item' nowrap>
			<span style='color:red;'>*</span> ".$af_TABLE5["client_text_hp"]."
		</td>
		<td class='val' colspan='3'>";
		if($input_data and $_GET["mode2"] == "normal")//090105
			{
			$md_client .= $clean['client_hp'].$af_TABLE4['client_hp'];
			}
		else
			{
			$md_client .= "
			<select name='sel_client_hp' id='sel_client_hp' onchange='this.form[\"client_hp1\"].value=this.options[this.selectedIndex].value;dummys_input(\"client_hp\",\"client_hp_dummy1\");client_hp2.focus();'>
				<option id='h-phone' value='' $c_hp_selected0>휴대폰번호
				<option value='010' $c_hp_selected1>010
				<option value='011' $c_hp_selected2>011
				<option value='016' $c_hp_selected3>016
				<option value='017' $c_hp_selected4>017
				<option value='018' $c_hp_selected5>018
				<option value='019' $c_hp_selected6>019									
				</select>
			<input type='hidden' name='client_hp1' id='client_hp_dummy1' onkeyup=\"Numbering2(this);dummys_input('client_hp','client_hp_dummy1');\" onmouseout=\"Numbering2(this);dummys_input('client_hp','client_hp_dummy1');\" size='4' value='".$c_hp0."'>
			<input type='text' name='client_hp2' id='client_hp_dummy2' onkeyup=\"Numbering2(this);dummys_input('client_hp','client_hp_dummy2');if(this.value.length >= 4)client_hp3.focus();\" onmouseout=\"Numbering2(this);dummys_input('client_hp','client_hp_dummy2');\" size='4' class='ess' value='".$c_hp1."'>
			<input type='text' name='client_hp3' id='client_hp_dummy3' onkeyup=\"Numbering2(this);dummys_input('client_hp','client_hp_dummy3');\" onmouseout=\"Numbering2(this);dummys_input('client_hp','client_hp_dummy3');\" size='4' class='ess' value='".$c_hp2."'>

			<input type='hidden' name='client_hp' id='client_hp' value='".$clean['client_hp'].$af_TABLE4['client_hp']."'>";
			}
	$md_client .= "
		</td>
		</tr>
		$c1_trEnd
		";
						
	}
	else
	{//한국어 설정이 아닐때는 국번을 그냥 입력하게
	$md_client .= "			
		<!--	고객 휴대폰	-->
		<tr>
		<td class='item' nowrap>
			<span style='color:red;'>*</span> ".$af_TABLE5["client_text_hp"]."
		</td>
		<td class='val' colspan='3'>";
		if($input_data and $_GET["mode2"] == "normal")//090105
			{
			$md_client .= $clean['client_hp'].$af_TABLE4['client_hp'];
			}
		else
			{
			$md_client .= "
			<input type='text' name='client_hp1' id='client_hp_dummy1' onkeyup=\"Numbering2(this);dummys_input('client_hp','client_hp_dummy1');\" onmouseout=\"Numbering2(this);dummys_input('client_hp','client_hp_dummy1');\" size='4' class='ess' value='".$c_hp0."'> - 
			<input type='text' name='client_hp2' id='client_hp_dummy2' onkeyup=\"Numbering2(this);dummys_input('client_hp','client_hp_dummy2');\" onmouseout=\"Numbering2(this);dummys_input('client_hp','client_hp_dummy2');\" size='4' class='ess' value='".$c_hp1."'> -
			<input type='text' name='client_hp3' id='client_hp_dummy3' onkeyup=\"Numbering2(this);dummys_input('client_hp','client_hp_dummy3');\" onmouseout=\"Numbering2(this);dummys_input('client_hp','client_hp_dummy3');\" size='4' class='ess' value='".$c_hp2."'>

			<input type='hidden' name='client_hp' id='client_hp' value='".$clean['client_hp'].$af_TABLE4['client_hp']."'>";
			}
	$md_client .= "
		</td>
		</tr>
		$c1_trEnd
		";
			
	}
}
	
if($af_client_itemsArr[3])
{
	if($input_data)	   //090105 if else 추가 후, value=$c_tel0 ~ $c_tel2 로 구분(원래는 value값 없었음)
	{
		$arr_c_tel = explode("-",$clean['client_tel'].$af_TABLE4['client_tel']);
		$c_tel0 = $arr_c_tel[0];
		$c_tel1 = $arr_c_tel[1];
		$c_tel2 = $arr_c_tel[2];
		if($c_tel0 == "02") $c_tel_selected1 = "selected";
		if($c_tel0 == "031") $c_tel_selected2 = "selected";
		if($c_tel0 == "032") $c_tel_selected3 = "selected";
		if($c_tel0 == "033") $c_tel_selected4 = "selected";
		if($c_tel0 == "041") $c_tel_selected5 = "selected";
		if($c_tel0 == "042") $c_tel_selected6 = "selected";
		if($c_tel0 == "043") $c_tel_selected7 = "selected";
		if($c_tel0 == "051") $c_tel_selected8 = "selected";
		if($c_tel0 == "052") $c_tel_selected9 = "selected";
		if($c_tel0 == "053") $c_tel_selected10 = "selected";
		if($c_tel0 == "054") $c_tel_selected11 = "selected";
		if($c_tel0 == "055") $c_tel_selected12 = "selected";
		if($c_tel0 == "061") $c_tel_selected13 = "selected";
		if($c_tel0 == "062") $c_tel_selected14 = "selected";
		if($c_tel0 == "063") $c_tel_selected15 = "selected";
		if($c_tel0 == "064") $c_tel_selected16 = "selected";
		if($c_tel0 == "060") $c_tel_selected17 = "selected";
		if($c_tel0 == "070") $c_tel_selected18 = "selected";
		if($c_tel0 == "080") $c_tel_selected19 = "selected";
		if($c_tel0 == "0502") $c_tel_selected20 = "selected";
		if($c_tel0 == "1544") $c_tel_selected21 = "selected";
		if($c_tel0 == "1644") $c_tel_selected22 = "selected";
		if($c_tel0 == "1588") $c_tel_selected23 = "selected";
		if($c_tel0 == "1577") $c_tel_selected24 = "selected";																			
	}
else{
		$c_tel0 = "";
		$c_tel1 = "";
		$c_tel2 = "";										
	}
	if(addform_rang == "korean")
	{//한국어 설정일 때
	$md_client .= "
		<!--	고객 전화번호	-->
		<td class='item' nowrap>
			&nbsp;&nbsp;".$af_TABLE5["client_text_tel"]."
		</td>
		<td class='val' colspan='3'>";
		if($input_data and $_GET["mode2"] == "normal")//090105
			{
			$md_client .= $clean['client_tel'].$af_TABLE4['client_tel'];
			}
		else
			{
			$md_client .= "
			<select name='sel_client_tel' id='sel_client_tel' onchange='this.form[\"client_tel1\"].value=this.options[this.selectedIndex].value;dummys_input(\"client_tel\",\"client_tel_dummy1\");client_tel2.focus();'>
				<option value='' $c_tel_selected0>지역번호
				<option value='02' $c_tel_selected1>	 02 서울
				<option value='031' $c_tel_selected2>031 경기
				<option value='032' $c_tel_selected3>032 인천
				<option value='033' $c_tel_selected4>033 강원
				<option value='041' $c_tel_selected5>041 충남
				<option value='042' $c_tel_selected6>042 대전
				<option value='043' $c_tel_selected7>043 충북
				<option value='051' $c_tel_selected8>051 부산
				<option value='052' $c_tel_selected9>052 울산
				<option value='053' $c_tel_selected10>053 대구
				<option value='054' $c_tel_selected11>054 경북
				<option value='055' $c_tel_selected12>055 경남
				<option value='061' $c_tel_selected13>061 전남
				<option value='062' $c_tel_selected14>062 광주
				<option value='063' $c_tel_selected15>063 전북
				<option value='064' $c_tel_selected16>064 제주
				<option value='060' $c_tel_selected17>060
				<option value='070' $c_tel_selected18>070
				<option value='080' $c_tel_selected19>080
				<option value='0502' $c_tel_selected20>0502
				<option value='1544' $c_tel_selected21>1544
				<option value='1644' $c_tel_selected22>1644
				<option value='1588' $c_tel_selected23>1588
				<option value='1577' $c_tel_selected24>1577
			</select>
			<input type='hidden' name='client_tel1' id='client_tel_dummy1' onkeyup=\"Numbering2(this);dummys_input('client_tel','client_tel_dummy1');\" onmouseout=\"Numbering2(this);dummys_input('client_tel','client_tel_dummy1');\" size='4' value='".$c_tel0."'> - 
			<input type='text' name='client_tel2' id='client_tel_dummy2' onkeyup=\"Numbering2(this);dummys_input('client_tel','client_tel_dummy2');if(this.value.length >= 4)client_tel3.focus();\" onmouseout=\"Numbering2(this);dummys_input('client_tel','client_tel_dummy2');\" size='4' value='".$c_tel1."'> -
			<input type='text' name='client_tel3' id='client_tel_dummy3' onkeyup=\"Numbering2(this);dummys_input('client_tel','client_tel_dummy3');\" onmouseout=\"Numbering2(this);dummys_input('client_tel','client_tel_dummy3');\" size='4' value='".$c_tel2."'>

			<input type='hidden' name='client_tel' id='client_tel' value='".$clean['client_tel'].$af_TABLE4['client_tel']."'>";
			}
	$md_client .= "
		</td>
		</tr>
		";
	}
	else
	{//한국어 설정이 아닐때는 지역번호를 그냥 입력하게
	$md_client .= "
		<!--	고객 전화번호	-->
		$c2_trStart
		<td class='item' nowrap>
			&nbsp;&nbsp;".$af_TABLE5["client_text_tel"]."
		</td>
		<td class='val' colspan='$c_colspan'>";
		if($input_data and $_GET["mode2"] == "normal")//090105
			{
			$md_client .= $clean['client_tel'].$af_TABLE4['client_tel'];
			}
		else
			{
			$md_client .= "
			<input type='text' name='client_tel1' id='client_tel_dummy1' onkeyup=\"Numbering2(this);dummys_input('client_tel','client_tel_dummy1');\" onmouseout=\"Numbering2(this);dummys_input('client_tel','client_tel_dummy1');\" size='4' value='".$c_tel0."'> - 
			<input type='text' name='client_tel2' id='client_tel_dummy2' onkeyup=\"Numbering2(this);dummys_input('client_tel','client_tel_dummy2');\" onmouseout=\"Numbering2(this);dummys_input('client_tel','client_tel_dummy2');\" size='4' value='".$c_tel1."'> -
			<input type='text' name='client_tel3' id='client_tel_dummy3' onkeyup=\"Numbering2(this);dummys_input('client_tel','client_tel_dummy3');\" onmouseout=\"Numbering2(this);dummys_input('client_tel','client_tel_dummy3');\" size='4' value='".$c_tel2."'>

			<input type='hidden' name='client_tel' id='client_tel' value='".$clean['client_tel'].$af_TABLE4['client_tel']."'>";
			}
	$md_client .= "
		</td>
		</tr>
		";
	}
}

if($af_client_itemsArr[4])
{
$arr_c_fax = explode("-",$clean['client_fax'].$af_TABLE4['client_fax']);//090105 추가 후, 아래 value에 추가
$md_client .= "
		<!--	고객 팩스	-->
		<tr>
		<td class='item' nowrap>
			&nbsp;&nbsp;".$af_TABLE5["client_text_fax"]."
		</td>
		<td class='val' colspan='3'>";
		if($input_data and $_GET["mode2"] == "normal")//090105
			{
			$md_client .= $clean['client_fax'].$af_TABLE4['client_fax'];
			}
		else
			{
			$md_client .= "
			<input type='text' name='client_fax1' id='client_fax_dummy1' onkeyup=\"Numbering2(this);dummys_input('client_fax','client_fax_dummy1');\" onmouseout=\"Numbering2(this);dummys_input('client_fax','client_fax_dummy1');\" style='width:30px;' value='".$arr_c_fax[0]."'> - 
			<input type='text' name='client_fax2' id='client_fax_dummy2' onkeyup=\"Numbering2(this);dummys_input('client_fax','client_fax_dummy2');\" onmouseout=\"Numbering2(this);dummys_input('client_fax','client_fax_dummy2');\" style='width:30px;' value='".$arr_c_fax[1]."'> -
			<input type='text' name='client_fax3' id='client_fax_dummy3' onkeyup=\"Numbering2(this);dummys_input('client_fax','client_fax_dummy3');\" onmouseout=\"Numbering2(this);dummys_input('client_fax','client_fax_dummy3');\" style='width:30px;' value='".$arr_c_fax[2]."'>

			<input type='hidden' name='client_fax' id='client_fax' value='".$clean['client_fax'].$af_TABLE4['client_fax']."'>";
			}
$md_client .= "
		</td>
		</tr>
		";
}
		
if($af_client_itemsArr[5])
{
$md_client .= "
		<!--	고객 주소	-->
		<tr>
		<td class='item' nowrap>
			&nbsp;&nbsp;".$af_TABLE5["client_text_address"]."
		</td>
		<td class='val' colspan='3'>";
		if($input_data and $_GET["mode2"] == "normal")//090105
			{
			$md_client .= $clean['client_address'].$af_TABLE4['client_address'];
			}
		else
			{	
				$onclick_zipcode = "onclick=\"javascript:void(window.open('zipcode_search.php?w=500&amp;h=380&amp;id1=client_zipcode1&amp;id2=client_zipcode2&amp;id3=client_zipcode3&amp;id4=client_zipcode4&amp;formname=form1','zipcode','width=500,height=380,statusbar=no,scrollbars=yes,toolbar=no'))\"";

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
			$md_client .= "
			<table class='c_address' ".$md_client_display.">
				<tr>
					<td>
						<input type='text' name='client_zipcode1' id='client_zipcode1' value='' size='5' style='text-align:center;font-weight:bold;' readonly ".$onclick_zipcode."> -
						<input type='text' name='client_zipcode2' id='client_zipcode2' value='' size='5' style='text-align:center;font-weight:bold;' readonly ".$onclick_zipcode.">				
						<img src='skins/$af_TABLE5[skin_name]/img/btn_zipcode.gif' alt='우편번호찾기' ".$onclick_zipcode." style='cursor:hand;vertical-align:top;margin-top:1px;'>
					</td>
				</tr>
				<tr>
					<td colspan='2'>
						<input type='text' name='client_zipcode3' id='client_zipcode3' value='' size='50' readonly ".$onclick_zipcode.">
					</td>
				</tr>
				<tr>
					<td colspan='2'>
						<input type='text' name='client_zipcode4' id='client_zipcode4' value='' size='42' onblur='this.form.client_address.value=\"[\"+this.form.client_zipcode1.value+\"-\"+this.form.client_zipcode2.value+\"] \"+this.form.client_zipcode3.value+\" \"+this.form.client_zipcode4.value;quot_Del(this);this.style.backgroundColor=\"white\";' style='ime-mode:active;'>
						<img src='skins/$af_TABLE5[skin_name]/img/address.png' alt='상세주소' style='vertical-align:middle;'>
					</td>
				</tr>
			</table>
			<input type='".$md_client_hidden."' name='client_address' value='".$clean['client_address'].$af_TABLE4['client_address']."' style='width:100%;ime-mode:active;' onblur='quot_Del(this)'>
			";
				}
				else								//090402(설정이 한국이 아닐 때는 주소입력을 일반  text모드로)
				{
			$md_client .= "<input type='".$md_client_hidden."' name='client_address' value='".$clean['client_address'].$af_TABLE4['client_address']."' style='width:100%;ime-mode:active;' onblur='quot_Del(this)'>";
				}
			}
$md_client .= "
		</td>
		</tr>
		";
}					

#-------------------------		$md_client 끝	----------------------------#
#----------		폼메일에서 고객메모 사용할 경우 맨 아래 표시되게	--------#
if($af_TABLE5["form_type"]=="1" and $af_client_itemsArr[6])
{
$md_client_memo = "
		<!--	고객 메모	-->
		<tr><td class='af_divi' colspan='4' style='height:10px;'></td></tr>
		<tr>
		<td class='item' nowrap>
			&nbsp;&nbsp;".$af_TABLE5["client_text_memo"]."
		</td>
		<td class='val' colspan='3'>";
		if($input_data and $_GET["mode2"] == "normal")//090105
			{
			$md_client_memo .= nl2br($clean['client_memo'].$af_TABLE4['client_memo']);
			}
		else
			{
			$md_client_memo .= "
			<textarea name='client_memo' id='client_memo' placeholder=' 남기실 말씀을 입력해주세요' style='width:100%;ime-mode:active;' rows='7' onblur='quot_Del(this)'>".$clean['client_memo'].$af_TABLE4['client_memo']."</textarea>";
			}
$md_client_memo .= "
		</td>
		</tr>				
		";
}
?>

<script type="text/javascript" src='js/placeholders.min.js'></script>