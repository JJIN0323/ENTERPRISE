<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN"   "http://www.w3.org/TR/html4/strict.dtd">
<HTML>
<HEAD>
<meta http-equiv='content-type' content='text/html; charset=utf-8'>
<meta name='robots' content='none,noindex,nofollow'>
<title>애드폼 v7.2 파일 검사</title>
<LINK REL="stylesheet" HREF="style_setup.css" TYPE="text/css">
<script type='text/javascript'>
function chk_license(f)
{
	if(document.getElementById('chk_lic').checked == false)
	{
		alert('이용약관에 동의하십시오');
		document.getElementById('chk_lic').focus();
	}
	else f.submit();
}
</script>
</head>

<body style='background: url(imgs/box_s.jpg);background-repeat:no-repeat;background-position:top right;'>

<div id='fixed_div'>
	<table style='width:100%;border:1px solid #999;margin-top:100px;'>
		<tr>
		<?php
		for($i=0;$i<26;$i++)		//실제배열보다 1많게
			{
			echo "<td id='progresTd$i' style='background-color:#ccc;height:30px;width:10px;'></td>\n\t\t";
			}
		?>			
		</tr>
	</table>
</div>

<img src='imgs/setup1.gif' alt='설치진행이미지1'>
<p>
<textarea name='lic' id='lic' rows='9' cols='90' style='background-color:#a1c2c6;'>
애드폼 이용약관

개인/단체/회사등을 구분하지 않고, 누구나 애드폼을 다운받아서 상업적인 경제활동의 목적이나,공익적인 소프트웨어 발전을 위해, 사용/개발/제공을 할 수 있습니다.
무상으로 배포되는, 프로그램의 사용은, 사용자의 자유의지에 의한것이므로, 개발자는 어떠한 책임을 지지 않습니다.
모호한 용어상의 규정으로, 개발자나 사용자의 혼선을 방지하기 위해, 3금지의 프로그램 사용약관을 명시합니다.

[금지1]
화면상의 하단에 표시되는 배너광고와 프로그램출처를, 애드폼 최초개발자와 협의없이 삭제/수정할 수 없고, 변칙적인 방법으로 감추어서는 안됩니다.

[금지2]
애드폼 관리자화면 좌상단에 위치한, 애드폼 로고나 프로그램명을 삭제하거나 수정할 수 없습니다.

[금지3]
애드폼을 업무용도에 맞게 개작하여 사용하거나 제공하는것은 허가하되, 프로그램명을 바꾸어 제공하거나 배포할 수 없습니다.

위 애드폼 이용약관은 개작하여 타인에게 제공시에도 수정/추가/삭제 할 수 없습니다.
</textarea>
</p>
<p>
<input type='checkbox' name='chk_lic' id='chk_lic'>이용약관에 동의합니다.
</p>

<?php
/* ------------------------------------------------------------------------------------*/
/*									 파일전수검사									   */
/* ------------------------------------------------------------------------------------*/
$arr_dir = array();
$arr_dir[0] = "./";
$arr_dir[1] = "admine/";
$arr_dir[2] = "admine/img/";
$arr_dir[3] = "admine/js/";
$arr_dir[4] = "function/";
$arr_dir[5] = "imgs/";
$arr_dir[6] = "js/";
$arr_dir[7] = "lib/";
$arr_dir[8] = "lib/lang/korean/";
$arr_dir[9] = "lib/lang/korean/img/";
$arr_dir[10] = "lib/lang/english/";
$arr_dir[11] = "lib/lang/english/img/";
$arr_dir[12] = "plugin/calendar/";
$arr_dir[13] = "plugin/js/";
$arr_dir[14] = "plugin/sms/whois/";
$arr_dir[15] = "skins/addform_default/";
$arr_dir[16] = "skins/addform_default/img/";
$arr_dir[17] = "skins/addform_default/sheet/";
$arr_dir[18] = "skins/addform_default/sheet/php/";
$arr_dir[19] = "plugin/PG/kcp/";
$arr_dir[20] = "plugin/PG/kcp/css/";
$arr_dir[21] = "plugin/PG/kcp/img/";
$arr_dir[22] = "plugin/PG/kcp/payplus/bin/";
$arr_dir[23] = "plugin/PG/ksnet/";
$arr_dir[24] = "zipcode/";
$arr_dir[25] = "html/";

