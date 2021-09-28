
<!DOCTYPE html>
<html lang="en">
    

<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <meta charset="UTF-8">
    <title>Question show page</title>
    <!-- CSS FOR STYLING THE PAGE -->
    <style>

        section {
            width: 75%;
        }
        
    
    </style>



<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Navbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
      <li class="nav-item active">
        <a class="nav-link" href="mainPage.html">AnaSayfa <span class="sr-only">(current)</span></a>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="insert.php">Soru Ekle</a>
      </li>

    </ul>
  </div>
</nav>



    <section>
        <h1></h1>
        <hr>
        <p>Bu sayfada soru havuzunda bulunan tüm sorular listelenmektedir </p>
        <hr>
        <table class="table table-striped">
            
        <thead class="thead-dark">
            <tr>
                <th>Number</th>
                <th>Question</th>
                <th>Category</th>
                <th>language</th>
                <th>Writer</th>
                <th>Options</th>
                <th>correct Answer</th>
                <th colspan="2" >actions</th>
                
            </tr>
           
        </thead>
            <?php
                include "db_connection.php" ;
                $result =$conn->query("SELECT id,question_text,category,langauge,creative_by,question_options,correct_answer FROM questions");
                $result->execute();
                $counter = 1;
                while($rows = $result -> fetch(PDO::FETCH_ASSOC))
                {
                    
            ?>
            <tr>
                <! -- Fetch data form each row of every column-->
                <td> <?php echo $counter;?> </td>
                <td> <?php echo $rows['question_text'];?> </td>
                <td> <?php echo $rows['category'];?> </td>
                <td> <?php echo $rows['langauge'];?> </td>
                <td> <?php echo $rows['creative_by'];?> </td>
                <td> <?php echo $rows['question_options'];?> </td>
                <td> <?php echo $rows['correct_answer'];?> </td>
                <td><a class="btn btn-primary" href="update.php?id=<?=$rows['id'];?>">Edit</a></td>
                <td><a class="btn btn-primary" href="delete.php?id=<?=$rows['id'];?>">Delete</a></td>

            </tr>
            <?php
            $counter++;
                }
            ?>    
        </table>
    </section>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>

</head>

</html>