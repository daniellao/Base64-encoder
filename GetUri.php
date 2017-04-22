<?php

require "Db.php";
session_start();

if (isset($_POST['submit'])) {
    if (isset($_POST['open'])) {
        $file_name = filter_input(INPUT_POST, 'open');

        function getFile($connection, $file_name)
        {
            $query = "SELECT file_name, uri FROM images WHERE file_name = '$file_name'";
            if ($result = mysqli_query($connection, $query)) {
                $row = mysqli_fetch_assoc($result);
                return $row;
            } else {
                exit('Fout met verbinden: ' . mysqli_connect_error());
            }
        }
    } else {
        $_SESSION['message'] = 'kies eerst een bestand';
        header('location: index.php?data=get&download=false');
    }
}

$file = getFile($connection, $file_name);

if ($file) {

    $dir = __DIR__ . sprintf("%simages%s", DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR);
    $file_name = $file['file_name'] . ".txt";
    $uri = $file['uri'];
    $_SESSION['file_name'] = $file_name;

    function saveFile($dir, $file_name, $uri)
    {
        $file = file_put_contents($dir . $file_name, $uri);
        if ($file) {
            $_SESSION['message'] = "bestand succesvol gedownload";
            header('location: index.php?data=get&download=true');
            return $file;
        }

    }
}

saveFile($dir, $file_name, $uri);