$arr_file[0] = array(
"index.php",
"chk_ok.gif",
"chk_lose.gif",
"estimate.php",
"formmail.php",
"groupANDform.php",
"lastest_order.php",
"order.php",
"setup1.php",
"setup2.php",
"setup3.php",
"setup4.php",
"style_setup.css",
"uninstall.php",
"view_addform.php",
"view_list.php",
"zipcode_search.php"
);

$arr_file[1] = array(
"addform_Group.php",
"addform_list.php",
"addform_order_list.php",
"addGroup.php",
"add_items.php",
"add_opt.php",
"admine_add.php",
"admine_level.php",
"admine_list.php",
"backup.php",
"backup_forms.php",
"chk_formname.php",
"chk_id.php",
"dump_odlist.php",
"formmail_modify.php",
"form_add.php",
"form_copy.php",
"form_env.php",
"global.css",
"index.html",
"lic.html",
"mail_delivery.php",
"main.html",
"modify_admine.php",
"modify_layout.php",
"move_Group.php",
"move_Group_forDel.php",
"order_modify.php",
"situation_add.php",
"situation_modify.php",
"top.html",
"upload_forms.php",
"url_copy.php"
);

$arr_file[2] = array(
"1.gif",
"2.gif",
"3.gif",
"4.gif",
"5.gif",
"6.gif",
"7.gif",
"8.gif",
"9.gif",
"10.gif",
"11.gif",
"12.gif",
"after.gif",
"asc.gif",
"basket.gif",
"bg_addform.gif",
"bg_addGroup.gif",
"bg_f11.gif",
"btnTop_line.gif",
"btn_bottom.gif",
"del.gif",
"deleted.gif",
"desc.gif",
"disket.gif",
"edit_head.gif",
"edit_left.gif",
"edit_right.gif",
"edit_footer.gif",
"float_left.gif",
"float_none.gif",
"float_right.gif",
"hand1.gif",
"hand2.gif",
"htmltag.gif",
"htmltag_s.gif",
"icon_read.gif",
"icon_noread.gif",
"key_level1.gif",
"key_level10.gif",
"layout1.gif",
"layout2.gif",
"layout3.gif",
"layout4.gif",
"layout5.gif",
"layout6.gif",
"layout7.gif",
"layout8.gif",
"man.jpg",
"search_on.gif",
"search_off.gif",
"sign.gif",
"tab_bg.gif",
"tab_bg_click.gif",
"td_bg.png",
"th_bg.png",
"th_bg2.png",
"tip_btn_level.gif",
"today.gif"
);

$arr_file[3] = array(
"adjust_table.js",
"array_del.js",
"check_input.js",
"chkAll_situModify.js",
"chk_all.js",
"chk_count_zeroN.js",
"chk_delN.js",
"chk_levelModify.js",
"chkAll_levelModify.js",
"chk_moveN.js",
"chk_null.js",
"chk_readN.js",
"chk_readN_no.js",
"chk_situModify.js",
"client_position.js",
"code_re.js",
"conf_style.js",
"cookie_listN.js",
"display_sms.js",
"displayOpt.js",
"displayOpt_all.js",
"format_byte.js",
"items_unlink.js",
"link_itemDisplay.js",
"Mix_text.js",
"only_en.js",
"pop_center.js",
"tableruller.js",
"trBgOver.js"
);

$arr_file[4] = array(
"f_af_attachFileUpload.php",
"f_af_formImgUpload.php",
"f_af_formStyle.php",
"f_af_formThumbUpload.php",
"f_af_order_no_set.php",
"f_af_upload_forms.php",
"f_get_afTABLE.php",
"f_get_afTABLE1.php",
"f_get_afTABLE2.php",
"f_get_afTABLE3.php",
"f_get_afTABLE4.php",
"f_get_afTABLE5.php",
"f_get_afTABLE7.php",
"f_get_af_detailTxt.php",
"f_get_af_dir.php",
"f_get_af_formStyle.php",
"f_yagoseng_hetda.php",
"fm_formSelectBox2.php",
"fm_groupSelectBox2.php"
);

