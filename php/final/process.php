<?php
    /* 
        Bu sayfa insert.php den alınan 


    */


    // Tüm PHP hatalarını raporlayalım
    //error_reporting(E_ALL);
    // error_reporting(E_ALL) ile aynı;
    //ini_set('error_reporting', E_ALL);

    include "db_connection.php" ;


    if (isset($_GET['save']))
    {
        $_questionText = htmlspecialchars($_GET['question_text']);
        $questionText = addslashes($_questionText); 
        $language = $_GET['language'];  
        $category = $_GET['categories'];
	    $writer = addslashes($_GET['writer']);
	    $optionsNumber = $_GET['options'];
	    $answer = addslashes($_GET['answer']);
        
        $question_options =$_GET['question_options'];

       
        try{
          
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "INSERT INTO questions (question_text, category, langauge, creative_by, question_options, correct_answer) 
            VALUES ('$questionText', '$category','$language','$writer',$optionsNumber,'$answer')";

            $conn->exec($sql);

            $last_id= $conn->lastInsertId();
                       
            foreach($question_options as $option){
                $option = addslashes($option); // escape single quote icin

                if ($option == $answer)
                {
                    $sql2 = "INSERT INTO answers (option_text, is_it_true, question_id) 
                    VALUES ('$option', 'T',$last_id)"; 

                    $conn->exec($sql2);
                }

                else {
                    $sql2 = "INSERT INTO answers (option_text, is_it_true, question_id) 
                    VALUES ('$option', 'F',$last_id)"; 

                    $conn->exec($sql2);
                }
                

            }
            

            echo "New record created successfully";
            echo "<script>";
            echo "window.location.href = 'fetch_data.php'";
            echo "</script>";
        }
        catch(PDOException $e) {
            echo $sql . "<br>" . $e->getMessage();
            echo $sql2 . "<br>" . $e->getMessage();
        }
        

    }                   

    $conn = null;

?>
