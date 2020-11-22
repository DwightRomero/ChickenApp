<?php
namespace Common\Data;

use \PDO;
use Library\DataBase\DataAccessCredentials;

class MySqlParameter 
{
	public $Name = "";
	public $Value; //object
	public $Direction = 1; //IN: 1; OUT: 2

	public function __construct($parameterName, $parameterValue, $parameterDirection) {
		$this->Name = $parameterName; 
		$this->Value = $parameterValue;
		$this->Direction = $parameterDirection;
	}
}

class DataAccessLayer
{
    // connection variables 
    /* private $_server 			= DataAccessCredentials::ConnectionServer; //private $_server = '104.198.143.83';
    private $_username 			= DataAccessCredentials::ConnectionUsername; //private $_username = 'root';
    private $_password 			= DataAccessCredentials::ConnectionPassword; //private $_password = 'IT1@nd#485263';
    private $_database 			= DataAccessCredentials::ConnectionDatabase; //private $_database = 'dbchatbot';
    private $_projectid 		= DataAccessCredentials::ConnectionProjectid; //private $_projectid = 'itland-database';
    private $_region 			= DataAccessCredentials::ConnectionRegion; //private $_region = 'us-central1';
	private $_instancename 		= DataAccessCredentials::ConnectionInstancename; //private $_instancename = 'itland'; */
	
	private $_server 			= '108.59.83.154';
    private $_username 			= 'root';
    private $_password 			= '7PnxAKeF3FiAp9IB';
    private $_database 			= 'chatbot_centrum';
    private $_projectid 		= 'titalab-centrum';
    private $_region 			= 'us-central1';
	private $_instancename 		= 'titalab-centrum';
	
    private $_connectionstring 	= '';
    //public  $debug = false;
 
    // connection
    private $_db;
    private $_connected = false;

    public $exception = null;

    public function __construct() {
        
    	//case "mysql":
		//$this->_connectionstring = "mysql:host=".$this->_server.";dbname=".$this->_database;
		//$this->_connectionstring = 'mysql:unix_socket=/cloudsql/'.$this->_projectid.':'.$this->_region.':'.$this->_instancename.';dbname='.$this->_database.';host='.$this->_server.';charset=utf8mb4';
		$this->_connectionstring = 'mysql:unix_socket=/cloudsql/'.$this->_projectid.':'.$this->_region.':'.$this->_instancename.';dbname='.$this->_database.';charset=utf8mb4';
		//$this->_connectionstring = 'mysql:unix_socket=/cloudsql/'.$this->_projectid.':'.$this->_region.':'.$this->_instancename.';dbname='.$this->_database.';charset=utf8mb4';
		
		//case "sqlite":
		//$this->_connectionstring = "sqlite:".$db_path;
		
		//case "oracle":
		//$this->_connectionstring = "OCI:dbname=".$db_name.";charset=UTF-8";
		
		//case "dblib":
		//$this->_connectionstring = "dblib:host=".$db_host.";dbname=".$db_name;
		
		//case "postgresql":
		//$this->_connectionstring = "pgsql:host=".$db_host." dbname=".$db_name;
    }

	public function connect()
	{
		if(!$this->_db)
		{
			try {
				$this->_db = new PDO(
					$this->_connectionstring, 
					(string)$this->_username, 
					(string)$this->_password//, 
					//array(
					//	PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"
					//)
				);
				$this->_db->setAttribute(PDO::ATTR_TIMEOUT, 10);
				$this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    			$this->_db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
				//$this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				//$this->_db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
				//$this->_db->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8'");
				$this->_connected = true;
				return $this->_connected;
			}
			catch (PDOException $e) 
			{
				return $e->getMessage();
			}
		}
		else
		{
			return true; //already connected, do nothing and show true
		}
	}
	public function disconnect()
	{
		if($this->_connected)
		{
			unset($this->_db); 
			$this->_connected = false;
			return true;
		}
	}
	// print error
	public function error() {
		return $this->_db->errno . ': ' . $this->_db->error;
	}

	public function ExecuteSelectQuery($query) {
		if(!$this->_connected) return null;

		$rtn = null;
		try {
			$sql = $this->_db->prepare($query);
			$sql->execute();
			$rtn = $sql->fetchAll(PDO::FETCH_ASSOC); //$this->result = $sql->fetchAll(PDO::FETCH_ASSOC);
			//$numResults = count($rtn); //$this->numResults = count($this->result);
			//$this->numResults === 0 ? $this->result = null : true ;
		}
		catch (PDOException $e) 
		{
			////return $e->getMessage().'<pre>'.$e->getTraceAsString().'</pre>';
			//$this->exception = $e;
			//print_r($this->_db->errorInfo());
			//$rtn = $this->_db->errorInfo();
			$rtn = null;
		}
		return $rtn;
	}

	 public function ExecuteSelectQuery2($query) {
    	if(!$this->_connected) return null;

    	$rtn = null;
    	try {
			$sql = $this->_db->prepare($query);
			$sql->execute();
			$rtn = $sql->fetchAll(PDO::FETCH_ASSOC); //$this->result = $sql->fetchAll(PDO::FETCH_ASSOC);
			//$numResults = count($rtn); //$this->numResults = count($this->result);
			//$this->numResults === 0 ? $this->result = null : true ;
		}
		catch (PDOException $e) 
		{
			//return $e->getMessage().'<pre>'.$e->getTraceAsString().'</pre>';
			$this->_error = $e;
			$rtn = null;
		}
		return $rtn;
    }

