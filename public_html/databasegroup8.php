<?php
class Database {
  public function __construct() {
    die('Init function error');
  }

  public static function dbConnect() {
	$mysqli = null;
  $servername = "localhost";
  $username = "group8";
  $password = '$ICgnirut';
  $db = "group8";


if($mysqli == null) {
    try {
         $mysqli = new PDO("mysql:host=$servername;dbname=$db", $username, $password);
    }
    catch(PDOException $e) {
         echo "Could not connect";
         die($e->getMessage());
    }
}
    return $mysqli;
  }

  public static function dbDisconnect() {
    $mysqli = null;
  }
}
?>
