<?php
	class DatabaseConnection
	{
		private static $host = 'localhost';
		
		private static $user = 'root';
		
		private static $password = '';
		
		private static $database = 'gainTimeOff';

		private static $pdo;
			
		
		public static function getPDO()
		{
			if(!isset(self::$pdo))
			{
				self::$pdo = new PDO("mysql:host=".self::$host.";dbname=".self::$database.";charset=utf8", self::$user, self::$password,
										[PDO::ATTR_EMULATE_PREPARES=>false, PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION]);
			}
			return self::$pdo;
		}
	}
?>