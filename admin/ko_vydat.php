<?php
include "include/header.php";

echo "<h1>Administrace &gt; Schv�len� koment��e</h1>\n";

if (isset($_GET["id"])) {
  $id = $_GET["id"];
}

/*--- zji�t�n� autorstv� a pr�v ---*/

if ($_data["prava"] == "1") {

  /*--- vybr�n� ID �l�nku ke kter�mu pat�� koment�� ---*/

  $result_x = mysqli_query($db,"select id_clanek from komentare where id = '$id'");
  $a = mysqli_fetch_array($result_x);

  $id_clanek = $a["id_clanek"];

  /*--- zji�t�n� po�tu schv�len�ch koment��� u �l�nku ---*/

  $result_y = mysqli_query($db,"select id from komentare where id_clanek = '$id_clanek' and stav = '1'");
  $odp_1 = mysqli_num_rows($result_y);

  /*--- spo��t�n� ��sla koment��e ---*/

  if ($odp_1 == "0") {
    $kom_cislo = "1";
  } else {
    $kom_cislo = $odp_1+1;
  }

  $sql = "update komentare set stav = '1', cislo = '$kom_cislo' where id = '$id'";
  $result = mysqli_query($db,$sql);

  if (!$result) {
    alert2("Koment�� nebyl schv�len!");
  } else {
    alert("Koment�� byl schv�len.");
  }

} else {
  alert2("Neopr�vn�n� p��stup!<br/>Do t�to sekce maj� p��stup pouze administr�to�i!");
}

include "include/footer.php";
?>