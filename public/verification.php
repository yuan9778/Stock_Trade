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
    $sql = sprintf("SELECT * FROM users WHERE email='%s' AND password='%s'", 
								$_POST['email'],
								$_POST['pwd']);
    $result1 = $conn->query($sql);

    foreach($result1 as $row) {
		$_SESSION['fname'] = $row['firstname'];
	}

	$result = $result1->rowCount();
    $host = $_SERVER["HTTP_HOST"];
    $path = rtrim(dirname($_SERVER["PHP_SELF"]), "/\\");

  
     if ($result === 0) { 
		 // incorrect username or password
		 // go back to home page
		 $_SESSION['match'] = false;
		 header("Location: http://$host$path/index.php");
         exit();
	 }
     else { 
		 // log in successfully
		 // echo "hahahe!";
		 $_SESSION['match'] = true;
		 $_SESSION['email'] = $_POST['email'];
         header("Location: http://$host$path/profile.php");
         exit();
	 }

?>
