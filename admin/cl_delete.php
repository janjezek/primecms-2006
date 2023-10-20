<?php
include "include/header.php";

echo "<h1>Administrace &gt; Smazání èlánku</h1>\n";

$id = $_GET["id"];

$res = mysqli_query($db,"select id_autor from clanky where id = '$id'");
$row = mysqli_fetch_array($res);

/*--- kontrola autorství a práv ---*/

if ($row["id_autor"] == $_id or $_data["prava"] == "1") {
  $sql = "delete from clanky where id = '$id'";
  $result = mysqli_query($db,$sql);

  if (!$result) {
    alert2("Èlánek nebyl smazán z databáze!");
  } else {
    alert("Èlánek byl úspìšnì smazán z databáze.");
  }

} else {
  alert2("Neoprávnìný pøístup!<br/>Smazat mùžete pouze své vlastní èlánky!");
}

include "include/footer.php";
?>