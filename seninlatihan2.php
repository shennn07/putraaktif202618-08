<?php

$putra = [
[21,22,23,24,25],
[31,32,33,34,35],
[41,42,43,44,45]
];

echo "soal ke 2"."<br>";
echo "<br>";

$indek = 0;

while ($indek < count($putra)) {
    $putraisi = 0;
    while ($putraisi < count($putra[$indek])) {
        if ($putraisi == 0 || $putraisi == 4) {
            echo $putra[$indek][$putraisi]." ";
        }
    $putraisi++;
    }
    echo "<br>";
    $indek++;
}