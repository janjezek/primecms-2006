<?php
include "include/header.php";

echo "<h1>Administrace &gt; Schválit komentáøe</h1>\n";

/*--- listování ---*/

$pocet = $pocet_adm;

if (!isset($_GET["list"])) {
  $list = 1;
  $zaznam = 0;
} else {
  $list = $_GET["list"];
  $newlist = $list - 1;
  $zaznam = $pocet * $newlist;
}

/*--- vypsání prvních 50ti znakù komentáøe ---*/

function perex($text) {
  if (strlen($text) > 50) {
    $text = substr($text, 0, 50);
    $text = "$text ...";
  }
  return $text;
}

$vysledek_celk = mysqli_query($db,"select id from komentare where stav = '0'");
$vysledek = mysqli_query($db,"select id, text from komentare where stav = '0' order by datum desc limit $zaznam, $pocet");

$ne_celkem = mysqli_num_rows($vysledek);

/*--- sestavení tabulky ---*/

if ($ne_celkem != "0") {
  echo "<table class=\"vp_table\"><tr><td class=\"vp_cell1_cl\">Název</td><td class=\"vp_cell2\">Možnosti</td></tr>";

  while ($row = mysqli_fetch_array($vysledek)) {
    $id = $row["id"];
    $textus = $row["text"];

    $textx = perex($textus);

    echo "<tr><td>$textx</td>\n<td><a href=\"ko_view.php?id=$id\" title=\"Zobrazit\"><img src=\"icons/preview.gif\" alt=\"Zobrazit\"/> Zobrazit</a>, <a href=\"ko_edit.php?id=$id\" title=\"Upravit\"><img src=\"icons/edit.gif\" alt=\"Upravit\"/> Upravit</a>, <a href=\"ko_delete.php?id=$id\" onclick=\"return confirm('Opravdu chcete smazat tento komentáø?')\" title=\"Smazat\"><img src=\"icons/delete.gif\" alt=\"Smazat\"/> Smazat</a></td>\n</tr>\n";
  }
  echo "</table>";
}

include "listovani.php";
include "include/footer.php";
?>