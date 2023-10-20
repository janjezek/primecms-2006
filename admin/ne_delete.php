<?php
include "include/header.php";

echo "<h1>Administrace &gt; Smazání novinky</h1>\n";

$id = $_GET["id"];

$result = mysqli_query($db,"select autor from novinky where id = '$id'");
$row = mysqli_fetch_array($result);

/*--- zjištìní práv a autorství ---*/

if ($row["autor"] == $_id or $_data["prava"] == "1") {

$sql = "delete from novinky where id = '$id'";
$res = mysqli_query($db,$sql);
if (!$res) {
  alert2("Novinka nebyla smazána z databáze!");
} else {
  alert("Novinka byla úspìšnì smazána z databáze.");
}

} else {
  alert2("Neoprávnìný pøístup!<br/>Smazat mùžete pouze své vlastní novinky!");
}

include "include/footer.php";
?>