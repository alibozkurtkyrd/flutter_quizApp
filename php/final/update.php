<!DOCTYPE html>


<!--  fetch_data dan alınan id numaralı soruyu güncellememizi sağlar -->
<html>
        
        <!--  Yardımcı KAYNAK: https://www.w3schools.com/css/tryit.asp?filename=trycss_form_responsive -->
    <head>
    <link rel="stylesheet" href="mystyle.css">
    <title>Update Page</title>

    </head>

    <body>

         <?php

        error_reporting(E_ALL);
        ini_set('display_errors', 'On');

        include "db_connection.php" ;
    

        $id = $_GET['id'];
            
        $result =$conn->query("SELECT * FROM questions where id = '$id' ");
        $result->execute();
        $row = $result -> fetch(PDO::FETCH_ASSOC)

        ?>    


        <div class = "outside">
            
            <h2>Welcome Update  Page</h2>
            <p>Please update question.</p>
    
        <div class= "container">
             <form method="POST" >

            
            <div class = "row">
                <div class="col-25">

                <label for="question_text">Enter question:</label>
                </div>
            
                <div class = "col-75">
                    <textarea  name = "question_text"  style="height:150px" required><?php echo $row['question_text']; ?></textarea>>
                </div>
             </div>

             <div class = "row">
                <div class="col-25">

                    <label for="language"> Question language:</label>
                </div>
                
                <div class = "col-75">
                    <select name ="language" >

                    <?php
                        if ($row['langauge'] == 'Tr') {

                        echo "<option value='Tr' selected>Türkçe</option>";
                        echo "<option value='En'>English</option>";

                    } else {
                        echo "<option value='En' selected>En</option>";
                        echo "<option value='Tr'>Tr</option>";
                    }
                    ?>
                      
                    </select>
                </div>
             </div>

             <div class = "row">
                <div class="col-25">

                    <label for="categories">Question category:</label>
                </div>
                
                <div class = "col-75">
                    <select name ="categories" >
                    <?php
                        if ($row['category'] == 'General knowledge') {

                        echo "<option value='General knowledge' selected>General Knowledge</option>";
                        echo "<option value='Sience'>Sience</option>";
                        echo "<option value='Sport'>Sport</option>";
                        echo "<option value='Art'>Art</option>";

                    } else if($row['category'] == 'Sience'){
                        
                        echo "<option value='Sience'selected>Sience</option>";
                        echo "<option value='General knowledge'>General Knowledge</option>";
                        echo "<option value='Sport'>Sport</option>";
                        echo "<option value='Art'>Art</option>";
                    }
                    else if($row['category'] == 'Sport'){
                    
                    echo "<option value='Sport' selected>Sport</option>";
                    echo "<option value='Sience'>Sience</option>";
                    echo "<option value='General knowledge'>General Knowledge</option>";                    
                    echo "<option value='Art'>Art</option>";
                    }

                    else if($row['category'] == 'Art'){

                        echo "<option value='Art' selected>Art</option>";
                        echo "<option value='Sport' >Sport</option>";
                        echo "<option value='Sience'>Sience</option>";
                        echo "<option value='General knowledge'>General Knowledge</option>";                    
                        
                        }
                    ?>
                        
                    </select>
                </div>
             </div>


             <div class = "row">
                <div class="col-25">

                    <label for="writer">Creator of question:</label>
                </div>
                
                <div class = "col-75">
                    <input type="text" id="writer" name="writer" value = "<?php echo $row['creative_by']; ?>">
                </div>
             </div>



            <div class = optionSmall> 

                <?php include "option_helper2.php";  ?>

                <?php  $optionNumber = optionField($id);  ?>
                

            </div>

            <div class = "row">
                <div class="col-25">
                    <label for="options">Options of question:</label><br>
                </div>
                
                <div class = "col-75">
                    <input type="number" id="options" name="options" value = <?php echo $optionNumber;?> >
                </div>
             </div>

            <div class = "row">
                <div class="col-25">
                     <label for="answer">Answer of Question :</label>
                </div>
                
                <div class = "col-75">
                 <input type="text" id="answer" name="answer" value= "<?php echo $row['correct_answer']; ?>">
                </div>
             </div>


             <div class="row">
                 
                 <input type="submit" name="update" value="update">
                 
             </div>


         </form>
        </div>
    </div>

    <?php

        if (isset($_POST['update'])){
 
            $update = $conn->prepare("UPDATE questions SET
             question_text = :question_text,
             category = :category,
             langauge = :langauge,
             creative_by = :creative_by,
             question_options = :question_options,
             correct_answer= :correct_answer,
             creative_by = :creative_by where id = :id");

            $check = $update->execute(array(
                ":question_text" => $_POST["question_text"],
                ":creative_by" => $_POST["writer"],
                ":category" => $_POST["categories"],
                ":langauge" => $_POST["language"],
                ":creative_by" => $_POST["writer"],
                ":question_options" => $_POST["options"],
                ":correct_answer" => $_POST["answer"],
                ":id" => $row['id']));

            if ($check)
            {
               
                header('Location: fetch_data.php');
                echo "<script>";
                echo "window.location.href = 'fetch_data.php'";
                echo "</script>";
            }

            else{
                echo "Error";
            }
            

        }


    ?>
               
    <body>

</html>
