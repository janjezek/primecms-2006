<?php
include "include/header.php";

echo "<h1>Administrace &gt; Schválené novinky</h1>\n";

/*--- listování ---*/

$pocet = $pocet_adm;

if (!isset($_GET["list"])) {
  $list = 1;
  $zaznam = 0;
} else {
  $_list = $_GET["list"];
  $newlist = $list - 1;
  $zaznam = $pocet * $newlist;
}

$vysledek_celk = mysqli_query($db,"select id from novinky where stav = 'v'");
$vysledek = mysqli_query($db,"select n.*, a.jmeno from novinky n, autori a where n.autor = a.id and stav = 'v' order by n.id desc limit $zaznam, $pocet");

$ne_celkem = mysqli_num_rows($vysledek);

/*--- sestavení tabulky ---*/

if ($ne_celkem != "0") {
  echo "<table class=\"vp_table\"><tr><td class=\"vp_cell1\">Název</td><td class=\"vp_cell2\">Možnosti</td></tr>";

  while ($row = mysqli_fetch_array($vysledek)) {
  $id = $row["id"];
  $datum = $row["datum"];
  $titulek = $row["titulek"];
  $novinka = $row["novinka"];
  $jmeno = $row["jmeno"];

    echo "<tr><td>$titulek</td>\n<td><a href=\"ne_edit.php?id=$id\" title=\"Upravit\"><img src=\"icons/edit.gif\" alt=\"Upravit\"/> Upravit</a>, <a href=\"ne_delete.php?id=$id\" onclick=\"return confirm('Opravdu chcete smazat tuto novinku?')\" title=\"Smazat\"><img src=\"icons/delete.gif\" alt=\"Smazat\"/> Smazat</a></td>\n</tr>\n";
  }
  echo "</table>";
}

include "listovani.php";
include "include/footer.php";
?>