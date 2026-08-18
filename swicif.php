<?php

$nilai = 100;

switch ($nilai) {
    case ($nilai > 100):
        echo "ngibul";
        break;
    case ($nilai >= 91):
        echo "grade = A";
        break;
    case ($nilai >= 81):
        echo "grade = B";
        break;
    case ($nilai >= 71):
        echo "grade = C";
        break;
    case ($nilai >= 61):
        echo "grade = D";
        break;
    default:
        echo "grade = bodoh";
        break;
}