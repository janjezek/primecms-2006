<?php
include "include/header.php";

echo "<h1>Administrace &gt; Zobrazení komentáøe</h1>\n";

if (isset($_GET["id"])) {
  $id = $_GET["id"];
} elseif (isset($_POST["id"])) {
  $id = $_POST["id"];
}

/*--- zjištìní autorství a práv ---*/

if ($_data["prava"] == "1") {
  $result = mysqli_query($db,"select c.nadpis,k.* from clanky c, komentare k where k.id_clanek = c.id and k.id = '$id'");
  $myrow2 = mysqli_fetch_array($result);
?>

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
        Email:
      </td>
      <td>
        <a href="mailto:<?php echo $myrow2["email"];?>"><?php echo $myrow2["email"];?></a>
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
        Èlánek:
      </td>
      <td>
        <a href="../article.php?id=<?php echo $myrow2["id_clanek"];?>"><?php echo $myrow2["nadpis"];?></a>
      </td>
    </tr>
    <tr>
      <td>
        Text:
      </td>
      <td>
        <?php echo $myrow2["text"];?>
      </td>
    </tr>
  </table>

<p></p>

<table class="vp_table">
  <tr>
    <td class="vp_cell2">Možnosti</td>
  </tr>
  <tr>
    <td>
      <a href="ko_vydat.php?id=<?php echo $myrow2["id"];?>" title="Schválit"><img src="icons/pub_1.gif" alt="Schválit"/> Schválit</a>,
      <a href="ko_edit.php?id=<?php echo $myrow2["id"];?>" title="Upravit"><img src="icons/edit.gif" alt="Upravit"/> Upravit</a>,
      <a href="ko_delete.php?id=<?php echo $myrow2["id"];?>" onclick="return confirm('Opravdu chcete smazat tento komentáø?')" title="Smazat"><img src="icons/delete.gif" alt="Smazat"/> Smazat</a>
    </td>
  </tr>
</table>


<?php
} else {
  alert2("Neoprávnìný pøístup!<br/>Do této sekce mají pøístup pouze administrátoøi!");
}

include "include/footer.php";
?>