<?php
include "include/header.php";

echo "<h1>Administrace &gt; Smaz�n� �l�nku</h1>\n";

$id = $_GET["id"];

$res = mysqli_query($db,"select id_autor from clanky where id = '$id'");
$row = mysqli_fetch_array($res);

/*--- kontrola autorstv� a pr�v ---*/

if ($row["id_autor"] == $_id or $_data["prava"] == "1") {
  $sql = "delete from clanky where id = '$id'";
  $result = mysqli_query($db,$sql);

  if (!$result) {
    alert2("�l�nek nebyl smaz�n z datab�ze!");
  } else {
    alert("�l�nek byl �sp�n� smaz�n z datab�ze.");
  }

} else {
  alert2("Neopr�vn�n� p��stup!<br/>Smazat m��ete pouze sv� vlastn� �l�nky!");
}

include "include/footer.php";
?>