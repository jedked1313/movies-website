<?php

// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$username = $email = $password = $confirm_password = "";
$username_err = $email_err = $password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate email
    if(empty(trim($_POST["email"]))){
        $email_err = "Please enter a email.";
    }else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE email = :email";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email",$param_email, PDO::PARAM_STR);

            // Set parameters
            $param_email = trim($_POST["email"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $email_err = "This email is already taken.";
                } else{
                    $email = trim($_POST["email"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            unset($stmt);
        }
    }
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain Letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE Username = :username";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username",$param_username, PDO::PARAM_STR);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "This username is already taken.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            unset($stmt);
        }
    }
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    // Check input errors before inserting in database
    if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){

        // Prepare an insert statement
        $sql = "INSERT INTO users (username, email ,Password) VALUES (:username, :email ,:password)";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username" , $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":email" , $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":password" , $param_password, PDO::PARAM_STR);

            // Set parameters
            $param_username = $username;
            $param_email = $email;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: Login.php");
            } else{
                echo "Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }
    // Close connection
    unset($pdo);
}
?>
<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">
    <title>Register</title>
  </head>
  <body>
  <div class="half">
    <div class="bg order-1 order-md-2" style="background-image: url('Images/header.jpg');"></div>
    <div class="contents order-2 order-md-1">
      <div class="container">
        <div class="row align-items-center justify-content-center">
          <div class="col-md-6">
            <div class="form-block">
              <div class="text-center mb-5">
              <h3>Register to <b>EgyBest</b></h3>
              </div>
              <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-group first">
                  <label for="Email">Email</label>
                  <input type="email"  placeholder="your-email@gmail.com" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $email; ?>">
                  <span class="invalid-feedback"><?php echo $email_err; ?></span>
                </div>
                <div class="form-group last mb-3">
                  <label for="username">Username</label>
                  <input type="text" placeholder="Your Username" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
                </div>
                <div class="form-group last mb-3">
                  <label for="password">Password</label>
                  <input type="password" name="password" placeholder="Your Password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
                </div>
                <div class="form-group last mb-3">
                  <label for="password">Confirm Password</label>
                  <input type="password" name="confirm_password" placeholder="Confirm Password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
                </div>
                <div class="d-sm-flex mb-5 align-items-center">
                  <label class="control control--checkbox mb-3 mb-sm-0"><span class="caption">Remember me</span>
                    <input type="checkbox" checked="checked"/>
                    <div class="control__indicator"></div>
                  </label>
                  <span class="ml-auto"><a href="Login.php" class="forgot-pass">Already Have Account</a></span> 
                </div>
                <div class="d-sm-flex mb-5 align-items-center" style="margin: -20px 0 0 0; ">
                  <label class="control control--checkbox mb-3 mb-sm-0"><span class="caption" >I accept the terms and conditions</span>
                    <input type="checkbox" name="terms" required/>
                    <div class="control__indicator"></div>
                  </label>
                </div>
                <input type="submit" value="Sign Up" class="btn btn-block" style="background-color:#f5802e; color:white">
                <input type="reset" class="btn btn-secondary" style="margin : 10px 0 0 0" value="Reset">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>