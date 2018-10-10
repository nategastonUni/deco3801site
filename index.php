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

<!DOCTYPE html>
<html>
<head>
	<title>Landing Page</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="css/style.css"/>
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
	<script src="js/javascript.js"></script>
</head>

<body>
<div id="nav">
  <div id="logo">Logo</div>
		<ul>
			<li>
			<a href="#home">Home</a>
			</li>
			<li>
			<a href="#mosaic">Feature 1</a>
			</li>
			<li>
			<a href="#feedback">Feature 2</a>
			</li>
			<li>
			<a href="#back">Feature 3</a>
			</li>
		</ul>
</div>


    <div id="boximg1">
        </div>
		<div id="boxtxt1">
            <h1>Feature goes here?</h1>
			<p>Pellentesque imperdiet, elit eget ultricies ultricies, libero urna scelerisque lorem, vitae convallis eros felis eu tellus. Curabitur posuere ut neque nec elementum. Nam feugiat lorem metus, eget maximus nibh molestie at. Aliquam sed nisi ante. Vivamus vel sem turpis. Curabitur ut metus a ex bibendum accumsan id in orci. Nam placerat facilisis nulla a sodales. Aliquam quis malesuada nisl.</p>
        </div>
        <div id="boximg2">         
        </div>
		<div id="boxtxt2"> 
			<h1> Feature goes here?</h1>
			<p> Pellentesque eget efficitur ipsum. Suspendisse mattis tellus libero, sit amet congue felis pulvinar eu. Vestibulum placerat facilisis felis non bibendum. Sed blandit est ex, ac sagittis enim varius at. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis egestas efficitur tellus in semper. Fusce sed ante purus. Nulla nec turpis ac neque facilisis varius. Interdum et malesuada fames ac ante ipsum primis in faucibus. Interdum et malesuada fames ac ante ipsum primis in faucibus. Pellentesque ut consectetur massa. Nulla in neque sit amet dui rhoncus hendrerit. Morbi mattis lorem sed luctus sodales. Mauris quis venenatis nulla. Cras venenatis quam ut libero euismod, non consectetur urna porttitor. Cras viverra ac sapien sit amet semper.</p>
        </div>
        <div class ="bodyDiv" id ="video">
				<iframe width="720" height="486" src="https://www.youtube.com/embed/-1jKBcxRp94" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
			</div>
		<div id="boxtxt3">
			<h1>Feature goes here?</h1>
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed ullamcorper neque ullamcorper, imperdiet nunc faucibus, volutpat leo. Etiam vitae ex facilisis libero mattis elementum non nec tellus. Proin volutpat ante quis nibh vulputate, at vehicula diam pharetra. Interdum et malesuada fames ac ante ipsum primis in faucibus. Cras tincidunt quam at ipsum tempus porta. Sed aliquet viverra nulla, id molestie massa pretium sed. Donec blandit tempus tellus sit amet pellentesque. Proin in congue urna, in hendrerit tellus. Mauris dapibus ex sit amet dui pellentesque laoreet. Cras vitae sagittis tellus. Cras porttitor nec turpis ac egestas. Nullam non molestie arcu, at dictum nulla. Mauris semper molestie felis, a rhoncus quam varius id. Phasellus pellentesque turpis et faucibus viverra. Aenean rutrum venenatis facilisis.</p>
        </div>
		<div id="boximg4">
        </div>
		<div id="boxfooter">
			<p><h1></h1>facebook     |     twitter     |     youtube</h1></p>
			
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
							$format = 'User: %s, Student: %s, Singer: %s, Age Group: %s, %Time: %s';
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
	
</html>