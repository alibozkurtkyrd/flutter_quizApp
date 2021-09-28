<?php

 /*
    Bu sayfa option_helper2.php isimli get methodu ile almış oldugu option_id ile
    answer tablosu üzerindeki ilgili option üzerinde güncelleme yapar.

    Daha sonra update.php sayfasına yönlendirmede bulunur.

     Not: option_helper2.php isimli dosya update.php sayfasının option ile ilgili
        işleminden sorumludur

 */
error_reporting(E_ALL);
ini_set('display_errors', 'On');

$id = $_GET['update'];
include "db_connection.php" ;
$result =$conn->query("SELECT option_text, is_it_true, question_id FROM answers where  id = '$id' ");
$result->bindParam(1,$id);
$result->execute();

$result_array= $result -> fetch(PDO::FETCH_ASSOC);
$option_text = $result_array["option_text"];
$isTrue = $result_array["is_it_true"];
$question_id = $result_array["question_id"];


?>

<!DOCTYPE html>
<html lang="en">
<head>
  <title>Update Option</title>
  <link rel="stylesheet" href="mystyle.css">

  <style>
      .top{
                margin-top: 10px;
            }

  </style>
</head>
<body>

<h1>Update related option</h1>


<div class= "container">
    <form method="POST" >

    

        <div class = "row">
            <div class="col-25">
                <label for="option_text">option:</label><br>
            </div>
                
            <div class = "col-75">
                <input type="text" id="option_text" value = "<?php echo $option_text; ?>" name="option_text"> 
            
         </div>

         <div class = "row">
            <div class="col-25">
                <label for="isTrue">Is this option true answer:</label><br>
            </div>
                
            <div class = "col-75">
                <input type="text" id="isTrue" value = "<?php echo $isTrue; ?>" name="isTrue"> 
            
         </div>

         <div class="row">
            <div class ="top">
                 <input type="submit" name="update" value="update">
            </div>     
             </div>

             
    <form methformod="POST" >
<div class= "container">
</body>
</html>

<?php
    if (isset($_POST['update'])){

        $update = $conn->prepare("UPDATE answers SET
             option_text = :option_text,
             is_it_true = :is_it_true where id = :id");
       
       $check = $update->execute(array(
            ":option_text" => $_POST["option_text"],
            
            ":is_it_true" => $_POST["isTrue"],
            ":id" => $id));

        if ($check)
        {
                echo ("calıstı");
               
                echo "<script>";
                echo "window.location.href = 'update.php?id=$question_id'";
                echo "</script>";
        }

        else{
           echo "Error";
        }       
    }




?>
