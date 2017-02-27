<?php
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');    // DB username
define('DB_PASSWORD', 'k1llersql');    // DB password
define('DB_DATABASE', 'Esportes');      // DB name

$connection = mysql_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD) or die( "Unable to connect");
mysql_query ("set character_set_client='utf8'"); 
mysql_query ("set character_set_results='utf8'"); 
mysql_query ("set collation_connection='utf8_general_ci'");
$database = mysql_select_db(DB_DATABASE) or die( "Unable to select database");

?>