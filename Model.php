<?php

function getImages($connection)
{
    $query = "SELECT file_name FROM images ORDER BY id DESC";

    return $result = mysqli_query($connection, $query);

}

