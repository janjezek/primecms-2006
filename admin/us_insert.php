<?php
include "include/header.php";

echo "<h1>Administrace &gt; P�idat u�ivatele</h1>\n";

/*--- zji�t�n� pr�v ---*/

if ($_data["prava"] == "1") {

  /*--- p�id�n� u�ivatele ---*/

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
      alert2("U�ivatel nebyl p�id�n!");;
    }
    alert("U�ivatel byl �sp�n� p�id�n.");
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
          <option value="1">Administr�tor</option>
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
        Jm�no:
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
        Pozn�mka:
      </td>
      <td>
        <textarea name="informace" rows="5" cols="40"></textarea>
      </td>
    </tr>

  </table>

    <input type="submit" name="update" value="Vlo�it"/>
  </form>
<?php

}
 else {
  alert2("Neopr�vn�n� p��stup!<br/>Do t�to sekce maj� p��stup jen administr�to�i!");
}

include "include/footer.php";
?>