<?php include ("config.php"); ?>
<html>
    <head>
        <title>Exam Result</title>
        <link rel="stylesheet" href="style5.css">
    </head>
    <body>
        <?php
            $paper_id = $_GET['paper_id'];
            $std_id = $_SESSION['student_id'];
            $query = "SELECT * FROM `questions` LEFT JOIN `result` ON `result`.`q_id`=`questions`.`question_number` WHERE `paper_id`=$paper_id AND `stud_id`=$std_id ORDER BY `questions`.`question_number` ASC";
            $res = mysqli_query($conn, $query);
            $correct = 0;
            $questions = 0;
            while($row=$res->fetch_assoc()){
                $questions++;
                if($row['status'] == 1) {
                    $correct++;
                }
            }
        ?>
        <p class="hedder5">Exam Results</p>
        <div class="sidebar"></div>
        <nav></nav>
        <div>
            <a href="stu_exam.php">
				<button><h3><img src=d.jpg width="9px"></h3></button>
			</a>
			<?php
				$paper_id = $_GET['paper_id'];
                $sql3="SELECT * FROM paper WHERE `paper_id`= $paper_id";
                $result1=$conn ->query($sql3);
               
               if($result1->num_rows > 0){
                   while($row=$result1->fetch_assoc()){
                       $p_id = $row['paper_id'];
                       $paper_name=$row['paper_name'];
                       $sql = "SELECT * FROM paper WHERE paper_name='{$paper_name}' AND paper_id = $p_id";
                       $result2=$conn ->query($sql);
                       echo '<b>'.$paper_name.'</b>                ';
                
                    }   
                }
			?>
            
        </div>
        <div class="Stu_Result">
            <div><h4>Exam completed</h4></div> 
            <div class="pass"><h1><?php echo $correct >= ($questions/2) ? 'Passed' : 'Failed'; ?></h1></div>
            <div class="point"><h3><?php echo  $correct.'/'.$questions; ?></h3></div>
        </div>
        <div>
            <div class="question">
                <div><h4>Questions</h4></div>
        
            <?php
                $q_no = 1;
                $res = mysqli_query($conn, $query);
                while($row=$res->fetch_assoc()){
                    echo '<div style=margin:0 0 0 0 class="question3">
                         <h4>Question '.$q_no.'</h4>
                         <table class="tab">
                             <tr><td><b>'.($row['status'] == 1 ? 'Correct' : 'Incorrect').'</b></td></tr>
                        </table>
                        </div>';
                        $q_no++;
                 }
            ?>
            </div>
        </div>   
        <div ><br> <a href="log.html"><button class="close" style="margin: 0 0 0 900 ;width: 10% ";>Close</button></a></div>

    </body>
</html>