<?
function f_get_af_dir($fold)
{
	$folder = dir($fold);
	$upload_totalsize = 0;
	$file_list = "";
	while($entry=$folder->read())
	{	
		$file_list .= $entry."<br>";
		$totalsize += filesize($fold."/".$entry."");	
	}
	$folder->rewind();
	$folder->close();
	unset($folder);
	
$arr = array();
$arr["file_list"] = $file_list; 
$arr["totalsize"] = $totalsize; 
return $arr;
}
?>