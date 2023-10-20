<?php
include "include/header.php";

if (isset($_GET["id"])) {
  if ($_GET["id"] != "") {
    $id = $_GET["id"];

    /* --- získání dat z databáze --- */

    $result = mysqli_query($db,"select c.id_autor, c.id_rubrika, c.datum, c.counter, c.nadpis, c.perex, c.obsah, a.id, a.jmeno, a.informace, r.rubrika, c.komentare, c.forma from clanky c, autori a, rubriky r where c.id = '$id' and c.id_autor = a.id and c.id_rubrika = r.id and c.stav = 'v'");
    $odp_1 = mysqli_num_rows($result);

    if ($odp_1 == "1") {
      $row = mysqli_fetch_array($result);

      $vic = $row["counter"]+1;

      /* --- aktualizace poèítadla --- */

      $sql = "update clanky set counter = '$vic' where id = $id";
      mysqli_query($db,$sql);

      $dates = date("d.m.Y",$row["datum"]);

      /* --- zobrazení èlánku --- */

      $pop = "$row[rubrika] - $row[nadpis]";

      cr_head($sitename, $pop);

      /*--- zpracování komentáøù ---*/

      if (isset($_POST["id_clanek"])) {
        $id = $_POST["id_clanek"];
        $jmeno = $_POST["jmeno"];
        $email = $_POST["email"];
        $komentar = $_POST["komentar"];

        if((!$jmeno) || (!$komentar)) { // kontrola polí
          echo "<p>Nevyplnil(a) jste tyto povinné údaje:</p><ul>"; // výpis chyb

          if(!$jmeno) echo "<li>Chybí jméno!</li>";
          if(!$komentar) echo "<li>Chybí komentáø!</li>";

          echo "</ul>";
        } else { // zpracování dat
          $komentar = htmlspecialchars($komentar);

          /* --- kontrola správnosti parametru ID --- */

          $result = mysqli_query($db,"select nadpis from clanky where id = $id");
          $odp_1 = mysqli_num_rows($result);

          if ($odp_1 == "1") {
            $myrowx = mysqli_fetch_array($result);
            $nazev_cl = $myrowx["nadpis"];

            /*--- zjištìní èísla komentáøe ---*/

            if ($k_stav == "1") { // komentáøe nebudou schvalovány
              $result = mysqli_query($db,"select id from komentare where id_clanek = $id and stav = '1'");
              $odp_x = mysqli_num_rows($result);

              if ($odp_x == "0") {
                $kom_cislo = "1";
              } else {
                $kom_cislo = $odp_x+1;
              }

            } elseif ($k_stav == "0") { // komentáøe budou schvalovány
              $kom_cislo = "1";
            }

          /* --- vložení komentáøe do databáze --- */

          $datum = date("j. m. Y G:i");
          $sql = "insert into komentare (id, id_clanek, stav, cislo, datum, jmeno, email, text) values ('','$id','$k_stav','$kom_cislo','$datum','$jmeno','$email','$komentar')";
          $result2 = mysqli_query($db,$sql);

          if (!$result2) {
            echo "<p>Váš komentáø nebyl uložen!</p>";
          } else {
            if ($k_stav == "0") {
            echo "<p>Váš komentáø byl uložen a èeká na schválení!</p>";
            } else {
              echo "<p>Váš komentáø byl uložen!</p>";
            }
          }

        } else {
          echo "<p>Špatné ID!</p>";
        }
      }
    }

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

      /* --- zobrazení komentáøù --- */

      if ($row["komentare"] == "1") {  // komentáøe jsou povoleny
        $result = mysqli_query($db,"select id from komentare where id_clanek = $id and stav = '1'");
        $odp_1 = mysqli_num_rows($result);

        if ($odp_1 != "0") {
          // jsou vloženy nìjaké komentáøe
          $vysledek = mysqli_query($db,"select cislo, datum, jmeno, email, text from komentare where id_clanek = $id and stav = '1' order by cislo asc");

          echo "<h4>Komentáøe</h4><p class=\"komentare\">";

          while ($row = mysqli_fetch_array($vysledek)) {  // vypsání komentáøù
            $cislo = $row["cislo"];
            $datum = $row["datum"];
            $jmeno = $row["jmeno"];
            $email = $row["email"];
            $text = $row["text"];

            echo "[$cislo] <br/> <a href=\"mailto:$email\">$jmeno</a><br/>\n<p>$text</p>\n<p>$datum</p>\n";
          }

          echo "</p>";
        }

      ?>
      <h4>Pøidat komentáø</h4>

      <form method="post" action="article.php?id=<?php echo $id;?>">
        <div>
          <input type="hidden" name="id_clanek" value="<?php echo $id;?>"/>

          <table>
            <tr>
              <td><strong>Jméno:</strong></td>
              <td><input type="text" name="jmeno" size="30"/></td>
            </tr>
            <tr>
              <td>Email:</td>
              <td><input type="text" name="email" size="30"/></td>
            </tr>
            <tr>
              <td><strong>Komentáø:</strong></td>
              <td><textarea name="komentar" rows="5" cols="40"></textarea></td>
            </tr>
          </table>

          <input type="submit" name="submit" value="Odeslat"/>
        </div>
      </form>
      <?php
      }

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