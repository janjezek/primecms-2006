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
				$user_data = mysqli_fetch_array($query);    //Zpracování dotazu
				$_SESSION["user"]["id"] = $user_data["id"]; //Uložíme si do session ID uživatele pro pozdìjší použití
				$_SESSION["user"]["interval"] = "600";      //Uložíme také interval jak dlouho mùže být uživatel neèinný
				$_SESSION["user"]["session_time"] = Time(); //A také aktuální èas
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