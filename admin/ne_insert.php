<?php
include "include/header.php";

echo "<h1>Administrace &gt; Vlo�it novinku</h1>\n";

/*--- vlo�en� do datab�ze ---*/

if(isset($_POST["submit"]))
{
  $titulek = $_POST["titulek"];
  $novinka = $_POST["novinka"];

  if ($_data["prava"] == 1) {
    $stav = "v";
  } else {
    $stav = "n";
  }

  $datum = date("j. m. Y G:i");
  $sql = "insert into novinky (autor, titulek, novinka, datum, stav) values ('$_id','$titulek','$novinka','$datum','$stav')";
  $result = mysqli_query($db,$sql);
  if (!$result) {
  alert2("Novinka nebyla ulo�ena v datab�zi!");
  }
  alert("Novinka byla �sp�n� ulo�ena v datab�zi.");
}

?>

<form method="post" action="ne_insert.php">
<div>
  <table id="table_form" cellspacing="0" cellpadding="0">
    <tr>
      <td>
        Autor:
      </td>
      <td>
      <?php echo $_data["jmeno"]; ?>
      </td>
    </tr>
    <tr>
      <td>
        Titulek:
      </td>
      <td>
        <input type="text" name="titulek" size="70"/>
      </td>
    </tr>
    <tr>
      <td>
        Text:
      </td>
      <td>
        <textarea name="novinka" id="clanek" rows="15" cols="90"></textarea>
      </td>
    </tr>
  </table>

<input type="submit" name="submit" value="Ulo�it"/>
</div>
</form>

<?php
include "include/footer.php";
?>