<?php
include "include/header.php";

echo "<h1>Administrace &gt; Úprava uživatele</h1>\n";

/*--- zjištìní práv ---*/

if ($_data["prava"] == "1") {

/*--- úprava ---*/

if(isset($_POST["update"])) {

  if (isset($_GET["id"])) {
    $id = $_GET["id"];
  } elseif (isset($_POST["id"])) {
    $id = $_POST["id"];
  }

  $id = $_POST["id"];
  $login = $_POST["login"];
  $heslo = $_POST["heslo"];
  $jmeno = $_POST["jmeno"];
  $email = $_POST["email"];
  $pozic = $_POST["pozic"];
  $informace = $_POST["informace"];

  $sql = "update autori set login = '$login', heslo = '$heslo', jmeno = '$jmeno', email = '$email', prava = '$pozic', informace = '$informace' where id = '$id'";
  $result = mysqli_query($db,$sql);

  if (!$result) {
    alert2("Uživatelovy údaje nebyly upraveny!");;
  }
  alert("Uživatelovy údaje byly úspìšnì opraveny.");
} else {

  if (isset($_GET["id"])) {
    $id = $_GET["id"];
  } elseif (isset($_POST["id"])) {
    $id = $_POST["id"];
  }

  $result = mysqli_query($db,"select * from autori where id = $id");
  $myrow = mysqli_fetch_array($result);
?>
  <form method="post" action="us_edit.php">
  <div>
  <table style="width: 100%" cellspacing="0" cellpadding="0">
    <tr>
      <td>
        Pozice:
      </td>
      <td>
        <select name="pozic">
        <?php
        $prava = $myrow["prava"];

        if ($prava == "1") {
          echo "<option value=\"1\">Administrátor</option>\n<option value=\"0\">Redaktor</option>\n";
        } else {
          echo "<option value=\"0\">Redaktor</option>\n<option value=\"1\">Administrátor</option>\n";
        }
        ?>
        </select>
      </td>
    </tr>
    <tr>
      <td>
        <input type="hidden" name="id" value="<?php echo $myrow["id"]?>"/>
        Nick:
      </td>
      <td>
        <input type="text" name="login" size="40" value="<?php echo $myrow["login"]?>"/>
      </td>
    </tr>
    <tr>
      <td>
        Heslo:
      </td>
      <td>
        <input type="text" name="heslo" size="40" value="<?php echo $myrow["heslo"]?>"/>
      </td>
    </tr>
    <tr>
      <td>
        Jméno:
      </td>
      <td>
        <input type="text" name="jmeno" size="40" value="<?php echo $myrow["jmeno"]?>"/>
      </td>
    </tr>
    <tr>
      <td>
        Email:
      </td>
      <td>
        <input type="text" name="email" size="40" value="<?php echo $myrow["email"]?>"/>
      </td>
    </tr>
    <tr>
      <td>
        Poznámka:
      </td>
      <td>
        <textarea name="informace" rows="5" cols="40"><?php echo $myrow["informace"]?></textarea>
      </td>
    </tr>

  </table>

    <input type="submit" name="update" value="Upravit"/>
    </div>
  </form>
<?php
}

} else {
  alert2("Neoprávnìný pøístup!<br/>Do této sekce mají pøístup jen administrátoøi!");
}

include "include/footer.php";
?>
