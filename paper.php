<?php
    include ("config.php");

    if(isset($_POST['btnnewexam'])){
        $paper_name = $_POST['exam_name'];
       
        $sql1="INSERT INTO paper(paper_name)VALUES('{$paper_name}')";
        $result = mysqli_query($conn,$sql1);

    }
?>

<html lang="en" dir="ltr">
    <head>
        <meta charset="utf-8">
      <title>Exam page</title>
      <link rel="stylesheet" href="style1.css">
    </head>
    <body>
        <p class="hedder2">Exams</p>
        <div class="sidebar"></div>
        <div class="main">
            <nav></nav>
            <input type="text" placeholder="Search" >
            <button class="er1">Search</button>
            <form method="POST" action="">  
                <p>
                    <input style="margin: 0 0 0 800 ;width: 30%;border-radius: 2px;height: 30px;" type="" class="er0" name="exam_name" id="n2" placeholder="Exam Name" required>
                    <button class="er2" value="New Exam" name="btnnewexam">New Exam</button>
                </p>
            </form>    
                
            <div class="form">
                <table class="texam">
                    <tr>
                        <th>Exam</th><th>Last Updated</th><th>Status</th>
                    </tr>
                    <?php
                            $sql2="SELECT * FROM paper";
                            $result1=$conn->query($sql2);
                        if($result1->num_rows > 0){
                            while($row=$result1->fetch_assoc()){
                                $paper_id=$row['paper_id'];
                                $paper_name=$row['paper_name'];
                                $last_update=$row['last_update'];
                                $status=$row['status'];

                                echo'
                                <tr>
                                <td> <a href="exam.php?id='.$paper_id.'">'.$paper_name.'</a></td><td>'.$last_update.'</td><td>'.$status.'</td>';
                            }
                        }

                    ?>                
                </table>            
            </div>
        </div>
    </body>
</html>