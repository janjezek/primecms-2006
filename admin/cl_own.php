<?php
include "include/header.php";

echo "<h1>Administrace &gt; Vlastn� �l�nky</h1>\n";

/*--- listov�n� ---*/

$pocet = $pocet_adm;
$cas = time();

if (!isset($_GET["list"])) {
  $list = 1;
  $zaznam = 0;
} else {
  $list = $_GET["list"];
  $newlist = $list - 1;
  $zaznam = $pocet * $newlist;
}

/*--- v�pis sekc� se zobraz� jen pokud jsou vlo�eny n�jak� �l�nky ---*/

$vys_celk = mysqli_query($db,"select id from clanky where id_autor = '$_id'");
$vys_celkem = mysqli_num_rows($vys_celk);

if ($vys_celkem != "0") {

  /*--- zobrazen� v�pisu sekc� ---*/

  echo "<table><tr><td>Vybrat jen �l�nky z rubriky:</td><td><form action=\"cl_own.php\"><div>\n";
  echo "<select name=\"id\">\n";

  $res = mysqli_query($db,"select id, rubrika from rubriky order by rubrika");

  while ($row = mysqli_fetch_array($res)) {
    $id = $row["id"];
    $rubrika = $row["rubrika"];

    echo "<option value=\"$id\"";

    if ($_GET["id"] == $id)
      echo " selected=\"selected\"";

    echo ">$rubrika</option>\n";
  }
  echo "</select><input type=\"submit\" value=\"Jdi\"/></div></form></td></tr></table>\n";
}

/*--- dotazy rozd�len� podle parametru ID ---*/

if (isset($_GET["id"])) {
  $id_r = $_GET["id"];

  $vysledek_celk = mysqli_query($db,"select id from clanky where id_rubrika = '$id_r' and id_autor = '$_id'");
  $vysledek = mysqli_query($db,"select c.id,c.nadpis,c.perex,r.rubrika,a.jmeno from clanky c, rubriky r, autori a where c.id_rubrika = r.id and c.id_autor = a.id and id_rubrika = '$id_r' and c.id_autor = '$_id' order by c.datum desc limit $zaznam, $pocet");

  $cl_celkem = mysqli_num_rows($vysledek);

  if ($cl_celkem != "0") {
    echo "<table class=\"vp_table\"><tr><td class=\"vp_cell1_cl\">N�zev</td><td class=\"vp_cell2\">Mo�nosti</td></tr>";

    while ($row = mysqli_fetch_array($vysledek)) {
      $id = $row["id"];
      $nadpis = $row["nadpis"];
      $perex = $row["perex"];
      $rubrika = $row["rubrika"];
      $jmeno = $row["jmeno"];

      echo "<tr><td>$nadpis</td>\n<td><a href=\"../cl_preview.php?id=$id\" title=\"Zobrazit\"><img src=\"icons/preview.gif\" alt=\"Zobrazit\"/> Zobrazit</a>, <a href=\"cl_edit.php?id=$id\" title=\"Upravit\"><img src=\"icons/edit.gif\" alt=\"Upravit\"/> Upravit</a>, <a href=\"cl_delete.php?id=$id\" onclick=\"return confirm('Opravdu chcete smazat tento �l�nek?')\" title=\"Smazat\"><img src=\"icons/delete.gif\" alt=\"Smazat\"/> Smazat</a></td>\n</tr>\n";
    }
    echo "</table>";
  }
} else {
  $vysledek_celk = mysqli_query($db,"select id from clanky where id_autor = '$_id'");
  $vysledek = mysqli_query($db,"select c.id,c.nadpis,c.perex,r.rubrika,a.jmeno from clanky c, rubriky r, autori a where c.id_rubrika = r.id and c.id_autor = a.id and c.id_autor = '$_id' order by c.datum desc limit $zaznam, $pocet");

  $cl_celkem = mysqli_num_rows($vysledek);

  if ($cl_celkem != "0") {
    echo "<table class=\"vp_table\"><tr><td class=\"vp_cell1_cl\">N�zev</td><td class=\"vp_cell2\">Mo�nosti</td></tr>";

    while ($row = mysqli_fetch_array($vysledek)) {
      $id = $row["id"];
      $nadpis = $row["nadpis"];
      $perex = $row["perex"];
      $rubrika = $row["rubrika"];
      $jmeno = $row["jmeno"];

      echo "<tr><td>$nadpis</td>\n<td><a href=\"../cl_preview.php?id=$id\" title=\"Zobrazit\"><img src=\"icons/preview.gif\" alt=\"Zobrazit\"/> Zobrazit</a>, <a href=\"cl_edit.php?id=$id\" title=\"Upravit\"><img src=\"icons/edit.gif\" alt=\"Upravit\"/> Upravit</a>, <a href=\"cl_delete.php?id=$id\" onclick=\"return confirm('Opravdu chcete smazat tento �l�nek?')\" title=\"Smazat\"><img src=\"icons/delete.gif\" alt=\"Smazat\"/> Smazat</a></td>\n</tr>\n";
    }
    echo "</table>";
  }
}
$id = $_GET["id"];

include "listovani.php";
include "include/footer.php";
?>