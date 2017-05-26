<html>
<head>
<style>
.error {color: #FF0000;}
</style>
</head>
<body>
<?php
$nameerr = $emailiderr = $gendererr = $websiteerr = $commenterr = "";
$name = $emailid = $gender = $comment = $website = "";

require('conn.php');

if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if (empty($_POST["name"])){
		$nameerr = "Name is req" ;
	}else{
	$name = test($_POST["name"]);
		if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
     	$nameerr = "Only letters and white space allowed"; 
    	}
    }

	if (empty($_POST["emailid"])){
		$emailiderr = "Emailid is req" ;
	}else{
	$emailid = test($_POST["emailid"]); 

	//Here we are checking the validation of emailid, either it is present or not in the database
	$query = "SELECT `emailid` FROM `form` WHERE `emailid` = '$emailid' ";           
    $sql=mysqli_query( $conn, $query);
  //  echo mysqli_num_rows($sql);
		if (!filter_var($emailid, FILTER_VALIDATE_EMAIL)) {
        	$emailiderr = "Invalid email format"; 
    	}elseif( mysqli_num_rows($sql) >  0){
    		$emailiderr = "This email is already being used";
		}else{
			$emailid = test($_POST["emailid"]); 
		}
	}

	if (empty($_POST["website"])){
		$websiteerr = "" ;
	}else{
	$website = test($_POST["website"]);
		if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
      		$websiteerr = "Invalid URL"; 
    	}
    }

	if (empty($_POST["comment"])){
		$commenterr = "" ;
	}else{
	$comment = test($_POST["comment"]); }

	if (empty($_POST["gender"])){
		$gendererr = "Gender is req" ;
	}else{
	$gender = test($_POST["gender"]); }

	
	//Now inserting the values of the input in the database table
	if($nameerr == "" && $emailiderr == "" && $gendererr == "" && $websiteerr == "" && $commenterr == ""){
	 //	echo "I am going to run the query now ";
        $stmt = $conn -> prepare( "INSERT INTO `form` (name, emailid, website, comment, gender) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $name, $emailid, $website, $comment, $gender);
       // $result = mysqli_query($conn, $sql);
      
        if($stmt->execute()){
            echo "User Created Successfully.";
        }
    }else{
            echo "User Registration Failed";          //if any of the error is not equal to null then this will get print
        } 
}

//to avoid the use of special characters or extended data to be inserted in the input values,this function is created
function test($data){
	$data = trim($data);
	$data = stripslashes($data);
	$data =  htmlspecialchars($data);
	return $data;
}
?>


<h2>Form</h2>
<p><span class="error">* required field.</span></p>

<form action = "<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
	NAME:<input type="text" value = "<?php echo $name;?>" name="name">
	<span class = "error">* <?php echo $nameerr; ?></span>
	<br><br>
	EMAILID:<input id = "emailid" type="text" value = "<?php echo $emailid;?>" name ="emailid" onblur = "valid()">
	<span id="emailValid" class="error">* <?php echo $emailiderr; ?></span>
	<br><br>
	WEBSITE:<input type="text" value = "<?php echo $website;?>"  name="website">
	<span class = "error"> <?php echo $websiteerr; ?></span>
	<br><br>
	COMMENT: <textarea name = "comment" rows="5" cols="20"></textarea>
		<span class = "error"> <?php echo $commenterr; ?></span>
		<br><br>
	GENDER: <input type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="female">female
			<input type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="male">male
			<span class = "error">* <?php echo $gendererr; ?></span>


			<br><br>
		<input type="submit" name="submit" value="Submit" >
	</form>



</body>
</html>

