<?php
include "include/header.php";

echo "<h1>Administrace &gt; Rubriky</h1>\n";

/*--- zjištìní práv ---*/

if ($_data["prava"] == "1") {

  /*--- smazání ---*/

  if(isset($_GET["delete"])) {
    $id = $_GET["id"];

    $sql = "delete from rubriky where id = '$id'";
    $result = mysqli_query($db,$sql);

    if (!$result) {
      alert2("Rubrika nebyla smazána z databáze!");
    }
    alert("Rubrika byla úspìšnì smazána z databáze.");
  }

  /*--- úprava ---*/

  if(isset($_POST["change"])) {
    $id = $_POST["id"];
    $rubrika = $_POST["rubrika"];

    $sql = "update rubriky set rubrika = '$rubrika' where id = '$id'";
    $result = mysqli_query($db,$sql);

    if (!$result) {
      alert2("Rubrika nebyla upravena v databázi!");
    }
    alert("Rubrika byla úspìšnì upravena v databázi.");
  }

  /*--- pøidání ---*/

  if(isset($_POST["submit"])) {
    $rubrika = $_POST["rubrika"];

    $sql = "insert into rubriky (rubrika) values ('$rubrika')";
    $result = mysqli_query($db,$sql);

    if (!$result) {
      alert2("Rubrika nebyla uložena v databázi!");
    }
    alert("Rubrika byla úspìšnì uložena v databázi.");
  }
?>

<form method="post" action="cl_sekce.php">
<div>
  <table id="table_form" cellspacing="0" cellpadding="0">
    <tr>
      <td>
        Název:
      </td>
      <td>
<?php
  if (isset($_GET["op"])) {
    $id = $_GET["id"];

    $result = mysqli_query($db,"select * from rubriky where id = $id");
    $row = mysqli_fetch_array($result);

    $id = $row["id"];
    $rubrika = $row["rubrika"];

    echo "<input type=\"text\" name=\"rubrika\" size=\"35\" value=\"$rubrika\"/>\n<input type=\"hidden\" name=\"id\" value=\"$id\"/>\n</td>\n</tr>\n</table>\n<input type=\"submit\" name=\"change\" value=\"Upravit\"/>\n</div></form>";
  } else {
    echo "<input type=\"text\" name=\"rubrika\" size=\"35\"/>\n</td>\n</tr>\n</table>\n<input type=\"submit\" name=\"submit\" value=\"Pøidat\"/>\n</div></form>";
  }

  $res = mysqli_query($db,"select id, rubrika from rubriky order by rubrika");

  echo "<br/><table class=\"vp_table\"><tr><td class=\"vp_cell1\">Název</td><td class=\"vp_cell2\">Možnosti</td></tr>";

  while ($row2 = mysqli_fetch_array($res)) {
    $id2 = $row2["id"];
    $jmeno = $row2["rubrika"];

    echo "<tr><td>$jmeno</td><td><a href=\"cl_sekce.php?op=edit&amp;id=$id2\" title=\"Upravit\"><img src=\"icons/edit.gif\" alt=\"Upravit\"/> Upravit</a>, <a href=\"cl_sekce.php?id=$id2&amp;delete\" onclick=\"return confirm('Opravdu chcete smazat tuto rubriku?')\"><img src=\"icons/delete.gif\" alt=\"Smazat\"/> Smazat</a></td></tr>\n";
  }

  echo "</table>";
} else {
  alert2("Neoprávnìný pøístup!<br/>Do této sekce mají pøístup jen administrátoøi!");
}

include "include/footer.php";
?>