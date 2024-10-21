<div id="container">
	<?php if($af_TABLE5["layout"] < 6){?>
	<!-- 상단	-->
	<div id="header">
		<?php include_once("header.html");?>
	</div>
	<?php }?>

	<!-- 바디 -->
	<div id="body">  
		<table width="100%">
			<tr>
				<?php if($af_TABLE5["layout"] == 1 or $af_TABLE5["layout"] == 2 or $af_TABLE5["layout"] == 7){?>
				<td id="left" valign="top" width="<?php echo $af_TABLE7[left_width];?>">
					<?php include_once("left.html");?>
				</td>
				<?php }?>
				<td id="list" valign="top">
					<?php include_once("list.html");?>
				</td>
				<?php if($af_TABLE5["layout"] == 1 or $af_TABLE5["layout"] == 3  or $af_TABLE5["layout"] == 7){?>
				<td id="right" valign="top" width="<?php echo $af_TABLE7[right_width];?>">
					<?php include_once("right.html");?>
				</td>
				<?php }?>
			</tr>
		</table>
	</div>
	<?php if($af_TABLE5["layout"] == 1 or $af_TABLE5["layout"] == 2 or $af_TABLE5["layout"] == 3 or $af_TABLE5["layout"] == 4 or $af_TABLE5["layout"] == 6){?>
	<!-- 하단	-->
	<div id="footer">
		<?php include_once("footer.html");?>
	</div>
	<?php }?>

</div>

