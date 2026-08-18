<?php

$putra = [
[21,22,23,24,25],
[31,32,33,34,35],
[41,42,43,44,45]
];

$indek = 0;

echo "soal ke 1"."<br>";
while ($indek < count($putra)) {
    $putraisi = 0;
    while ($putraisi < count($putra[$indek])) {
    echo $putra[$indek][$putraisi]." ";
    $putraisi++;
    }
    echo "<br>";
    $indek++;
}
echo "<br>"."<br>"."<br>";
echo "================="."<br>";
