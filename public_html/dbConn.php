<?php 
require '../vendor/autoload.php';

// Add .env support
$dotenv = new Dotenv\Dotenv('../');

// We need specific values in the file, so lets check we have them
$dotenv->load();
$dotenv->required(['DB_HOST', 'DB_PORT', 'DB_USER', 'DB_PASS']);
$dotenv->required('DB_NAME')->notEmpty();
class dbConn  extends pdo{

	public function dbConn(){
		$dbhost = getenv('DB_HOST');
		$dbport = getenv('DB_PORT');
		$dbuser = getenv('DB_USER');
		$dbpass = getenv('DB_PASS');
		$dbname = getenv('DB_NAME');

		try {
			$dsn = "mysql:dbname=".$dbname.";host=".$dbhost.";port=".$dbport;
			parent::__construct($dsn,$dbuser,$dbpass);
		} catch(PDOException $e){
			 var_dump($e);
		}
	}
}
