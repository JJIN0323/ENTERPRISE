<?php
#----------------------------------------------------------------------------------------#
#										그룹 선택상자 start								 #  
#----------------------------------------------------------------------------------------#

//<option>태그 생성
function fm_groupSelectBox3($val,$text,$default="",$head="") 
{
	$buf="<option value='$val'";
	if ($default&&$default==$text) 
		{
			$buf.="selected";
		}
	$buf.=">".$head;
	return $buf;
}
//select 선택상자 구성
function fm_groupSelectBox2($arr) 
{
	if ($arr[name]) $arr[name]="name=$arr[name]";
    if ($arr[id]) $arr[id]="id=$arr[id]";
    if ($arr[style]) $arr[style]="style='$arr[style]'";	
    if ($arr[disable]) $arr[disable]="disable";
    
    $buf="<select 
	    $arr[name]
        $arr[id]
        $arr[style]
		$arr[script]
        $arr[disable]
        >
			
    \n";
    if ($arr["end"]>$arr[start]) 
		{             //숫자 범위 지정시
        for ($i=$arr[start];$i<=$arr["end"];$i++) 
			{
            $buf.=fm_groupSelectBox3($i,$arr["default"],$arr[head]).$i.$arr[tail]."\n";
			}
		} 
	elseif (count($arr[text])) 
		{          
        for ($i=0;$i<count($arr[text]);$i++) 
			{
            $buf.=fm_groupSelectBox3($arr[optVal].$arr[no][$i],&$arr[no][$i],$arr["default"],$arr[head]).$arr[text][$i].$arr[tail]."\n";
			}
		}    
    $buf.="</select>\n";
    return $buf;
}
?>