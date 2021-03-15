<?php
    function bodyEchoer(){
        echo('<body>
            <div class="wrapper indexPage">
                <div class="mainSection">
                    <div class="logoContainer">
                        <img src="assets/images/prior.png">
                    </div>
                    <center>
                        <h1>Fill in the details to activate PRIOR</h1>
                        <br><h3>Danger Ahead: This file will be deleted after activation!!
                        <br><br>
                        Kindly ensure the reliability of the data you provide below.</h3>
                    </center>
                    <div class="searchContainer">
                        <form action="activate.php" method="POST">
                            <input class="searchBox" type="text" name="host_name" placeholder="Host Name: "><br>
                            <input class="searchBox" type="text" name="db_name" placeholder="Database Name: "><br>
                            <input class="searchBox" type="text" name="user_name" placeholder="Database Username: "><br>
                            <input class="searchBox" type="text" name="password" placeholder="Database Password: "><br>
                            <input class="searchButton" type="submit" name="login_button" value="Activate"><br>
                        </form>		
                    </div>
                </div>       
            </div>
        </body>
        </html>');
    }

    function htmlHeader(){
        echo('<!DOCTYPE html>
            <html>
            <head>
                <title>Activate</title>
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" type="text/css" href="assets/css/style.css">
            </head>');
    }

    function deleteFile(){
        $file_pointer = "activate.php"; 
        if (!unlink($file_pointer)) { 
            header("Location: index.php");
        }
    }

    function createTable(){
        $host = $_POST['host_name'];
        $dbname = $_POST['db_name'];
        $username = $_POST['user_name'];
        $password = $_POST['password'];

        $con = new mysqli($host, $username, $password, $dbname);

        $query = "CREATE TABLE `urlshort` (
                    `id` int(11) NOT NULL AUTO_INCREMENT UNIQUE,
                    `url` varchar(4096) NOT NULL,
                    `short` varchar(10) NOT NULL
                    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

        if(mysqli_query($con, $query)){
            
            deleteFile();
                 
        }

    }

    if(isset($_POST['login_button'])) {
        createTable();
    }
    htmlHeader();
    bodyEchoer();

?>