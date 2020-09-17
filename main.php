<!-- Omar Ismail -->
<!-- October 23, 2019 -->
<!-- CMP SCI 4610 -->
<!-- Instructor: Abde Mtibaa -->

<?php
    session_start();
	
	//Sets the assignment number.
	if (isset($_SESSION["crtassignid"])) {
		$anid = intval($_SESSION["crtassignid"]);
	} else {
		$anid = 0;
	}
	
	//Displays the message that the assignment already existed if a title exists using error code
	$ec = intval(filter_input(INPUT_GET, "ec"));
	
	//Sets the question id for adding to and removing from assignments
	$qid = intval(filter_input(INPUT_GET, "qid"));

	$dbhost = "localhost";
	$dbuser = "root";
	$dbpassword = "";
	$dbname = "math";
	
	$conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
	
	if(!$conn){
		die('Cannot connect: ' . mysqli_connect_error());
	}
	
	//Here is where the attribute names are retrieved and initialized to the field array for math questions.
	$sql_math_title = 'SHOW COLUMNS FROM math_questions';
	$result_math_title = mysqli_query($conn, $sql_math_title);
	while($record = mysqli_fetch_array($result_math_title)){
		$math_fields[] = $record['0'];
	}
	
	//Here is where the tuples are received before storing them into the math question bank.
	$math_2d_arr = array();
	$sql_math = 'SELECT * FROM math_questions';
	$result_math = mysqli_query($conn, $sql_math);
	while($line = mysqli_fetch_array($result_math, MYSQL_ASSOC)){
		$i = 0;
		foreach($line as $col_value){
			$math_2d_arr[$i][] = $col_value;
			$i++;
		}
	}
	
	$math_ques_belongs = array();
	$sql_math_ques_belongs = 'SELECT m.question_id, m.problem
							  FROM math_questions AS m
							  JOIN belongs AS b ON m.question_id = b.question_id
							  AND b.assignment_num = '.$anid;
	$result_math_belongs = mysqli_query($conn, $sql_math_ques_belongs);
	while($line = mysqli_fetch_array($result_math_belongs, MYSQL_ASSOC)){
		$i = 0;
		foreach($line as $col_value){
			$math_ques_belongs[$i][] = $col_value;
			$i++;
		}
	}
	
	//Here is where the attribute names are reccived and initialized to the field array for assignments.
	$sql_assignment_title = 'SHOW COLUMNS FROM assignments';
	$result_assignment_title = mysqli_query($conn, $sql_assignment_title);
	while($record_2 = mysqli_fetch_array($result_assignment_title)){
		$assignment_fields[] = $record_2['0'];
	}
	
	$assignment_2d_arr = array();
	$sql_assignment = 'SELECT * FROM assignments';
	$result_assignment = mysqli_query($conn, $sql_assignment);
	while($line_2 = mysqli_fetch_array($result_assignment, MYSQL_ASSOC)){
		$i = 0;
		foreach($line_2 as $col_value_2){
			$assignment_2d_arr[$i][] = $col_value_2;
			$i++;
		}
	}
	
	//Here is where the query is set after the user chooses
	//the current assignment from the drop down list.
	$sql_assign_info = 'SELECT * FROM assignments WHERE assignment_num = ' . $anid;
	$result_assign_info = mysqli_query($conn, $sql_assign_info);
	
	$anarr = array();
	$title = "";
	$due_date = "";
	$course_num = "";
	$section = "";
	
	while($line_3 = mysqli_fetch_array($result_assign_info, MYSQL_ASSOC)){
		
		foreach($line_3 as $col_value_3){
			$anarr[] = $col_value_3;
		}
		
		$title = $anarr[1];
		$due_date = $anarr[2];
		$course_num = $anarr[3];
		$section = $anarr[4];
	}
?>

