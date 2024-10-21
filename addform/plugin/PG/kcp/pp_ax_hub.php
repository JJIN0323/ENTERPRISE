<?	
	### 애드폼 주문서 접수번호 셋팅 start
	include_once("../../../lib/db_ini.php");		  //DB 접속정보   
	include_once("../../../lib/db_tblname.php");     //생성한 테이블 이름
	include_once("../../../lib/dbconnect.php");      //DB 연결
	define("TABLE4","".db_tblname."_order_table");	
	
	
	//function f_af_order_no_set()
	//{
	$headtoken = "m-";
	
	$res_forOrderNo = mysql_query("select * from ".TABLE4." order by no desc limit 1");		 //접수테이블에서 가장 최근행 뽑아옴
	$row_forOrderNo = mysql_fetch_array($res_forOrderNo);				 //위 결과를 배열

	if($row_forOrderNo)															 //접수내역이 있을 때
		{
		$last_af_order_no = explode("-",$row_forOrderNo[1]);					 //년월일 구분자로 부터 배열화

		if($last_af_order_no[1] != date("Ymd"))										 
			{
			$af_order_no_tail = "0001";											 //같은날 접수내역이 없을 때 후미 정의
			}
		else{																		 
			$af_order_no_tail = $last_af_order_no[2] + 1;	
			$mathN = 4;
			$cnt_af_order_no_tail = strlen($af_order_no_tail);
			$addZero = "0";
			for($i = $cnt_af_order_no_tail; $i < $mathN;$i++)
				{
				$af_order_no_tail = $addZero.$af_order_no_tail;					 //같은날 접수내역이 있을 때 후미정의
				}

			}
		 $af_order_no = $headtoken.date("Ymd")."-".$af_order_no_tail;			 //접수번호 셋팅
		}
	else $af_order_no = $headtoken.date("Ymd")."-0001";							 //접수내역이 하나도 없을 때 셋팅
	//$arr = array();
	//$arr["af_order_no"] = $af_order_no;
	//return $arr;
	//}
	### 애드폼 주문서 접수번호 셋팅 end
?>
<?
    /* ============================================================================== */
    /* =   PAGE : 지불 요청 및 결과 처리 PAGE                                       = */
    /* = -------------------------------------------------------------------------- = */
    /* =   오류 발생시 아래의 주소에서 조회하시기 바랍니다.                         = */
    /* =   http://testpay.kcp.co.kr/pgsample/FAQ/search_error.jsp                   = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2006   KCP Inc.   All Rights Reserverd.                   = */
    /* ============================================================================== */
