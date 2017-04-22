<?php

require "Db.php";
require "Model.php";
session_start();

if (! isset($_GET['data'])) {
    $_GET['data'] = 'set';
}

if (isset($_GET['data']) && $_GET['data'] === 'set') {
    require __DIR__ . "/CreateUri.phtml";
}
if (isset($_GET['data']) && $_GET['data'] === 'get') {
    require __DIR__ . "/OpenUri.phtml";
}
?>


