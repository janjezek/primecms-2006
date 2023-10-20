<?php
include "include/header.php";
?>

<h1>Administrace &gt; Titulní stránka</h1>

<p>Vítejte, byl(a) jste úspìšnì pøihlášen(a) do administraèní sekce!</p>

<p>V levé èásti stránky si mùžete vybrat odkaz a zaèít okamžitì pracovat s redakèním systémem <a href="http://primecms.cz">PrimeCMS</a>. Nabídka boxù se liší podle Vaší pozice.</p>

<p>Zde si mùžete prohlédnout základní statistiky:</p>

<?php
/* --- vytvoøení statistiky --- */

$cas = time();

$dotaz_1 = mysqli_query($db,"select id from clanky");
$dotaz_2 = mysqli_query($db,"select id from clanky where stav = 'n' or datum >= $cas");
$dotaz_3 = mysqli_query($db,"select id from rubriky");
$dotaz_4 = mysqli_query($db,"select id from autori");

$vydane = mysqli_num_rows($dotaz_1);
$nevydane = mysqli_num_rows($dotaz_2);
$rubky = mysqli_num_rows($dotaz_3);
$autors = mysqli_num_rows($dotaz_4);

/* --- zobrazení statistiky --- */

echo "<table id=\"table_form\">\n<tr>\n<td><strong>Poèet èlánkù:</strong></td>\n<td>";
echo $vydane;
echo "</td>\n</tr>\n<tr>\n<td><strong>Nevydané èlánky:</strong></td>\n<td>";
echo $nevydane;
echo "</td>\n</tr>\n<tr>\n<td><strong>Poèet rubrik:</strong></td>\n<td>";
echo $rubky;
echo "</td>\n</tr>\n<tr>\n<td><strong>Poèet redaktorù:</strong></td>\n<td>";
echo $autors;
echo "</td>\n</tr>\n</table>\n";

echo "<p>Pøíjemnou práci Vám pøeje vývojový tým redakèního systému <a href=\"http://primecms.cz\">PrimeCMS</a>!</p>\n";

include "include/footer.php";
?>