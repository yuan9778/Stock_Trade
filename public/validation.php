<?
    // load functions
    require('../functions/functions.php');
    
    /** this is register validation page. 
    ** if validation succeed, go to profile page
    ** otherwise go to register page
    */
    session_start();
     
    $conn = connectDB("stock");	
    
    // check if this user already exists.
    $sql = sprintf("SELECT * FROM users WHERE email='%s'", $_POST["email"]);
    $result = $conn->query($sql)->rowCount();
	
    $host = $_SERVER["HTTP_HOST"];
    $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");
    if ($result === 0) { 
	// this username is never used
	 //update database to include this new user
	 $_SESSION['exist'] = false;
	 $sql = sprintf("INSERT INTO users (firstname, lastname, email, password, balance) 
			VALUES ('%s', '%s', '%s', '%s', '100000')",
			$_POST["firstname"], $_POST["lastname"], $_POST["email"], $_POST["password1"]);
                       
	// execute query
	$conn->exec($sql);
	//redirect user to profile page
	$_SESSION['fname'] = $_POST['firstname'];
	$_SESSION['email'] = $_POST['email'];
	header("Location: http://$host$path/profile.php");
         exit();
    }
    else { 
        // this username was used, go back to registration page.
	$_SESSION['exist'] = true;
        header("Location: http://$host$path/register.php");
        exit();
    }
	 
?>
