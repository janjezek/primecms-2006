<?php
include "include/header.php";

if (isset($_GET["id"])) {
  $id = $_GET["id"];

/* --- zjistí název sekce --- */

  $vysledek = mysqli_query($db,"select rubrika from rubriky where id = '$id'");
  $odp_1 = mysqli_num_rows($vysledek);

  if ($odp_1 == "1") {

    while ($row = mysqli_fetch_row($vysledek)) {
      $naz_sek = $row[0];
      cr_head($sitename, $naz_sek);
      echo "<h2>Rubrika $naz_sek</h2>";
    }

/* --- listování --- */

    $cas = time();

    if (!isset($_GET["list"])) {
      $list = 1;
      $zaznam = 0;
    } else {
      $_list = $_GET["list"];
      $list = $_list--;
      $zaznam = $pocet * $_list;
    }

    $_pocet = $zaznam + $pocet;
    $vysledek_celk = mysqli_query($db,"select id from clanky where stav = 'v' and id_rubrika = '$id' and datum <= $cas and zobrazeni != '3'");

/* --- vybere èlánky z datbáze --- */

    $vysledek = mysqli_query($db,"select c.id,c.nadpis,c.perex,r.id,r.rubrika,a.id,a.jmeno,c.datum,c.komentare,c.forma from clanky c, rubriky r, autori a where c.id_rubrika = r.id and c.id_autor = a.id and c.stav = 'v' and c.id_rubrika = '$id' and c.datum <= $cas and c.zobrazeni != '3' order by c.datum desc limit $zaznam, $_pocet");
    $control = mysqli_num_rows($vysledek);

    if ($control == "0") {
      if (!isset($_GET["list"])) {
        echo "<p>V této rubrice zatím nejsou ÿádné èlánky!</p>";
      } else {
        echo "<p>Neexistující parametr LIST. Bez správného parametru není moÿné zobrazit èlánky.<br/>Prosím pokraèujte na <a href=\"index.php\">titulní stránku</a>.\n";
      }
    } else {
      while ($row = mysqli_fetch_row($vysledek)) {
        $id2 = $row[0];
        $nadpis = $row[1];
        $perex = $row[2];
        $r_id = $row[3];
        $rubrika = $row[4];
        $a_id = $row[5];
        $jmeno = $row[6];
        $datum = date("d.m.Y",$row[7]);
        $k_ok = $row[8];
    $format = $row[9];

        $vysledek2 = mysqli_query($db,"select id from komentare where stav = 1 and id_clanek = $id2");
        $comx = mysqli_num_rows($vysledek2);

        if ($comx == "1") {
          $hl_cm = "komentáø";
        } elseif ($comx >= "5" or $comx == "0") {
          $hl_cm = "komentáøù";
        } else {
          $hl_cm = "komentáøe";
        }

        $comx2 = "$comx $hl_cm";

        clanek($id2, $nadpis, $perex, $r_id, $rubrika, $a_id, $jmeno, $datum, $comx2, $k_ok, $format);
      }
      include "listovani.php";
    }

  } else {
    cr_head($sitename, "Neoèekávaná chyba");
    echo "<h2>Neoèekávaná chyba</h2>\n";
    echo "<p>Neexistující parametr ID. Bez správného parametru není moÿné zobrazit èlánky.<br/>Prosím pokraèujte na <a href=\"index.php\">titulní stránku</a>.\n";
  }

} else {
  cr_head($sitename, "Neoèekávaná chyba");
  echo "<h2>Neoèekávaná chyba</h2>\n";
  echo "<p>Není zadán parametr ID. Bez tohoto parametru není moÿné zobrazit èlánky.<br/>Prosím pokraèujte na <a href=\"index.php\">titulní stránku</a>.\n";
}

include "include/footer.php";
?>