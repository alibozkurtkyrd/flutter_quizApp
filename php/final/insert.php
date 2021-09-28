<!DOCTYPE html>

<html>
        
        <!--Bu sayfa kullancını soru havuzuna degeri girmesini sağlayan bir form sayfasıdır.-->
    <head>
    <title>İnsert Page</title>
    <style>
         * {
            box-sizing: border-box;
            }

            input[type=text], input[type=number],select, textarea{
                width: 100%;
                padding: 12px;
                border: 1px solid #ccc;
                border-radius: 4px;
                resize: vertical;
            }
            label {
                padding: 12px 12px 12px 0;
                display: inline-block;
            }
            .container{
                
                border-radius: 5px;
                background-color: #f2f2f2;
                padding: 10px;
                margin: 40px 100px 150px;
                width: 70%;
                height: 90%;

            }

           
            .outside{
                background-color: #fc8803;
                padding: 20px;
                border-radius: 4px;
            }

            .col-25{
                float:left;
                width: 25%;
                margin-top: 5px;
            }

            .col-75{
                float:left;
                width: 75%;
                margin-top: 5px;
            }

            input[type=submit] {
                
                background-color: #008CBA;
                color: white;
                padding: 12px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                float: right;
                
            }

            input[type=submit]:hover {
                background-color: #45a049;
        }
            .row:after{
                content: "";
                display: table;
                clear:both
            }

            h2{

                color: #ccdbd8;
                font-size: 30px;

            }

            p{
                color: #ccdbd8;
                font-size: 20px;
            }

            .wrapper {
                width: 60%;
                float:left;
                padding: 15px;
                border-radius: 5px;
                background: #d48585;
                
                box-shadow: 0px 10px 40px 0px rgba(47,47,47,.1);

            }


            .controls #add_more_fields{
                background-color: green;
                color: white;
                padding: 12px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                float: left;
                margin-top: 10px
 
            }
            .controls #remove_fields {
                background-color: red;
                color: white;
                padding: 12px 20px;
                border: none;
                border-radius: 4px;
                cursor: pointer;
                margin-top: 10px
                
            }

          

            #remove_fields {
                float: right;
            }
            

            a {
            color: black;
            text-decoration: none;
            }

            .top{
                margin-top: 10px;
            }
            @import url('https://fonts.googleapis.com/css2?family=Jost:wght@100;300;400;700&display=swap');


    </style>

    </head>

    <body>



        <div class = "outside">
            
            <h2>Welcome Question Creation Page</h2>
            <p>Please fill out the form below to create a question.</p>
    
        <div class= "container">
             <form method="get" action="process.php">

            
            <div class = "row">
                <div class="col-25">

                <label for="question_text">Enter question:</label>
                </div>
            
                <div class = "col-75">
                    <textarea placeholder="Enter question here"  name = "question_text"  style="height:150px"></textarea></textarea>
                </div>

            </div>

             <div class = "row">
                <div class="col-25">

                    <label for="language"> Question language:</label>
                </div>
                
                <div class = "col-75">
                    <select name ="language" >
                        <option value="Tr"> Türkçe</option> 
                        <option value="En">English</option>
                    </select>
                </div>
             </div>

             <div class = "row">
                <div class="col-25">

                    <label for="categories">Question category:</label>
                </div>
                
                <div class = "col-75">
                    <select name ="categories" >
                        <option value="General knowledge"> General Knowledge</option> 
                        <option value="Sience">Sience</option>
                        <option value="Sport"> Sport</option>
                        <option value="Art"> Art</option>
                    </select>
                </div>
             </div>


             <div class = "row">
                <div class="col-25">

                    <label for="writer">Creator of question:</label>
                </div>
                
                <div class = "col-75">
                    <input type="text" id="writer" name="writer">
                </div>
             </div>


             <div class = "row">
                <div class="col-25">

                    <label for="optionofText">Enter options:</label>
                </div> 
                    <div class="wrapper">

                        <div id="question_options">
                            <input type="text" name="question_options[]" class="question_options"
                            placeholder= "Add an option">
                        </div>

                        <div class="controls">
                            <a href="#" id="add_more_fields">Add</a>
                            <a href="#" id="remove_fields">Remove</a>
                        </div>
                    </div>
                
             </div>

             <div class = "row">
                <div class="col-25">
                    <label for="options">Options of question:</label><br>
                </div>
                
                <div class = "col-75">
                    <input type="number" id="options" name="options" min="1" max="10">
                </div>
             </div>

             <div class = "row">
                <div class="col-25">
                     <label for="answer">Answer of Question :</label>
                </div>
                
                <div class = "col-75">
                 <input type="text" id="answer" name="answer">
                </div>
             </div>
 
             <div class="row top">
                 
                 <input type="submit" name="save" value="Submit">
                 
             </div>


         </form>
        </div>
    </div>
    <script src="script.js"></script>           
    <body>

</html>

