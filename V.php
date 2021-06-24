<?php 

session_start(); 

if(!isset($_SESSION["verify"]) || $_SESSION["verify"] !== true){
    header("location: L.php");
    exit;
}
 
require_once "c.php";


$code_err = "";
$_SESSION["code_access"] = true;



if(isset($_POST['login']))
{ 
    if(empty(trim($_POST["code"]))){
        echo "<script>alert('PLEASE ENTER CODE');</script>";
    } else{ 

        date_default_timezone_set('Asia/Manila');
        $currentDate = date('Y-m-d H:i:s');
        $currentDate_timestamp = strtotime($currentDate);
        $code = $_POST['code'];
        

        $id_code = mysqli_query($link,"SELECT * FROM code WHERE code='$code' AND id_code=id_code") or die('Error connecting to MySQL server');
        $count = mysqli_num_rows($id_code);


        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $dbname = 'test';

        
        $conn = new mysqli($servername, $username, $password, $dbname);
        
        if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
        }

        $sql = "SELECT expiration FROM code where code='$code'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            
            while($row = $result->fetch_assoc()) {
                echo "<div style='display: none;'>"."Expiration: " . $row["expiration"]. "<br>";
                echo $currentDate."<br></div>";
                if(($row["expiration"]) >($currentDate)){

                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $id;
                    $_SESSION["username"] = $username;                            
                    header("location: W.php");

                }
                else{
                    echo "<script>alert('EXPIRED CODE ERROR');</script>";
                }
            }
          } else {
            echo "<script>alert('WRONG CODE ERROR');</script>";
          }

          $conn->close();
    }
    
    mysqli_close($link);
}
?>
  


<style>
    
h2 {
    border: black 1px solid;
    background: beige;
    border-radius: 4px;
    width: 500px;
}

a {
    border: black 1px solid;
    background: lightblue;
    border-radius: 4px;
    width: 500px;
}



</style>









<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Verification</title>
   
</head>  
<body bgcolor="color: black;">
    
    <div class="wrapper" style="position: relative;top: 220px;">
       <center><h2>Enter Code</h2></center>
        </div>
        
        <form role="form" method="post" >

                  <div class="form-group"  style="position: relative;right: -660px; top: 250px;">
                    
                    <input type="text" name="code" class="form-control">
                   
                </div>
                <div class="form-group" style="position: relative;right: -710px; top: 260px;" >
                    <button type="submit" name="login" class="btn btn-primary">LOGIN</button><BR>  
                </div>
                <br>
                <div style="position: relative;right: -700px; top: 250px;">
                     <a class="" style=" color: black;" href="R.php" target="_blank">GET CODE</a>
                </div>
        </form>

    
</body>
</html>


