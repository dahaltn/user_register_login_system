<?php
class Connection{

	private static $db=null;
	private function __construct(){
		$this->conn();
		}

	//singletone instance	
	public static function dbinst(){
		if(!self::$db){
			self::$db = new self;
		}
		return self::$db;
	}  	
	
	//database connection
	public static function conn(){

			try{
				$mysql = new PDO("mysql::host=localhost; dbname=reg", "root", "test");
				$mysql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				return $mysql;
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}


}

?>