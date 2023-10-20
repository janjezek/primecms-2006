<?php
include "include/header.php";

echo "<h1>Administrace &gt; Smaz˜n˜ u˜ivatele</h1>\n";

$id = $_GET["id"];

/*--- zji˜t˜n˜ pr˜v ---*/

if ($_data["prava"] == "1") {

  $sql = "delete from autori where id = '$id'";
  $result = mysqli_query($db,$sql);

  if (!$result) {
    alert2("U˜ivatel nebyl smaz˜n z datab˜ze!");
  }
  alert("U˜ivatel byl ˜sp˜n˜ smaz˜n z datab˜ze.");

} else {
  alert2("Neopr˜vn˜n˜ p˜˜stup!<br/>Do t˜to sekce maj˜ p˜˜stup jen administr˜to˜i!");
}

include "include/footer.php";
?>