<?php
include "include/header.php";

cr_head($sitename, "Tituln� str�nka");

/* --- listov�n� �l�nk� --- */

$cas = time();

if (!isset($_GET["list"])) {
  $list = 1;
  $zaznam = 0;
} else {
  $list = $_GET["list"];
  $newlist = $list - 1;
  $zaznam = $pocet * $newlist;
}

$vysledek_celk = mysqli_query($db,"select id from clanky where stav = 'v' and datum <= $cas and zobrazeni = '1'");

/* --- vybr�n� �l�nk� z datab�ze --- */

$vysledek = mysqli_query($db,"select c.id,c.nadpis,c.perex,r.id,r.rubrika,a.id,a.jmeno,c.datum,c.komentare,c.forma from clanky c, rubriky r, autori a where c.id_rubrika = r.id and c.id_autor = a.id and c.stav = 'v' and c.datum <= $cas and c.zobrazeni = '1' order by c.datum desc limit $zaznam, $pocet");
$control = mysqli_num_rows($vysledek);

if ($control == "0") {
  if (!isset($_GET["list"])) {
    echo "<p>��dn� �l�nky zat�m nebyly vlo�eny!</p>";
  } else {
    echo "<h2>Neo�ek�van� chyba</h2>\n";
    echo "<p>Neexistuj�c� parametr LIST. Bez spr�vn�ho parametru nen� mo�n� zobrazit �l�nky.<br/>Pros�m pokra�ujte na <a href=\"index.php\">tituln� str�nku</a>.\n";
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
      $hl_cm = "koment��";
    } elseif ($comx >= "5" or $comx == "0") {
      $hl_cm = "koment���";
    } else {
      $hl_cm = "koment��e";
    }

    $comx2 = "$comx $hl_cm";

    clanek($id2, $nadpis, $perex, $r_id, $rubrika, $a_id, $jmeno, $datum, $comx2, $k_ok, $format);
  }
  include "listovani.php";
}

include "include/footer.php";
?>