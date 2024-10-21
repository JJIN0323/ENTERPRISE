<?php
include_once("../lib/C_CONNECT.php");
include_once("../lib/define_table.php");
include_once("../lib/authentication.php");

/* ----------------------------------------------------------------------------------- */
/*	프로그램명 : 애드폼(영문 addform												   */									
/*	프로그램용도: 견적서 주문서 폼메일 제작											   */
/*	제작자: 박성규																	   */
/*	공식배포처: http://www.addform.net												   */
/*  프로그램 편집시 위 제작자 정보를 편집하거나 삭제해서는 안됩니다.				   */
/* ----------------------------------------------------------------------------------- */

$mode = $_POST['mode'];
$post_no = $_POST['post_no'];

?>

<?
#########################################################################################
############################### 전역변수사용을 위한 것 ##################################
#########################################################################################

$re=$DBconn->f_selectDB("*",TABLE2,"where no=1");		//C_CONNECT 클래스 멤버함수인 f_selectDB($field="*",$table,$where="")를 실행하여
														//$re[result]에 저장하고 불러온 레코드 수를 $re[cnt]에 저장 
	
           
              
        $row=mysql_fetch_array($re[result]);			//배열의 요소들을 $row에 대입
														//애드폼환경 테이블  $dummy1 필드의 값		
		$dummy1 = explode("|",htmlspecialchars(stripslashes($row["dummy1"])));		
			$arr_situation = explode(",",$dummy1[0]);		
			$arr_situation_color = explode(",",$dummy1[1]);			




#########################################################################################
###################################   수정 mode   #######################################
#########################################################################################

