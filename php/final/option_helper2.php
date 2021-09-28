<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="mystyle.css">
</head>
<body>

    <?php

        error_reporting(E_ALL);
        ini_set('display_errors', 'On');

        include "db_connection.php" ;


        function optionField($id)
        {
            
            //echo "$id ";
            include "db_connection.php" ;
            $result =$conn->query("SELECT id,option_text FROM answers where  question_id = '$id' ");
            //$result =$conn->prepare("SELECT option_text FROM answers WHERE id = ?");

            $result->bindParam(1,$id);
            $result->execute();
            $counter = 1;
            //echo "TESTS";
            //var_dump($result);
            
            while($rows = $result -> fetch(PDO::FETCH_ASSOC))
            {
                //var_dump($rows['option_text']);

                echo "<div class = row>"; // row2
                echo "<div class='col-25'>";
                /*
                echo<?php echo $option_text; ?> " "<label for='option".$counter."'>Option".$counter.": </label>";
                */
                echo "<label for='option".$counter."'>Option".$counter.": </label>";

                echo "</div>";     // col-25 class ını kapanma divi


                echo "<div class = 'col-75'>"; // col-75 acılma divi

                echo "<input type='text' value = '".$rows['option_text']."' id='option ".$counter."' name='option".$counter."'>";
                

                echo "<td><a href=update_answers.php?update=".$rows['id'].">/update</a></td>"; // question_id yi cekiyorum


                echo "<td><a href=deleteAnswer.php?sil=".$rows['id'].">Delete</a></td>";
                
               

                echo "</div>"; // col 75 in kapanma divi   

                echo "</div>" ; // row kapanma

                $counter++;

            }

            echo "<div class='row'>"; 
            echo "<div class='span_class'>";
            echo "<a href=answer_insert.php?insert=".$id.">Add Option</a> ";
            //echo "<a href=answer_insert.php> <button>Add Option</button>  </a> ";
            echo "</div>";

            echo "</div>";

            return $counter-1; // fazladan sonuc döndürüyor
        }



    ?>
</body>
</html>


