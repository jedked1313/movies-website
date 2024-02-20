<?php

// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect him to Home page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
  header("location: index.php");
  exit();
}

// Include config file
require_once "config.php";

//Define variables and initialize with emty values
$email = $password = "";
$email_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

  // Chech if email is empty
  if(empty(trim($_POST["email"]))){
    $email_err = "Please enter The email.";
  } else{
    $email = trim($_POST["email"]);
  }

  // Check if password is empty
  if(empty(trim($_POST["password"]))){
    $password_err = "Please Enter your password.";
  } else{
    $password = trim($_POST["password"]);
  }

  //Validate credentials
  if(empty($email_err) && empty($password_err)){
    // Prepare a select statemnt
    $sql = "SELECT id, email, username, password FROM users WHERE email = :email";

    if($stmt = $pdo->prepare($sql)){
      // Bind Variables to the prepare statement as parameters
      $stmt->bindParam(":email", $param_email, PDO::PARAM_STR);

      // Set Parameters
      $param_email = trim($_POST["email"]);

      // Attempt to execute the prepare statement
      if($stmt->execute()){
        // Check if email exists, if yes then verify password
        if($stmt-> rowCount() == 1){
        if($row = $stmt->fetch()){
          $id = $row["id"];
          $email = $row["email"];
          $username = $row["username"];
          $hashed_password = $row["password"];
          if(password_verify($password, $hashed_password)){
            // Password is correct, so start a new session
            session_start();

            // Store data in session variables
            $_SESSION["loggedin"] = true;
            $_SESSION["id"] = $id;
            $_SESSION["email"] = $email;
            $_SESSION["username"] = $username;

            // Redirect user to welcome page
            header("location: index.php");
          } else{
            // Password is not valid, display a generic error message
            $login_err = "Invalied email or password.";
          }
        }
      } else {
        // email doesn't exist, display a generic error message
        $login_err = "Invalied email or password.";
      }
    } else {
      echo "Oops! something went wrong. Please try again Later.";
    }

    // close statment
    unset($stmt);
  }
}
// close connection
unset($pdo);
}
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
  <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/Login_style.css">
</head>
<body>
<div class="container">
	<div class="container_small">
		<h3 class="text-center">Welcome to EgyBest</h3>
    <?php
      if(!empty($login_err)){
        echo '<div class="alert alert-danger">'. $login_err . '</div>';
      }
      ?>
		<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
			<label for="email">Email</label>
			<input type="text" name="email" class="<?php echo (!empty ($email_err)) ? 'is-invalid' :'' ; ?>"  value="<?php echo $email ; ?>">
      <span class="invalid-feedback"><?php echo $email_err; ?></span>
			<label for="password">Password</label>
			<input type="password" name="password" class="<?php echo (!empty($password_err)) ? 'is-invalid' : '';?>">
      <span class="invalid-feedback"><?php echo $password_err; ?></span>
			<a href="#" class="right">Forget Password ?</a>
			<input type="submit" name="submit" value="LOGIN" class="Sign_in">
		</form>
		<h2><span class="line-center">OR</span></h2>
		<div class="google_icon"><a href=""><img src="icons/google.png">Sign in With Google</a></div>
		<div class="sign_new">Don't have an account yet ? <a href="register.php">Sign up now</a></div>
	</div>
  <div class="slider image">
		<div id="main-slider" class="carousel slide" data-ride="carousel">
			<ol class="carousel-indicators">
				<li data-target="#main-slider" data-slide-to="0" class="active"></li>
				<li data-target="#main-slider" data-slide-to="1"></li>
				<li data-target="#main-slider" data-slide-to="2"></li>
        <li data-target="#main-slider" data-slide-to="3"></li>
        <li data-target="#main-slider" data-slide-to="4"></li>
			</ol>
			<div class="carousel-inner">
				<div class="carousel-item active">
				<img class="d-block w-100" src="Images/1.JPG" height="400" width="300" alt="First slide">
				</div>
				<div class="carousel-item">
				<img class="d-block w-100" src="Images/2.JPG" height="400" width="300" alt="Second slide">
				</div>
				<div class="carousel-item">
				<img class="d-block w-100" src="Images/3.PNG" height="400" width="300" alt="Third slide">
				</div>
        <div class="carousel-item">
				<img class="d-block w-100" src="Images/4.JPG" height="400" width="300" alt="fourth slide">
				</div>
        <div class="carousel-item">
				<img class="d-block w-100" src="Images/5.JPG" height="400" width="300" alt="fifth slide">
				</div>
			</div>
		</div>
	</div>
	</div>
</div>
	<!-- Javascript Links -->
	<script src="js/jquery-3.6.0.min.js"></script>
	<script src="js/popper.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/main.js"></script>
</body>
</html>