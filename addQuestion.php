<?php
	session_start();

	$dbhost = "localhost";
	$dbuser = "root";
	$dbpassword = "";
	$dbname = "math";
	
	$conn = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);
	
	if(!$conn){
		die('Cannot connect: ' . mysqli_connect_error());
	}
	
	//Sets the assignment number.
	$anid = intval($_SESSION["crtassignid"]);
	
	//Sets the question id for adding to and removing from assignments
	$qid = intval(filter_input(INPUT_GET, "qid"));
	
	$query = "INSERT INTO belongs (`question_id`, `assignment_num`) VALUES ('$qid', '$anid')";
	$result = mysqli_query($conn, $query);
	
	header("Location: main.php");
?>