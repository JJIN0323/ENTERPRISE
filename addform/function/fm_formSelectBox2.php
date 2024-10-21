<?php
#----------------------------------------------------------------------------------------#
#										폼 선택상자 start								 #  
#----------------------------------------------------------------------------------------#
//<option>태그 생성
function fm_formSelectBox3($val,$text,$default="",$head="",$fname) 
{
	$buf="<option value='".$val."'";
	if ($default&&$default==$text) 
	{
		$buf.="selected ";		
	}
	$buf.=">".$head;
	return $buf;
}

//select 선택상자 구성
function fm_formSelectBox2($arr) 
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
			<option value='#'>선택하세요</option>			
    \n";
    if ($arr["end"]>$arr[start]) 
	{																		//숫자 범위 지정시
        for ($i=$arr[start];$i <= $arr["end"];$i++) 
		{
            $buf.=fm_formSelectBox3($i,$arr["default"],$arr[head]).$i.$arr[tail]."\n";
        }
    } elseif (count($arr[text])) 
		{          
        for ($i=0;$i < count($arr[text]);$i++) 
		{
            $buf.=fm_formSelectBox3($arr[optVal].$arr[na][$i],&$arr[text][$i],$arr["default"],$arr[head],$arr[na][$i]).$arr[tail][$i]."\n";
        }
    }
    
    $buf.="</select>\n";
    return $buf;
}
?>