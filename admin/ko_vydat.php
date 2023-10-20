<?php
include "include/header.php";

echo "<h1>Administrace &gt; Schválení komentáøe</h1>\n";

if (isset($_GET["id"])) {
  $id = $_GET["id"];
}

/*--- zjištìní autorství a práv ---*/

if ($_data["prava"] == "1") {

  /*--- vybrání ID èlánku ke kterému patøí komentáø ---*/

  $result_x = mysqli_query($db,"select id_clanek from komentare where id = '$id'");
  $a = mysqli_fetch_array($result_x);

  $id_clanek = $a["id_clanek"];

  /*--- zjištìní poètu schválenıch komentáøù u èlánku ---*/

  $result_y = mysqli_query($db,"select id from komentare where id_clanek = '$id_clanek' and stav = '1'");
  $odp_1 = mysqli_num_rows($result_y);

  /*--- spoèítání èísla komentáøe ---*/

  if ($odp_1 == "0") {
    $kom_cislo = "1";
  } else {
    $kom_cislo = $odp_1+1;
  }

  $sql = "update komentare set stav = '1', cislo = '$kom_cislo' where id = '$id'";
  $result = mysqli_query($db,$sql);

  if (!$result) {
    alert2("Komentáø nebyl schválen!");
  } else {
    alert("Komentáø byl schválen.");
  }

} else {
  alert2("Neoprávnìnı pøístup!<br/>Do této sekce mají pøístup pouze administrátoøi!");
}

include "include/footer.php";
?>