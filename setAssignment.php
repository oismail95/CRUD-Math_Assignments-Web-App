<?php
session_start();

$an = intval(filter_input(INPUT_GET, "an"));

$_SESSION["crtassignid"] = $an;

header("Location: main.php");
?>