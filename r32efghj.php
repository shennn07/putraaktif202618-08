<?php

$putra = [
    [
        "nama" => "putra",  
        "umur" => 71,     
        "manusia" => "yes"
    ],
    [
        "nama" => "putro",
        "umur" => 71,
        "manusia" => "yes"
    ],
    [
        "nama" => "putri",
        "umur" => 71,
        "manusia" => "yes"
    ]
];

$a = 0;

foreach ($putra as $putri) {
    echo "index putra ke:" . $a++ . "<br>";
    echo "nama nya adalah: " . $putri["nama"] . "<br><br>";
}

?>