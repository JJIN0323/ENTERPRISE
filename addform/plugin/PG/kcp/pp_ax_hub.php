<?	
	### �ֵ��� �ֹ��� ������ȣ ���� start
	include_once("../../../lib/db_ini.php");		  //DB ��������   
	include_once("../../../lib/db_tblname.php");     //������ ���̺� �̸�
	include_once("../../../lib/dbconnect.php");      //DB ����
	define("TABLE4","".db_tblname."_order_table");	
	
	
	//function f_af_order_no_set()
	//{
	$headtoken = "m-";
	
	$res_forOrderNo = mysql_query("select * from ".TABLE4." order by no desc limit 1");		 //�������̺��� ���� �ֱ��� �̾ƿ�
	$row_forOrderNo = mysql_fetch_array($res_forOrderNo);				 //�� ����� �迭

	if($row_forOrderNo)															 //���������� ���� ��
		{
		$last_af_order_no = explode("-",$row_forOrderNo[1]);					 //����� �����ڷ� ���� �迭ȭ

		if($last_af_order_no[1] != date("Ymd"))										 
			{
			$af_order_no_tail = "0001";											 //������ ���������� ���� �� �Ĺ� ����
			}
		else{																		 
			$af_order_no_tail = $last_af_order_no[2] + 1;	
			$mathN = 4;
			$cnt_af_order_no_tail = strlen($af_order_no_tail);
			$addZero = "0";
			for($i = $cnt_af_order_no_tail; $i < $mathN;$i++)
				{
				$af_order_no_tail = $addZero.$af_order_no_tail;					 //������ ���������� ���� �� �Ĺ�����
				}

			}
		 $af_order_no = $headtoken.date("Ymd")."-".$af_order_no_tail;			 //������ȣ ����
		}
	else $af_order_no = $headtoken.date("Ymd")."-0001";							 //���������� �ϳ��� ���� �� ����
	//$arr = array();
	//$arr["af_order_no"] = $af_order_no;
	//return $arr;
	//}
	### �ֵ��� �ֹ��� ������ȣ ���� end
?>
<?
    /* ============================================================================== */
    /* =   PAGE : ���� ��û �� ��� ó�� PAGE                                       = */
    /* = -------------------------------------------------------------------------- = */
    /* =   ���� �߻��� �Ʒ��� �ּҿ��� ��ȸ�Ͻñ� �ٶ��ϴ�.                         = */
    /* =   http://testpay.kcp.co.kr/pgsample/FAQ/search_error.jsp                   = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2006   KCP Inc.   All Rights Reserverd.                   = */
    /* ============================================================================== */
