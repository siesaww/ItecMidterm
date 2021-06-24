<?php 
session_start();
  
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] !== true){
    header("location: W.php");
    exit;
}
  
require_once "C.php";

$_SESSION["verify"] = false;
$_SESSION["code_access"] = false;
  
 
 
if($_SERVER["REQUEST_METHOD"] == "POST"){
  
    if(empty(trim($_POST["username"]))){
        echo "<script>alert('ENTER USERNAME');</script>";
    } else{
        $username = trim($_POST["username"]);
    }
     
    if(empty(trim($_POST["password"]))){
        echo "<script>alert('ENTER PASSWORD');</script>";
    } else{
        $password = trim($_POST["password"]);
    }
     
    if(empty($username_err) && empty($password_err)){ 
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){ 
            mysqli_stmt_bind_param($stmt, "s", $param_username);
             
            $param_username = $username;
             
            if(mysqli_stmt_execute($stmt)){ 
                mysqli_stmt_store_result($stmt);
                 
                if(mysqli_stmt_num_rows($stmt) == 1){ 
                    mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){

                            $_SESSION["verify"] = true;
                            $_SESSION["code_access"] = true;
                            
                            $_SESSION["id"] = $id;
                            header("location: V.php");
                            

                        } else{ 
                             
                            echo "<script>alert('PASSWORD ERROR');</script>";
                        }
                    }
                } else{ 
                    echo "<script>alert('USERNAME IS NOT EXIST');</script>";
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_stmt_close($stmt);
        }
    }
    mysqli_close($link);
}
?>
  






<style type="text/css">
	
body{
	font-family: 'gerogia'
    background-color: black;
}
h1 {
	border: white 1px solid;
    background: white;
    border-radius: 4px;
}
form {
    font-size: 30px;
}
form {
    padding: 20px;
}
h1{
	text-align:center;
}
form {
color: yellow;
font-weight: bold;
text-align: center;
width: 100%;
}
form{
	border: black 1px solid;
    padding: 10px 20px;
    background-color: black;
}
button {
	padding: 10px 20px;
    background: pink;
    border: red 1px solid;
    color: orange;
}

</style>


<!DOCTYPE html>
<html>
<head>
	<title>LOGIN</title>

</head>
<body>



		<center><div id="main">
			<h1>LOGIN</h1>
			<form method="POST" action="#">
				<input type="text" name="username" class="text" autocomplete="off" required placeholder="username"><br><hr><br>
				<input type="password" name="password" class="text" required placeholder="password"><br><hr><br>
			
			
				<input type="Submit" name="login" class="POST">
			</form>
		</div></center>
</body>
</html>

