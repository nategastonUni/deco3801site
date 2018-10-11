<?php

$GLOBALS['servername'] = 'localhost';
$GLOBALS['username'] = 'root';
$GLOBALS['password'] = 'c08a15fcaf53e799';
$GLOBALS['dbname'] = 'operapedia_website';

function filterEmail($field){
    $candidateEmail = filter_var(trim($field), FILTER_SANITIZE_EMAIL);
    
    // Validate email
    if(filter_var($candidateEmail, FILTER_VALIDATE_EMAIL)){
        return $candidateEmail;
    } else {
        return FALSE;
    }
}


//Very basic sanitisation of string field
function filterField($field) {
    $field = trim($field);
    $field = stripslashes($field);
    $field = htmlspecialchars($field);
    return $field;
}

$student = $singer = $email = $age = "";
$studentError = $singerError = $emailError = $ageError = "";

$success = "";

//On submission of form
//if ($_SERVER["REQUEST_METHOD"] == "POST") {
if (1 === 1) {
    // Validate email 
    if (empty($_POST['email'])) {
        $emailError = "<br>Please enter your email address.";     
    } else {
        $email = filterEmail($_POST['email']);
        if ($email == FALSE) {
            $emailError = "<br>Please enter a valid email address.";
        }
    }
    
    //validate radio button states
    //TODO check if protecting against SQL injection is necessary for radio button fields here
    if (empty($_POST['student'])) { 
        $studentError = "<br>This is required.";
    } else { 
    //if (isset($_POST['student'])) {
        $student = filterField($_POST['student']);
    }

    if (empty($_POST['singer'])) { 
        $singerError = "<br>This is required.";
    } else { 
        $singer = filterField($_POST['singer']);
    }

    //validate radio button states
    if (empty($_POST['age'])) { 
        $ageError = "<br>This is required.";
    } else { 
        $age = filterField($_POST['age']);
    }
    
    // Check errors before sending to database
    if(empty($emailError) && empty($studentError) && empty($singerError) && empty($ageError)){
        //success
        $success = "<br>Form validated";
        //send to database
        //testing the steel thread connection for now


        //create conncetion
        $conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
        //check connection
        if ($conn->connect_error) {
            die("Connection failed: ". $conn->connect_error);
        }
        //submit query
        $sql = "INSERT INTO `USER` (email, student, singer, age_group) VALUES ('" . $email . "', '" . $student . "', '" . $singer . "', '" . $age . "')";
        if ($conn->query($sql) === TRUE) {
            // echo "Record created successfully";
            $success = $success . " + record submitted";
        } else {
            echo "Error : " . $sql . "<br>" . $conn->error;
        }
        
        // $insert = "INSERT INTO USER (email, student, singer, age_group) VALUES (?, ?, ?, ?)";
        // $stmt = mysqli_prepare($conn, $insert);
        // $stmt->bind_param("ssss", $email, $student, $singer, $age_group);
        // $stmt->execute();
        // $stmt->close();


        mysqli_close($conn);
    }
}

?>