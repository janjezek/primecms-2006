<?php
include "include/header.php";

echo "<h1>Administrace &gt; Vložit èlánek</h1>\n";

if(isset($_POST["submit"])) {

  /*--- získání promìnných ---*/

  $id_rubrika = $_POST["id_rubrika"];
  $nadpis = strip_tags($_POST["nadpis"], '');
  $perex = $_POST["perex"];
  $obsah = $_POST["obsah"];
  $forma = $_POST["forma"];

  /*--- pøevod na seo uri ---*/

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
  $counter = "0";

  if ($_data["prava"] == "1") { // uživatel je administrátor
    $komentare = $_POST["komentare"];
    $zobr = $_POST["zobr"];

    $mesic = $_POST["mesic"];
    $den = $_POST["den"];
    $rok = $_POST["rok"];

    $datum = mktime(0,0,0,$mesic,$den,$rok);
    $stav = $_POST["stav"];

    /*--- vložení všech údajù do databáze ---*/

    $sql = "insert into clanky (id_autor, id_rubrika, datum, counter, nadpis, seouri, perex, obsah, stav, zobrazeni, komentare, forma) values ('$_id', '$id_rubrika', '$datum', '$counter', '$nadpis', '$seouri', '$perex', '$obsah', '$stav', '$zobr', '$komentare', '$forma')";
    $result = mysqli_query($db,$sql);

    if (!$result) {
      alert2("Èlánek nebyl uložen v databázi!");
    }
    alert("Èlánek byl úspìšnì uložen v databázi.");
  } else {  // uživatel je redaktor
    $datum = time();
    $stav = "n";

    /*--- vložení údajù do databáze ---*/

    $sql = "insert into clanky (id_autor, id_rubrika, datum, counter, nadpis, seouri, perex, obsah, stav, forma) values ('$_id', '$id_rubrika', '$datum', '$counter', '$nadpis', '$seouri', '$perex', '$obsah', '$stav', '$forma')";
    $result = mysqli_query($db,$sql);

    if (!$result) {
      alert2("Èlánek nebyl uložen v databázi!");
    }
    alert("Èlánek byl úspìšnì uložen v databázi.");
  }
}
?>
<form method="post" action="cl_insert.php">
<div>
  <table id="table_form" cellspacing="0" cellpadding="0">
    <tr>
      <td>
        Autor:
      </td>
      <td>
        <?php echo $_data["jmeno"];?>
      </td>
    </tr>
    <tr>
      <td>
        Název:
      </td>
      <td>
        <input type="text" name="nadpis" size="70"/>
      </td>
    </tr>
    <tr>
      <td>
        Sekce:
      </td>
      <td>
    <?php
    echo "<select name=\"id_rubrika\">\n";

    $res = mysqli_query($db,"select id, rubrika from rubriky order by rubrika");

    while ($row = mysqli_fetch_array($res)) {
      $id = $row["id"];
      $rubrika = $row["rubrika"];

      echo "<option value=\"$id\">$rubrika</option>\n";
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
            $_den = date("d");
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
            $_mesic = date("m");
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
          for ($i=6; $i<=9; $i++)
          {
            echo "<option value=\"200$i\"";
            $_rok = date("Y");
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
          <option value="v">Ano</option>
          <option value="n">Ne</option>
        </select>
      </td>
    </tr>
    <tr>
      <td>
        Zobrazení:
      </td>
      <td>
        <input type="radio" name="zobr" value="1" checked="checked"/> Zobrazovat všude<br/>
        <input type="radio" name="zobr" value="2"/> Nezobrazovat na titulní stránce<br/>
        <input type="radio" name="zobr" value="3"/> Nezobrazovat nikde
      </td>
    </tr>
    <tr>
      <td>
        Komentáøe:
      </td>
      <td>
        <select name="komentare">
          <option value="1">Ano</option>
          <option value="0">Ne</option>
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
        <input type="radio" name="forma" value="1" checked="checked"/> Klasický èlánek
         <input type="radio" name="forma" value="2"/> Blog
      </td>
    </tr>
    <tr>
      <td>
        Perex:
      </td>
      <td>
        <textarea name="perex" id="perex" rows="15" cols="90"></textarea>
      </td>
    </tr>
    <tr>
      <td>
        Obsah:
      </td>
      <td>
        <textarea name="obsah" id="clanek" rows="25" cols="90"></textarea>
      </td>
    </tr>
  </table>

  <input type="submit" name="submit" value="Vložit"/>
</div>
</form>
<?php
include "include/footer.php";
?>