<?php include ("config.php"); ?>
<?php

	$paper_id = isset($_GET['id']) ? $_GET['id'] : null;
	$q_id = isset($_GET['qu']) ? $_GET['qu'] : null;

	if (isset($_GET['prev'])) {
		$q_id = $_GET['p_qu'];
	}
	
	if($paper_id != null && $q_id != null){

		$get_q_name_query="SELECT * FROM questions WHERE `paper_id`= $paper_id AND `question_number` = '$q_id';";
		$result_q_name=$conn ->query($get_q_name_query);
		
		$question_data_array = mysqli_fetch_assoc($result_q_name);

		if($question_data_array['question_number'] != null){
		
			$count_q_query = "SELECT COUNT(*) FROM `questions` WHERE `paper_id`= $paper_id;";
			$count_q_res=$conn ->query($count_q_query);
			$total_questions = mysqli_fetch_assoc($count_q_res);
			
			$next_question_number = intval($question_data_array['question_number']) + 1;
			$prev_question_number = null;

			if($total_questions['COUNT(*)'] < $next_question_number) {
				$next_question_number = null;
			}


			if ($q_id >= 2) {
				$prev_question_number = intval($question_data_array['question_number']) - 1;
			}
		}
		else{
			$question_data_array = array();
			$question_data_array['question_name'] = "no questions found";
		

		}
	}

?>
<?php
	if(isset($_GET['next']) || isset($_GET['completebtn'])){
		if (isset($_GET['ans'])) {
			
			$ans_id = $_GET['ans'];
			$sql = "SELECT * FROM options WHERE op_id='$ans_id'";
			$res = mysqli_query($conn, $sql);
			$row = mysqli_fetch_assoc($res);
			$correct = $row['is_correct'];

			$sql1 ="SELECT COUNT(*) FROM result WHERE stud_id='{$_SESSION['student_id']}' AND exm_id='$paper_id' AND q_id='{$_GET['current_q']}'";
			$result = mysqli_query($conn, $sql1);
			$data = mysqli_fetch_assoc($result);

			if($data['COUNT(*)'] > 0) {
				$sql1 ="UPDATE result SET answer='$ans_id' AND status='$correct' WHERE stud_id='{$_SESSION['student_id']}' AND exm_id='$paper_id' AND q_id='{$_GET['current_q']}'";
			} else {
				$sql1 ="INSERT INTO result(stud_id,exm_id,q_id,answer,status) VALUES ('{$_SESSION['student_id']}','$paper_id','{$_GET['current_q']}','{$ans_id}','$correct')";
			}
			mysqli_query($conn, $sql1);
		}

		if (isset($_GET['completebtn'])) {
			header('location: ./result.php?paper_id='.$paper_id);
		}
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>single Exam</title>
		<link rel="stylesheet" type="text/css" href="style6.css">
	</head>
	<body>
		<p class="hedder6">Single Exam</p>
		<div class="sidebar"></div>
			<nav></nav>

		<div class="ax1">
			<div>
				<a href="stu_exam.php">
					<button><h3><img src=d.jpg width="9px"></h3></button>
				</a>
				<?php
					if ($paper_id == null) {
						echo 'Invalid Paper. Please go back and try again!</div>';
					} else if ($q_id == null) {
						echo 'Invalid question number. Please try again!</div>';
					} else {

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
									<td><b><h3>'.$paper_name.'</h3></td><tr></table>
									';
						
							}
						}
					?>

			</div>
			<div>
				<center><b>Time left : <span id="dem">00:00</span> Seconds</center></b>
		
			</div>

				<form class="border" id="q_form"  method="GET">
					<?php
						$sql3="SELECT * FROM questions WHERE `paper_id`= $paper_id";
						$result1=$conn ->query($sql3);

						if($row=$result1->fetch_assoc()){
							$p_id = $row['paper_id'];
							$question_name=$row['question_name'];
							$sql = "SELECT * FROM questions WHERE question_name='{$question_name}' AND paper_id = '$p_id'";
							$result2=$conn ->query($sql);
							echo '<p class="ax2"><br><br>Q:'.$question_data_array['question_name'].'</p>';
						}			
					?>
					<div class="border2">
						<?php
							$sql3="SELECT * FROM options WHERE question_number='$q_id' AND paper_id='$paper_id'";
							$result1=$conn ->query($sql3);
							if($result1->num_rows > 0){

								echo '
								<input type="hidden" name="id" value="'.$paper_id.'">
								<input type="hidden" name="qu" value="'.$next_question_number.'">
								<input type="hidden" name="p_qu" value="'.$prev_question_number.'">
								<input type="hidden" name="current_q" value="'.$q_id.'">
								';

								while($row=$result1->fetch_assoc()){
									$coption=$row['coption'];
									$op_id=$row['op_id'];
									echo'<p><input type="radio" name="ans" value="'.$op_id.'">'.$coption.'</p>';
								}	
							}
						?>
					</div>

				<?php
					echo'
						<p class="center">Question Number:'.$question_data_array['question_number'].'</p>';
				?>
					<div style="display:flex; justify-content: space-between;">
						<button type="submit" name="prev" <?php if(!$prev_question_number) { echo 'disabled'; } ?>>Previous</button>
						<button type="submit" name="next" <?php if(!$next_question_number) { echo 'disabled'; } ?>>Next</button>
					</div>
					<br></br>
					<div style="display:flex; justify-content: flex-end;">
						<button type="submit" class="ax6" name="completebtn" <?php if($next_question_number) { echo 'disabled'; } ?>>Complete</button>
					</div>
				</form>
			<?php } ?>
		</div>
		
		<script>
			
			let timeSecond = 30;
			const timeH = document.getElementById("dem");

			displayTime(timeSecond);

			const countDown = setInterval(() => {
			timeSecond--;
			displayTime(timeSecond);
			if (timeSecond == 0 || timeSecond < 1) {
				endCount();
				clearInterval(countDown);
			}
			}, 1000);

			function displayTime(second) {
				const min = Math.floor(second / 60);
				const sec = Math.floor(second % 60);
				timeH.innerHTML = `
				${min < 10 ? "0" : ""}${min}:${sec < 10 ? "0" : ""}${sec}`;
			}

			function endCount() {
			timeH.innerHTML = "Time out";
			}

			// *********************
			// This Code is for only the floating card in right bottom corner
			// **********************

			const touchButton = document.querySelector(".float-text");
			const card = document.querySelector(".float-card-info");
			const close = document.querySelector(".gg-close-r");

			touchButton.addEventListener("click", moveCard);
			close.addEventListener("click", moveCard);

			function moveCard() {
			card.classList.toggle("active");
			}

		</script>
		
	</body>
</html>