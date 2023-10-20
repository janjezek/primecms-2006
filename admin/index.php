<?php
include "../include/config.php";


function hlavicka($sitename) {
echo "<?xml version=\"1.0\" encoding=\"windows-1250\"?>\n";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
               "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title><?php echo $sitename;?> - Administrace</title>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250"/>
  <link rel="stylesheet" href="include/style.css" type="text/css"/>
</head>

<body>

<div id="telo">
  <div id="main">

    <div id="hlavicka"><div class="layout_1"><div class="layout_2">
      <h1><?php echo $sitename; ?> - Administrace</h1>
            <div class="user_panel">
   Zatím nejste přihlášen(a).
      </div>

    </div></div></div>

  <hr/>

    <div id="vlevo"><div class="layout_1"><div class="layout_2">

    <h2><img src="icons/vstup.gif" alt=""/> Administrace</h2>
      <p>
        <a href="index.php">Přihlášení</a><br/>
        <a href="password.php">Zapomenuté heslo</a><br/>
      </p>

    </div></div></div>

  <hr/>

    <div id="vpravo"><div class="layout_1"><div class="layout_2">
<?php
}

function formular() {
?>

<form action="login.php" method="post">

<table cellpadding="0" cellspacing="0">
  <tr>
    <td>Login: </td>
    <td><input type="text" name="us_login"/></td>
  </tr>
  <tr>
    <td>Heslo: </td>
    <td><input type="password" name="us_heslo"/></td>
  </tr>
  <tr>
    <td></td>
    <td><input type="submit" value="Přihlásit"/></td>
  </tr>
</table>

</form>
<?php
include "include/footer.php";
}

if (isset($_GET["akce"])) {

if ($_GET["akce"] == "1") {
  hlavicka($sitename);
	echo " <h1>Administrace &gt; Chyba při přihlašování</h1>\n";
	formular();
}

if ($_GET["akce"] == "2") {
  hlavicka($sitename);
	echo "<h1>Administrace &gt; Snaha o neautorizovaný přístup</h1>\n";
	formular();
}

if ($_GET["akce"] == "3") {
  hlavicka($sitename);
	echo "<h1>Administrace &gt; Vyplňte login a heslo</h1>\n";
	formular();
}

if ($_GET["akce"] == "4") {
	session_start();
	hlavicka($sitename);
	echo "<h1>Administrace &gt; Automatické odhlášení</h1>\n";
	session_unregister("user");
	session_destroy();
	formular();
}

if ($_GET["akce"] == "5") {
	session_start();
	$logout1=session_unregister("user");
	$logout2=session_destroy();

	hlavicka($sitename);

	if($logout1 || $logout2):  //Pokud byla úspěšně odstraněna sessions uživatele
		echo "<h1>Administrace &gt; Byl(a) jste úspěšně odhlášen(a)</h1>\n";
	else: //Pokud nebyla úspěšně odstraněna sessions uživatele
		echo "<h1>Administrace &gt; Nebyl(a) jste úspěšně odhlášen(a)</h1>\n<p>Zkuste to <a href=\"index.php?akce=5\">znovu.</a></p>\n";	endif;
	formular();
}
} else {

hlavicka($sitename);
echo "<h1>Administrace &gt; Přihlášení</h1>\n";
formular();
}
?>