$arr_file[5] = array(
"adminKey.gif",
"bg_ess.gif",
"blank11.gif",
"box.jpg",
"box_s.jpg",
"btn_down.gif",
"btn_down_over.gif",
"btn_next.gif",
"btn_pre.gif",
"btn_up.gif",
"btn_up_over.gif",
"category.gif",
"date.gif",
"dokdo.gif",
"entry.gif",
"err_pp_cli.gif",
"ex-itemTip1.gif",
"folder.gif",
"html.gif",
"incorrect.jpg",
"link_item.gif",
"logo.gif",
"man.gif",
"more.gif",
"noimage.gif",
"phone.gif",
"q.gif",
"search_zipcode.gif",
"setup1.gif",
"work.gif",
);

$arr_file[6] = array(
"change_form.js",
"check_input.js",
"chk_all_item.js",
"chk_checkBox.js",
"chk_null.js",
"display_css.js",
"display_upload.js",
"dummys_input.js",
"eq_client.js",
"estimate_calculator.js",
"formmail_calculator.js",
"formmail_mixdata.js",
"formmail_onloadSum.js",
"mix_shipTo.js",
"money_china.js",
"money_kr.js",
"number_format.js",
"only_en.js",
"pop_center.js",
"pop_img.js",
"roll_table.js"
);

$arr_file[7] = array(
"addform_scheme.php",
"authentication.php",
"C_CONNECT.php",
"dbconnect.php",
"define_table.php",
"function.php",
"Func_textlicense.php",
"lib.php",
"level_alert.php",
"level.ini"
);

$arr_file[8] = array(
"language.php"
);

$arr_file[9] = array(
"btnAdmin_0.gif",
"btnAdmin_1.gif",
"btnAdmin_2.gif",
"btnForm_0.gif",
"btnForm_1.gif",
"btnForm_2.gif",
"btn_formBackup_1.gif",
"btn_formBackup_over.gif",
"btn_topup_1.gif",
"btn_topup_over.gif",
"btnGroup_0.gif",
"btnGroup_1.gif",
"btnGroup_2.gif",
"btnLayout_0.gif",
"btnLayout_2.gif",
"btnOrder_0.gif",
"btnOrder_1.gif",
"btnOrder_2.gif",
"btnStaff_0.gif",
"btnStaff_2.gif",
"btn_top1.gif",
"btn_top1_over.gif",
"btn_top2.gif",
"btn_top2_over.gif",
"btn_top3.gif",
"btn_top3_over.gif",
"btn_top5.gif",
"btn_top5_over.gif",
"btn_top7.gif",
"btn_top7_over.gif",
"btn_top8.gif",
"btn_top8_over.gif",
"btn_top9.gif",
"btn_top9_over.gif",
"btn_topbackup.gif",
"btn_topbackup_over.gif",
"btn_topHelp.gif",
"btn_topHelp_over.gif",
"myaccount.gif"
);

$arr_file[10] = array(
"language.php"
);

$arr_file[11] = array(
"btnAdmin_0.gif",
"btnAdmin_1.gif",
"btnAdmin_2.gif",
"btnForm_0.gif",
"btnForm_1.gif",
"btnForm_2.gif",
"btn_formBackup_1.gif",
"btn_formBackup_over.gif",
"btn_topup_1.gif",
"btn_topup_over.gif",
"btnGroup_0.gif",
"btnGroup_1.gif",
"btnGroup_2.gif",
"btnLayout_0.gif",
"btnLayout_2.gif",
"btnOrder_0.gif",
"btnOrder_1.gif",
"btnOrder_2.gif",
"btnStaff_0.gif",
"btnStaff_2.gif",
"btn_top1.gif",
"btn_top1_over.gif",
"btn_top2.gif",
"btn_top2_over.gif",
"btn_top3.gif",
"btn_top3_over.gif",
"btn_top5.gif",
"btn_top5_over.gif",
"btn_top7.gif",
"btn_top7_over.gif",
"btn_top8.gif",
"btn_top8_over.gif",
"btn_top9.gif",
"btn_top9_over.gif",
"btn_topbackup.gif",
"btn_topbackup_over.gif",
"btn_topHelp.gif",
"btn_topHelp_over.gif",
"myaccount.gif"
);

$arr_file[12] = array(
"bg.gif",
"calendar.js",
"calendar.php",
"calendar_pop.js",
"icon_calendar.gif",
"icon_next.gif",
"icon_prew.gif"
);

$arr_file[13] = array(
"jquery-latest.js",
"obj.dragble.js",
"ui.base.js",
"ui.sortable.js"
);

