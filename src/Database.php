<?php

namespace MyApp;

class Database
{	
	use \MyApp\Traits\Singletone;
	
	protected $config;
	
    private $pdo;
    public $host = 'localhost';
    public $username = 'root';
    public $database = 'database';
    public $password = 'password';
    public $charset = 'utf8';
	
	
	public function __construct() {
		$this->config = require "../config/db.php";
		$this->host = $this->config['server'];
		$this->username = $this->config['bd_username'];
    	$this->database = $this->config['database'];
    	$this->password = $this->config['bd_pass'];
		
		$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->database .';charset=' . $this->charset;
        $opt = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
        ];
        $this->pdo = new \PDO($dsn, $this->username, $this->password, $opt);
	}
	
	public static function getPDO() {
        return self::getInstance()->pdo;
    }
	
	public function executeQuery($sql) {
		$pdo = $this->getPDO();
		$result = $pdo->query($sql);
		var_dump($result);
		return $result->execute();
	}

	public function getAssocResult($sql) {
		$pdo = $this->getPDO();
    	$result = $pdo->query($sql);
		$array = [];
    	foreach ($result->fetchAll() as $row) {
			array_push($array, $row);
    	}
    	return $array;
	}

	public function getGoodsResult($sql) {
		$pdo = $this->getPDO();
		$result = mysqli_fetch_assoc($pdo->query($sql));
    	return $result;
	}

	public function getAssocResultOne($sql) {
		$pdo = $this->getPDO();
		$result = $pdo->query($sql);
		return $result->fetchAll()[0];
	}
	
	public function addSuffix($val, $suffix1, $suffix2, $suffix3) {
	if ($val > 20) {
		$val %= 10;
	}
	if ($val == 0 || ($val >= 5 && $val <= 20)) {
		return $suffix1;
	} else if ($val >=2 && $val <= 4) {
		return $suffix2;
	} else {
		return $suffix3;
	}
}
}