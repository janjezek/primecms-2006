<?php
include "include/header.php";

echo "<h1>Administrace &gt; Smaz�n� novinky</h1>\n";

$id = $_GET["id"];

$result = mysqli_query($db,"select autor from novinky where id = '$id'");
$row = mysqli_fetch_array($result);

/*--- zji�t�n� pr�v a autorstv� ---*/

if ($row["autor"] == $_id or $_data["prava"] == "1") {

$sql = "delete from novinky where id = '$id'";
$res = mysqli_query($db,$sql);
if (!$res) {
  alert2("Novinka nebyla smaz�na z datab�ze!");
} else {
  alert("Novinka byla �sp�n� smaz�na z datab�ze.");
}

} else {
  alert2("Neopr�vn�n� p��stup!<br/>Smazat m��ete pouze sv� vlastn� novinky!");
}

include "include/footer.php";
?>