?>
<?
    /* ============================================================================== */
    /* =   01. 지불 데이터 셋업 (업체에 맞게 수정)                                  = */
    /* = -------------------------------------------------------------------------- = */
	$g_conf_home_dir = getcwd()."/payplus";
    //$g_conf_home_dir  = "payplus"; // BIN 절대경로 입력
	//$g_conf_home_dir  = "/home/kcpuser/eschae/mywww/v6_ax_hub_new/kcp/payplus"; // BIN 절대경로 입력
    $g_conf_log_level = "3";                      // 변경불가
    $g_conf_pa_url    = "paygw.kcp.co.kr";		  // real url : paygw.kcp.co.kr , test url : testpaygw.kcp.co.kr
    $g_conf_pa_port   = "8090";                   // 포트번호 , 변경불가
    $g_conf_mode      = 0;                        // 변경불가

    require "pp_ax_hub_lib.php";                  // library [수정불가]
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   02. 지불 요청 정보 설정                                                  = */
    /* = -------------------------------------------------------------------------- = */
    $site_cd        = $_POST[ "site_cd"        ]; // 사이트 코드
    $site_key       = $_POST[ "site_key"       ]; // 사이트 키
    $req_tx         = $_POST[ "req_tx"         ]; // 요청 종류
    $cust_ip        = getenv( "REMOTE_ADDR"    ); // 요청 IP
    //$ordr_idxx      = $_POST[ "ordr_idxx"      ]; // 쇼핑몰 주문번호
	$ordr_idxx      = $af_order_no; // 쇼핑몰 주문번호
    $good_name      = $_POST[ "good_name"      ]; // 상품명
    /* = -------------------------------------------------------------------------- = */
    $good_mny       = $_POST[ "good_mny"       ]; // 결제 총금액
    $tran_cd        = $_POST[ "tran_cd"        ]; // 처리 종류
    /* = -------------------------------------------------------------------------- = */
    $res_cd         = "";                         // 응답코드
    $res_msg        = "";                         // 응답메시지
    $tno            = $_POST[ "tno"            ]; // KCP 거래 고유 번호
    /* = -------------------------------------------------------------------------- = */
    $buyr_name      = $_POST[ "buyr_name"      ]; // 주문자명
    $buyr_tel1      = $_POST[ "buyr_tel1"      ]; // 주문자 전화번호
    $buyr_tel2      = $_POST[ "buyr_tel2"      ]; // 주문자 핸드폰 번호
    $buyr_mail      = $_POST[ "buyr_mail"      ]; // 주문자 E-mail 주소
    /* = -------------------------------------------------------------------------- = */
    $bank_name      = "";                         // 은행명
    $bank_code      = "";                         // 은행코드
    $bank_issu      = $_POST[ "bank_issu"      ]; // 계좌이체 서비스사
    /* = -------------------------------------------------------------------------- = */
    $mod_type       = $_POST[ "mod_type"       ]; // 변경TYPE VALUE 승인취소시 필요
    $mod_desc       = $_POST[ "mod_desc"       ]; // 변경사유
    /* = -------------------------------------------------------------------------- = */
    $use_pay_method = $_POST[ "use_pay_method" ]; // 결제 방법
    $epnt_issu      = $_POST[ "epnt_issu"      ]; //포인트(OK캐쉬백,복지포인트)
    $bSucc          = "";                         // 업체 DB 처리 성공 여부
    /* = -------------------------------------------------------------------------- = */
    $card_cd        = "";                         // 신용카드 코드
    $card_name      = "";                         // 신용카드 명
    $app_time       = "";                         // 승인시간 (모든 결제 수단 공통)
    $app_no         = "";                         // 신용카드 승인번호
    $noinf          = "";                         // 신용카드 무이자 여부
    $quota          = "";                         // 신용카드 할부개월
    $bankname       = "";                         // 은행명
    $depositor      = "";                         // 입금 계좌 예금주 성명
    $account        = "";                         // 입금 계좌 번호
    /* = -------------------------------------------------------------------------- = */
    $amount         = "";                         // KCP 실제 거래 금액
    /* = -------------------------------------------------------------------------- = */
    $add_pnt        = "";                         // 발생 포인트
	$use_pnt        = "";                         // 사용가능 포인트
	$rsv_pnt        = "";                         // 적립 포인트
	$pnt_app_time   = "";                         // 승인시간
	$pnt_app_no     = "";                         // 승인번호
	$pnt_amount     = "";                         // 적립금액 or 사용금액
    /* = -------------------------------------------------------------------------- = */
    $cash_yn        = $_POST[ "cash_yn"        ]; // 현금영수증 등록 여부
    $cash_authno    = "";                         // 현금 영수증 승인 번호
    $cash_tr_code   = $_POST[ "cash_tr_code"   ]; // 현금 영수증 발행 구분
    $cash_id_info   = $_POST[ "cash_id_info"   ]; // 현금 영수증 등록 번호
    /* ============================================================================== */

    /* ============================================================================== */
    /* =   03. 인스턴스 생성 및 초기화                                              = */
    /* = -------------------------------------------------------------------------- = */
    /* =       결제에 필요한 인스턴스를 생성하고 초기화 합니다.                     = */
    /* = -------------------------------------------------------------------------- = */
    $c_PayPlus = new C_PP_CLI;

    $c_PayPlus->mf_clear();
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   04. 처리 요청 정보 설정, 실행                                            = */
    /* = -------------------------------------------------------------------------- = */

    /* = -------------------------------------------------------------------------- = */
    /* =   04-1. 승인 요청                                                          = */
    /* = -------------------------------------------------------------------------- = */
    if ( $req_tx == "pay" )
    {
        if ( $bank_issu == "SCOB" ) // 동방시스템 계좌이체 시
        {
            $tran_cd = "00200000";

            $c_PayPlus->mf_set_modx_data( "tno",           $tno       ); // KCP 원거래 거래번호
            $c_PayPlus->mf_set_modx_data( "mod_type",      "STAQ"     ); // 원거래 변경 요청 종류
            $c_PayPlus->mf_set_modx_data( "mod_ip",        $cust_ip   ); // 변경 요청자 IP
            $c_PayPlus->mf_set_modx_data( "mod_ordr_idxx", $ordr_idxx ); // 주문번호
        }
        else
        {
            $c_PayPlus->mf_set_encx_data( $_POST[ "enc_data" ], $_POST[ "enc_info" ] );
        }
    }

    /* = -------------------------------------------------------------------------- = */
    /* =   04-2. 취소/매입 요청                                                     = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $req_tx == "mod" )
    {
        $tran_cd = "00200000";

        $c_PayPlus->mf_set_modx_data( "tno",      $tno      ); // KCP 원거래 거래번호
        $c_PayPlus->mf_set_modx_data( "mod_type", $mod_type ); // 원거래 변경 요청 종류
        $c_PayPlus->mf_set_modx_data( "mod_ip",   $cust_ip  ); // 변경 요청자 IP
        $c_PayPlus->mf_set_modx_data( "mod_desc", $mod_desc ); // 변경 사유
    }

    /* = -------------------------------------------------------------------------- = */
    /* =   04-3. 실행                                                               = */
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
        $c_PayPlus->m_res_msg = "연동 오류 TRAN_CD[" . $tran_cd . "]";
    }

    $res_cd  = $c_PayPlus->m_res_cd;  // 결과 코드
    $res_msg = $c_PayPlus->m_res_msg; // 결과 메시지
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   05. 승인 결과 처리                                                       = */
    /* = -------------------------------------------------------------------------- = */
    if ( $req_tx == "pay" )
    {
        if( $res_cd == "0000" )
        {
            $tno    = $c_PayPlus->mf_get_res_data( "tno"    ); // KCP 거래 고유 번호
            $amount = $c_PayPlus->mf_get_res_data( "amount" ); // KCP 실제 거래 금액

    /* = -------------------------------------------------------------------------- = */
    /* =   05-1. 신용카드 승인 결과 처리                                            = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "100000000000" )
            {
                $card_cd   = $c_PayPlus->mf_get_res_data( "card_cd"   ); // 카드 코드
                $card_name = $c_PayPlus->mf_get_res_data( "card_name" ); // 카드 종류
                $app_time  = $c_PayPlus->mf_get_res_data( "app_time"  ); // 승인 시간
                $app_no    = $c_PayPlus->mf_get_res_data( "app_no"    ); // 승인 번호
                $noinf     = $c_PayPlus->mf_get_res_data( "noinf"     ); // 무이자 여부 ( 'Y' : 무이자 )
                $quota     = $c_PayPlus->mf_get_res_data( "quota"     ); // 할부 개월

                /* = -------------------------------------------------------------- = */
                /* =   05-1.1. 복합결제(포인트+신용카드) 승인 결과 처리               = */
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
    /* =   05-2. 계좌이체 승인 결과 처리                                            = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "010000000000" )
            {
                $bank_name = $c_PayPlus->mf_get_res_data( "bank_name"  );  // 은행명
                $bank_code = $c_PayPlus->mf_get_res_data( "bank_code"  );  // 은행코드
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-3. 가상계좌 승인 결과 처리                                            = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "001000000000" )
            {
                $bankname  = $c_PayPlus->mf_get_res_data( "bankname"  ); // 입금할 은행 이름
                $depositor = $c_PayPlus->mf_get_res_data( "depositor" ); // 입금할 계좌 예금주
                $account   = $c_PayPlus->mf_get_res_data( "account"   ); // 입금할 계좌 번호
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-4. 포인트 승인 결과 처리                                               = */
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
    /* =   05-5. 휴대폰 승인 결과 처리                                              = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "000010000000" )
            {
                $app_time = $c_PayPlus->mf_get_res_data( "hp_app_time"  ); // 승인 시간
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-6. 상품권 승인 결과 처리                                              = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "000000001000" )
            {
                $app_time = $c_PayPlus->mf_get_res_data( "tk_app_time"  ); // 승인 시간
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-7. 티머니 승인 결과 처리                                              = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "000000000100" )
            {
                $app_time = $c_PayPlus->mf_get_res_data("app_time"      ); // 승인시간
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-8. ARS 승인 결과 처리                                                 = */
    /* = -------------------------------------------------------------------------- = */
            if ( $use_pay_method == "000000000010" )
            {
                $app_time = $c_PayPlus->mf_get_res_data( "ars_app_time" ); // 승인 시간
            }

    /* = -------------------------------------------------------------------------- = */
    /* =   05-9. 현금영수증 결과 처리                                               = */
    /* = -------------------------------------------------------------------------- = */
            if ( $cash_yn == "Y" )
            {
                $cash_authno  = $c_PayPlus->mf_get_res_data( "cash_authno"  ); // 현금 영수증 승인 번호
            }

	/* = -------------------------------------------------------------------------- = */
    /* =   05-10. 승인 결과를 업체 자체적으로 DB 처리 작업하시는 부분입니다.         = */
    /* = -------------------------------------------------------------------------- = */
    /* =         승인 결과를 DB 작업 하는 과정에서 정상적으로 승인된 건에 대해      = */
    /* =         DB 작업을 실패하여 DB update 가 완료되지 않은 경우, 자동으로       = */
    /* =         승인 취소 요청을 하는 프로세스가 구성되어 있습니다.                = */
    /* =         DB 작업이 실패 한 경우, bSucc 라는 변수(String)의 값을 "false"     = */
    /* =         로 세팅해 주시기 바랍니다. (DB 작업 성공의 경우에는 "false" 이외의 = */
    /* =         값을 세팅하시면 됩니다.)                                           = */
    /* =         amount(KCP실제 거래금액)과 업체가 DB 처리하실 금액이 다를 경우의   = */
    /* =         비교 루틴을 추가 하셔서 다를 경우 마찬가지로 "false"로 셋팅하여    = */
    /* =         주시길 바랍니다.                                                   = */
    /* = -------------------------------------------------------------------------- = */
            $bSucc = ""; // DB 작업 실패 또는 금액 불일치의 경우 "false" 로 세팅

    /* = -------------------------------------------------------------------------- = */
    /* =   05-11. DB 작업 실패일 경우 자동 승인 취소                                 = */
    /* = -------------------------------------------------------------------------- = */
            if ( $bSucc == "false" )
            {
                $c_PayPlus->mf_clear();

                $tran_cd = "00200000";

                $c_PayPlus->mf_set_modx_data( "tno",      $tno                         );  // KCP 원거래 거래번호
                $c_PayPlus->mf_set_modx_data( "mod_type", "STSC"                       );  // 원거래 변경 요청 종류
                $c_PayPlus->mf_set_modx_data( "mod_ip",   $cust_ip                     );  // 변경 요청자 IP
                $c_PayPlus->mf_set_modx_data( "mod_desc", "결과 처리 오류 - 가맹점에서 취소 요청" );  // 변경 사유

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
    /* =   05-12. 승인 실패를 업체 자체적으로 DB 처리 작업하시는 부분입니다.         = */
    /* = -------------------------------------------------------------------------- = */
        else
        {
        }
    }
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   06. 취소/매입 결과 처리                                                  = */
    /* = -------------------------------------------------------------------------- = */
    else if ( $req_tx == "mod" )
    {
		//취소시 접수테이블 pay_cancel필드값 off
		mysql_query("update ".TABLE4." set pay_cancel='off' where tno=$tno");		 		
    } // End of Process
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   07. 폼 구성 및 결과페이지 호출                                           = */
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
		<!-- result.html 에서 폼형식에 따라 부모창 액션 다르게 하기 위한 히든필드 -->		
		<input type='hidden' name='type'          value='<?php echo $_POST[type];?>'>
		<!-- kcp 히든필드  -->
        <input type="hidden" name="req_tx"            value="<?=$req_tx?>">            <!-- 요청 구분 -->
        <input type="hidden" name="use_pay_method"    value="<?=$use_pay_method?>">    <!-- 사용한 결제 수단 -->
        <input type="hidden" name="bSucc"             value="<?=$bSucc?>">             <!-- 쇼핑몰 DB 처리 성공 여부 -->

        <input type="hidden" name="res_cd"            value="<?=$res_cd?>">            <!-- 결과 코드 -->
        <input type="hidden" name="res_msg"           value="<?=$res_msg?>">           <!-- 결과 메세지 -->
        <input type="hidden" name="ordr_idxx"         value="<?=$ordr_idxx?>">         <!-- 주문번호 -->
        <input type="hidden" name="tno"               value="<?=$tno?>">               <!-- KCP 거래번호 -->
        <input type="hidden" name="good_mny"          value="<?=$good_mny?>">          <!-- 결제금액 -->
        <input type="hidden" name="good_name"         value="<?=$good_name?>">         <!-- 상품명 -->
        <input type="hidden" name="buyr_name"         value="<?=$buyr_name?>">         <!-- 주문자명 -->
        <input type="hidden" name="buyr_tel1"         value="<?=$buyr_tel1?>">         <!-- 주문자 전화번호 -->
        <input type="hidden" name="buyr_tel2"         value="<?=$buyr_tel2?>">         <!-- 주문자 휴대폰번호 -->
        <input type="hidden" name="buyr_mail"         value="<?=$buyr_mail?>">         <!-- 주문자 E-mail -->

        <input type="hidden" name="card_cd"           value="<?=$card_cd?>">           <!-- 카드코드 -->
        <input type="hidden" name="card_name"         value="<?=$card_name?>">         <!-- 카드명 -->
        <input type="hidden" name="app_time"          value="<?=$app_time?>">          <!-- 승인시간 -->
        <input type="hidden" name="app_no"            value="<?=$app_no?>">            <!-- 승인번호 -->
        <input type="hidden" name="quota"             value="<?=$quota?>">             <!-- 할부개월 -->

        <input type="hidden" name="bank_name"         value="<?=$bank_name?>">         <!-- 은행명 -->
        <input type="hidden" name="bank_0code"         value="<?=$bank_code?>">         <!-- 은행코드 -->

        <input type="hidden" name="bankname"          value="<?=$bankname?>">          <!-- 입금 은행 -->
        <input type="hidden" name="depositor"         value="<?=$depositor?>">         <!-- 입금계좌 예금주 -->
        <input type="hidden" name="account"           value="<?=$account?>">           <!-- 입금계좌 번호 -->

        <input type="hidden" name="epnt_issu"         value="<?=$epnt_issu?>">         <!-- 포인트 서비스사 -->
		<input type="hidden" name="pnt_app_time"      value="<?=$pnt_app_time?>">      <!-- 승인시간 -->
        <input type="hidden" name="pnt_app_no"        value="<?=$pnt_app_no?>">        <!-- 승인번호 -->
        <input type="hidden" name="pnt_amount"        value="<?=$pnt_amount?>">        <!-- 적립금액 or 사용금액 -->
        <input type="hidden" name="add_pnt"           value="<?=$add_pnt?>">           <!-- 발생 포인트 -->
        <input type="hidden" name="use_pnt"           value="<?=$use_pnt?>">           <!-- 사용가능 포인트 -->
        <input type="hidden" name="rsv_pnt"           value="<?=$rsv_pnt?>">           <!-- 적립 포인트 -->

        <input type="hidden" name="cash_yn"           value="<?=$cash_yn?>">            <!-- 현금영수증 등록 여부 -->
        <input type="hidden" name="cash_authno"       value="<?=$cash_authno?>">        <!-- 현금 영수증 승인 번호 -->
        <input type="hidden" name="cash_tr_code"      value="<?=$cash_tr_code?>">       <!-- 현금 영수증 발행 구분 -->
        <input type="hidden" name="cash_id_info"      value="<?=$cash_id_info?>">       <!-- 현금 영수증 등록 번호 -->
    </form>
    </body>
    </html>
