<?php 
$akt_rok = date("Y");
if ($akt_rok != $start_year) {
  $bt_dt = "$start_year - $akt_rok";
} else {
  $bt_dt = $akt_rok;
}
?>
  </div></div></div>

  <div id="right"><div class="layout_1"><div class="content">
    <!-- pravý sloupec -->

<?php
echo "<h2>Novinky</h2>\n<div class=\"box\">";

$vysledek_n = mysqli_query($db,"select n.*, a.id, a.jmeno from novinky n, autori a where n.autor = a.id and stav = 'v' order by n.id desc limit $pocet_n");
$kontrola = mysqli_num_rows($vysledek_n);

if ($kontrola == "0") {
  echo "Žádné novinky nebyly zatím vloženy!";
} else {
  while ($row_n = mysqli_fetch_array($vysledek_n)) {
    $datum2 = $row_n["datum"];
    $titulek2 = $row_n["titulek"];
    $novinka2 = $row_n["novinka"];
    $n_a_id = $row_n["id"];
    $jmeno2 = $row_n["jmeno"];

    echo "<h3>$titulek2</h3><p>$novinka2</p><p>$datum2</p><p><a href=\"author.php?id=$n_a_id\">$jmeno2</a></p>\n";
  }
}
 echo "</div>";

$vysledek = mysqli_query($db,"select pozice, head, body from boxy where strana = 1 order by pozice asc");

while ($row = mysqli_fetch_array($vysledek)) {
  $hd = $row["head"];
  $bd = $row["body"];

box($hd, $bd);
}
?>

  </div></div></div>

  <div class="clear">&nbsp;</div></div>
  <!-- oddìlovaè -->


  <div id="footer"><div class="layout_1"><div class="layout_2">
    <!-- patièka -->
	  <p>
      Vytvoøil <a href="mailto:<?php echo $admin_mail;?>"><?php echo $admin_name;?></a> <?php echo $bt_dt;?>. Všechna práva vyhrazena.<br/>
      <a href="http://validator.w3.org/check/referer">XHTML 1.1</a>, <a href="http://jigsaw.w3.org/css-validator/check/referer">CSS 2.0</a> validní.<br/>
      Redakèní systém <a href="http://primecms.cz">PrimeCMS</a>.
	  </p>
  </div></div></div>

</div>

</body>
</html>
