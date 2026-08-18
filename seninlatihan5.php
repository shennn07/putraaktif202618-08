<?php

$putra = [
[21,22,23,24,25],
[31,32,33,34,35],
[41,42,43,44,45]
];

$indek = 0;

echo "soal ke 1"."<br>"."<br>";
echo "============"."<br>"."<br>";
while ($indek < count($putra)) {
    $putraisi = 0;
    while ($putraisi < count($putra[$indek])) {
    if ($indek == 0 && $putraisi == 0 || $indek == 1 && $putraisi == 2 || $indek == 2 && $putraisi == 4) {
        echo $putra[$indek][$putraisi]." ";
    }
    $putraisi++;
    }
    echo "<br>";
    $indek++;
}
echo "<br>";
echo "================="."<br>";
