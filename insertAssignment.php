<?php
	session_start();

	//Sets the assignment number.
	$an = intval(filter_input(INPUT_GET, "an"));
	
	//Displays the message that the assignment already existed if a title exists using error code.
	$ec = intval(filter_input(INPUT_GET, "ec"));

	$dbhost = "localhost";
	$dbuser = "root";
	$dbpassword = "";
	$dbname = "math";
	
	$conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
	
	if(!$conn){
		die('Cannot connect: ' . mysqli_connect_error());
	}
	
	//Here is where the attribute names are received
	//and initializes them into the field array.
	$sql_math_title = 'SHOW COLUMNS FROM math_questions';
	$result_math_title = mysqli_query($conn, $sql_math_title);
	while($record = mysqli_fetch_array($result_math_title)){
		$fields[] = $record['0'];
	}
	
	//Here is where the tuples are received before storing
	//them into the math question bank.
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

	//Here is where the attribute names are reccived
	//and initialized to the field array for assignments.
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
	
	$attr_num = $_POST['attr_num'];
	$an = (int)$attr_num;
	
	//Here is where the column numbers gets initialized to insert.
	for($i = 1; $i < $an; $i++){
		$fieldArr[$i] = $_POST["field".$i];
	}
	
	//Here is where the title assignmet gets checked if it existed to
	//prevent the interface from going to the last title assignment even
	//though it already existed.
	$ec = 0;
	if($assignment_2d_arr != null){
		for($i = 0; $i < count($assignment_2d_arr[0]); $i++){
			if($fieldArr[1] == $assignment_2d_arr[1][$i])
				$ec = 1;
		}
	}
	
	//If the error code is 0, the assignment will be added.
	if($ec == 0){
		//Here is where the assignment information gets inserted into the database.
		$query = "INSERT INTO assignments (`title`, `due_date`, `course_num`, `section`)
			VALUES ('$fieldArr[1]', '$fieldArr[2]', '$fieldArr[3]', '$fieldArr[4]')";
	
		$result = mysqli_query($conn, $query);
	
		//Here is where the new created assignment is set as the current one.
		$maxassign = 'SELECT MAX(assignment_num) FROM assignments';
		$maxresult = mysqli_query($conn, $maxassign);
		$maxline = mysqli_fetch_array($maxresult, MYSQL_ASSOC);
	
		$_SESSION["crtassignid"] = intval($maxline['MAX(assignment_num)']);
	}
	
	header("Location: main.php?ec=" . $ec);
?>