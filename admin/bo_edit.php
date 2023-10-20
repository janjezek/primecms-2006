<?php
include "include/header.php";

echo "<h1>Administrace &gt; Úprava boxu</h1>\n";

/* --- zjištìní práv uživatele --- */

if ($_data["prava"] == "1") {

  /* --- zjištìní pøítomnosti promìnné $id --- */

  if (isset($_POST["submit"])) {

    if (isset($_POST["id"])) {

      $id = $_POST["id"];
      $strana = $_POST["strana"];
      $pozice = $_POST["pozice"];
      $head = $_POST["head"];
      $body = $_POST["body"];

      $sql = "update boxy set strana = '$strana', pozice = '$pozice', head = '$head', body = '$body' where id = '$id'";
      $result = mysqli_query($db,$sql);

        /* --- chybová hlášení --- */

        if (!$result) {
          alert2("Box nebyl upraven v databázi!");
        } else {
          alert("Box byl úspìšnì upraven v databázi.");
        }

    } else {
      alert2("Požadavek nelze provést! Není stanoven parametr ID!");
    }

  } else {

    /* --- zjištìní pøítomnosti promìnné $id --- */

    if (isset($_GET["id"])) {

      $id = $_GET["id"];
      $result = mysqli_query($db,"select * from boxy where id = '$id'");
      $odp_1 = mysqli_num_rows($result);

/* --- kontrola správnosti parametru ID --- */

      if ($odp_1 == "1") {
        $myrow2 = mysqli_fetch_array($result);
?>

<form method="post" action="bo_edit.php">
<div>
<table id="table_form" cellspacing="0" cellpadding="0">
    <tr>
      <td>
        Strana:
      </td>
      <td>
        <select name="strana">
          <?php
            if ($myrow2["strana"] == "0") {
              echo "<option value=\"0\" selected=\"selected\">vlevo</option><option value=\"1\">vpravo</option>";
            } else {
              echo "<option value=\"1\" selected=\"selected\">vpravo</option><option value=\"0\">vlevo</option>";
            }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td>
        <input type="hidden" name="id" value="<?php echo $myrow2["id"];?>"/>
        Pozice:
      </td>
      <td>
        <select name="pozice">
          <?php
          for ($i=1; $i<= 10; $i++)
          {
            echo "<option value=\"$i\"";
            if ($myrow2["pozice"] == $i) {
            echo " selected=\"selected\"";
            }
            echo ">$i</option>\n";
          }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td>
        Nadpis:
      </td>
      <td>
        <input type="text" name="head" value="<?php echo $myrow2["head"];?>" size="90"/>
      </td>
    </tr>
      <tr>
      <td>
        Obsah:
      </td>
      <td>
        <textarea name="body" id="clanek" rows="15" cols="90"><?php echo $myrow2["body"];?></textarea>
      </td>
    </tr>
  </table>

<input type="submit" name="submit" value="Uložit"/>
</div>
</form>

<?php
/* --- chybová hlášení --- */

      } else {
        alert2("Požadavek nelze provést! Je stanoven chybný parametr ID!");
      }

    } else {
      alert2("Požadavek nelze provést! Není stanoven parametr ID!");
    }
  }

} else {
  alert2("Neoprávnìný pøístup!<br/>Do této sekce mají pøístup jen administrátoøi!");
}

include "include/footer.php";
?>