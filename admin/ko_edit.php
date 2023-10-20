<?php
include "include/header.php";

echo "<h1>Administrace &gt; Úprava komentáøe</h1>\n";

if (isset($_GET["id"])) {
  $id = $_GET["id"];
} elseif (isset($_POST["id"])) {
  $id = $_POST["id"];
}

/*--- zjištìní autorství a práv ---*/

if ($_data["prava"] == "1") {

  /*--- úprava v databázi ---*/

  if(isset($_POST["submit"])) {
    $id_clanek = $_POST["id_clanek"];
    $jmeno = $_POST["jmeno"];
    $email = $_POST["email"];
    $text = $_POST["text"];
    $stav = $_POST["stav"];

    /*--- komentáø má být vydán ---*/

    if ($stav == "1") {
      $result_y = mysqli_query($db,"select id from komentare where id_clanek = '$id_clanek' and stav = '1'");
      $odp_1 = mysqli_num_rows($result_y);

      /*--- spoèítání èísla komentáøe ---*/

      if ($odp_1 == "0") {
        $kom_cislo = "1";
      } else {
        $kom_cislo = $odp_1+1;
      }
    } else {
      $kom_cislo = "1";
    }

    $sql = "update komentare set stav = '$stav', cislo = '$kom_cislo', jmeno = '$jmeno', email = '$email', text = '$text' where id = '$id'";
    $result = mysqli_query($db,$sql);

    if (!$result) {
      alert2("Komentáø nebyl upraven v databázi!");
    } else {
      alert("Komentáø byl úspìšnì upraven v databázi.");
    }
  } else {
    $result = mysqli_query($db,"select c.nadpis,k.* from clanky c, komentare k where k.id_clanek = c.id and k.id = '$id'");
    $myrow2 = mysqli_fetch_array($result);
?>

<form method="post" action="ko_edit.php">
  <div>
    <table id="table_form" cellspacing="0" cellpadding="0">
      <tr>
        <td>Èlánek:</td>
        <td>
          <a href="../article.php?id=<?php echo $myrow2["id_clanek"];?>"><?php echo $myrow2["nadpis"];?></a>
        </td>
      </tr>
      <tr>
        <td>Vloženo:</td>
        <td>
          <?php echo $myrow2["datum"];?>
        </td>
      </tr>
      <tr>
        <td>
          <input type="hidden" name="id" value="<?php echo $myrow2["id"];?>"/>
          <input type="hidden" name="id_clanek" value="<?php echo $myrow2["id_clanek"];?>"/>
          Autor:
        </td>
        <td>
          <input type="text" name="jmeno" value="<?php echo $myrow2["jmeno"];?>"/>
        </td>
      </tr>
      <tr>
        <td>Email:</td>
        <td>
          <input type="text" name="email" value="<?php echo $myrow2["email"];?>"/>
        </td>
      </tr>
      <tr>
        <td>Obsah:</td>
        <td>
          <textarea name="text" rows="15" cols="90"><?php echo $myrow2["text"];?></textarea>
        </td>
      </tr>
      <tr>
        <td>Schválit:</td>
        <td>
          <select name="stav">
            <option value="1">Ano</option>
            <option value="0">Ne</option>
          </select>
        </td>
      </tr>
    </table>

    <input type="submit" name="submit" value="Uložit"/>
  </div>
</form>

<?php
  }
} else {
  alert2("Neoprávnìný pøístup!<br/>Mùžete upravovat pouze své vlastní novinky!");
}

include "include/footer.php";
?>