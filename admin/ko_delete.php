s<?php
include "include/header.php";

echo "<h1>Administrace &gt; Smaz�n� koment��e</h1>\n";

$id = $_GET["id"];

/*--- zji�t�n� pr�v a autorstv� ---*/

if ($_data["prava"] == "1") {
  $sql = "delete from komentare where id = '$id'";
  $res = mysqli_query($db,$sql);

  if (!$res) {
    alert2("Koment�� nebyl smaz�n z datab�ze!");
  } else {
    alert("Koment�� byl �sp�n� smaz�n z datab�ze.");
  }

} else {
  alert2("Neopr�vn�n� p��stup!<br/>Do t�to sekce maj� p��stup pouze administr�to�i!");
}

include "include/footer.php";
?>