?>
<?
    /* ============================================================================== */
    /* =   01. ���� ������ �¾� (��ü�� �°� ����)                                  = */
    /* = -------------------------------------------------------------------------- = */
	$g_conf_home_dir = getcwd()."/payplus";
    //$g_conf_home_dir  = "payplus"; // BIN ������ �Է�
	//$g_conf_home_dir  = "/home/kcpuser/eschae/mywww/v6_ax_hub_new/kcp/payplus"; // BIN ������ �Է�
    $g_conf_log_level = "3";                      // ����Ұ�
    $g_conf_pa_url    = "paygw.kcp.co.kr";		  // real url : paygw.kcp.co.kr , test url : testpaygw.kcp.co.kr
    $g_conf_pa_port   = "8090";                   // ��Ʈ��ȣ , ����Ұ�
    $g_conf_mode      = 0;                        // ����Ұ�

    require "pp_ax_hub_lib.php";                  // library [�����Ұ�]
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   02. ���� ��û ���� ����                                                  = */
    /* = -------------------------------------------------------------------------- = */
    $site_cd        = $_POST[ "site_cd"        ]; // ����Ʈ �ڵ�
    $site_key       = $_POST[ "site_key"       ]; // ����Ʈ Ű
    $req_tx         = $_POST[ "req_tx"         ]; // ��û ����
    $cust_ip        = getenv( "REMOTE_ADDR"    ); // ��û IP
    //$ordr_idxx      = $_POST[ "ordr_idxx"      ]; // ���θ� �ֹ���ȣ
	$ordr_idxx      = $af_order_no; // ���θ� �ֹ���ȣ
    $good_name      = $_POST[ "good_name"      ]; // ��ǰ��
    /* = -------------------------------------------------------------------------- = */
    $good_mny       = $_POST[ "good_mny"       ]; // ���� �ѱݾ�
    $tran_cd        = $_POST[ "tran_cd"        ]; // ó�� ����
    /* = -------------------------------------------------------------------------- = */
    $res_cd         = "";                         // �����ڵ�
    $res_msg        = "";                         // ����޽���
    $tno            = $_POST[ "tno"            ]; // KCP �ŷ� ���� ��ȣ
    /* = -------------------------------------------------------------------------- = */
    $buyr_name      = $_POST[ "buyr_name"      ]; // �ֹ��ڸ�
    $buyr_tel1      = $_POST[ "buyr_tel1"      ]; // �ֹ��� ��ȭ��ȣ
    $buyr_tel2      = $_POST[ "buyr_tel2"      ]; // �ֹ��� �ڵ��� ��ȣ
    $buyr_mail      = $_POST[ "buyr_mail"      ]; // �ֹ��� E-mail �ּ�
    /* = -------------------------------------------------------------------------- = */
    $bank_name      = "";                         // �����
    $bank_code      = "";                         // �����ڵ�
    $bank_issu      = $_POST[ "bank_issu"      ]; // ������ü ���񽺻�
    /* = -------------------------------------------------------------------------- = */
    $mod_type       = $_POST[ "mod_type"       ]; // ����TYPE VALUE ������ҽ� �ʿ�
    $mod_desc       = $_POST[ "mod_desc"       ]; // �������
    /* = -------------------------------------------------------------------------- = */
    $use_pay_method = $_POST[ "use_pay_method" ]; // ���� ���
    $epnt_issu      = $_POST[ "epnt_issu"      ]; //����Ʈ(OKĳ����,��������Ʈ)
    $bSucc          = "";                         // ��ü DB ó�� ���� ����
    /* = -------------------------------------------------------------------------- = */
    $card_cd        = "";                         // �ſ�ī�� �ڵ�
    $card_name      = "";                         // �ſ�ī�� ��
    $app_time       = "";                         // ���νð� (��� ���� ���� ����)
    $app_no         = "";                         // �ſ�ī�� ���ι�ȣ
    $noinf          = "";                         // �ſ�ī�� ������ ����
    $quota          = "";                         // �ſ�ī�� �Һΰ���
    $bankname       = "";                         // �����
    $depositor      = "";                         // �Ա� ���� ������ ����
    $account        = "";                         // �Ա� ���� ��ȣ
    /* = -------------------------------------------------------------------------- = */
    $amount         = "";                         // KCP ���� �ŷ� �ݾ�
    /* = -------------------------------------------------------------------------- = */
    $add_pnt        = "";                         // �߻� ����Ʈ
	$use_pnt        = "";                         // ��밡�� ����Ʈ
	$rsv_pnt        = "";                         // ���� ����Ʈ
	$pnt_app_time   = "";                         // ���νð�
	$pnt_app_no     = "";                         // ���ι�ȣ
	$pnt_amount     = "";                         // �����ݾ� or ���ݾ�
    /* = -------------------------------------------------------------------------- = */
    $cash_yn        = $_POST[ "cash_yn"        ]; // ���ݿ����� ��� ����
    $cash_authno    = "";                         // ���� ������ ���� ��ȣ
    $cash_tr_code   = $_POST[ "cash_tr_code"   ]; // ���� ������ ���� ����
    $cash_id_info   = $_POST[ "cash_id_info"   ]; // ���� ������ ��� ��ȣ
    /* ============================================================================== */

    /* ============================================================================== */
    /* =   03. �ν��Ͻ� ���� �� �ʱ�ȭ                                              = */
    /* = -------------------------------------------------------------------------- = */
    /* =       ������ �ʿ��� �ν��Ͻ��� �����ϰ� �ʱ�ȭ �մϴ�.                     = */
    /* = -------------------------------------------------------------------------- = */
    $c_PayPlus = new C_PP_CLI;

    $c_PayPlus->mf_clear();
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   04. ó�� ��û ���� ����, ����                                            = */
    /* = -------------------------------------------------------------------------- = */

    /* = -------------------------------------------------------------------------- = */
    /* =   04-1. ���� ��û                                                          = */
    /* = -------------------------------------------------------------------------- = */
    if ( $req_tx == "pay" )
    {
        if ( $bank_issu == "SCOB" ) // ����ý��� ������ü ��
        {
            $tran_cd = "00200000";

            $c_PayPlus->mf_set_modx_data( "tno",           $tno       ); // KCP ���ŷ� �ŷ���ȣ
            $c_PayPlus->mf_set_modx_data( "mod_type",      "STAQ"     ); // ���ŷ� ���� ��û ����
            $c_PayPlus->mf_set_modx_data( "mod_ip",        $cust_ip   ); // ���� ��û�� IP
            $c_PayPlus->mf_set_modx_data( "mod_ordr_idxx", $ordr_idxx ); // �ֹ���ȣ
        }
        else
        {
            $c_PayPlus->mf_set_encx_data( $_POST[ "enc_data" ], $_POST[ "enc_info" ] );
        }
    }

    /* = -------------------------------------------------------------------------- = */
    /* =   04-2. ���/���� ��û                                                     = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $req_tx == "mod" )
    {
        $tran_cd = "00200000";

        $c_PayPlus->mf_set_modx_data( "tno",      $tno      ); // KCP ���ŷ� �ŷ���ȣ
        $c_PayPlus->mf_set_modx_data( "mod_type", $mod_type ); // ���ŷ� ���� ��û ����
        $c_PayPlus->mf_set_modx_data( "mod_ip",   $cust_ip  ); // ���� ��û�� IP
        $c_PayPlus->mf_set_modx_data( "mod_desc", $mod_desc ); // ���� ����
    }

    /* = -------------------------------------------------------------------------- = */
    /* =   04-3. ����                                                               = */
    /* = -------------------------------------------------------------------------- = */
    if ( $tran_cd != "" )
    {
        $c_PayPlus->mf_do_tx( $trace_no, $g_conf_home_dir, $site_cd, $site_key, $tran_cd, "",
                              $g_conf_pa_url, $g_conf_pa_port, "payplus_cli_slib", $ordr_idxx,
                              $cust_ip, $g_conf_log_level, 0, $g_conf_mode );
    }
    else
    {
        $c_PayPlus->m_res_cd  = "9562";
        $c_PayPlus->m_res_msg = "���� ���� TRAN_CD[" . $tran_cd . "]";
    }

    $res_cd  = $c_PayPlus->m_res_cd;  // ��� �ڵ�
    $res_msg = $c_PayPlus->m_res_msg; // ��� �޽���
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   05. ���� ��� ó��                                                       = */
    /* = -------------------------------------------------------------------------- = */
    if ( $req_tx == "pay" )
    {
        if( $res_cd == "0000" )
        {
            $tno    = $c_PayPlus->mf_get_res_data( "tno"    ); // KCP �ŷ� ���� ��ȣ
            $amount = $c_PayPlus->mf_get_res_data( "amount" ); // KCP ���� �ŷ� �ݾ�

    /* = -------------------------------------------------------------------------- = */
    /* =   05-1. �ſ�ī�� ���� ��� ó��                                            = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "100000000000" )
            {
                $card_cd   = $c_PayPlus->mf_get_res_data( "card_cd"   ); // ī�� �ڵ�
                $card_name = $c_PayPlus->mf_get_res_data( "card_name" ); // ī�� ����
                $app_time  = $c_PayPlus->mf_get_res_data( "app_time"  ); // ���� �ð�
                $app_no    = $c_PayPlus->mf_get_res_data( "app_no"    ); // ���� ��ȣ
                $noinf     = $c_PayPlus->mf_get_res_data( "noinf"     ); // ������ ���� ( 'Y' : ������ )
                $quota     = $c_PayPlus->mf_get_res_data( "quota"     ); // �Һ� ����

                /* = -------------------------------------------------------------- = */
                /* =   05-1.1. ���հ���(����Ʈ+�ſ�ī��) ���� ��� ó��               = */
                /* = -------------------------------------------------------------- = */
                if ( $epnt_issu == "SCSK" || $epnt_issu == "SCWB" )
                {
                    $pnt_amount   = $c_PayPlus->mf_get_res_data ( "pnt_amount"   );
	                $pnt_app_time = $c_PayPlus->mf_get_res_data ( "pnt_app_time" );
	                $pnt_app_no   = $c_PayPlus->mf_get_res_data ( "pnt_app_no"   );
	                $add_pnt      = $c_PayPlus->mf_get_res_data ( "add_pnt"      );
                    $use_pnt      = $c_PayPlus->mf_get_res_data ( "use_pnt"      );
                    $rsv_pnt      = $c_PayPlus->mf_get_res_data ( "rsv_pnt"      );
                }
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-2. ������ü ���� ��� ó��                                            = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "010000000000" )
            {
                $bank_name = $c_PayPlus->mf_get_res_data( "bank_name"  );  // �����
                $bank_code = $c_PayPlus->mf_get_res_data( "bank_code"  );  // �����ڵ�
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-3. ������� ���� ��� ó��                                            = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "001000000000" )
            {
                $bankname  = $c_PayPlus->mf_get_res_data( "bankname"  ); // �Ա��� ���� �̸�
                $depositor = $c_PayPlus->mf_get_res_data( "depositor" ); // �Ա��� ���� ������
                $account   = $c_PayPlus->mf_get_res_data( "account"   ); // �Ա��� ���� ��ȣ
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-4. ����Ʈ ���� ��� ó��                                               = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "000100000000" )
            {
                $pnt_amount   = $c_PayPlus->mf_get_res_data( "pnt_amount"   );
	            $pnt_app_time = $c_PayPlus->mf_get_res_data( "pnt_app_time" );
	            $pnt_app_no   = $c_PayPlus->mf_get_res_data( "pnt_app_no"   );
	            $add_pnt      = $c_PayPlus->mf_get_res_data( "add_pnt"      );
                $use_pnt      = $c_PayPlus->mf_get_res_data( "use_pnt"      );
                $rsv_pnt      = $c_PayPlus->mf_get_res_data( "rsv_pnt"      );
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-5. �޴��� ���� ��� ó��                                              = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "000010000000" )
            {
                $app_time = $c_PayPlus->mf_get_res_data( "hp_app_time"  ); // ���� �ð�
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-6. ��ǰ�� ���� ��� ó��                                              = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "000000001000" )
            {
                $app_time = $c_PayPlus->mf_get_res_data( "tk_app_time"  ); // ���� �ð�
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-7. Ƽ�Ӵ� ���� ��� ó��                                              = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "000000000100" )
            {
                $app_time = $c_PayPlus->mf_get_res_data("app_time"      ); // ���νð�
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-8. ARS ���� ��� ó��                                                 = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "000000000010" )
            {
                $app_time = $c_PayPlus->mf_get_res_data( "ars_app_time" ); // ���� �ð�
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-9. ���ݿ����� ��� ó��                                               = */
    /* = -------------------------------------------------------------------------- = */
            if ( $cash_yn == "Y" )
            {
                $cash_authno  = $c_PayPlus->mf_get_res_data( "cash_authno"  ); // ���� ������ ���� ��ȣ
            }

	/* = -------------------------------------------------------------------------- = */
    /* =   05-10. ���� ����� ��ü ��ü������ DB ó�� �۾��Ͻô� �κ��Դϴ�.         = */
    /* = -------------------------------------------------------------------------- = */
    /* =         ���� ����� DB �۾� �ϴ� �������� ���������� ���ε� �ǿ� ����      = */
    /* =         DB �۾��� �����Ͽ� DB update �� �Ϸ���� ���� ���, �ڵ�����       = */
    /* =         ���� ��� ��û�� �ϴ� ���μ����� �����Ǿ� �ֽ��ϴ�.                = */
    /* =         DB �۾��� ���� �� ���, bSucc ��� ����(String)�� ���� "false"     = */
    /* =         �� ������ �ֽñ� �ٶ��ϴ�. (DB �۾� ������ ��쿡�� "false" �̿��� = */
    /* =         ���� �����Ͻø� �˴ϴ�.)                                           = */
    /* =         amount(KCP���� �ŷ��ݾ�)�� ��ü�� DB ó���Ͻ� �ݾ��� �ٸ� �����   = */
    /* =         �� ��ƾ�� �߰� �ϼż� �ٸ� ��� ���������� "false"�� �����Ͽ�    = */
    /* =         �ֽñ� �ٶ��ϴ�.                                                   = */
    /* = -------------------------------------------------------------------------- = */
            $bSucc = ""; // DB �۾� ���� �Ǵ� �ݾ� ����ġ�� ��� "false" �� ����

    /* = -------------------------------------------------------------------------- = */
    /* =   05-11. DB �۾� ������ ��� �ڵ� ���� ���                                 = */
    /* = -------------------------------------------------------------------------- = */
            if ( $bSucc == "false" )
            {
                $c_PayPlus->mf_clear();

                $tran_cd = "00200000";

                $c_PayPlus->mf_set_modx_data( "tno",      $tno                         );  // KCP ���ŷ� �ŷ���ȣ
                $c_PayPlus->mf_set_modx_data( "mod_type", "STSC"                       );  // ���ŷ� ���� ��û ����
                $c_PayPlus->mf_set_modx_data( "mod_ip",   $cust_ip                     );  // ���� ��û�� IP
                $c_PayPlus->mf_set_modx_data( "mod_desc", "��� ó�� ���� - ���������� ��� ��û" );  // ���� ����

                $c_PayPlus->mf_do_tx( $tno,  $g_conf_home_dir, $site_cd,
                                      $site_key,  $tran_cd,    "",
                                      $g_conf_pa_url,  $g_conf_pa_port,  "payplus_cli_slib",
                                      $ordr_idxx, $cust_ip,    $g_conf_log_level,
                                      0,    $g_conf_mode );

                $res_cd  = $c_PayPlus->m_res_cd;
                $res_msg = $c_PayPlus->m_res_msg;
            }
        } // End of [res_cd = "0000"]

    /* = -------------------------------------------------------------------------- = */
    /* =   05-12. ���� ���и� ��ü ��ü������ DB ó�� �۾��Ͻô� �κ��Դϴ�.         = */
    /* = -------------------------------------------------------------------------- = */
        else
        {
        }
    }
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   06. ���/���� ��� ó��                                                  = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $req_tx == "mod" )
    {
		//��ҽ� �������̺� pay_cancel�ʵ尪 off
		mysql_query("update ".TABLE4." set pay_cancel='off' where tno=$tno");		 		
    } // End of Process
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   07. �� ���� �� ��������� ȣ��                                           = */
    /* ============================================================================== */
