<?php 
// DB credentials.
define('DB_HOST','localhost');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','damsmsdb');

try {
    // Establish database connection.
    $conn = new PDO(
        "mysql:host=".DB_HOST.";dbname=".DB_NAME,
        DB_USER,
        DB_PASS,
        array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'")
    );

    // If connection is successful
   // $conn = new mysqli($servername, $username, $password, $dbname);

} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}
?>
