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
		if (!filter_var($emailid, FILTER_VALIDATE_EMAIL)) {
        $emailiderr = "Invalid email format"; 
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

	
	 if($nameerr == "" && $emailiderr == "" && $gendererr == "" && $websiteerr == "" && $commenterr == ""){
	 //	echo "I am going to run the query now ";
        $stmt = $conn -> prepare( "INSERT INTO `form` (name, emailid, website, comment, gender) VALUES (?,?,?,?,?)");
        $stmt->bind_param("sssss", $name, $emailid, $website, $comment, $gender);
       // $result = mysqli_query($conn, $sql);
      
        if($stmt->execute()){
            echo "User Created Successfully.";
        }
    }else{
            echo "User Registration Failed";
        } 
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


<script>
//Using the AJAX technique in PHP to show the validation of form without reloading the page.
//By using onblur event for the validation of the emailid, here we create its function
	function valid(){
       var data = document.getElementById('emailid').value;    //data variable stores the value fetch from id = emailid
       console.log(data);                                      //to diaplay the output value of data in console
       var xhr = new XMLHttpRequest();
		xhr.onreadystatechange = function() {
    		if (this.readyState == 4 && this.status == 200) {     //this is the condition which shows that the server is working properly
    			console.log("output");
    			console.log(this.responseText);                //this.responseText gives the final output of the validation code
    			document.getElementById('emailValid').innerHTML = this.responseText;   
    			//to get print the output near  the emailid box, we store its value in a id and call it in the <span> tag of the html code
    		}
    	}
    	xhr.open("GET", 'xm.php?q='+data, true);       //we fetch the url here by concatenating xm.php with the input data 
    	xhr.send();

	}
</script> 

</body>
</html>

