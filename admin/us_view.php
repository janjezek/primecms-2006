<?php
include "include/header.php";

/*--- v�pis �daj� ---*/

$result = mysqli_query($db,"select * from autori where id = '$_id'");
$row = mysqli_fetch_array($result);

$dotaz_1 = mysqli_query($db,"select id from clanky where id_autor = '$_id'");
$vydane = mysqli_num_rows($dotaz_1);

echo "<h1>Administrace &gt; ";
echo $row["jmeno"];
echo "</h1>\n";

echo "<p><a href=\"cl_own.php\" class=\"od_pridat\">Zobrazit vlastn� �l�nky</a>, <a href=\"us_selfedit.php\" class=\"od_pridat\">Upravit �daje</a></p>\n";
?>
  <table id="table_form" cellspacing="0" cellpadding="0">
    <tr>
      <td>
        Jm�no:
      </td>
      <td>
        <?php echo $row["jmeno"];?>
      </td>
    </tr>
    <tr>
      <td>
        Pozice:
      </td>
      <td>
        <?php
        $prava = $_data["prava"];

        if ($prava == "1") {
          $pozice = "Administr�tor";
        } else {
          $pozice = "Redaktor";
        }
        echo $pozice;
        ?>
      </td>
    </tr>
    <tr>
      <td>
        Po�et �l�nk�:
      </td>
      <td>
        <?php echo $vydane;?>
      </td>
    </tr>
    <tr>
      <td>
      </td>
      <td>
      </td>
    </tr>
    <tr>
      <td>
        Nick:
      </td>
      <td>
        <?php echo $row["login"];?>
      </td>
    </tr>
    <tr>
      <td>
        Heslo:
      </td>
      <td>
        <?php echo $row["heslo"];?>
      </td>
    </tr>
    <tr>
      <td>
        Email:
      </td>
      <td>
        <?php echo $row["email"];?>
      </td>
    </tr>
    <tr>
      <td>
        Pozn�mka:
      </td>
      <td>
        <?php echo $row["informace"];?>
      </td>
    </tr>
  </table>

<?php
include "include/footer.php";
?>