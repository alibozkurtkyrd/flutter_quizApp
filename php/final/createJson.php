<?php

    /*
        Bu sayfa Mysql deki verileri json a çeviren php dosyadır. Bu dosya mobil tarafından işlenip
        mobil sayfa ekranına soru olarak basılacaktır
    
    */

    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    include "db_connection.php" ;
    



    $result =$conn->query("SELECT id,question_text,category,langauge,creative_by,question_options,correct_answer FROM questions
                         order by rand() limit 7"); // 7 adet rastgele veri alacak
    $result->execute();


    while($rows = $result -> fetch(PDO::FETCH_ASSOC))
    {
        $result2 =$conn->query("SELECT * FROM answers WHERE question_id = ".$rows['id']."");
        $result2->execute();
        while ($rows2 = $result2 -> fetch(PDO::FETCH_ASSOC))
        {
            $options_data [] = array(
                'option_text' => $rows2['option_text'],
                'isTrue' => $rows2['is_it_true'],
                'question_id' => $rows2['question_id']);
        }

        $questions_data[] = array(
            'question_id' => $rows['id'],
            'question_text' => $rows['question_text'],
            'category' => $rows['category'],
            'language'  => $rows['langauge'],
            'language'  => $rows['langauge'],
            'optionNumber' => $rows['question_options'],
            'correct_answer' => $rows['correct_answer'],
            'options' => $options_data
            );

        // options_data yı bosaltmalıyız yoksa yeni soruda öncekine ekleme yapmıs oluyor
        unset($options_data);
        
    }

    
    print_r(json_encode($questions_data));
    
?>
