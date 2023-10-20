<?php
include "include/header.php";

echo "<h1>Administrace &gt; P�ehled u�ivatel�</h1>\n";
echo "<p><a href=\"us_insert.php\" class=\"od_pridat\">P�idat u�ivatele</a></p>\n";

/*--- zji�t�n� pr�v ---*/

if ($_data["prava"] == "1") {

  /*--- listov�n� ---*/

  $pocet_adm = $pocet;

  if (!isset($_GET["list"])) {
    $list = 1;
    $zaznam = 0;
  } else {
    $_list = $_GET["list"];
    $newlist = $list - 1;
    $zaznam = $pocet * $newlist;
  }

  $vysledek_celk = mysqli_query($db,"select id from autori");
  $vysledek  = mysqli_query($db,"select id, jmeno, email, informace, prava from autori order by jmeno limit $zaznam, $pocet");

  echo "<table class=\"vp_table\"><tr><td class=\"vp_cell1\">N�zev</td><td class=\"vp_cell2\">Mo�nosti</td></tr>";

  while ($row = mysqli_fetch_array($vysledek)) {
    $id = $row["id"];
    $prava = $row["prava"];
    $jmeno = $row["jmeno"];
    $email = $row["email"];
    $informace = $row["informace"];

    if ($prava == "1") {
      $pozice = "Administr�tor";
    } else {
      $pozice = "Redaktor";
    }

    echo "<tr><td>$jmeno</td>\n<td><a href=\"us_edit.php?id=$id\" title=\"Upravit\"><img src=\"icons/edit.gif\" alt=\"Upravit\"/> Upravit</a>, <a href=\"us_delete.php?id=$id\" onclick=\"return confirm('Opravdu chcete smazat tohoto u�ivatele?')\" title=\"Smazat\"><img src=\"icons/delete.gif\" alt=\"Smazat\"/> Smazat</a></td></tr>\n";
  }

echo "</table>";
include "listovani.php";
} else {
  alert2("Neopr�vn�n� p��stup!<br/>Do t�to sekce maj� p��stup jen administr�to�i!");
}

include "include/footer.php";
?>