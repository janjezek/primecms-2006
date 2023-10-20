s<?php
include "include/header.php";

echo "<h1>Administrace &gt; Smazání komentáøe</h1>\n";

$id = $_GET["id"];

/*--- zjištìní práv a autorství ---*/

if ($_data["prava"] == "1") {
  $sql = "delete from komentare where id = '$id'";
  $res = mysqli_query($db,$sql);

  if (!$res) {
    alert2("Komentáø nebyl smazán z databáze!");
  } else {
    alert("Komentáø byl úspìšnì smazán z databáze.");
  }

} else {
  alert2("Neoprávnìnı pøístup!<br/>Do této sekce mají pøístup pouze administrátoøi!");
}

include "include/footer.php";
?>