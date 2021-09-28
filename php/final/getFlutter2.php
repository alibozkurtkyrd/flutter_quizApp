<?php
  /*
    Bu sayfa mobil uygulamadan gelen verileri Mysql'deki "player" isimli tabloya kaydeder.
   */
  error_reporting(E_ALL);
  ini_set('display_errors', 'On');
  include "db_connection.php" ;

// getting image process
//TODO: güvenlik amacıyla dosya tipini jpeg, png şeklinde sınrılamalısın: https://www.w3schools.com/php/php_file_upload.asp
$image = $_FILES['image']['name'];
$imagePath = "uploads/".$image;
move_uploaded_file($_FILES['image']['tmp_name'],$imagePath);

// get other fields
$name = $_POST['name'];
$point = (int) $_POST['point'];
$completion_time = (int) $_POST['completion_time'];
//$now =  date("Y-m-d H:i:s"); database kendi ekleyecek

$country = $_POST['country'];
$result = $conn->query("INSERT INTO player (name, image, point, completion_time, country) VALUES ('".$name."', '".$image."',
'".$point."', '".$completion_time."', '".$country."')");

 ?>
