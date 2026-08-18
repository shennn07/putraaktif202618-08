<?php

$putra = [
[1,2,3,4,5,6,7,8,9,10,11,12,13,14],
[15,16,17,18,19,20,21,22,23,24,25,26,27,28],
[29,30,31,32,33,34,35,36,37,38,39,40,41,42]
];

$indek = 0;

while ($indek < count($putra)) {
    $putraisi = 0;
    while ($putraisi < count($putra[$indek])) {
    echo "putra ke:" . $putra[$indek][$putraisi] . "<br>";
    $putraisi++;
    }
    echo "putra indek lain"."<br>";
    $indek++;
}