$arr_file[14] = array(
"class.EmmaSMS.php",
"example.php",
"original_name.html",
"sms_toAdmin.php",
"sms_toClient.php",
"xmlrpc.inc.php"
);

$arr_file[15] = array(
"design_formmail.php",
"design_orderform.php",
"detailExp.php",
"footer.html",
"form.html",
"header.html",
"index.php",
"index_list.php",
"left.html",
"list.html",
"right.html",
"style.css"
);

$arr_file[16] = array(
"address.png",
"bank.gif",
"bg_title.gif",
"btn_bg.gif",
"btn_zipcode.gif",
"formTab.gif",
"head_menuBg.gif",
"hot.gif",
"new.gif",
"phone.gif",
"sitecontens.gif",
"submit.gif",
"th_bg.png"
);

$arr_file[17] = array(
"estimate.html",
"formmail.html",
"order.html",
"print.css"
);

$arr_file[18] = array(
"af_total_price.php",
"client_formmail.php",
"client_orderform.php",
"f_af_esti_loop.php",
"f_af_od_loop.php",
"item_loop_formmail.php",
"item_loop_orderform.php",
"skin_function.php"
);

$arr_file[19] = array(
"chk_plugin.html",
"common_return.php",
"index.html",
"index.php",
"mod.html",
"mod_admin.html",
"order.html",
"pp_ax_hub.php",
"pp_ax_hub_lib.php",
"proc_win.html",
"result.php"
);

$arr_file[20] = array(
"sample.css"
);

$arr_file[21] = array(
"bullet.gif",
"dot_line.gif",
"KcpLogo.jpg",
"kcp_ing.gif",
"kcp_plug_bg01.gif",
"kcp_plug_img01.gif",
"kcp_plug_img02.gif",
"kcp_plug_img03.gif",
"kcp_plug_img04.gif",
"kcp_plug_img05.gif",
"processing.gif"
);

$arr_file[22] = array(
"pp_cli"
);

$arr_file[23] = array(
"AuthFrm.php",
"backUrl.php",
"dummy.php",
"index.php",
"KEscrowRcv.html",
"KSPayRcv.php",
"result.php"
);

$arr_file[24] = array(
"zipcode.php",
"zipcode0.php",
"zipcode1.php",
"zipcode2.php",
"zipcode3.php",
"zipcode4.php",
"zipcode5.php",
"zipcode6.php",
"zipcode7.php",
"zipcode8.php",
"zipcode9.php",
"zipcode10.php",
"zipcode11.php",
"zipcode12.php",
"zipcode13.php",
"zipcode14.php",
"zipcode15.php",
"zipcode16.php",
"zipcode17.php",
"zipcode18.php",
"zipcode19.php",
"zipcode20.php",
"zipcode21.php",
"zipcode22.php",
"zipcode23.php",
"zipcode24.php",
"zipcode25.php",
"zipcode26.php",
"zipcode27.php",
"zipcode28.php",
"zipcode29.php",
"zipcode30.php",
"zipcode31.php",
"zipcode32.php",
"zipcode33.php",
"zipcode34.php",
"zipcode35.php",
"zipcode36.php",
"zipcode37.php",
"zipcode38.php",
"zipcode39.php",
"zipcode40.php",
"zipcode41.php",
"zipcode42.php",
"zipcode43.php",
"zipcode44.php",
"zipcode45.php",
"zipcode46.php",
"zipcode47.php",
"zipcode48.php",
"zipcode49.php",
"zipcode50.php"
);

$arr_file[25] = array(
"foot.html",
"global.css",
"head.html",
"index.html",
"progress.html"
);


echo "<h1>애드폼 설치파일 전수검사 <span style='color:#999;font-size:15px'>STEP 1/5</span></h1>";
echo "<p>애드폼 설치를 시작합니다. 이 단계에서는 정상적인 설치와 프로그램 실행에 필요한 파일들이 모두 존재하고 적합한지 검사합니다.</p>";	
echo "<p>이미 검사를 수행하였다면, 바로 설치하기 버튼을 클릭하여 퍼미션 검사를 하십시오.</p>";	
echo "<table style='width:300px;margin-top:20px;'><tr><td>";
echo "<form name='inspect' method='post' action=''>
		<input type='hidden' name='mode' value='inspect'><input type='submit' value='검사하기' style='width:100px;height:30px;'>
	 </form>
	 </td><td>";
