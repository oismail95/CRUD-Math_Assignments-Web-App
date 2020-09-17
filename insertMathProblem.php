<?php
	//Sets the assignment number.
	$an = intval(filter_input(INPUT_GET, "an"));

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
	
	$attr_num = $_POST['attr_num'];
	$an = (int)$attr_num;
	
	//Here is where the column numbers gets initialized to insert.
	for($i = 1; $i < $an; $i++){
		$fieldArr[$i] = $_POST["field".$i];
	}
	
	//Here is the insertion process for math questions and other contents.
	$query = "INSERT INTO math_questions (`problem`, `answer`, `points`)
		VALUES ('$fieldArr[1]', '$fieldArr[2]', '$fieldArr[3]')";
		
	$result = mysqli_query($conn, $query);
	
	header("Location: main.php");
?>