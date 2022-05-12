<?php 

include ("config.php");

if(isset($_POST['btnsave'])){
	$paper_id = $_GET['id'];
    $question_number = $_POST['question_number'];
    $question_name =$_POST['question_name'];
    $correct_choice = $_POST['correct_choice'];

    $ans = array();
    $ans[1] = $_POST['ans1'];
    $ans[2] = $_POST['ans2'];
    $ans[3]= $_POST['ans3'];
    $ans[4]= $_POST['ans4'];


    
    $sql1 ="INSERT INTO questions (paper_id,question_number,question_name) VALUES ('$paper_id','{$question_number}','{$question_name}')";
    $result = mysqli_query($conn,$sql1);

    if($result){
		foreach($ans as $option => $value){
			if($value != ""){
				if($correct_choice == $option){
					$is_correct = 1;
				}else{
					$is_correct = 0;
				}
            }

            $sql2 ="INSERT INTO options(paper_id,question_number,is_correct,coption) VALUES ('$paper_id','{$question_number}','{$is_correct}','{$value}')";
            $insert_row = mysqli_query($conn,$sql2);

            if($insert_row){
                continue;
            }else{
            die("2nd Query for Choices could not be executed" . $sql2);
        
            }
        }
    }
}

	if(isset($_POST['btnpublish'])){
		$exam_date = $_POST['examdate'];
		$exam_time = $_POST['examtime'];
		$exam_duration=$_POST['examduration'];
		$paper_id = $_GET['id'];

		echo($exam_date);
		echo($paper_id);
		$sql5 ="UPDATE paper SET last_update='$exam_date/$exam_time', `status`='published',exam_duration='$exam_duration' WHERE paper_id=$paper_id";
            $result= mysqli_query($conn,$sql5);

		echo("Paper has been published successfully");
	}
?>




<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<title></title>

		<link rel="stylesheet" type="text/css" href="style3.css">
	</head>
	<body>
		<p class="hedder3">Single Exam</p>
		<div class="sidebar"></div>
			<nav></nav>
		<div class="my1">
			<a href="paper.php">
				<button><img src="d.jpg" width="10px" id="my2"></h3></button>
			</a> 
			<?php
				$paper_id = $_GET['id'];
				$sql3="SELECT * FROM paper WHERE `paper_id`= $paper_id";
				$result1=$conn ->query($sql3);
				
				if($result1->num_rows > 0){
					while($row=$result1->fetch_assoc()){
						$p_id = $row['paper_id'];
						$paper_name=$row['paper_name'];
						$sql = "SELECT * FROM paper WHERE paper_name='{$paper_name}' AND paper_id = $p_id";
						$result2=$conn ->query($sql);
						echo '
						<table>
						<tr>
							<td><b>'.$paper_name.'</td><tr></table>';
					
					}
				}
			?>
		
			<div>
				<h4 class="my3">Question List</h4>
				<h3 class="my4"><button class="my5">Add Question</button> </h3>
			</div>

			<div class="my6">
				<table class="my7">
					<tr>
						<th>Question</th><th>Answers</th>
					</tr>
					<?php

						$paper_id = $_GET['id'];
						$sql3="SELECT * FROM questions WHERE `paper_id`= $paper_id";
						$result1=$conn ->query($sql3);

						if($result1->num_rows > 0){
							while($row=$result1->fetch_assoc()){
								$question_name=$row['question_name'];
								$p_id = $row['paper_id'];
								$q_id = $row['question_number'];
								$sql = "SELECT * FROM options WHERE question_number='{$q_id}' AND paper_id = $p_id";
								$result2=$conn ->query($sql);
								echo '
								<tr>
										<td>'.$question_name.'</td><td>';
								if($result2->num_rows >0){
									while($row2=$result2->fetch_assoc()){
										echo $row2['coption']." <br> ";
									}
									echo '</td>';
								}
							}
						}
					?>

				
				</table>
			</div>
				<div>
					<form method="POST" action="">
						<p>
						
							<input type="date" required class="my10" name="examdate" id="n20" placeholder="Exam Date" >
							<input type="time" required class="my10" name="examtime" id="n20" placeholder="Time" >
							<input type="number" required class="my11" name="examduration" id="n20" placeholder="Exam Duration (Seconds)" >
							
							<button class="my12" name="btnpublish" type="submit">Publish Paper</button>


							</p>
					</form>
				</div>

		</div>


			<div class="n1">
				
				<form method="POST" action="">
					<label>Question Number:</label>
					<input type="number"min="1"  name="question_number" value="<?php echo $next;  ?>" required>

					<input type="" name="question_name" id="n2" placeholder="Question name" required>

					<p class="n3">Answers List</p>

					<div for={c1}>
						<input type="" name="ans1" id="c1" class="v3" placeholder="type ans1"required >
					</div>
					
					<div for={c2}>
						<input type="" name="ans2" id="c1" class="v3" placeholder="type ans2" required >
					</div>

					<div  for={c3}>
						<input type="" name="ans3" id="c1" class="v3" placeholder="type ans3"  required>
					</div>

					<div for={c4}>
						<input type="" name="ans4" id="c1" class="v3" placeholder="type ans4" required >
					</div>
					<div>
						<input type="number" min="1" max="4" name="correct_choice" id="c1" class="v3" placeholder="correct Answers Number" required>
					</div>
					<p class="n6"> <button class="n5" value="Save" name="btnsave">Save</button></p>
				</form>
			</div>			
	</body>
</html>
