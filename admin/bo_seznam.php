<?php
include "include/header.php";

echo "<h1>Administrace &gt; Seznam box�</h1>\n";
echo "<p><a href=\"bo_insert.php\" class=\"od_pridat\">P�idat box</a></p>\n";

/*--- kontrola pr�v u�ivatele ---*/

if ($_data["prava"] == "1") {
  $vysledek = mysqli_query($db,"select * from boxy order by pozice asc");
  $bo_celkem = mysqli_num_rows($vysledek);

  /*--- zobrazen� tabulky z�znam� ---*/

  if ($bo_celkem == "0") {
    alert2("Nenalezeny ��dn� z�znamy!");
  } else {
    echo "<table class=\"vp_table\"><tr><td class=\"vp_cell1\">N�zev</td><td class=\"vp_cell2\">Mo�nosti</td></tr>";

    while ($row = mysqli_fetch_array($vysledek)) {
      $id = $row["id"];
      $pozice = $row["pozice"];
      $head = $row["head"];
      $body = $row["body"];

      echo "<tr><td>$head</td>\n<td><a href=\"bo_edit.php?id=$id\" title=\"Upravit\"><img src=\"icons/edit.gif\" alt=\"Upravit\"/> Upravit</a>, <a href=\"bo_delete.php?id=$id\" onclick=\"return confirm('Opravdu chcete smazat tento box?')\" title=\"Smazat\"><img src=\"icons/delete.gif\" alt=\"Smazat\"/> Smazat</a></td></tr>\n";
    }
    echo "</table>";
  }

} else {
  alert2("Neopr�vn�n� p��stup!<br/>Do t�to sekce maj� p��stup jen administr�to�i!");
}

include "include/footer.php";
?>