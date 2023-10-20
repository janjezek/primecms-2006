<?php
echo "<?xml version=\"1.0\" encoding=\"windows-1250\"?>\n";
include "include/connect.php";

/* --- definice funkcí --- */

function cr_head($sitename, $title) {
include "include/connect.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
    "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <meta http-equiv="content-type" content="text/html; charset=windows-1250"/>
  <meta http-equiv="content-language" content="cs"/>
  <meta http-equiv="cache-control" content="no-cache"/>
  <meta http-equiv="pragma" content="no-cache"/>
  <meta http-equiv="expires" content="-1"/>

  <meta name="description" content="<?php echo $desc;?>"/>
  <meta name="keywords" content="<?php echo "$keyw";?>"/>

  <link rel="shortcut icon" type="image/x-icon" href="favicon.ico"/>
  <link rel="stylesheet" href="include/style.css" type="text/css"/>

  <title><?php echo "$sitename - $title";?></title>
</head>

<body>

<div id="page">

  <div id="header"><div class="layout_1"><div class="layout_2">
    <!-- hlavička -->
    <div id="top">
      <h1><?php echo $title;?></h1>
    </div>
  </div></div></div>

  <div id="holder">

    <div id="left"><div class="layout_1"><div class="layout_2">
<?php
include "include/connect.php";

/* --- rubriky --- */

$res = mysqli_query($db,"select id, rubrika from rubriky order by rubrika");

echo "<h2>Rubriky</h2>\n";
echo "<div  class=\"box\">\n<div class=\"menu\">\n";
echo "<a href=\"index.php\">Titulní stránka</a><br/>\n";

while ($row2 = mysqli_fetch_array($res)) {
  $id2 = $row2["id"];
  $jmeno = $row2["rubrika"];

  echo "<a href=\"section.php?id=$id2\">$jmeno</a><br/>\n";
}

echo "</div>\n</div>\n";


?>
<h2>Vyhledávání</h2>
<div class="box">
  <form action="search.php" method="get">
    <div>
      Hledaný výraz:<br/>
      <input type="text" name="id" size="17"/><br/>
      <input type="submit" value="Hledat"/>
    </div>
  </form>
</div>

<?php

/* --- boxy --- */

$vysledek = mysqli_query($db,"select pozice, head, body from boxy where strana = 0 order by pozice asc");

while ($row = mysqli_fetch_array($vysledek)) {
  $hd = $row["head"];
  $bd = $row["body"];

box($hd, $bd);
}
?>
  </div></div></div>

  <div id="main"><div class="layout_1"><div class="layout_2">
    <!-- prostřední sloupec -->
<?php
}

function clanek($id2, $nadpis, $perex, $r_id, $rubrika, $a_id, $jmeno, $datum, $comx, $k_ok, $format) {
  echo "<h3><a href=\"article.php?id=$id2\">$nadpis</a></h3>";
  echo "<p class=\"rubrika\">Rubrika: <a href=\"section.php?id=$r_id\">$rubrika</a></p>";
  echo "<p class=\"justify\">$perex</p><p class=\"info\">Vydáno $datum</p> ";
  echo "<p class=\"info\"><a href=\"author.php?id=$a_id\">$jmeno</a></p> ";

  if ($k_ok == "1") {
    echo "<p class=\"info\"><a href=\"comment.php?id=$id2\">$comx</a></p>";
  }
}

function box($head, $body) {
  echo "<h2>$head</h2>\n";
	echo "<div class=\"box\">\n";
	echo $body;
  echo "</div>\n";
}
?>
