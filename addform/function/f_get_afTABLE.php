<?
#########################################################################################
#####################		인자로받은 테이블에서 정보 가져옴			  ###############
#########################################################################################
function f_get_afTABLE($tbl,$field,$kw,$odFld,$desc,$limit)
{
global $DBconn;
if($field and $kw) $where = "where $field='$kw'";
else $where = "";
$where .= " order by $odFld $desc";
$where .= " limit $limit";
$res=$DBconn->f_selectDB("*",$tbl,$where);						//필드, 테이블, 조건절

$html = array();
$html["res_count"]=mysql_num_rows($res[result]);				//리턴된 행의 개수
for($i=0;$i < $html["res_count"];$i++)
			{
			$html["row"][$i] = mysql_fetch_array($res[result]);	//데이타 배열
			}

return $html;
}
?>