echo "<form name='form1' method='post' action='setup1.php' onsubmit='return false'>
		<input type='hidden' name='mode' value='setup'>
		<input type='button' value='바로설치'  style='width:100px;height:30px;' onclick='chk_license(this.form)'>		
	  </form>
	";
echo "</td></tr></table><hr>";

function f_inspection()
{
	global $arr_dir;
	global $arr_file;
	$n_dir_ess = 0;
	$n_dir_lose = 0;
	$n_file_ess = 0;
	$n_file_lose = 0;
	$n_size_error = 0;
	echo "<script type='text/javascript'>document.getElementById('fixed_div').style.display='inline';</script>";

	for($i=0;$i < count($arr_dir);$i++)
	{
		echo "<h3><img src='imgs/folder.gif' alt='폴더' style='vertical-align:middle'> ".$arr_dir[$i]."</h3>";
		echo "<ul>";
		echo "<li>";	
		for($z=0;$z < count($arr_file[$i]);$z++)
			{
			if(file_exists($arr_dir[$i].$arr_file[$i][$z]))
				{
				//echo "<li>";			
				echo "<img src='chk_ok.gif' style='vertical-align:middle' alt='exists'>";				
				echo "".$arr_file[$i][$z];
				if(filesize($arr_dir[$i].$arr_file[$i][$z]) == 0)
					{
					echo "<span style='color:red;font-size:15px;font-weight:bold'>[".filesize($arr_dir[$i].$arr_file[$i][$z])."]</span>&nbsp;&nbsp;";
					$n_size_error++;
					}
				else
					{
					echo "<span style='font-size:0.8em;color:#c0c0c0;'>[".filesize($arr_dir[$i].$arr_file[$i][$z])."]</span>&nbsp;&nbsp;";					
					}
				//echo "</li>";
			
				$n_file_ess++;	
				flush(); 
				usleep(10000);
				}
			else 
				{
				//echo "<li>";
				echo "<img src='chk_lose.gif' style='vertical-align:middle' alt='loss'>";
				echo "<span style='color:#ff6600'>".$arr_file[$i][$z]."</span>";
				//echo "</li>";
				$n_file_lose++;
				$n_file_ess++;	
				flush(); 
				usleep(10000);
				}	
			echo "<script type='text/javascript'>scrollBy(0,500)</script>";	
			}
		echo "</li>";	
		echo "</ul>";
		echo "<script type='text/javascript'>document.getElementById('progresTd".$i."').style.backgroundColor='#007a00';</script>";
	}//for 문 끝
	echo "<hr>";
	echo "<h2>결과 보고(report)</h2>";
	echo "<h4>애드폼 설치에 필요한 파일 ".$n_file_ess."개 중 ".$n_file_lose." 개의 파일이 누락되었습니다.</h4>";

	if($n_file_lose > 0) 
		{
		echo "<span style='color:red;padding-left:5px;'>정상적인 설치와 실행에 문제가 있을 수 있으니, 위에서 누락된 파일을 확인하고, 업로드 하신 후 설치를 하십시오.</span>";	
		}
	else  
		{
		echo "<span style='color:blue;padding-left:5px;'>필요한 파일들이 모두 업로드 되어 있습니다.</span>";		
		}

	if($n_size_error > 0) 
		{
		echo "<div style='padding-left:5px;'><span style='color:red'>파일사이즈가 0 byte 인것이 <strong>$n_size_error</strong> 개 있습니다. 위에서 파일이름 옆에 <strong>[0]</strong> 이라고 빨갛게 표시된, 해당파일을 다시 올려주세요</div>";		
		}

	echo "<script type='text/javascript'>document.getElementById('fixed_div').style.display='none';</script>";
	echo "<div><form name='form2' method='post' action='setup1.php' onsubmit='return false'>";
	echo "<input type='hidden' name='mode' value='setup'>";
	echo "<input type='button' value='설치하기(setup)' style='widht:100px;height:30px;'onclick='chk_license(this.form)'>";
	echo "</form></div>";
	echo "<script type='text/javascript'>scrollBy(0,500)</script>";		
}

if($_POST['mode'] == "inspect") f_inspection();


?> 

</body>
</html>