<?php 
// $conn = mysqli_connect("localhost", "rizal", "rizal123", "data_kependudukan");
$conn = mysqli_connect("localhost", "root", "", "data_kependudukan");

	function query ($query) {
	global $conn;
	$result = mysqli_query ($conn , $query);
	$rows = [];
	while ($row = mysqli_fetch_assoc ($result)) {
	$rows[] = $row;
	}	
		return $rows; 
}
?>