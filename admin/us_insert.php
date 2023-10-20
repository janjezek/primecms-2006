<?php
include "include/header.php";

echo "<h1>Administrace &gt; Pøidat uživatele</h1>\n";

/*--- zjištìní práv ---*/

if ($_data["prava"] == "1") {

  /*--- pøidání uživatele ---*/

  if(isset($_POST["update"]))
  {
    $login = $_POST["login"];
    $heslo = $_POST["heslo"];
    $jmeno = $_POST["jmeno"];
    $pozic = $_POST["pozic"];
    $email = $_POST["email"];
    $informace = $_POST["informace"];

    $sql = "insert into autori values ('', '$login', '$heslo', '$jmeno', '$email', '$informace', '$pozic')";
    $result = mysqli_query($db,$sql);

    if (!$result) {
      alert2("Uživatel nebyl pøidán!");;
    }
    alert("Uživatel byl úspìšnì pøidán.");
  }
?>
  <form method="post" action="us_insert.php">

  <table id="table_form" cellspacing="0" cellpadding="0">
    <tr>
      <td>
        Pozice:
      </td>
      <td>
        <select name="pozic">
          <option value="1">Administrátor</option>
          <option value="0">Redaktor</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>
        Nick:
      </td>
      <td>
        <input type="text" name="login" size="40"/>
      </td>
    </tr>
    <tr>
      <td>
        Heslo:
      </td>
      <td>
        <input type="text" name="heslo" size="40"/>
      </td>
    </tr>
    <tr>
      <td>
        Jméno:
      </td>
      <td>
        <input type="text" name="jmeno" size="40"/>
      </td>
    </tr>
    <tr>
      <td>
        Email:
      </td>
      <td>
        <input type="text" name="email" size="40"/>
      </td>
    </tr>
    <tr>
      <td>
        Poznámka:
      </td>
      <td>
        <textarea name="informace" rows="5" cols="40"></textarea>
      </td>
    </tr>

  </table>

    <input type="submit" name="update" value="Vložit"/>
  </form>
<?php

}
 else {
  alert2("Neoprávnìný pøístup!<br/>Do této sekce mají pøístup jen administrátoøi!");
}

include "include/footer.php";
?>