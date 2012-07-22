<?php

// for DB_insert , DB_update , DB_delete etc.

if( ! class_exists( 'db_download' ) )
{
	class db_download
	{
		var $table_name;
		var $id_name;
		var $db;

		function db_download( $table_name, $id_name )
		{
			$this->db =& Database::getInstance();
			$this->table = $table_name;
			$this->id = $id_name;
		}

		function db_insert( $set4sql )
		{
			$sql = "INSERT INTO ".$this->table." SET $set4sql";
			$result = $this->db->query( $sql );
			$new_id = $this->db->getInsertId();
			return $new_id;
		}

		function db_update( $set4sql, $id )
		{
			$sql = "UPDATE ".$this->table." SET $set4sql WHERE ".$this->id."='".$id."'";
			$result = $this->db->query( $sql );
			return $result;
		}

		function db_delete( $id )
		{
			$sql = "DELETE FROM ".$this->table." WHERE ".$this->id."='".$id."'";
			$result = $this->db->query( $sql );
			return $result;
		}

		function db_getrowsnum( $id )
		{
			$sql = "SELECT * FROM ".$this->table." WHERE ".$this->id."='".$id."'";
			$result = $this->db->query( $sql );
			return $this->db->getRowsNum( $result );
		}
	}
}

?>