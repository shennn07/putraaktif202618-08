<?php
include "latihan1.php";
$index1 = 0;
while ($index1 < count($orang)) {
    if ($orang[$index1]["umur"] == 17) {
        echo "nama=" . $orang[$index1]["nama"] . "<br>";
        echo "umur=" . $orang[$index1]["umur"] . "<br>";
        echo "alamat=" . $orang[$index1]["alamat"] . "<br>";
        echo "=================================". "<br>";
    }
    $index1++;
}