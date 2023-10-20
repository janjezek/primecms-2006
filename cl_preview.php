<?php
include "include/header.php";

if (isset($_GET["id"])) {
  if ($_GET["id"] != "") {
    $id = $_GET["id"];

    /* --- z�sk�n� dat z datab�ze --- */

    $result = mysqli_query($db,"select c.id_autor, c.id_rubrika, c.datum, c.counter, c.nadpis, c.perex, c.obsah, a.id, a.jmeno, a.informace, r.rubrika, c.komentare, c.forma from clanky c, autori a, rubriky r where c.id = '$id' and c.id_autor = a.id and c.id_rubrika = r.id");
    $odp_1 = mysqli_num_rows($result);

    if ($odp_1 == "1") {
      $row = mysqli_fetch_array($result);
      $dates = date("d.m.Y",$row["datum"]);

      /* --- zobrazen� �l�nku --- */

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
      echo "Po��tadlo: $row[counter] ";

      if ($row["counter"] == "1") {
        echo "�ten��\n";
      } elseif ($row["counter"] >= "5" or $row["counter"] == "0") {
        echo "�ten���\n";
      } else {
        echo "�ten��i\n";
      }

      echo "</p>\n";
      echo "</div>\n";

      /* --- chybov� hl�en� --- */

    } else {
      cr_head($sitename, "Neo�ek�van� chyba");
      echo "<h2>Neo�ek�van� chyba</h2>\n";
      echo "<p>Neexistuj�c� parametr ID. Bez spr�vn�ho parametru nen� mo?n� zobrazit �l�nek.<br/>Pros�m pokra�ujte na <a href=\"index.php\">tituln� str�nku</a>.\n";
    }

  } else {
    cr_head($sitename, "Neo�ek�van� chyba");
    echo "<h2>Neo�ek�van� chyba</h2>\n";
    echo "<p>Pr�zdn� parametr ID. Bez spr�vn�ho parametru nen� mo?n� zobrazit �l�nek.<br/>Pros�m pokra�ujte na <a href=\"index.php\">tituln� str�nku</a>.\n";
  }

} else {
  cr_head($sitename, "Neo�ek�van� chyba");
  echo "<h2>Neo�ek�van� chyba</h2>\n";
  echo "<p>Nen� zad�n parametr ID. Bez tohoto parametru nen� mo?n� zobrazit �l�nek.<br/>Pros�m pokra�ujte na <a href=\"index.php\">tituln� str�nku</a>.\n";
}

include "include/footer.php";
?>