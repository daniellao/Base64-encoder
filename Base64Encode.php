<?php

require "Db.php";
session_start();

if ($_FILES['file']['error'] == UPLOAD_ERR_NO_FILE) {
    $_SESSION['message'] = "kies eerst een bestand";
    header('location: index.php?data=set&download=false');
} else {
    function getFile()
    {
        if (isset($_POST['submit'])) {
            while ($file = $_FILES) {
                return $file;
            }
        }
    }

    function saveFile()
    {
        if (isset($_POST['submit'])) {
            $temp = $_FILES['file']['tmp_name'];
            $file = $_FILES['file']['name'];
            $destination = __DIR__ . sprintf("%simages%s", DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR);
            return move_uploaded_file($temp, $destination . $file);
        }
    }

    saveFile();

    function setBase64($image)
    {
        $dir = __DIR__ . sprintf("%simages%s", DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR);
        $file = file_get_contents($dir . $image);
        return base64_encode($file);
    }

    $image = getFile()['file']['name'];
    $uri = setBase64($image);
    $file_name = basename($image, '.jpg');

    $query = "INSERT INTO images(file_name, uri) VALUES ('{$file_name}','{$uri}')";
    $result = mysqli_query($connection, $query);
    if ($result) {
        $_SESSION['message'] = "<span id=\"message\">string succesvol aangemaakt</span>";
        $_SESSION['file_name'] = $file_name . ".txt";
        header('location: index.php?data=set&download=true');
    } else {
        $_SESSION['message'] = "Error: %s\n {mysqli_error($link)}";
    }

    function getUri($connection, $file_name)
    {
        $query = "SELECT file_name, uri FROM images WHERE file_name = '$file_name'";
        $result = mysqli_query($connection, $query);
        $file = mysqli_fetch_assoc($result);

        $file_name = $file['file_name'];
        $dir = __DIR__ . sprintf("%simages%s", DIRECTORY_SEPARATOR, DIRECTORY_SEPARATOR);
        $path = $dir . $file_name . '.txt';
        $uri = $file['uri'];
        return file_put_contents($path, $uri);
    }

    getUri($connection, $file_name);
}