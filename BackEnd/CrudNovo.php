<?php

require 'Conexao.php';

class Crud extends conexao{
	public static function insert($tabela, $atributos){
		$keys = array_keys($atributos);
		$camposTabela = implode(',', $keys);

		$valores = null;
		foreach ($keys as $key) {
			$valores.=', :'.$key;
		}
		$valores=(trim(ltrim($valores,',')));
		try {
			$cadastrar=conexao::conectar()->prepare("INSERT INTO $tabela ( $camposTabela )VALUES( $valores )");
			$cadastrar->execute($atributos);
			return conexao::conectar()->lastInsertId();	
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}

	public static function atualiza($tabela, $campo, $id, $atributos){
		$values = null;

		$query = 'UPDATE '.$tabela.' SET';
		foreach ($atributos as $name => $value) {
			$query .= ' '.$name.' = :'.$name.',';
			$values[':'.$name] = $value;
		}
		$query = substr($query, 0, -1).' WHERE '.$campo.'=:'.$campo.';';

		try {
			$atualizar = conexao::conectar()->prepare($query);
			$values[$campo] = $id;
			$atualizar->execute($values);
	
		} catch (Exception $e) {
			echo $e->getMessage();
		}
	}


	public static function lista($tabela){
		try {
			$listar = conexao::conectar()->query("SELECT * FROM $tabela");
			$listar->execute();
			conexao::desconectar();
			return $listar->fetchAll(PDO::FETCH_ASSOC);
		} catch (PDOPDOException $e) {
			echo $e->getMessage();	
		}
	}

	public static function deletar($tabela, $campo, $id){
		try {
			$deletar= conexao::conectar()->prepare("DELETE FROM $tabela WHERE $campo=:id");	
			$deletar->bindValue(":id",$id);		
			return $deletar->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();	
		}	
	}
	public static function migrateTabela($tabela, $campos){
		$sql = "CREATE TABLE IF NOT EXISTS ".$tabela." ( ".$campos." )";
		try {
			$pstatement = conexao::conectar()->prepare($sql);
			$pstatement->execute();
			conexao::desconectar();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}
	}
}

//Crud::migrateTabela("cliente_tb", "cliente_id INT(11) NOT NULL AUTO_INCREMENT,cliente_nome VARCHAR(255),cliente_email VARCHAR(255),PRIMARY KEY ( cliente_id )");