<!DOCTYPE HTML>
<html><head><title>Edit Member</title> </head>
 <body>

<?php
include "config.php"; //load in any variables
$DBC = mysqli_connect("127.0.0.1", DBUSER, DBPASSWORD, DBDATABASE);

if (mysqli_connect_errno()) {
  echo "Error: Unable to connect to MySQL. ".mysqli_connect_error() ;
  exit; //stop processing the page further
};

//this line is for debugging purposes so that we cna see the actual POST/GET data
echo "<pre>"; var_dump($_POST); var_dump($_GET);echo "</pre>";

//function to clean input but not validate type and content
function cleanInput($data) {  
  return htmlspecialchars(stripslashes(trim($data)));
}

//retrieve the memberid from the URL
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $id = $_GET['id'];
    if (empty($id) or !is_numeric($id)) {
        echo "<h2>Invalid memberID</h2>"; //simple error feedback
        exit;
    } 
}
//the data was sent using a formtherefore we use the $_POST instead of $_GET
//check if we are saving data first by checking if the submit button exists in the array
if (isset($_POST['submit']) and !empty($_POST['submit']) and ($_POST['submit'] == 'Update')) {     
//validate incoming data - only the first field is done for you in this example - rest is up to you do
    $error = 0; //clear our error flag
    $msg = 'Error: ';  
     
//memberID (sent via a form ti is a string not a number so we try a type conversion!)    
    if (isset($_POST['id']) and !empty($_POST['id']) and is_integer(intval($_POST['id']))) {
       $id = cleanInput($_POST['id']); 
    } else {
       $error++; //bump the error flag
       $msg .= 'Invalid member ID '; //append error message
       $id = 0;  
    }   
//firstname
       $firstname = cleanInput($_POST['firstname']); 
//lastname
       $lastname = cleanInput($_POST['lastname']);        
//email
       $email = cleanInput($_POST['email']);        
//username
       $username = cleanInput($_POST['username']);        
    
//save the member data if the error flag is still clear and member id is > 0
    if ($error == 0 and $id > 0) {
        $query = "UPDATE member SET firstname=?,lastname=?,email=?,username=? WHERE memberID=?";
        $stmt = mysqli_prepare($DBC,$query); //prepare the query
        mysqli_stmt_bind_param($stmt,'ssssi', $firstname, $lastname, $email,$username,$id); 
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);    
        echo "<h2>Member details updated.</h2>";     
//        header('Location: http://localhost/bit608/listmembers.php', true, 303);      
    } else { 
      echo "<h2>$msg</h2>".PHP_EOL;
    }      
}
//locate the member to edit by using the memberID
//we also include the member ID in our form for sending it back for saving the data
$query = 'SELECT memberid,firstname,lastname,email,username FROM member WHERE memberid='.$id;
$result = mysqli_query($DBC,$query);
$rowcount = mysqli_num_rows($result);
if ($rowcount > 0) {
  $row = mysqli_fetch_assoc($result);
?>
<h1>Member update</h1>
<h2><a href='listmembers.php'>[Return to the member listing]</a></h2>

<form method="POST" action="editmember.php">
  <input type="hidden" name="id" value="<?php echo $id;?>">
  <p>
    <label for="firstname">Name: </label>
    <input type="text" id="firstname" name="firstname" minlength="5" 
           maxlength="50" required value="<?php echo $row['firstname']; ?>"> 
  </p> 
  <p>
    <label for="lastname">Name: </label>
    <input type="text" id="lastname" name="lastname" minlength="5" 
           maxlength="50" required value="<?php echo $row['lastname']; ?>">  
  </p>  
  <p>  
    <label for="email">Email: </label>
    <input type="email" id="email" name="email" maxlength="100" 
           size="50" required value="<?php echo $row['email']; ?>"> 
   </p>
  <p>
    <label for="username">Username: </label>
    <input type="text" id="username" name="username" minlength="8" 
           maxlength="32" required  value="<?php echo $row['username']; ?>"> 
  </p> 
  
   <input type="submit" name="submit" value="Update">
 </form>
<?php 
} else { 
  echo "<h2>Member not found with that ID</h2>"; //simple error feedback
}
mysqli_close($DBC); //close the connection once done
?>
</body>
</html>
  