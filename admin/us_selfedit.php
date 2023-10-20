<?php
include "include/header.php";

echo "<h1>Administrace &gt; Úprava uživatele</h1>\n";

/*--- úprava údajù ---*/

if(isset($_POST["update"])) {
  $login = $_POST["login"];
  $heslo = $_POST["heslo"];
  $jmeno = $_POST["jmeno"];
  $email = $_POST["email"];
  $informace = $_POST["informace"];

  $sql = "update autori set login = '$login', heslo = '$heslo', jmeno = '$jmeno', email = '$email', informace = '$informace' where id = '$_id'";
  $result = mysqli_query($db,$sql);

  if (!$result) {
    alert2("Uživatelovy údaje nebyly upraveny!");
  }
  alert("Uživatelovy údaje byly úspìšnì opraveny.");
} else {
  $result = mysqli_query($db,"select * from autori where id = $_id");
  $row = mysqli_fetch_array($result);
?>
  <form method="post" action="us_selfedit.php">
  <div>
  <table id="table_form" cellspacing="0" cellpadding="0">
    <tr>
      <td>
        Pozice:
      </td>
      <td>
        <?php
        $prava = $_data["prava"];

        if ($prava == "1") {
          $pozice = "Administrátor";
        } else {
          $pozice = "Redaktor";
        }
        echo $pozice;
        ?>
      </td>
    </tr>
    <tr>
      <td>
        Nick:
      </td>
      <td>
        <input type="text" name="login" size="40" value="<?php echo $row["login"];?>"/>
      </td>
    </tr>
    <tr>
      <td>
        Heslo:
      </td>
      <td>
        <input type="text" name="heslo" size="40" value="<?php echo $row["heslo"];?>"/>
      </td>
    </tr>
    <tr>
      <td>
        Jméno:
      </td>
      <td>
        <input type="text" name="jmeno" size="40" value="<?php echo $row["jmeno"];?>"/>
      </td>
    </tr>
    <tr>
      <td>
        Email:
      </td>
      <td>
        <input type="text" name="email" size="40" value="<?php echo $row["email"];?>"/>
      </td>
    </tr>
    <tr>
      <td>
        Poznámka:
      </td>
      <td>
        <textarea name="informace" rows="5" cols="40"><?php echo $row["informace"];?></textarea>
      </td>
    </tr>

  </table>

    <input type="submit" name="update" value="Upravit"/>
    </div>
  </form>
<?php
}

include "include/footer.php";
?>