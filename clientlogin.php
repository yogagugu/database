<?php
session_start();
require_once "connection.php";
if ($_SERVER["REQUEST_METHOD"] == "POST")
{	
	$ClientID = $_POST['ClientID'];
	$CPassword = $_POST['CPassword'];
	if (empty($ClientID)||empty($CPassword)){
		echo"<br>";
		echo "Client ID or password is missing";
	}
	else{
		$sql = "select * from Clients where ClientID='".$ClientID."'";
		$result = $conn->query($sql);
		if(!$result ){
		   die('There was an error running the query [' . $conn->error . ']');
		}
		$row = $result->fetch_array();
		$conn->close();
		if(!empty($row)){	
			if($row[3] == $CPassword){
				$_SESSION['ClientID']=$ClientID;
				header('Location: clienthomepage.php');
				//echo "get in";
				exit;
			}else{
				echo"<br>";

				echo "Password is wrong";
			}
		}else{
			echo"<br>";
			echo "Client does not exist";
		}
	}
}
?>
<!DOCTYPE HTML>
<html> 
  <?php include 'head/headclient.php';?>
  <head>
  <title>Client Login</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  </head>
	
	<body background="./images/background.jpg">
		<br><br><br><br><br><br>
	  <div class="container">

	      <form class="form-signin" method="post" action="<?php $_SERVER['PHP_SELF'];?>">
	        <label for="inputEmail" class="sr-only"></label>
	        <input type="text" name="ClientID" id="inputEmail" class="form-control" placeholder="Client ID" required autofocus>
	        <label for="inputCPassword" class="sr-only"></label>
	        <input type="CPassword" name="CPassword" id="inputCPassword" class="form-control" placeholder="CPassword" required>
	        <input class="btn btn-lg btn-primary btn-block" type="submit" name="submit" value="Log in"></input>
	      </form>

	    </div> <!-- /container -->
	    <div class="container">

	      <form class="form-signin">
	        <button class="btn btn-lg btn-primary btn-block" type="button" onclick="location.href='Clients.php?mode=New'">Create Account</button>
			
	      </form>

	    </div> <!-- /container -->
	    
	    <div class="container">

	    <form class="form-signin">
	    <button class="btn btn-lg btn-primary btn-block" type="button" onclick="location.href='./index.php'">Back</button>
		</form>

	    </div> <!-- /container -->
	</body>
</html>
