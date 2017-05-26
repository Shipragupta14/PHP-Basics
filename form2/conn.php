<?php
$servername = "localhost";
$username = "root";
$password = "shipra";
$dbname = "Data";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 
//echo "Connected successfully";


/*
$sql = "CREATE TABLE Form (
name varchar(50) not null,
emailid varchar(50) not null,
website varchar(50) ,
comment varchar(100) ,
gender varchar(30) not null
)";

if ($conn->query($sql) === TRUE) {
    echo "Table Form created successfully";
} else {
    echo "Error creating table: " . $conn->error;
}
*/

//$conn->close();
?>
