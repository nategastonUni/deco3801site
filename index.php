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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
        $success = "<p>Form validated</p>";
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
            $success = $success . " + record submitted"
        } else {
            // echo "Error : " . $sql . "<br>" . $conn->error;
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

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="css/style1.css">
        <script type="text/javascript" src="js/divcolour.js"></script>     
    </head>
    
    <body>
        
        <div id ="floatingNav">
            <ul>
                <li>f1</li>
                <li>f2</li>
                <li>f3</li>
                <li>Light-Dark Theme</li>
                <li>Join the beta</li>
            </ul>
        </div>
        
        
        <div class ="bodyDiv" id ="summary">
            <h1>operapedia</h1>
            <p>a voice coach in your pocket</p>
        </div>
        
        <div class ="bodyDiv" id ="video">
            <iframe width="720" height="486" src="https://www.youtube.com/embed/-1jKBcxRp94" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
        </div>
        
        <div class ="bodyDiv" id ="feature1">
            <h2>feature 1</h2>
        </div>
        
        <div class ="bodyDiv" id ="feature2">     
            <h2>feature 2</h2>
        </div>
        
        <div class ="bodyDiv" id ="feature3">        
            <h2>feature 3</h2>
        </div>
        
        
        <div id ="feature4" class ="bodyDiv" >
            <h2>Light-Dark Theme</h2>
            <!-- needs a button -->
            
                      
            <input type="button" id="themebtn" value="Change Theme" onclick="divColor('feature4')" />
            
            
            
            
        </div>
        
        <div class ="bodyDiv" id ="callTo"> 
            <p>facebook     |     twitter     |     youtube</p>
            
            <h2> Register your Interest! </h2>
            <form method = "post">
                <p>
                    <label> Your Email Address: </label>
                    <input type ="text" name="email" id="inputEmail" value="">
                    <span class="error"><?php echo $emailError;?> </span>
                </p>
                <p>
                    <label> Are you a student? </label>
                    <input type ="radio" name="student" value ="yes"> Yes
                    <input type ="radio" name="student" value ="yes"> No
                    <span class="error"><?php echo $studentError;?></span>
                </p>
                <p>
                    <label> Are you a professional singer or teacher? </label>
                    <input type ="radio" name="singer" value ="yes"> Yes
                    <input type ="radio" name="singer" value ="yes"> No
                    <span class="error"><?php echo $singerError;?></span>
                </p>
                <p>
                <label> Please select your age: </label> <br>
                    <input type ="radio" name="age15-25" value ="15-25">15-25 <br>
                    <input type ="radio" name="age" value ="26-35">26-35 <br>
                    <input type ="radio" name="age" value ="36-45">35-45 <br>
                    <input type ="radio" name="age" value ="46-55">46-55 <br> 
                    <input type ="radio" name="age" value ="56-65">56-65 <br>
                    <input type ="radio" name="age" value ="65+">65+     <br>    
                    <span class="error"><?php echo $ageError;?></span>   
                </p>
                <p>
                    <input type="submit" name="submit" value="Register">
                    <span class="error"><?php echo $success;?></span>   
                </p>
                <p> 
                <?php
                    //test a retrieve all
                    $conn = new mysqli($GLOBALS['servername'], $GLOBALS['username'], $GLOBALS['password'], $GLOBALS['dbname']);
                    //check connection
                    if ($conn->connect_error) {
                        die("Connection failed: ". $conn->connect_error);
                    }

                    //test a retrieve all
                    $select = "SELECT email, student, singer, age_group, submission_time FROM USER";
                    $result = $conn->query($select);

                    if ($result->num_rows > 0) {
                        //output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $format = 'User: %s, Student: %s, Singer: %s, Age Group: %s, %Time: %s'
                            echo sprintf($format, $row[0], $row[1], $row[2], $row[3], $row[4]);
                        }
                    } else {
                        echo "0 results";
                    }
                    $conn->close();
                ?>

            </form>
            
            
        </div>
    
    
    
    
    </body>

    <footer>
    </footer>
</html>