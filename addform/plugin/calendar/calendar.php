<?php
function getId()
{
$getId1 = $_GET['inputId'];
$getId2 = $_GET['dummyId'];
$rt = "var getId1 = '$getId1';\n var getId2 = '$getId2';\n";
return $rt;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>

<HEAD>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<meta name='robots' content='none,noindex,nofollow'>
<title>날짜선택</title>
<style type="text/css">
body{margin:0px;padding:0px;background-image:url("bg.gif");}
a{text-decoration:none;}
.cal_TblTop{width:100%;height:100%;}
.cal_TblTop td{border:1px #F3F3F3 solid;text-align:center;}
.cal_TblTop td.SelectedDay{background:#E5E5E5;color:red;}
.cal_TblTop tr.cal_title td{font-weight:bold;background:#92a8bd;color:#FFF;}
.cal_TblTop tr.cal_title td a{color:#FFFFFF;}
.cal_TblTop tr.cal_day td{}
.cal_TblTop tr.cal_day td a{color:#000000;}
.cal_TblTop tr.cal_day td a:hover{background:#e1c08a;}
.cal_TblTop .cal_week td{font-weight:bold;}
.cal_TblTop{border:0;font:normal 11px Verdana, Arial;border-collapse:collapse;background:#FFFFFF;}
</style>
<script type="text/javascript" src='../../js/pop_center.js'></script>
<script type="text/javascript"><?php echo getId();?></script>
<script type="text/javascript" src='calendar.js'></script>
</head>

<body onLoad="init_calendar('<?php echo $_GET['getY'];?>','<?php echo $_GET['getM'];?>','<?php echo $_GET['getD'];?>','<?php echo $_GET['inputId'];?>');"> 
	<div id='calendar'>
	</div>
</body>
</html>






