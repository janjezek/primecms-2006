<?php
include "include/header.php";

echo "<h1>Administrace &gt; Úprava novinky</h1>\n";

if (isset($_GET["id"])) {
  $id = $_GET["id"];
} elseif (isset($_POST["id"])) {
  $id = $_POST["id"];
}

$res = mysqli_query($db,"select autor from novinky where id = '$id'");
$row2 = mysqli_fetch_array($res);

/*--- zjištìní autorství a práv ---*/

if ($row2["autor"] == $_id or $_data["prava"] == "1") {

/*--- úprava v databázi ---*/

if(isset($_POST["submit"]))
{
  $titulek = $_POST["titulek"];
  $id = $_POST["id"];
  $novinka = $_POST["novinka"];

  $sql = "update novinky set titulek = '$titulek', novinka = '$novinka' where id = '$id'";
  $result = mysqli_query($db,$sql);
  if (!$result) {
    alert2("Novinka nebyla upravena v databázi!");
  } else {
    alert("Novinka byla úspìšnì upravena v databázi.");
  }
} else {
$result = mysqli_query($db,"select n.*, a.jmeno from novinky n, autori a where n.id = '$id' and n.autor = a.id");
$myrow2 = mysqli_fetch_array($result);
?>

<form method="post" action="ne_edit.php">
<div>
<table id="table_form" cellspacing="0" cellpadding="0">
    <tr>
      <td>
        <input type="hidden" name="id" value="<?php echo $myrow2["id"];?>"/>
        Autor:
      </td>
      <td>
        <?php echo $myrow2["jmeno"];?>
      </td>
    </tr>
    <tr>
      <td>
        Vloženo:
      </td>
      <td>
        <?php echo $myrow2["datum"];?>
      </td>
    </tr>
    <tr>
      <td>
        Titulek:
      </td>
      <td>
        <input type="text" name="titulek" value="<?php echo $myrow2["titulek"];?>" size="70"/>
      </td>
    </tr>
      <tr>
      <td>
        Obsah:
      </td>
      <td>
        <textarea name="novinka" id="clanek" rows="15" cols="90"><?php echo $myrow2["novinka"];?></textarea>
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