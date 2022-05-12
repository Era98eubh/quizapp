<html lang="en" dir="ltr">
    <head>
        <title>Student Exam</title>
        <link rel="stylesheet" href="style4.css">
    </head>
    <body>
      <p class="hedder4">Exams</p>
        <div class="sidebar"></div>
        <nav></nav>
      <div class="stexam"> 
          <input type="text" placeholder="Search">
          <button>Search</button>
      </div> 
      <div class="student">
          <table class="stexam1">
              <tr>
                 <th>Exam</th><th>Starting Date & Time</th><th>Exam Duration</th><th>Status</th>
              </tr>
            <?php
              include ("config.php");
              $sql2="SELECT * FROM paper";
              $result1=$conn->query($sql2);
              if($result1->num_rows > 0){
                while($row=$result1->fetch_assoc()){
                    $paper_id=$row['paper_id'];
                    $paper_name=$row['paper_name'];
                    $last_update=$row['last_update'];
                    $exam_duration=$row['exam_duration'];
                    $status=$row['status'];
                    if($status=='Draft'){
                      echo'
                      <tr>
                    <td> <a href="'.$paper_id.'&qu=1">'.$paper_name.'</a></td><td>'.$last_update.'</td><td>'.$exam_duration.'</td><td>'.$status.'</td>';
                    
                    }else{
                    echo'
                    <tr>
                    <td> <a href="single_exam2.php?id='.$paper_id.'&qu=1">'.$paper_name.'</a></td><td>'.$last_update.'</td><td>'.$exam_duration.'</td><td>'.$status.'</td>';
                    }
                  }
              }
            ?>
             
            
          </table>
      </div>
    </body>
</html>