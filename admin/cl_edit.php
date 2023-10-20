<?php
include "include/header.php";

echo "<h1>Administrace &gt; Úprava èlánku</h1>\n";

if (isset($_GET["id"])) {
  $id = $_GET["id"];
} elseif (isset($_POST["id"])) {
  $id = $_POST["id"];
}

/*--- kontrola autorství a práv ---*/

$res = mysqli_query($db,"select id_autor from clanky where id = $id");
$row2 = mysqli_fetch_array($res);

if ($row2["id_autor"] == $_id or $_data["prava"] == "1") {

  /*--- formuláø je odeslán ---*/

  if(isset($_POST["update"])) {
    $id_autor = $_POST["id_autor"];
    $id_rubrika = $_POST["id_rubrika"];
    $nadpis = strip_tags($_POST["nadpis"], '');
    $perex = $_POST["perex"];
    $obsah = $_POST["obsah"];
    $forma = $_POST["forma"];

    function convert($title) {
      static $convertTable = array (
        'á' => 'a', 'Á' => 'A', 'ä' => 'a', 'Ä' => 'A', 'è' => 'c',
        'È' => 'C', 'ï' => 'd', 'Ï' => 'D', 'é' => 'e', 'É' => 'E',
        'ì' => 'e', 'Ì' => 'E', 'ë' => 'e', 'Ë' => 'E', 'í' => 'i',
        'Í' => 'I', 'i' => 'i', 'I' => 'I', '¾' => 'l', '¼' => 'L',
        'å' => 'l', 'Å' => 'L', 'ò' => 'n', 'Ò' => 'N', 'ñ' => 'n',
        'Ñ' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ö' => 'o', 'Ö' => 'O',
        'ø' => 'r', 'Ø' => 'R', 'à' => 'r', 'À' => 'R', 'š' => 's',
        'Š' => 'S', 'œ' => 's', 'Œ' => 'S', '' => 't', '' => 'T',
        'ú' => 'u', 'Ú' => 'U', 'ù' => 'u', 'Ù' => 'U', 'ü' => 'u',
        'Ü' => 'U', 'ý' => 'y', 'Ý' => 'Y', 'y' => 'y', 'Y' => 'Y',
        'ž' => 'z', 'Ž' => 'Z', 'Ÿ' => 'z', '' => 'Z',
      );
      $title = strtolower(strtr($title, $convertTable));
      $title = preg_replace('/[^a-zA-Z0-9]+/u', '-', $title);
      $title = str_replace('--', '-', $title);
      $title = trim($title, '-');
      return $title;
    }

    $seouri = convert($nadpis);

    if ($_data["prava"] == "1") { // uživatel je administrátor
      $komentare = $_POST["komentare"];
      $zobr = $_POST["zobr"];

      $mesic = $_POST["mesic"];
      $den = $_POST["den"];
      $rok = $_POST["rok"];

      $datum = mktime(0,0,0,$mesic,$den,$rok);
      $stav = $_POST["stav"];

      /*--- vložení všech údajù do databáze ---*/

      $sql = "update clanky set id_autor = '$id_autor', id_rubrika = '$id_rubrika', datum = '$datum', nadpis = '$nadpis', seouri = '$seouri', perex = '$perex', obsah = '$obsah', stav = '$stav', zobrazeni = '$zobr', komentare = '$komentare', forma = '$forma' where id = $id";
      $result = mysqli_query($db,$sql);

      if (!$result) {
        alert2("Èlánek nebyl upraven!");
      }
      alert("Èlánek byl úspìšnì opraven.");
    } else {  // uživatel je redaktor
      $sql = "update clanky set id_autor = '$id_autor', id_rubrika = '$id_rubrika', nadpis = '$nadpis', seouri = '$seouri', perex = '$perex', obsah = '$obsah', forma = '$forma' where id = $id";
      $result = mysqli_query($db,$sql);

      if (!$result) {
        alert2("Èlánek nebyl upraven!");
      }
      alert("Èlánek byl úspìšnì opraven.");
    }
  } else {
    $result = mysqli_query($db,"select c.*, a.jmeno from clanky c, autori a where c.id = '$id' and c.id_autor = a.id");
    $myrow2 = mysqli_fetch_array($result);
?>
  <form method="post" action="cl_edit.php">
<div>
  <table id="table_form" cellspacing="0" cellpadding="0">
    <tr>
      <td>
        <input type="hidden" name="id_autor" value="<?php echo $myrow2["id_autor"]?>"/>
        Autor:
      </td>
      <td>
        <?php
        echo $myrow2["jmeno"];
        ?>
      </td>
    </tr>
    <tr>
      <td>
        <input type="hidden" name="id" value="<?php echo $myrow2["id"]?>"/>
        Název:
      </td>
      <td>
        <input type="text" name="nadpis" size="70" value="<?php echo $myrow2["nadpis"]?>"/>
      </td>
    </tr>
    <tr>
      <td>
        Sekce:
      </td>
      <td>
    <?php
    /*--- vybrání rubrik ---*/

    echo "<select name=\"id_rubrika\">\n";

    $res2 = mysqli_query($db,"select id, rubrika from rubriky order by rubrika");

    while ($row = mysqli_fetch_array($res2)) {
      $section = $myrow2["id_rubrika"];
      $id2 = $row["id"];
      $jmeno = $row["rubrika"];

      echo "<option value=\"$id2\"";

      if ($section == $id2)
        echo " selected=\"selected\"";

      echo ">$jmeno</option>\n";
    }

    echo "</select>\n";
    ?>
      </td>
    </tr>
    <?php
    if ($_data["prava"] == 1) {
    ?>
    <tr>
      <td>
        Datum:
      </td>
      <td>
        <select name="den">
          <?php
          for ($i=1; $i<=31; $i++)
          {
            echo "<option value=\"$i\"";
            $_den = date("d",$myrow2["datum"]);
            if ($_den == $i) {
            echo " selected=\"selected\"";
            }
            echo ">$i</option>\n";
          }
          ?>
        </select>
        .
        <select name="mesic">
          <?php
          for ($i=1; $i<= 12; $i++)
          {
            echo "<option value=\"$i\"";
            $_mesic = date("m",$myrow2["datum"]);
            if ($_mesic == $i) {
            echo " selected=\"selected\"";
            }
            echo ">$i</option>\n";
          }
          ?>
        </select>
        .
        <select name="rok">
          <?php
          for ($i=5; $i<= 7; $i++)
          {
            echo "<option value=\"200$i\"";
            $_rok = date("Y",$myrow2["datum"]);
            if ($_rok == $i) {
            echo " selected=\"selected\"";
            }
            echo ">200$i</option>\n";
          }
          ?>
        </select>
      </td>
    </tr>
    <tr>
      <td>
        Vydat:
      </td>
      <td>
        <select name="stav">
          <option value="v" <?php if ($myrow2["stav"] == "v") echo "selected=\"selected\"";?>>Ano</option>
          <option value="n" <?php if ($myrow2["stav"] == "n") echo "selected=\"selected\"";?>>Ne</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>
        Zobrazení:
      </td>
      <td>
        <input type="radio" name="zobr" value="1" <?php if ($myrow2["zobrazeni"] == "1") echo "checked=\"checked\"";?>/> Zobrazovat všude<br/>
        <input type="radio" name="zobr" value="2" <?php if ($myrow2["zobrazeni"] == "2") echo "checked=\"checked\"";?>/> Nezobrazovat na titulní stránce<br/>
        <input type="radio" name="zobr" value="3" <?php if ($myrow2["zobrazeni"] == "3") echo "checked=\"checked\"";?>/> Nezobrazovat nikde
      </td>
    </tr>
    <tr>
      <td>
        Komentáøe:
      </td>
      <td>
        <select name="komentare">
          <option value="1" <?php if ($myrow2["komentare"] == "1") echo "selected=\"selected\"";?>>Ano</option>
          <option value="0" <?php if ($myrow2["komentare"] == "0") echo "selected=\"selected\"";?>>Ne</option>
        </select>
      </td>
    </tr>
    <?php
    }
    ?>
    <tr>
      <td>
        Forma:
      </td>
      <td>
        <input type="radio" name="forma" value="1" <?php if ($myrow2["forma"] == "1") echo "checked=\"checked\"";?>/> Klasický èlánek
         <input type="radio" name="forma" value="2" <?php if ($myrow2["forma"] == "2") echo "checked=\"checked\"";?>/> Blog
      </td>
    </tr>
    <tr>
      <td>
        Perex:
      </td>
      <td>
        <textarea name="perex" id="perex" rows="15" cols="90"><?php echo $myrow2["perex"]?></textarea>
      </td>
    </tr>
    <tr>
      <td>
        Obsah:
      </td>
      <td>
        <textarea name="obsah" id="clanek" rows="25" cols="90"><?php echo $myrow2["obsah"]?></textarea>
      </td>
    </tr>
  </table>

    <input type="submit" name="update" value="Upravit"/>
    </div>
  </form>
<?php
}

} else {
  alert2("Neoprávnìný pøístup!<br/>Mùžete upravovat pouze své vlastní èlánky!");
}

include "include/footer.php";
?>