<?php
$base = '../';
require $base . 'includes/functions.php';

if (session_status() === PHP_SESSION_NONE) session_start();
$_SESSION = [];
session_destroy();

session_start();
setAlert('success', 'Anda berhasil logout.');
redirect($base . 'index.php');
