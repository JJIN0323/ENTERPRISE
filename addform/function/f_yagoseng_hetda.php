<?
function f_yagoseng_hetda($arr)
{
for($i=0;$i<count($arr);$i++)
	{
	mysql_query($arr[$i]) or die(mysql_error());
	echo ("			
			<script type='text/javascript'>document.getElementById('progres_td$i').style.backgroundColor='#007a00';</script>	
		 ");
	$rand = rand(0,5);
	flush(); 
	usleep(200000*$rand);
	}
}
?>