if($mode=="modify"){								 //수정일 때

	$clean = array();
	$clean['no'] = "1";								 //번호	
	$clean['dummy1'] = $_POST['mix'];				 //히든필드의 믹스데이타	

	///////	DB에 업데이트	///////
													
		$where="where no = ".$clean['no'];			 //문자형일 경우 작은따옴표 붙임에 주의
		$DBconn->f_updateDB(TABLE2,$clean,&$where);	 //테이블, 필드와값, 조건절

echo ("
	<script type='text/javascript'>
		opener.location.reload();
		alert('".af_txt_situation_modify_1."');
	</script>
");
	
}





#########################################################################################
###################################   삭제 mode   #######################################
#########################################################################################

if($mode=="del"){											//수정일 때

	for ($n=0;$n<$post_no-1;$n++) {							//선택상황 삭제해야하므로 $post_no-1
				 $situation_sec1 .= $arr_situation[$n].",";	//폼으로부터 받은 구분자 이전의 글자들
				 $situation_color1 .= $arr_situation_color[$n].",";	
			 }
	for ($n=$post_no;$n<count($arr_situation);$n++) {
				 $situation_sec3 .= $arr_situation[$n].",";	//폼으로부터 받은 구분자 이후의 글자들
				 $situation_color3 .= $arr_situation_color[$n].",";	
			 }		

															
	$situation_mix = $situation_sec1.$situation_sec3;		//선택상황 앞과 뒤만 합체
	$c_count = strlen($situation_mix);						//뒷 문자들의 수															
	$situation_mix = substr($situation_mix,-0,$c_count-1);	//뒷 문자에서 쉼표제거

	$situation_mix_color = $situation_color1.$situation_color3;		
	$c_count_color = strlen($situation_mix_color);																	
	$situation_mix_color = substr($situation_mix_color,-0,$c_count_color-1);

	$clean = array();
	$clean['no'] = "1";										//번호	
	$clean['dummy1'] = $situation_mix."|".$situation_mix_color;	//선택상황 삭제한 데이타

	///////	DB에 업데이트(환경테이블)	///////
													
		$where="where no = ".$clean['no'];					//문자형일 경우 작은따옴표 붙임에 주의
		$DBconn->f_updateDB(TABLE2,$clean,&$where);			//테이블, 필드와값, 조건절

	///////	DB에 업데이트(접수테이블)	///////
	for ($n=$post_no+1;$n<count($arr_situation)+1;$n++) {	//삭제한 상황코드 다음부터, 끝 상황코드까지	반복	
	$clean2 = array();
	$clean2['situation'] = $n-1;							//삭제상황 코드 후 부터, 코드번호를 1씩 감소
		$where="where situation = ".$n;					    //문자형일 경우 작은따옴표 붙임에 주의
															//테이블, 필드와값, 조건절
		$DBconn->f_updateDB(TABLE4,$clean2,&$where);			
			 }
		
		

echo ("
	<script type='text/javascript'>
		opener.location.reload();
		location.href='situation_modify.php';
		alert('".af_txt_situation_modify_2."');
	</script>
");
	
}


			


#########################################################################################
#########  자바스크립트에서 사용하기 위해 DB 테이블에서 데이타 가져오는 함수  ###########
#########################################################################################

function get_dbTable_recode() {								//이 함수는 자바스크립트문에서 출력할것임
    global $DBconn;											//$DBconn 글로벌변수 참조
	
	
    $re=$DBconn->f_selectDB("*",TABLE2,"where no=1");	    //C_CONNECT 클래스 멤버함수인 f_selectDB($field="*",$table,$where="")를 실행하여
															//$re[result]에 저장하고 불러온 레코드 수를 $re[cnt]에 저장 
	
           
        for ($i=0;$i<$re[cnt];$i++) {						//불러온 레코드의 수만큼 루프        
        $row=mysql_fetch_array($re[result]);				//배열의 요소들을 $row에 대입
															//애드폼환경 테이블  $dummy1 필드의 값
			$situ = explode("|",htmlspecialchars(stripslashes($row["dummy1"])));		
		}	
		
	$situation = explode(",",$situ[0]);						//처리상황 문구 배열화
	$situation_color = explode(",",$situ[1]);				//처리상황 색상 배열화
			
	$buffer="var items=new Array();\n";						//본 문서 자바스크립트문 안에서 사용하기 위해 배열을 자바스크립트로 치환 


	 if($situation){										//값이 있다면...
			
		for ($i=0;$i<count($situation);$i++) {				//배열의 수만큼 루프
															//접수내역 테이블에서 해상상황으로 표시된 접수내역수
			$res=$DBconn->f_selectDB('situation',TABLE4,'where situation='.($i+1));  
	        $situation_n = $res[cnt];			
															//아래라인에서 배열1=상황텍스트, 배열2=루프번호, 배뎔3은 해당상황으로 표시된 접수내역수	
			$buffer.="\t items[$i]=['$situation[$i]',$i+1,$situation_n,'$situation_color[$i]'];\n";			
		}
	 }
															
	/////// 결과값 리턴 ///////
    return $buffer;
	 }
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<meta name='robots' content='none,noindex,nofollow'>
<title>애드폼 처리상황 추가/편집</title>
<LINK REL="stylesheet" HREF="global.css" TYPE="text/css">
<!--##################################################################################-->
<!--########################	자바스크립트 start	##################################-->
<!--##################################################################################-->
<script type="text/javascript" src='js/pop_center.js'></script>
<script type="text/javascript" src='js/check_input.js'></script>
<script type="text/javascript" src='js/array_del.js'></script>

<script type="text/javascript">
//## 1. DB 테이블에서 데이타 가져와서 배열화 하는 php 함수(윗부분 php구문안에 정의되있음)
<?php echo get_dbTable_recode();?>                         

var item_len;											   //전체 레코드의 행수

var CurrentPosition;									   //현재 배열 레코드 포인트의 값

function resetItemSize() {								   //현재 레코드의 수를 재정의
    item_len=items.length;	
}


//########################## 배열요소들을 HTML로 변환하는 함수 ########################//						
function htmlConvert_data(i) {
        var buffer="<li>"

			+"<input name=name_it["+i+"] class=class_name onblur=\"quot_Del(this)\" "
            +"value=\""+items[i][0]+"\" size=\"10\"  style='ime-mode:active;'> "
			
			+"색상<input name=name_color["+i+"] class=class_color onblur=\"quot_Del(this)\" "
            +"value=\""+items[i][3]+"\" size=\"7\" style=\"background-color:"+items[i][3]+";ime-mode:disabled;\"> "
			
            +" <input type=button value='<?php echo af_txt_situation_modify_3;?>' "
            +"onClick=\"javascript:void(window.open('situation_add.php?w=400&amp;h=380&amp;mode=add&amp;situation_no="+items[i][1]+"','add','statusbar=yes,scrollbars=no,toolbar=no,location=no'))\"> "
			
			
			+" <input type=button value=\"<?php echo af_txt_situation_modify_4;?>("+items[i][2]+")\" "
             +"onClick=\"javascript:void(window.open('situation_add.php?w=400&amp;h=380&amp;mode=move&amp;situation_no="+items[i][1]+"','move','statusbar=yes,scrollbars=no,toolbar=no,location=no'))\"> "
			
			+"<input type=button value='<?php echo af_txt_situation_modify_5;?>' "
            +"onclick='del_item(this.form,\""+items[i][0]+"\",\""+items[i][1]+"\",\""+items[i][2]+"\")'><\/li>";
        return buffer;
}


//########### htmlConvert_data(i)에서 변환한 코드를 patchZone 에 쓰는 함수 ############//
function paste_patchZone(convertData) {					  
    //document.all['patchZone'].innerHTML+=convertData;	  //불여우에서는 동작안함
	document.getElementById('patchZone').innerHTML+=convertData;
}


//############################## 상황삭제 함수 start  ##############################//
function del_item(f,situ,i,n) {							  //인자(폼,상황텍스트,루프번호,해당표시수)
	if(n > 0){
		alert("해당상황으로 표시된 접수내역이 "+n+" 건이 있습니다. 상황이동 버튼을 눌러서 상황이동 후, 삭제할 수 있습니다.\n\n After the move, please delete");
	}
	else del_item2(f,situ,i,n);   
}

function del_item2(f,situ,i,n){
	 if (confirm(""+situ+" 상황을 삭제하시겠습니까? \n\n Delete credit?")) {        
        f.mode.value = "del";
		f.post_no.value = i;
		f.submit();
    }
}
															


//############################  초기 문서출력함수 start  ##############################//
function initial() {									  
    var buffer="";   
							
    resetItemSize();									  //현재 레코드의 수를 재정의
    
    for (var i=0;i<item_len;i++) {						  // items[] 배열수만큼      
        buffer+=htmlConvert_data(i);                      // HTML 변환
    } 
   
    CurrentPosition=i;									  //현재 배열 레코드 포인트의 값    
    
    paste_patchZone(buffer);							  //htmlConvert_data(i)에서 변환한 코드를 patchZone 에 쓰는 함수
	
}
//###########################  초기 문서출력함수 end  #################################//

</script>

<script type="text/javascript">	
<!--								 

function Mix(f){	
	var val_name = "";
	var val_color = "";

	var field=document.getElementsByTagName('input');	 //input 태그 갯수 검사
	
		for (i = 0; i < field.length;i++){				 //input 태그 갯수만큼 루프
										
			if(field[i].className=='class_name'){		 //일치하는 클래스명이 있을 때
				if (!field[i].value) {					 //항목 공란 검사
					alert('<?php echo af_txt_situation_modify_6;?>');
					return field[i].focus();
				}
				else val_name+=field[i].value+",";		 //항목입력값들을 쉼표구분자로 합침
				}
			}	
val_name = val_name.slice(0,-1);						 //마지막 쉼표 제거	

		for (i = 0; i < field.length;i++){				 //input 태그 갯수만큼 루프
										
			if(field[i].className=='class_color'){		 //일치하는 클래스명이 있을 때				
					val_color+=field[i].value+",";		 //항목입력값들을 쉼표구분자로 합침
				}
			}	
val_color = val_color.slice(0,-1);						 //마지막 쉼표 제거	

f.mix.value = val_name+"|"+val_color;					 //조건을 통과시 히든필드에 입력
f.submit();												 //폼 전송

}		

-->
</script>
<!--##################################################################################-->
<!--#################################	자바스크립트 end	##########################-->
<!--##################################################################################-->
</HEAD>

<BODY onload='initial();'>
<TABLE CLASS="noborder">
<TR>
	<TD style="text-align:left;padding:20px;background-color:#ffffff">
		<strong><big><?php echo af_txt_situation_modify_7;?></big></strong><br />		
	</TD>
</TR>
</TABLE>

<FORM name="form1" method="post" action="<?php echo $_SERVER['PHP_SELF'];?>" onsubmit="return false">
<input type="hidden" name="mode" value="modify">
<input type="hidden" name="post_no" value="">

<!--
onblur='Numbering(this)' 이벤트:커서를 영역밖으로 이동했을 때, Numbering함수 실행하여, 숫자만 입력했는지 체크
onkeyup='checkKey(addBtn)' 이벤트:checkKey()함수 실행하여, 폼전송
onblur='quot_Del(this)' 이벤트:입력필드항목의 인용부호(따옴표)를 제거
-->


<FIELDSET style="margin:20px;">
	<LEGEND style="margin-bottom:20px;"><strong><?php echo af_txt_situation_modify_8;?></strong></LEGEND> 

		<TABLE CLASS="noborder">
			<TR>
				<TD id="patchZone">
	
				</TD>
			</TR>
		</TABLE>

</FIELDSET>

<TABLE CLASS="noborder">
<TR>
	<TD style="text-align:center">
		<input type="hidden" name="mix" value="">
		<input type="button" value="<?php echo af_txt_confirm;?>" onclick="Mix(this.form)" class="btn_set">
	</TD>
</TR>

<TR>
	<TD style="text-align:left;padding:20px;border-top:1px solid #666666;">
		<ul>
			<li><strong>색상 - </strong> #ff6600 과 같이 #을 붙인 색상코드나, 혹은 red 와 같은 색상단어를 입력하세요.</li>
			<li><strong><?php echo af_txt_situation_modify_3;?></strong> - <?php echo af_txt_situation_modify_8;?></li>
			<li><strong><?php echo af_txt_situation_modify_4;?></strong> - <?php echo af_txt_situation_modify_9;?></li>
			<li><strong><?php echo af_txt_situation_modify_5;?></strong> - <?php echo af_txt_situation_modify_10;?></li>
		</ul>		
	</TD>
</TR>
</TABLE>
<!--##########################  출력 테이블 디자인 end  ##############################-->
</FORM>

</BODY>
</HTML>