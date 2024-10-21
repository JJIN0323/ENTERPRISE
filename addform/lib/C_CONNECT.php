<?php
include_once("lib.php");
//모든 DB입력에서 인용부호를 제거하고, 혹시 놓칠경우 다시 이스케이프
//입력 데이타에 인용부호가 사용되어야 한다면 9 라인 삭제
function str_Quot(&$val,$key) {
	$vowels = array("'","\"");							//제거할 특수문자 배열
	//$val = str_replace($vowels, "", $val);			//인용부호 제거
	//if(get_magic_quotes_gpc()) $val = "'".$val."'";	//magic_quotes_gpc가 0n이라면 중복 이스케이프 방지
    //else $val="'".mysql_real_escape_string($val)."'";	//이스케이프
	$val="'".mysql_real_escape_string($val)."'";		//이스케이프
	
}



class C_CONNECT {	
	var $connect;										//DB Access Resource Member Variable	

   	function C_CONNECT() {
    #######인클루드된 파일의 DB 접속 변수를 함수내에서 글로벌변수로 사용 #######
	global $db_hostname;	
	global $dbname;
	global $db_username;	
	global $db_password;
		
		$this->connect=@mysql_connect($db_hostname,$db_username,$db_password)
            or die("MySql DB 접속에 실패하였습니다.");
        
		mysql_select_db($dbname,$this->connect);
	}

	// 1행 레코드 insert 멤버함수
	function f_InsertDB($table,$arr)  {	
		

	    //$arr 배열의 각키에 str_Quot함수를 실행하여 작은따옴표를 붙여 쿼터링
        array_walk($arr,"str_Quot",1);
		//$arr = mysql_real_escape_string($arr);
        
        //insert 쿼리문의 형식에 맞게 implode문자열 함수로 재구성
		$q="insert into ".$table
            ."(".implode(",",array_keys($arr)).") values(".implode(",",$arr).")";            
        mysql_query($q,$this->connect);
	}
    
    // 다행 레코드 insert 멤버함수
    function f_InsertDBMulti($table,$fields,$array) { 
		
		$q="insert into $table($fields) values ";       
        $len=count($array);//인자의 수
        
        //디비에 입력되는 레코드들의 chunk(큰덩어리, 상당한양)를 $chunk 에 배열저장
        for ($i=0;$i<$len;$i++) {
            array_walk($array[$i],"str_Quot");
            $chunk[]="(".implode(",",$array[$i]).")";
        }
               
        $q.=implode(",",$chunk);							//$q insert 쿼리문에 $chunk 패치
        
        mysql_query($q,$this->connect);						//insert 쿼리문 실행
    }  

    
    // 디비 select 멤버함수
	function f_selectDB($field="*",$table,$where="") {
		$q="select $field from $table $where";
		$re=$this->f_Result($q); 
		return $re;
	}    

	// f_selectDB select 문의 결과값 리턴 멤버함수
	function f_Result($que) {
		$result[result]=@mysql_query($que,$this->connect);	//레코드 리소스를 배열형으로 리턴
        $result[cnt]=@mysql_affected_rows();				//가장 최근질의에 영향받은 행수 리턴
		return $result;
	}
    
	

    // 디비 update 멤버함수
	function f_updateDB($table,$arr,$where="") {
        array_walk($arr,"str_Quot");						//연관배열에 작은따옴표 처리 
        
        $temps=array();										//임시 배열변수
        while(list($key,$val)=each($arr)) {					//$arr연관배열로 부터 list 인자의 변수값에 할당
            $temps[]="$key=$val";
        }
        $q="update $table set ".implode(",",$temps)." $where";
        
        mysql_query($q,$this->connect);
	}
    
    // 디비테이블 delete 멤버함수
	function f_deleteTable($table,$where="") {
		$q="delete from $table $where";		
        mysql_query($q,$this->connect);
	}
}
/*
callback function)
Registers the function named by function to be executed when script processing is complete
*/
register_shutdown_function("mysql_close");
?>