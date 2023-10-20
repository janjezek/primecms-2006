<?php

/* --- zjist� po�et list� --- */

$pocet_listu = mysqli_num_rows($vysledek_celk)/$pocet;
$pocet_vysl = ceil($pocet_listu);

$pole[1] = 0;
$zaznam = 0;
for ($i = 2; $i <= $pocet_vysl; $i++):
  $zaznam += $pocet;
  $pole[$i] = $zaznam;
endfor;

/* --- list� je v�c ne� jeden --- */

while (list($cislo_listu, $x) = each($pole)):

  if ($cislo_listu == $list):
    $list1 = $list + 1;
    $list2 = $list - 1;
    $vpred = current($pole);
    $vzad = $x-$pocet;

  if($pocet_vysl == 1):
  break;
  endif;

/* --- obsluhuje jednotliv� situace --- */

  echo "<p id=\"list\">Listov�n� :\n";

  if(($pocet_vysl == 2)&&($list == 1)):
    echo " $list / $pocet_vysl ";
    echo " <a href=\"$_SERVER[PHP_SELF]?";
      if (isset($id)) {
        echo "id=$id&amp;";
      }
    echo "list=$pocet_vysl\">&gt;&gt;</a> ";
  break;
  endif;

  if(($pocet_vysl == 2)&&($list == 2)):
    echo " <a href=\"$_SERVER[PHP_SELF]?";
    if (isset($id)) {
      echo "id=$id&amp;";
    }
    echo "list=1\">&lt;&lt;</a> ";
    echo " $list / $pocet_vysl ";
  break;
  endif;

  if(($pocet_vysl == 3)&&($list == 2)):
    echo " <a href=\"$_SERVER[PHP_SELF]?";
    if (isset($id)) {
      echo "id=$id&amp;";
    }
    echo "list=1\">&lt;&lt;</a> ";
    echo " $list / $pocet_vysl ";
    echo " <a href=\"$_SERVER[PHP_SELF]?";
    if (isset($id)) {
      echo "id=$id&amp;";
    }
    echo "list=$pocet_vysl\">&gt;&gt;</a> ";
  break;
  endif;

  if($list == 1):
    echo " $list / $pocet_vysl ";
    echo " <a href=\"$_SERVER[PHP_SELF]?";
    if (isset($id)) {
      echo "id=$id&amp;";
    }
    echo "list=$list1\">&gt;</a> ";
    echo " <a href=\"$_SERVER[PHP_SELF]?";
    if (isset($id)) {
      echo "id=$id&amp;";
    }
    echo "list=$pocet_vysl\">&gt;&gt;</a> ";
  break;
  endif;

  if($list==2):
    echo " <a href=\"$_SERVER[PHP_SELF]?";
    if (isset($id)) {
      echo "id=$id&amp;";
    }
    echo "list=1\">&lt;&lt;</a> ";
    echo " $list / $pocet_vysl ";
    echo " <a href=\"$_SERVER[PHP_SELF]?";
    if (isset($id)) {
      echo "id=$id&amp;";
    }
    echo "list=$list1\">&gt;</a> ";
    echo " <a href=\"$_SERVER[PHP_SELF]?";
    if (isset($id)) {
      echo "id=$id&amp;";
    }
    echo "list=$pocet_vysl\">&gt;&gt;</a> ";
  break;
  endif;

  if ($list==($pocet_vysl-1)):
    echo " <a href=\"$_SERVER[PHP_SELF]";
    if (isset($id)) {
      echo "id=$id&amp;";
    }
    echo "?&list=1\">&lt;&lt;</a> ";
    echo " <a href=\"$_SERVER[PHP_SELF]";
    if (isset($id)) {
      echo "id=$id&amp;";
    }
    echo "?list=$list2\">&lt;</a> ";
    echo " $list / $pocet_vysl ";
    echo " <a href=\"$_SERVER[PHP_SELF]";
    if (isset($id)) {
      echo "id=$id&amp;";
    }
    echo "?list=$pocet_vysl\">&gt;&gt;</a> ";
  break;
  endif;

  if ($list==$pocet_vysl):
    echo " <a href=\"$_SERVER[PHP_SELF]";
    if (isset($id)) {
      echo "id=$id&amp;";
    }
    echo "?list=1\">&lt;&lt;</a> ";
    echo " <a href=\"$_SERVER[PHP_SELF]";
    if (isset($id)) {
      echo "id=$id&amp;";
    }
    echo "?list=$list2\">&lt;</a> ";
    echo " $list / $pocet_vysl ";
  break;
  endif;

  echo " <a href=\"$_SERVER[PHP_SELF]";
  if (isset($id)) {
    echo "id=$id&amp;";
  }
  echo "?list=1\">&lt;&lt;</a> ";
  echo " <a href=\"$_SERVER[PHP_SELF]";
  if (isset($id)) {
    echo "id=$id&amp;";
  }
  echo "?list=$list2\">&lt;</a> ";
  echo " $list / $pocet_vysl ";
  echo " <a href=\"$_SERVER[PHP_SELF]";
  if (isset($id)) {
    echo "id=$id&amp;";
  }
  echo "?list=$list1\">&gt;</a> ";
  echo " <a href=\"$_SERVER[PHP_SELF]";
  if (isset($id)) {
    echo "id=$id&amp;";
  }
  echo "?list=$pocet_vysl\">&gt;&gt;</a> ";

echo "\n</p>\n";
break;
endif;

endwhile;
?>