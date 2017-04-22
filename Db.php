<?php

$login = parse_ini_file("application.ini");

$connection = mysqli_connect($login['server'], $login['user'], $login['password'], 'file_db');

if (mysqli_connect_errno()) {
    printf("Fout met verbinden: %s\n", mysqli_connect_error());
    exit();
}

function get_message()
{
    if (isset($_SESSION['message'])) {
        echo $_SESSION['message'];
        $_SESSION['message'] = null;
    }
}


