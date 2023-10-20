<?php
include "../include/config.php";

/* --- vytvoření hlavičky --- */

echo "<?xml version=\"1.0\" encoding=\"windows-1250\"?>\n";
?>
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
        <a href="password.php">Zapomenuté heslo</a>
      </p>
    </div></div></div>

  <hr/>

    <div id="vpravo"><div class="layout_1"><div class="layout_2">
<?php

/* --- identifikace proměnných --- */

if (isset($_POST["email"])) {  // formulář byl odeslán
  include "include/connect.php";

  $email = $_POST["email"];

  $result = mysqli_query($db,"select heslo from autori where email = '$email'");
  $data = mysqli_fetch_array($result);

  $vys_celkem = mysqli_num_rows($result);

  /* --- sestavení emailu --- */

  if ($vys_celkem != "0") {  // email je v databázi
    $subject = "$sitename - Zapomenuté heslo";
    $message = "Dobrý den,\n\nžádal(a) jste o zaslání zapomenutého hesla pro vstup do administrace na stránkách $sitename ($linkh/).\n\nVaše heslo je $data[heslo].";
    $headers = "From: \"$sitename\" <jan.jezek@janjezek.cz>\nContent-Type: text/plain; charset=utf-8\nMIME-Version: 1.0\nContent-transfer-encoding: 8bit";

    mail($email, $subject, $message, $headers);

    echo "<h1>Administrace &gt; Email odeslán</h1>\n";
    echo "<p>Email s heslem byl odeslán na adresu $email.</p>";
	} else {  // email není v databázi
    echo "<h1>Administrace &gt; Chybný email</h1>\n";
    echo "<p>Emailová adresa $email nepatří žádnému z redaktorů.</p>";
  }

} else {  // formulář ještě nebyl odeslán
  echo "<h1>Administrace &gt; Zapomenuté heslo</h1>\n";
  echo "<p>Vložte emailovou adresu, která je uvedena ve Vaší registaci. Bude Vám zaslán email s heslem.</p>";
}
?>

<form action="password.php" method="post">

<table cellpadding="0" cellspacing="0">
  <tr>
    <td>Email: </td>
    <td><input type="text" name="email"/></td>
  </tr>
  <tr>
    <td></td>
    <td><input type="submit" value="Odeslat"/></td>
  </tr>
</table>

</form>

<?php
include "include/footer.php";
?>