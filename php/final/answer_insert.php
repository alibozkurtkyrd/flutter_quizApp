<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');
    
    include "db_connection.php" ;
    $question_id = $_GET['insert'];


?>


<!DOCTYPE html>
<html lang="en">
<head>
  <title>İnsert an Option</title>
  <link rel="stylesheet" href="mystyle.css">
</head>
<body>

<h1>Insert an option</h1>


<div class= "container">
    <form method="POST" >

    

        <div class = "row">
            <div class="col-25">
                <label for="option_text">option:</label><br>
            </div>
                
            <div class = "col-75">
                <input type="text" id="option_text"  name="option_text"> 
            
         </div>

         <div class = "row">
            <div class="col-25">
                <label for="isTrue">Is this option true answer:</label><br>
            </div>
                
            <div class = "col-75">
                <input type="text" id="isTrue" name="isTrue" placeholder="T/F"> 
            
         </div>

         <div class="row">

              <div class='span_class'>
                 
                 <input type="submit" name="Insert" value="Insert">
                 
               </div>
             </div>

             
    <form method="POST" >
<div class= "container">
</body>
</html>


<?php
    if (isset($_POST['Insert'])){
        $optionText = addslashes($_POST['option_text']);
        $isTrue = $_POST['isTrue'];

        try{
            
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO answers (option_text, is_it_true, question_id) 
            VALUES ('$optionText', '$isTrue', '$question_id')";

            $conn->exec($sql);
            echo "New record created successfully";
            
            echo "<script>";
            
            echo "window.location.href = 'update.php?id=$question_id'";
            echo "</script>";
        }
        catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
            
        }
    }

    


?>