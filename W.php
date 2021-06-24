<?php 
session_start();
  
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: L.php");
    exit;
}
?>
 <style >
     

h1 {
    border: black 1px solid;
    background: gray;
    border-radius: 4px;
    padding: 150px;
}





 </style>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LoggedIn</title>
    
</head>
<body>
    
    <div style="position: relative;top: 240px;">
       <center> <h1><b>Logged In Success</h1></b></h1></center>
    </div>
    <p>
       

    
</body>
</html>