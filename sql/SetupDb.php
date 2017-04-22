<?php

session_start();

if (isset($_POST['submit'])) {

    $server = filter_input(INPUT_POST, 'server');
    $user = filter_input(INPUT_POST, 'user');
    $password = filter_input(INPUT_POST, 'password');

    file_put_contents("../application.ini", "[login]\nserver = $server\nuser = $user\npassword = $password");

    $connection = mysqli_connect($server, $user, $password);

    if (mysqli_connect_errno()) {
        printf("Fout met verbinden: %s\n", mysqli_connect_error());
        exit();
    }

    function CreateDb($connection)
    {

        $query = "CREATE DATABASE file_db";
        $instance = mysqli_query($connection, $query);
        if ($instance) {
            $_SESSION['message'] = "Aanmaken ";
        } else {
            $_SESSION['message'] = "Aanmaken ";
        }
        return $instance;
    }

    CreateDb($connection);

    function CreateTable($connection)
    {

        $query = "CREATE TABLE file_db.images (";
        $query .= "id INT(4) NOT NULL AUTO_INCREMENT,";
        $query .= "file_name VARCHAR(30) NOT NULL,";
        $query .= "uri MEDIUMBLOB NOT NULL,";
        $query .= "PRIMARY KEY(id)";
        $query .= ")";
        $table = mysqli_query($connection, $query);
        if ($table) {
            $_SESSION['message'] .= "succesvol<br><a href=\"../index.php?data=set\">naar applicatie</a>";
            $_SESSION['server'] = "true";
            $_GET['login'] = "false";
        } else {
            $_SESSION['message'] .= "database mislukt";
            $_SESSION['server'] = 'false';
        }
        return $table;
    }

    CreateTable($connection);

    function get_message()
    {
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            $_SESSION['message'] = null;
        }
    }
}
?>
<! DOCTYPE html >
<html>
<meta charset="UTF-8">
<link rel="stylesheet" href="../css/style.css" type="text/css">
<body>
<div id="container">
    <div class="form">
        <div class="element">
            <form action="SetupDb.php" method="post">
                <input type="hidden" name="login" value="true">
                <?php
                if (isset($_POST['login']) && $_POST['login'] === 'true') {
                    echo "
                    <table>
                        <tr>
                            <th rowspan=\"4\">
                                <a href=\"index.php?data=set\" id=\"start\">login</a>
                            </th>
                            <td><a id=\"link\" href=\"SetupDb.php\">terug</a>";
                }
                if (isset($_SESSION['message'])) {
                    echo get_message();
                } else {
                    ?>
                    <table>
                        <tr>
                            <th rowspan="4">
                                <a href="index.php?data=set" id="start">login</a>
                            </th>
                            <td>
                                <input type="text" id="textfield" name="server" placeholder="server" value="">
                                <input type="text" id="textfield" name="user" placeholder="user" value="">
                                <input type="password" id="textfield" placeholder="password" name="password" value="">
                                <input id="link" type="submit" name="submit" value="login">

                            </td>
                        </tr>
                    </table>

                    <?php
                }
                ?>
            </form>
        </div>
    </div>
</body>
</html>
