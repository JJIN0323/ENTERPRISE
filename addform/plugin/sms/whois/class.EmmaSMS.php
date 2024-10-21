<?php

class EmmaSMS {

	var $Args;
	var $Host;
	var $Port;
	var $Path;
	var $errMsg;

	function EmmaSMS() {
		$this->Args = array();
		$this->Host = "www.whoisweb.net";
		$this->Port = 80;
	}

	function login($id, $pass) {
		$this->Args['Id'] = $id;
		$this->Args['Pass'] = $pass;
	}

	function send($To, $From, $Message, $Date='') {
		if(is_array($To)) $this->Args['To'] = implode(",",$To);
		else $this->Args['To'] = $To;
		$this->Args['From'] = $From;
		$this->Args['Message'] = $Message;
		$this->Args['Date'] = $Date;

		$this->setURL("http://www.whoisweb.net/emma/API/EmmaSend_All.php");
		foreach($this->Args as $key => $value) $args[$key] = base64_encode($value);
		$res = $this->xmlrpc_send('EmmaSend', $args);

		if($res['Code'] != '00') return $this->setError($res['CodeMsg']);
		else return $res;
	}

	function setURL($url) {
		if(!$m = parse_url($url)) return $this->setError("�Ľ��� �Ұ����� URL�Դϴ�.");

		$this->Host = $m['host'];
		$this->Port = ($m['port']) ? $m['port'] : 80;
		$this->Path = ($m['path']) ? $m['path'] : "/";
		return true;
	}

	function point() {
		$this->setURL("http://www.whoisweb.net/emma/API/EmmaSend_All.php");
		$res = $this->CheckPoint();
		return true;
	}

	function xmlrpc_send($func, $args) {

		$server = new xmlrpc_client($this->Path, $this->Host, $this->Port);
		//$server->setDebug(1);		
	
		$message = new xmlrpcmsg($func, array(xmlrpc_encode2($args)));
		$result = $server->send($message); 

		if($result) { 
			if($ret = $result->value()) { 
				return xmlrpc_decode2($ret);
			} else return $this->setError($result->faultCode().":".$result->faultString());
		} else return $this->setError("�������� ���ӿ� ��ְ� ������ϴ�.");
	}

	function setError($msg) {
		$this->errMsg = $msg;
		return false;
	}

}

?>