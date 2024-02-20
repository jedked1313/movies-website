<?php

// Initialize the session
session_start();

// Check if the user is already logged in, otherwise redircet to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit();
}

// Include config file
require_once "config.php";

//Define variables and initialize with emty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter a New Password.";
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "Password must have atleast 6 characters.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please Confirm Password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }

    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE users SET password = :password WHERE id = :id";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":password" , $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":id" , $param_id, PDO::PARAM_INT);

            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Password updated successsfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: Login.php");
                exit();
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <style>
        body {font:14px sans-serif;}
        .wrapper{width : 360px ; padding :20px;margin: 0 auto;}
    </style>
</head>
<body>
    <div class="container">
    <div class="wrapper">
        <h1>Reset Password</h1>
        <p>Please fill in your credentials to login</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name ="new_password" class="form-control <?php echo (!empty ($new_password_err)) ? 'is-invalid' :'' ; ?>"
                value="<?php echo $new_password ; ?>">
                <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name ="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : '';?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
            <input type="submit" class="btn btn-primary" value="submit">
            <a href="index.php" class="btn btn-link ml-2">Cancel</a>
            </div>
        </form>
    </div>
    </div>
</body>
</html>