<?php

$GLOBALS['servername'] = 'localhost';
$GLOBALS['username'] = 'root';
$GLOBALS['password'] = '';
$GLOBALS['dbname'] = 'operapedia_website';
$result_array = array();

//test a retrieve all        
//create conncetion
    $conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
    //$conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'],  $GLOBALS['dbname']);


//check connection
if ($conn->connect_error) {
    die("Connection failed: ". $conn->connect_error);
}

//test a retrieve all
$select = "SELECT student, singer, age_group, submission_time FROM USER";
$result = $conn->query($select);

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        array_push($result_array, $row);
    }
}
echo json_encode($result_array);
$conn->close();
?>
