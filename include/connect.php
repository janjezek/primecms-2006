<?php
include "include/config.php";

$db = mysqli_connect("$dbserver", "$dbuser", "$dbpass");
mysqli_select_db($db,"$dbname");
?>
