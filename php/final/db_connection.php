<?php

    // Mysql ile bağlantı kurmamızı sağlayan sayfa

    // Yardımcı kaynak: https://www.w3schools.com/php/php_mysql_connect.asp
    $servername = "localhost";
    $username = "root";
    $password = "090311Hukuk.";
    //$conn;
    try {
        $conn = new PDO("mysql:host=$servername; dbname=QuizlerApp", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // buradaki double semicolan PDO class ı icerisindeki static ya 
                                                                    // constant verilere ulasmamızı saglıyor
        //echo "connected succesfully";
    } catch(PDOException $e){
        echo "Connection failed: ". $e->getMessage();
    }

?>

