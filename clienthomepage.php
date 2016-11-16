<?php
	session_start();
	require_once "connection.php";
	$ClientID=$_SESSION['ClientID'];
	$Clients_CName=""; $Clients_CEmail=""; $Clients_CPassword=""; $Clients_CAddress=""; $Clients_CPhone=""; 

	//Loading Module for each section
	//USER
	function retrieveInfoClient($ClientID, $conn){
		global $ClientID;
		$SelectSQL = "SELECT * FROM Clients WHERE ClientID = '".$ClientID."'";
		// Connect to database
		$result = mysqli_query($conn,$SelectSQL);
		if(!$result ){
		   die('There was an error running the query [' . $conn->error . ']');
		}
		if ($result->num_rows > 0) {
			while ($row = $result->fetch_assoc()){
			global $Clients_CName, $Clients_CEmail, $Clients_CAddress, $Clients_CPhone;
			$Clients_CName=$row["CName"]; $Clients_CEmail=$row["CEmail"]; $Clients_CAddress=$row["CAddress"]; $Clients_CPhone=$row["CPhone"];
		}
	}
	
	}
	
	//
	if ($_SERVER["REQUEST_METHOD"] == "POST"){	
		//Logout
		$_SESSION['ClientID'] = '';
		header('Location: index.php');
	}
	//Main php
	if (empty($ClientID)){
		echo"<br>";
		echo "Client ID is missing";
	}else{
		retrieveInfoClient($ClientID, $conn);
	}
?>
<!DOCTYPE HTML>
<html> 
	<?php include 'head/headclient.php';?>
  	
  <head>
  <title>Homepage</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
  </head>
  	
  	<body background="./images/background.jpg">
	<!--User Information-->
	<div  class="container" >
			
		<div  class="container">    
			<br><br>
			<table class="table table-bordered">
			
				<tr>
					<td colspan="2" style="font-size:120%;" align="center"><b>General User Information </b><input type="button" class="btn btn-default" name="ClientEdit" value='Edit' onclick="location.href='Clients.php?mode=Update'"/></td>
				</tr>
				<tr>
					<td><b>Client ID</b></td>
					<td><?php echo $ClientID; ?></td>
				</tr>
				
				<tr>
					<td><b>Name</b></td>
					<td><?php echo $Clients_CName; ?></td>
				</tr>
				<?php if ($debug==1) { ?>
				
				<tr>
					<td><b>Email</b></td>
					<td><?php echo $Clients_CEmail; ?></td>	
				</tr>
				<tr>
					<td><b>Address</b></td>
					<td><?php echo $Clients_CAddress; ?></td>
				</tr>
				<tr>
					<td><b>Phone</b></td>
					<td><?php echo $Clients_CPhone; ?></td>
				</tr>
				
				<tr>
					<input type="button" class="btn btn-default" name="ClientAppetite" value='My Appetites' onclick="location.href='./Appetites.php?mode=New'"/></td>
				</tr>

				<tr>
					<input type="button" class="btn btn-default" name="ClientOrder" value='Order History' onclick="location.href='./ClientOrders.php'"/></td>
				</tr>
				
				<tr>
					<input type="button" class="btn btn-default" name="ClientReview" value='My Reviews' onclick="location.href='./Reviews.php?mode=New'"/></td>
				</tr>

				<tr>
					<input type="button" class="btn btn-default" name="ClientSearch" value='Search for Restaurants' onclick="location.href='./search.php'"/></td>
				</tr>
				<tr>
					<input type="button" class="btn btn-default" name="Recommend" value='Recommendation' onclick="location.href='./recommendation.php'"/></td>
				</tr>

			<?php } ?>
			</table>
		</div>
	</div>

	</body>
	<?php //$conn->close(); ?>
</html>
	
