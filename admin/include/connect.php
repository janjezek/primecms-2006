<?php
include "../include/config.php";

if (!function_exists("mysqli_connect")) {
  function mysqli_connect($host,$user,$password) {
	global $activedb;
    $activedb = mysql_connect($host,$user,$password);
  }
  function mysqli_select_db(&$activedb,$dbname) {
    mysql_select_db($dbname,$activedb) or
	   die(mysql_error($activedb));
  }
  function mysqli_query(&$activedb,$query) {
    return mysql_query($query,$activedb);
  }
  function mysqli_error(&$resource) {
	  mysql_error($resource);
  }
  function mysqli_close(&$activedb) {
	  mysql_close($activedb);
  }
  function mysqli_fetch_object(&$resource){
    return mysql_fetch_object($resource);
  }
  function mysqli_fetch_assoc(&$resource){
    return mysql_fetch_assoc($resource);
  }
  function mysqli_fetch_array(&$resource){
    return mysql_fetch_array($resource);
  }
  function mysqli_fetch_row(&$resource){
    return mysql_fetch_row($resource);
  }
  function mysqli_num_rows(&$resource){
	    return mysql_num_rows($resource);
  }
  function mysqli_free_result(&$resource){
	    mysql_free_result($resource);
  }
  function mysqli_insert_id(&$activedb){
	   return mysql_insert_id();
  }
  function mysqli_num_fields(&$result){
	  return mysql_num_fields($result);
  }
  function mysqli_field_name(&$result, $j){
	  return mysql_field_name($result, $j);
  }
  function mysqli_affected_rows(&$resource){
	  return mysql_affected_rows($resource);
  }
}

$db = mysqli_connect("$dbserver", "$dbuser", "$dbpass");
mysqli_select_db($db,"$dbname");
?>