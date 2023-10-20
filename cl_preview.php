<?php
include "include/header.php";

if (isset($_GET["id"])) {
  if ($_GET["id"] != "") {
    $id = $_GET["id"];

    /* --- získání dat z databáze --- */

    $result = mysqli_query($db,"select c.id_autor, c.id_rubrika, c.datum, c.counter, c.nadpis, c.perex, c.obsah, a.id, a.jmeno, a.informace, r.rubrika, c.komentare, c.forma from clanky c, autori a, rubriky r where c.id = '$id' and c.id_autor = a.id and c.id_rubrika = r.id");
    $odp_1 = mysqli_num_rows($result);

    if ($odp_1 == "1") {
      $row = mysqli_fetch_array($result);
      $dates = date("d.m.Y",$row["datum"]);

      /* --- zobrazení èlánku --- */

      $pop = "$row[rubrika] - $row[nadpis]";

      cr_head($sitename, $pop);

      echo "<div id=\"clanek\">\n";
      echo "<h2>$row[nadpis]</h2>\n";
      echo "<p>$row[perex]</p>\n";

      if ($row["forma"] == "1") {
        echo $row["obsah"];
      }

      echo "<p class=\"al_right\">\n";
      echo "<a href=\"author.php?id=$row[id]\">$row[jmeno]</a>\n<br/>\n$row[informace]\n";
      echo "</p>\n";

      echo "<p>\n";
      echo "Rubrika: <a href=\"section.php?id=$row[id_rubrika]\">$row[rubrika]</a><br/>\n";
      echo "Datum: $dates<br/>\n";
      echo "Poèítadlo: $row[counter] ";

      if ($row["counter"] == "1") {
        echo "ètenáø\n";
      } elseif ($row["counter"] >= "5" or $row["counter"] == "0") {
        echo "ètenáøù\n";
      } else {
        echo "ètenáøi\n";
      }

      echo "</p>\n";
      echo "</div>\n";

      /* --- chybová hlášení --- */

    } else {
      cr_head($sitename, "Neoèekávaná chyba");
      echo "<h2>Neoèekávaná chyba</h2>\n";
      echo "<p>Neexistující parametr ID. Bez správného parametru není mo?né zobrazit èlánek.<br/>Prosím pokraèujte na <a href=\"index.php\">titulní stránku</a>.\n";
    }

  } else {
    cr_head($sitename, "Neoèekávaná chyba");
    echo "<h2>Neoèekávaná chyba</h2>\n";
    echo "<p>Prázdný parametr ID. Bez správného parametru není mo?né zobrazit èlánek.<br/>Prosím pokraèujte na <a href=\"index.php\">titulní stránku</a>.\n";
  }

} else {
  cr_head($sitename, "Neoèekávaná chyba");
  echo "<h2>Neoèekávaná chyba</h2>\n";
  echo "<p>Není zadán parametr ID. Bez tohoto parametru není mo?né zobrazit èlánek.<br/>Prosím pokraèujte na <a href=\"index.php\">titulní stránku</a>.\n";
}

include "include/footer.php";
?>