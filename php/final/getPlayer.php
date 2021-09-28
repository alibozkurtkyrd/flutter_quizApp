
<!DOCTYPE html>
<!-- Bu sayfa -->
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>Question show page</title>
    <!-- CSS FOR STYLING THE PAGE -->


    <style>

        
        table {
            
            border-collapse: collapse;
            width: 70%;
        }

        th, td{
            border : 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }

        th {
            background-color: #0072ff;
            color: white;
        }

        tr:nth-child(even){
            background-color: #f2f2f2;
        }

        tr:hover{
            background-color: #ddd;
        }
        img {
            width: 75px;
            height: 75px;
        }
    </style>

</head>

<body>
    <h1>Liderlik Tablosu </h1>

    <p>Bu sayfada oyuncuların başarı sırası listelenmektedir </p>

    
        <section>

            <table class="table horizonal ">

                <tr>
                    <th>Başarı Sırası</th>
                    <th>Id</th>
                    <th>Resim</th>
                    <th>İsim</th>
                    <th>Puan</th>
                    <th>Sınavı Bitirme Süresi(Sn)</th>
                    <th>Tarih</th>
                    <th>Ülke</th>
                </tr>

<?php

include "db_connection.php" ;
$result = $conn->query("SELECT * FROM player order by point desc, completion_time asc");
//$result->execute();
$counter = 1;
while($rows = $result-> fetch(PDO::FETCH_ASSOC))
{
    //var_dump($rows['image']);
?>

<tr>
    <td><?php echo $counter;?></td>
    <td><?php echo $rows['id'];?></td>
    <td> <img src="uploads/<?php echo $rows['image'];?>"></td>
    <td> <?php echo $rows['name'];?> </td>
    <td> <?php echo $rows['point'];?> </td>
    <td> <?php echo $rows['completion_time'];?> </td>
    <td> <?php echo $rows['date'];?> </td>
    <td> <?php echo $rows['country'];?> </td>

</tr>

<?php
    $counter++;
}
?>

        </table>

    </section>
</body>


</html>
