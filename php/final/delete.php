<?php


    include "db_connection.php" ;
    
    $id = $_GET['id'];
    //var_dump($id);
    $result =$conn->query("DELETE FROM questions where id = '$id' ");
    $check = $result->execute();

    $result2 =$conn->query("DELETE FROM answers where question_id = '$id' ");
    $check2 = $result2->execute();
    
    if ($check && $check2){

        echo "kayıt silindi";
        echo "<script>";
        echo "window.location.href = 'fetch_data.php'";
        echo "</script>";
    }

    else{
        echo "Error";
    }
    

?>