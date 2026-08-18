<?php

$hari = "kamis";

// if ($hari == "senin") {
//     echo "hari ini adalah: ". $hari . "<br>";
//     echo "seragam : putih abu";
// }elseif($hari == "selasa" || $hari == "kamis") {
//     echo "hari ini adalah: ". $hari . "<br>";
//     echo "seragam : jurusan";
// }elseif ($hari == "rabu") {
//     echo "hari ini adalah: ". $hari . "<br>";
//     echo "seragam : almet";
// }else {
//     echo "hari ini adalah: ". $hari . "<br>";
//     echo "seragam : pramuka";
// }

switch ($hari) {
    case 'senin':
        echo "hari ini adalah: ". $hari . "<br>";
        echo "seragam : putih abu";
        break;
    case 'selasa':
    case 'kamis':
        echo "hari ini adalah: ". $hari . "<br>";
        echo "seragam : jurusan";
        break;
    case 'rabu':
        echo "hari ini adalah: ". $hari . "<br>";
        echo "seragam : almet";
        break;
    case 'jumat':
        echo "hari ini adalah: ". $hari . "<br>";
        echo "seragam : pramuka";
        break;
    default:
        echo "hari " . $hari . "<br>";
        echo " seragam hari ini: libur";
        break;
}