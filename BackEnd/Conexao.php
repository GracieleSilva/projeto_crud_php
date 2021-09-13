<?php


class conexao {

	private static $user   = "root";
	private static $pass   = "";
	private static $host   = "localhost";
	private static $banco  = "db_projeto_crud";

	private static $conn   = null;

	public static function conectar(){
		try {
			self::migrateBanco();
			self::$conn = new PDO("mysql:host=".self::$host.";dbname=".self::$banco, self::$user, self::$pass);
			self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return self::$conn;
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}

	public static function desconectar(){
		try {
			if (self::$conn) {
				self::$conn = null;
			}			
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	private static function migrateBanco(){
		try {
			$mysql = new PDO("mysql:host=".self::$host, self::$user, self::$pass);
			$pstatement = $mysql->prepare("CREATE DATABASE IF NOT EXISTS ".self::$banco);
			$pstatement->execute();
			$mysql = null;
		} catch (Exception $e) {
			echo $e->getMessage();
		}

	}
}