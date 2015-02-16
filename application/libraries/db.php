<?php

use Cassandra\Database;
require_once('Cassandra/Database.php');

class Db extends Database{

    private $CI;
    
    public $db;
    
    /*Ejemplo
    $nodes = [
    '127.0.0.1',
    '192.168.0.2:8882' => [
    'username' => 'admin',
    'password' => 'pass'
    		]
    		];
	*/
    private $nodes = ['127.0.0.1'=>['username'=>'','password'=>'']];
    
    public function __construct() {
    	$nodeas = ['127.0.0.1'];
        $this->CI = & get_instance();
        $this->db = new Database($nodeas, 'repositorio_proyectos');
        $this->db->connect();

        return $this->db;
    }

}