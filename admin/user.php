<?php
include "include/header.php";
?>

<h1>Administrace &gt; Tituln� str�nka</h1>

<p>V�tejte, byl(a) jste �sp�n� p�ihl�en(a) do administra�n� sekce!</p>

<p>V lev� ��sti str�nky si m��ete vybrat odkaz a za��t okam�it� pracovat s redak�n�m syst�mem <a href="http://primecms.cz">PrimeCMS</a>. Nab�dka box� se li�� podle Va�� pozice.</p>

<p>Zde si m��ete prohl�dnout z�kladn� statistiky:</p>

<?php
/* --- vytvo�en� statistiky --- */

$cas = time();

$dotaz_1 = mysqli_query($db,"select id from clanky");
$dotaz_2 = mysqli_query($db,"select id from clanky where stav = 'n' or datum >= $cas");
$dotaz_3 = mysqli_query($db,"select id from rubriky");
$dotaz_4 = mysqli_query($db,"select id from autori");

$vydane = mysqli_num_rows($dotaz_1);
$nevydane = mysqli_num_rows($dotaz_2);
$rubky = mysqli_num_rows($dotaz_3);
$autors = mysqli_num_rows($dotaz_4);

/* --- zobrazen� statistiky --- */

echo "<table id=\"table_form\">\n<tr>\n<td><strong>Po�et �l�nk�:</strong></td>\n<td>";
echo $vydane;
echo "</td>\n</tr>\n<tr>\n<td><strong>Nevydan� �l�nky:</strong></td>\n<td>";
echo $nevydane;
echo "</td>\n</tr>\n<tr>\n<td><strong>Po�et rubrik:</strong></td>\n<td>";
echo $rubky;
echo "</td>\n</tr>\n<tr>\n<td><strong>Po�et redaktor�:</strong></td>\n<td>";
echo $autors;
echo "</td>\n</tr>\n</table>\n";

echo "<p>P��jemnou pr�ci V�m p�eje v�vojov� t�m redak�n�ho syst�mu <a href=\"http://primecms.cz\">PrimeCMS</a>!</p>\n";

include "include/footer.php";
?>