	public function ExecuteSelect2($query) {
    	if(!$this->_connected) return null;

    	$rtn = null;
    	try {
			$sql = $this->_db->prepare($query);
			$sql->execute();
			$rtn = $sql->fetchAll(PDO::FETCH_ASSOC); //$this->result = $sql->fetchAll(PDO::FETCH_ASSOC);
			//$numResults = count($rtn); //$this->numResults = count($this->result);
			//$this->numResults === 0 ? $this->result = null : true ;
		}
		catch (PDOException $e) 
		{
			//return $e->getMessage().'<pre>'.$e->getTraceAsString().'</pre>';
			$this->_error = $e;
			$rtn = null;
		}
		return $rtn;
	}
	
	public function ExecuteSelect($procedureName, $params) {
		if(!$this->_connected) return false;

		$call_params = "";
		if (isset($params) && is_array($params) && count($params) > 0) 
		{
			foreach ($params as $param) 
			{
				if (is_numeric($param->Value)) 
				{
					$call_params = $call_params . ", " . $param->Value . "";
				} 
				else 
				{
					$call_params = $call_params . ", '" . $param->Value . "'";
				}
			}
			$call_params = substr($call_params, 2);
		}
		$call_query = "CALL " . $procedureName . "(" . $call_params . ");";
		
		$rtn = null;
		try 
		{
			$sql = $this->_db->prepare($call_query);
			$sql->execute();
			//$sql->closeCursor();
			//var_dump($call_query);
			$rtn = $sql->fetchAll(PDO::FETCH_ASSOC);
			//var_dump($rtn);
		}
		catch (PDOException $e) 
		{
			//return $e->getMessage();
			$rtn = null;
		}
		return $rtn;
	}

	public function ExecuteNonQuery($query) {
		if(!$this->_connected) return false;
		
		$rtn = false;
		try {
			$sql = $this->_db->prepare($query);
			$sql->execute();
			//$this->lastId = $this->_db->lastInsertId();
			//$this->numResults = $sql->rowCount();
			$rtn = true;
		}
		catch (PDOException $e) 
		{
			//return $e->getMessage();
			$rtn = false;
		}
		return $rtn;
	}

	public function ExecuteNonQueryWithOutput($procedureName, $params) {
    	if(!$this->_connected) return false;

    	$call_params = "";
    	$select_params = "";
		$has_outputs = false;
    	if (isset($params) && is_array($params) && count($params) > 0) {
    		foreach ($params as $param) {
    			switch ($param->Direction ) {
    			 	case 1:
    			 		$call_params = $call_params . ", :" . $param->Name;

    			 		break;
    			 	
    			 	case 2:
    			 		$call_params = $call_params . ", @" . $param->Name;
    			 		$select_params = $select_params . ", @" . $param->Name;
				 		$has_outputs = true;
    			 		
    			 		break;
    			 	
    			 	default:
    			 		
    			 		break;
    			 }
    		}
    		$call_params = substr($call_params, 2);
    		$select_params = substr($select_params, 2);
    	}
    	$call_query = "CALL " . $procedureName . "(" . $call_params . ");";
    	//error_log("call_query:".$call_query."\n");
    	$select_query = "select " . $select_params . ";";
    	//error_log("select_query:".$select_query."\n");
    	
    	$rtn = null;
    	try {
			$sql = $this->_db->prepare($call_query); //$sql = $this->_db->prepare("CALL sp_takes_string_returns_string(:pclient_id, :pchat_id, @pcustomer_id)");
			//$sql->bindParam(':pclient_id', 'hello'); //$sql->bindParam(':pchat_id', 'hello'); 
			if (isset($params) && is_array($params) && count($params) > 0) {
	    		foreach ($params as $param) {
	    			if ($param->Direction == 1) {
	    				$sql->bindParam(':' . $param->Name, $param->Value); 
	    			 }
	    		}
	    	}
			$sql->execute(); //error

			if ($has_outputs == true) {
				$result = $this->_db->query($select_query)->fetch(PDO::FETCH_ASSOC); //$rtn = $this->_db->query("select @pcustomer_id")->fetch(PDO::FETCH_ASSOC);
				$this->_error_found = 7;
				if (isset($result) && is_array($result) && count($result) > 0) {
					$rtn = array();
					$this->_error_found = 8;
					foreach ($result as $key => $value) {
	    				//error_log($key."=".$value."\n");
						$new_key = substr($key, 1);
						$rtn[$new_key] = $value; //$result[$key]; //$result['@pcustomer_id'];
						$this->_error_found = 9;
					}
					$this->_error_found = 10;
				}
				$this->_error_found = 11;
			}
		}
		catch (Exception $e) 
		{
			//return $e->getMessage();
			//$this->_error_found = $e->getMessage();
			//$this->_error_found = $call_query;
			//$this->_error_found = $select_query;
			//$this->_error_found = var_export($e, true);
			//$this->_error_found = var_export($this->_db->errorInfo(), true);
			//$this->_error_found = $this->_db->errorInfo();
			//$this->_error = $e;
			//$rtn = $this->_error;
			var_dump($e);
			$rtn = null;
		}
		//catch (PDOException $e) 
		//{
		//	//return $e->getMessage();
		//	$this->_error = $e;
		//	$rtn = null;
		//}
		return $rtn;
    }

	public function ExecuteWithIdentity($query, &$id) {
		if(!$this->_connected) return false;
		
		$rtn = false;
		try {
			$sql = $this->_db->prepare($query);
			$sql->execute();
			$id = $this->_db->lastInsertId(); //$this->lastId = $this->_db->lastInsertId();
			//$this->numResults = $sql->rowCount();
			$rtn = true;
		}
		catch (PDOException $e) 
		{
			//return $e->getMessage();
			$rtn = false;
		}
		return $rtn;
	}
}
?>