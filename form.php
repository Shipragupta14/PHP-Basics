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
	if (!filter_var($emailid, FILTER_VALIDATE_EMAIL)) {
      $emailiderr = "Invalid email format"; 
    }
	}

	if (empty($_POST["website"])){
		$websiteerr = " " ;
	}else{
	$website = test($_POST["website"]);
	if (!preg_match("/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*[-a-z0-9+&@#\/%=~_|]/i",$website)) {
      $websiteerr = "Invalid URL"; 
    }
    }

	if (empty($_POST["comment"])){
		$commenterr = " " ;
	}else{
	$comment = test($_POST["comment"]); }

	if (empty($_POST["gender"])){
		$gendererr = "Gender is req" ;
	}else{
	$gender = test($_POST["gender"]); }
}

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
	NAME:<input type="text" name="name">
	<span class = "error">* <?php echo $nameerr; ?></span>
	<br><br>
	EMAILID:<input type="text" name ="emailid">
	<span class="error">* <?php echo $emailiderr; ?></span>
	<br><br>
	WEBSITE:<input type="text" name="website">
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

<?php
require('conn.php');
    // If the values are posted, insert them into the database.
  //  if (isset($_POST['name']) && isset($_POST['emailid'])){
      /*  $name = $_POST['name'];
		$emailid = $_POST['emailid'];
        $website = $_POST['website'];
        $comment = $_POST['comment'];
        $gender - $_POST['gender']; */
        $stmt = $conn -> prepare( "INSERT INTO `form` (name, emailid, website, comment, gender) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $name, $emailid, $website, $comment, $gender);
       // $result = mysqli_query($conn, $sql);
        if($stmt->execute()){
            $smsg = "User Created Successfully.";
        }else{
            $fmsg ="User Registration Failed";
        }

    //}
?>
</body>
</html>

