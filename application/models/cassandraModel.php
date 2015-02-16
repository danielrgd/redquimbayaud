<?php
class cassandraModel extends CI_Model {

	function ejecutar($queryCQL)
	{
		return $this->db->db->query($queryCQL);
		
// 		return var_dump($this->db->db->query('SELECT uuid() as "uuid" FROM system.schema_keyspaces LIMIT 1;'));
		
	}

}