?>
    <html>
    <head>
    <script>
        function goResult()
        {
            var openwin = window.open( 'proc_win.html', 'proc_win', '' );
            document.pay_info.submit();
            openwin.close();
        }
    </script>
    </head>
    <body onload="goResult()">
    <form name="pay_info" method="post" action="./result.php">
		<!-- result.html ���� �����Ŀ� ���� �θ�â �׼� �ٸ��� �ϱ� ���� �����ʵ� -->		
		<input type='hidden' name='type'          value='<?php echo $_POST[type];?>'>
		<!-- kcp �����ʵ�  -->
        <input type="hidden" name="req_tx"            value="<?=$req_tx?>">            <!-- ��û ���� -->
        <input type="hidden" name="use_pay_method"    value="<?=$use_pay_method?>">    <!-- ����� ���� ���� -->
        <input type="hidden" name="bSucc"             value="<?=$bSucc?>">             <!-- ���θ� DB ó�� ���� ���� -->

        <input type="hidden" name="res_cd"            value="<?=$res_cd?>">            <!-- ��� �ڵ� -->
        <input type="hidden" name="res_msg"           value="<?=$res_msg?>">           <!-- ��� �޼��� -->
        <input type="hidden" name="ordr_idxx"         value="<?=$ordr_idxx?>">         <!-- �ֹ���ȣ -->
        <input type="hidden" name="tno"               value="<?=$tno?>">               <!-- KCP �ŷ���ȣ -->
        <input type="hidden" name="good_mny"          value="<?=$good_mny?>">          <!-- �����ݾ� -->
        <input type="hidden" name="good_name"         value="<?=$good_name?>">         <!-- ��ǰ�� -->
        <input type="hidden" name="buyr_name"         value="<?=$buyr_name?>">         <!-- �ֹ��ڸ� -->
        <input type="hidden" name="buyr_tel1"         value="<?=$buyr_tel1?>">         <!-- �ֹ��� ��ȭ��ȣ -->
        <input type="hidden" name="buyr_tel2"         value="<?=$buyr_tel2?>">         <!-- �ֹ��� �޴�����ȣ -->
        <input type="hidden" name="buyr_mail"         value="<?=$buyr_mail?>">         <!-- �ֹ��� E-mail -->

        <input type="hidden" name="card_cd"           value="<?=$card_cd?>">           <!-- ī���ڵ� -->
        <input type="hidden" name="card_name"         value="<?=$card_name?>">         <!-- ī��� -->
        <input type="hidden" name="app_time"          value="<?=$app_time?>">          <!-- ���νð� -->
        <input type="hidden" name="app_no"            value="<?=$app_no?>">            <!-- ���ι�ȣ -->
        <input type="hidden" name="quota"             value="<?=$quota?>">             <!-- �Һΰ��� -->

        <input type="hidden" name="bank_name"         value="<?=$bank_name?>">         <!-- ����� -->
        <input type="hidden" name="bank_0code"         value="<?=$bank_code?>">         <!-- �����ڵ� -->

        <input type="hidden" name="bankname"          value="<?=$bankname?>">          <!-- �Ա� ���� -->
        <input type="hidden" name="depositor"         value="<?=$depositor?>">         <!-- �Աݰ��� ������ -->
        <input type="hidden" name="account"           value="<?=$account?>">           <!-- �Աݰ��� ��ȣ -->

        <input type="hidden" name="epnt_issu"         value="<?=$epnt_issu?>">         <!-- ����Ʈ ���񽺻� -->
		<input type="hidden" name="pnt_app_time"      value="<?=$pnt_app_time?>">      <!-- ���νð� -->
        <input type="hidden" name="pnt_app_no"        value="<?=$pnt_app_no?>">        <!-- ���ι�ȣ -->
        <input type="hidden" name="pnt_amount"        value="<?=$pnt_amount?>">        <!-- �����ݾ� or ���ݾ� -->
        <input type="hidden" name="add_pnt"           value="<?=$add_pnt?>">           <!-- �߻� ����Ʈ -->
        <input type="hidden" name="use_pnt"           value="<?=$use_pnt?>">           <!-- ��밡�� ����Ʈ -->
        <input type="hidden" name="rsv_pnt"           value="<?=$rsv_pnt?>">           <!-- ���� ����Ʈ -->

        <input type="hidden" name="cash_yn"           value="<?=$cash_yn?>">            <!-- ���ݿ����� ��� ���� -->
        <input type="hidden" name="cash_authno"       value="<?=$cash_authno?>">        <!-- ���� ������ ���� ��ȣ -->
        <input type="hidden" name="cash_tr_code"      value="<?=$cash_tr_code?>">       <!-- ���� ������ ���� ���� -->
        <input type="hidden" name="cash_id_info"      value="<?=$cash_id_info?>">       <!-- ���� ������ ��� ��ȣ -->
    </form>
    </body>
    </html>
