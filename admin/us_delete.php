<?php
include "include/header.php";

echo "<h1>Administrace &gt; Smazání uživatele</h1>\n";

$id = $_GET["id"];

/*--- zjištìní práv ---*/

if ($_data["prava"] == "1") {

  $sql = "delete from autori where id = '$id'";
  $result = mysqli_query($db,$sql);

  if (!$result) {
    alert2("Uživatel nebyl smazán z databáze!");
  }
  alert("Uživatel byl úspìšnì smazán z databáze.");

} else {
  alert2("Neoprávnìný pøístup!<br/>Do této sekce mají pøístup jen administrátoøi!");
}

include "include/footer.php";
?>