<?php
include "../include/connect.php";

$_login = $_POST["us_login"];
$_heslo = $_POST["us_heslo"];

if(isset($_login) and isset($_heslo)) {

	$query = mysqli_query($db,"select id from autori where login = '$_login' and heslo = '$_heslo'");
	$check = mysqli_num_rows($query);

	if($check == "1") {
		session_start();
		$registrace = session_register("user") ;
			if($registrace) {
				$user_data = mysqli_fetch_array($query);    //Zpracov�n� dotazu
				$_SESSION["user"]["id"] = $user_data["id"]; //Ulo��me si do session ID u�ivatele pro pozd�j�� pou�it�
				$_SESSION["user"]["interval"] = "600";      //Ulo��me tak� interval jak dlouho m��e b�t u�ivatel ne�inn�
				$_SESSION["user"]["session_time"] = Time(); //A tak� aktu�ln� �as
				header("location:user.php");
			} else {
				header("location:index.php?akce=1");
			}
	} else {
		header("location:index.php?akce=2");
	}
} else {
	header("location:index.php?akce=3");
}
?>