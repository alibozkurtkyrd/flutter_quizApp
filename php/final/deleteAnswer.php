<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    include "db_connection.php" ;
    
    $id = $_GET['sil'];


    $result2 =$conn->query("SELECT question_id FROM answers where id = '$id' ");
    $check2 = $result2->execute();
    $question_array = $result2 -> fetch(PDO::FETCH_ASSOC);

    $question_id = $question_array["question_id"];
    $question_id = (int)$question_id;

    

    $result =$conn->query("DELETE FROM answers where id = '$id' ");
    $check = $result->execute();


    if ($check){

        echo "kayıt silindi";
        echo "<script>";
        //echo "header('location: javascript:history.go(-1)')";
        echo "window.location.href = 'update.php?id=$question_id'";
        echo "</script>";
    }

    else{
        echo "Error";
    }
    

?>