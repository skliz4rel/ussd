<?php
/*Add at the begining of the file*/
 
$connectstr_dbhost = '';
$connectstr_dbname = '';
$connectstr_dbusername = '';
$connectstr_dbpassword = '';
 
foreach ($_SERVER as $key => $value) {
 if (strpos($key, "MYSQLCONNSTR_localdb") !== 0) {
 continue;
 }
  
 $connectstr_dbhost = preg_replace("/^.*Data Source=(.+?);.*$/", "\\1", $value);
 $connectstr_dbname = preg_replace("/^.*Database=(.+?);.*$/", "\\1", $value);
 $connectstr_dbusername = preg_replace("/^.*User Id=(.+?);.*$/", "\\1", $value);
 $connectstr_dbpassword = preg_replace("/^.*Password=(.+?)$/", "\\1", $value);
}
 
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('database', "promptfinder");
 
/** MySQL database username */
define('username', $connectstr_dbusername);
 
/** MySQL database password */
define('password', $connectstr_dbpassword);

/** MySQL hostname : this contains the port number in this format host:port . Port is not 3306 when using this feature*/
define('dbserverip', $connectstr_dbhost);

?>