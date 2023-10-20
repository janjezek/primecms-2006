<?php
include "include/connect.php";

session_start();

header("Pragma: No-cache");
header("Cache-Control: No-cache, Must-revalidate");
header("Expires: ".GMDate("D, d M Y H:i:s")." GMT");

if(!session_is_registered("user") != FALSE):
	header("location:index.php?akce=2");
elseif ((Time() - $_SESSION["user"]["session_time"])>=$_SESSION["user"]["interval"]):
	header("location:index.php?akce=4");
else:
	$_SESSION["user"]["session_time"] = time();
endif;

echo "<?xml version=\"1.0\" encoding=\"windows-1250\"?>\n";

function alert($mess) {
  echo "<p class=\"alert\">$mess</p>";
}

function alert2($mess) {
  echo "<p class=\"alert2\">$mess</p>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
               "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250"/>
  <link rel="stylesheet" href="include/style.css" type="text/css"/>
  <?php
  if ($editor == "1") {
  ?>
  <script type="text/javascript" src="editor/tiny_mce.js"></script>
  <script type="text/javascript">
    tinyMCE.init({
	    mode : "exact",
	    elements : "perex,clanek",
	    theme : "advanced",
	    plugins : "table,advimage,advlink",
	    theme_advanced_buttons2_add : "separator,forecolor,backcolor",
	    theme_advanced_buttons2_add_before: "cut,copy,paste,separator,",
	    theme_advanced_buttons3_add_before : "tablecontrols,separator",
	    theme_advanced_toolbar_location : "top",
	    theme_advanced_toolbar_align : "left"
    });
  </script>
  <?php
  }
  ?>
  <title><?php echo $sitename; ?> - Administrace</title>
</head>

<body>

<div id="telo">
  <div id="main">

    <div id="hlavicka"><div class="layout_1"><div class="layout_2">
      <h1><?php echo $sitename; ?> - Administrace</h1>
      <div class="user_panel">
    <?php
    $_id = $_SESSION["user"]["id"];

    $_res = mysqli_query($db,"select jmeno, prava from autori where id = '$_id'");
    $_data = mysqli_fetch_array($_res);

    echo "Jste přihlášen(a) jako <a href=\"us_view.php\"><strong>$_data[jmeno]</strong></a>, <a href=\"index.php?akce=5\">Odhlásit</a><br/>\n";
    ?>
      </div>
    </div></div></div>

  <hr/>

    <div id="vlevo"><div class="layout_1"><div class="layout_2">

    <?php
    if ($_data["prava"] == "1") {
      echo "<h2><img src=\"icons/admin.gif\" alt=\"\"/> Admin menu</h2>\n";
      echo "<p>\n";
      echo "<a href=\"cl_schval.php\">Schválit články</a><br/>\n";
      echo "<a href=\"ne_schval.php\">Schválit novinky</a><br/>\n";

      if ($k_stav == "0") {
        echo "<a href=\"ko_schval.php\">Schválit komentáře</a><br/><br/>\n";
      } else {
        echo "<br/>";
      }

      echo "<a href=\"us_prehled.php\">Uživatelé</a><br/>\n";
      echo "<a href=\"bo_seznam.php\">Postranní boxy</a><br/>\n";
      echo "<a href=\"cl_sekce.php\">Rubriky</a>\n";
      echo "</p>\n";
    }
    ?>

      <h2><img src="icons/arts.gif" alt=""/> Články</h2>
      <p>
        <a href="cl_insert.php">Vložit článek</a><br/>
        <a href="cl_files.php">Nahrát soubor</a><br/><br/>
        <a href="cl_passno.php">Neschválené články</a><br/>
        <a href="cl_pass.php">Schválené články</a><br/>
        <a href="cl_vydane.php">Vydané články</a>
      </p>

      <h2><img src="icons/news.gif" alt=""/> Novinky</h2>
      <p>
        <a href="ne_insert.php">Vložit novinku</a><br/>
        <a href="ne_passno.php">Neschválené novinky</a><br/>
       <a href="ne_pass.php">Schválené novinky</a>
      </p>

    </div></div></div>

  <hr/>

    <div id="vpravo"><div class="layout_1"><div class="layout_2">