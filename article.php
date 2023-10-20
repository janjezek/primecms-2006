<?php
include "include/header.php";

if (isset($_GET["id"])) {
  if ($_GET["id"] != "") {
    $id = $_GET["id"];

    /* --- z�sk�n� dat z datab�ze --- */

    $result = mysqli_query($db,"select c.id_autor, c.id_rubrika, c.datum, c.counter, c.nadpis, c.perex, c.obsah, a.id, a.jmeno, a.informace, r.rubrika, c.komentare, c.forma from clanky c, autori a, rubriky r where c.id = '$id' and c.id_autor = a.id and c.id_rubrika = r.id and c.stav = 'v'");
    $odp_1 = mysqli_num_rows($result);

    if ($odp_1 == "1") {
      $row = mysqli_fetch_array($result);

      $vic = $row["counter"]+1;

      /* --- aktualizace po��tadla --- */

      $sql = "update clanky set counter = '$vic' where id = $id";
      mysqli_query($db,$sql);

      $dates = date("d.m.Y",$row["datum"]);

      /* --- zobrazen� �l�nku --- */

      $pop = "$row[rubrika] - $row[nadpis]";

      cr_head($sitename, $pop);

      /*--- zpracov�n� koment��� ---*/

      if (isset($_POST["id_clanek"])) {
        $id = $_POST["id_clanek"];
        $jmeno = $_POST["jmeno"];
        $email = $_POST["email"];
        $komentar = $_POST["komentar"];

        if((!$jmeno) || (!$komentar)) { // kontrola pol�
          echo "<p>Nevyplnil(a) jste tyto povinn� �daje:</p><ul>"; // v�pis chyb

          if(!$jmeno) echo "<li>Chyb� jm�no!</li>";
          if(!$komentar) echo "<li>Chyb� koment��!</li>";

          echo "</ul>";
        } else { // zpracov�n� dat
          $komentar = htmlspecialchars($komentar);

          /* --- kontrola spr�vnosti parametru ID --- */

          $result = mysqli_query($db,"select nadpis from clanky where id = $id");
          $odp_1 = mysqli_num_rows($result);

          if ($odp_1 == "1") {
            $myrowx = mysqli_fetch_array($result);
            $nazev_cl = $myrowx["nadpis"];

            /*--- zji�t�n� ��sla koment��e ---*/

            if ($k_stav == "1") { // koment��e nebudou schvalov�ny
              $result = mysqli_query($db,"select id from komentare where id_clanek = $id and stav = '1'");
              $odp_x = mysqli_num_rows($result);

              if ($odp_x == "0") {
                $kom_cislo = "1";
              } else {
                $kom_cislo = $odp_x+1;
              }

            } elseif ($k_stav == "0") { // koment��e budou schvalov�ny
              $kom_cislo = "1";
            }

          /* --- vlo�en� koment��e do datab�ze --- */

          $datum = date("j. m. Y G:i");
          $sql = "insert into komentare (id, id_clanek, stav, cislo, datum, jmeno, email, text) values ('','$id','$k_stav','$kom_cislo','$datum','$jmeno','$email','$komentar')";
          $result2 = mysqli_query($db,$sql);

          if (!$result2) {
            echo "<p>V� koment�� nebyl ulo�en!</p>";
          } else {
            if ($k_stav == "0") {
            echo "<p>V� koment�� byl ulo�en a �ek� na schv�len�!</p>";
            } else {
              echo "<p>V� koment�� byl ulo�en!</p>";
            }
          }

        } else {
          echo "<p>�patn� ID!</p>";
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

      /* --- zobrazen� koment��� --- */

      if ($row["komentare"] == "1") {  // koment��e jsou povoleny
        $result = mysqli_query($db,"select id from komentare where id_clanek = $id and stav = '1'");
        $odp_1 = mysqli_num_rows($result);

        if ($odp_1 != "0") {
          // jsou vlo�eny n�jak� koment��e
          $vysledek = mysqli_query($db,"select cislo, datum, jmeno, email, text from komentare where id_clanek = $id and stav = '1' order by cislo asc");

          echo "<h4>Koment��e</h4><p class=\"komentare\">";

          while ($row = mysqli_fetch_array($vysledek)) {  // vyps�n� koment���
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
      <h4>P�idat koment��</h4>

      <form method="post" action="article.php?id=<?php echo $id;?>">
        <div>
          <input type="hidden" name="id_clanek" value="<?php echo $id;?>"/>

          <table>
            <tr>
              <td><strong>Jm�no:</strong></td>
              <td><input type="text" name="jmeno" size="30"/></td>
            </tr>
            <tr>
              <td>Email:</td>
              <td><input type="text" name="email" size="30"/></td>
            </tr>
            <tr>
              <td><strong>Koment��:</strong></td>
              <td><textarea name="komentar" rows="5" cols="40"></textarea></td>
            </tr>
          </table>

          <input type="submit" name="submit" value="Odeslat"/>
        </div>
      </form>
      <?php
      }

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