<html>
	<head>
		<meta charset="UTF-8">
		<title>Math Assignments</title>
		
		<style>
			h2{
				font-family: "Ink Free";
			}
		
			body{
				background: linear-gradient(45deg, yellow, green, yellow);
			}
			
			table, th, td {
				border: 1px solid black;
			}
		</style>
	</head>
	
	<h2>Assignment Description</h2>
	
	<!-- Here is where the user can choose assignments to display. -->
	<select id="choose_assignment" onchange="setAssignment(this.value)">
		<!-- Sets as a default when the user starts accessing the web page. -->
	    <option value="0">Select an assignment</option>
	<?php
		for($i = 0; $i < count($assignment_2d_arr[0]); $i++){
			if ($assignment_2d_arr[0][$i] == $anid) {
		?>
			<option selected="selected" value="<?php print $assignment_2d_arr[0][$i]; ?>">
		<?php
			} else {
		?>
			<option value="<?php print $assignment_2d_arr[0][$i]; ?>">
		<?php
			}
	?>
			<?php print $assignment_2d_arr[1][$i]; ?>
		</option>
	<?php
		}
	?>
	</select>
	
	<!-- Here is where the javascript onchange is performed for displaying contents from selected assignment. -->
	<script type="text/javascript">
		function setAssignment(v){
			document.location.href = "setAssignment.php?an=" + v;
		}
	</script>
	
	<!-- Here is where the contents of the assignment gets displayed as the current one. -->
	<table bgcolor="#FF6347">
		<tr>
			<?php
			for($i = 1; $i < count($assignment_fields); $i++){
			?>
				<th style="width: 8em"><?php print $assignment_fields[$i]?></th>
			<?php
			}
			?>
		</tr>
		<?php
		if($anid != 0 && strlen($title) > 0){
		?>
			<tr>
				<td><?php print $title; ?></td>
				<td><?php print $due_date; ?></td>
				<td><?php print $course_num; ?></td>
				<td><?php print $section; ?></td>
			</tr>
		<?php
		}
		?>
	</table>
	
	</br>
	
	<input type="button" onclick="showQuestions()" value="View Questions" />
	
	<script type="text/javascript">
		function showQuestions(){
			document.getElementById("displayQuestions").style.display = "block";
		}
	</script>
	
	<!-- Here is where the user can view the questions in the current assignment when the view button is pressed. -->
	<div id="displayQuestions" style="display: none">
		<h2>Questions in Current Assignment</h2>
		<?php
		if (count($math_ques_belongs) > 0) {
		?>
		<table bgcolor="#00FF7F">
			<tr>
			    <th style="width: 4em"><?php print $math_fields[0]; ?></th>
				<th style="width: 12em"><?php print $math_fields[1]; ?></th>
			</tr>
			<?php
			for($i = 0; $i < count($math_ques_belongs[0]); $i++){
			?>
				<tr>
					<th style="width: 4em"><?php print $math_ques_belongs[0][$i]; ?></th>
					<th style="width: 12em"><?php print $math_ques_belongs[1][$i]; ?></th>
				</tr>
			<?php
			}
			?>
		</table>
		<?php
		}
		?>
	</div>
	
	<h2>List of Math Problems</h2>
	
	<body>
		<!-- Here is where the question bank gets displayed for the users to submit to the assignment. -->
		<table bgcolor="#00BFFF">
			<tr>
				<?php
				for($i = 0; $i < count($math_fields); $i++){
				?>
					<th style="width: 8em"><?php print $math_fields[$i];?></th>
				<?php
				}
				?>
			</tr>
			
			<!-- Here is where the tuples gets displayed. -->
			<?php
			if(count($math_2d_arr) != null){
				for($j = 0; $j < count($math_2d_arr[0]); $j++){
				?>
				<tr>
					<?php
					for($k = 0; $k < count($math_fields); $k++){
					?>
					
					<td><?php print $math_2d_arr[$k][$j]; ?></td>
					
					<?php
					}
					
					//Here is the query that checks the current assignment number and question id to make sure the user cannot
					//add the question again in the current assignment
					$sql_inassign = 'SELECT belong_id FROM belongs WHERE assignment_num = ' . $anid . ' AND question_id = ' . $math_2d_arr[0][$j];
					$result_inassign = mysqli_query($conn, $sql_inassign);
					$line_inassign = mysqli_fetch_array($result_inassign, MYSQL_ASSOC);
	
					if (count($line_inassign) > 0) {
					?>
					<td>
					  <input type="button" id="btn<?php print $j; ?>" value="Remove from Assignment" onClick="removeFromAssignment(<?php print $math_2d_arr[0][$j]; ?>, <?php print $j; ?>)" />
					</td>
					<?php
					} else {
						//In this query, it counts the number of same course and same section of different assignments
						//to make sure the user cannot add the same question again.
						$sql_insection = "SELECT COUNT(*) AS CNT, a.title AS T1 FROM assignments AS a, belongs AS b 
						                  WHERE a.assignment_num = b.assignment_num 
										  AND a.course_num = '$course_num' AND a.section = '$section'
										  AND b.question_id = " . $math_2d_arr[0][$j];
						$result_insection = mysqli_query($conn, $sql_insection);
					    $line_insection = mysqli_fetch_array($result_insection, MYSQL_ASSOC);
						
						//If the question is not added into the assignment, it'll display the button, 'Add to Assignment'.
						//Else will display the text explaining cannot be added because that question is added to the the
						//assignment of the same course and same section.
						if ($line_insection['CNT'] == 0) {
					?>
					<td>
					  <input type="button" id="btn<?php print $j; ?>" value="Add to Assignment" onClick="addToAssignment(<?php print $math_2d_arr[0][$j]; ?>, <?php print $j; ?>)" />
					</td>
					<?php
					    } else {
					?>
						<td>Quesiton cannot be added because it is in <?php print $line_insection['T1'] ?></td>
					<?php
						}
					}
					?>
				</tr>
			<?php
				}
			}
			?>
		</table>
		
		<!-- Here is where the text of the button changes when the user adds or removes a question from the current assignment. -->
		<script type="text/javascript">
			function addToAssignment(u,v){
				document.location.href = "addQuestion.php?qid=" + u;
			}
			
			function removeFromAssignment(u, v){
				document.location.href = "removeQuestion.php?qid=" + u;
			}
		</script>
		
		</br>
		
		<!-- Here is where the user can input a new math problem and other information. -->
		<form action="insertMathProblem.php" method="post">
		<table bgcolor="#FFFF00">
			<tr>
				<?php
				for($i = 1; $i < count($math_fields); $i++){
				?>
					<th style="width: 8em"><?php print $math_fields[$i]?></th>
				<?php
				}
				?>
			</tr>
			
			<tr>
				<?php
				for($i = 1; $i < count($math_fields); $i++){
					if($i == 1){
				?>
						<!-- Here is where the user inputs the math problem. -->
						<td><textarea rows="5" cols="50" name="field<?php print $i; ?>"></textarea></td>
				<?php
					}
					else{
					?>
						<!-- Here is where the user inputs other contents related to the math problem. -->
						<td><input type="text" value="" name="field<?php print $i; ?>" /></td>
					<?php
					}
				}
				?>
				<!-- Here is where the user submits the math problem into a question bank. -->
				<td><input type="submit" value="Submit" /></td>
			</tr>
			
			<!-- Here is where the number of attributes gets passed to the insert file. -->
			<input type="hidden" name="attr_num" value="<?php print $i; ?>" />
		</table>
		</form>
		
		<!-- Here is where the user can add a new assignment. -->
		<h2>Create Assignment</h2>
		<form action="insertAssignment.php" method="post">
			<table table bgcolor="#B0C4DE">
				<tr>
					<?php
					for($i = 1; $i < count($assignment_fields); $i++){
					?>
						<th style="width: 8em"><?php print $assignment_fields[$i]?></th>
					<?php
					}
					?>
				</tr>
			
				<tr>
					<?php
					for($j = 1; $j < count($assignment_fields); $j++){
					?>
						<td><input type="text" value="" name="field<?php print $j; ?>" /></td>
					<?php
					}
					?>
				
					<td><input type="submit" value="Submit" /></td>
				</tr>
				
				<input type="hidden" name="attr_num" value="<?php print $i; ?>" />
			</table>
		</form>
		
		<!-- Here is where the error message gets displayed if the user submits the assignment already existed. -->
		<?php
			if($ec == 1){
		?>
			<h2><font color="#800000">Error: The assignment entered already existed</font></h2>
		<?php
			}
		?>
	</body>
</html>

<?php
	mysqli_close($conn);
?>