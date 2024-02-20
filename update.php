<?php
// NOTE !!
/***** There is a error when updating the username only or email only , They all need to be updated *******/

// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}

// Include config file
require_once "config.php";
$pdo_statement = $pdo->prepare("select * from users where id = :id");
$id = $_GET['id'];
$pdo_statement->execute(['id' => $id]);
$row = $pdo_statement->fetch(PDO::FETCH_ASSOC);

// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain Letters, numbers, and underscores.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM users WHERE username = :username";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username",$param_username, PDO::PARAM_STR);

            // Set parameters
            $param_username = trim($_POST["username"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                //if($stmt->rowCount() == 1){
                    //$username_err = "This username is already taken.";
               // } else{
                    $username = trim($_POST["username"]);
                }
                /*}*/ else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            unset($stmt);
        }
    }
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
               // if($stmt->rowCount() == 1){
                   // $email_err = "This email is already taken.";
               // } else{
                    $email = trim($_POST["email"]);
                }
                /*}*/else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            unset($stmt);
        }
    }
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
    if(empty($new_password_err) && empty($confirm_password_err) && empty($username_err)){
        
        // Prepare an update statement
        $sql = "UPDATE users SET email = :email , username = :username , password = :password WHERE id = :id";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":email" , $param_email, PDO::PARAM_STR);
            $stmt->bindParam(":username" , $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password" , $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":id" , $param_id, PDO::PARAM_INT);

            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_email = $email;
            $param_username = $username;
            $param_id = $_SESSION["id"];

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                header("location: list.php");
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
    <title>Update user info</title>
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
    <link rel="stylesheet" herf="https://stackpath.bootstrapcdn.com/bootstrap/4.4.2/css//bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; margin: 0 auto;}
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Update user info</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <p class="lead" style="padding:20px 0 0 0;">All information must be changed !</p>
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>"
                value="<?php echo $row['username']; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>
            <div class="form-group">
                <label for="email">email</label>
                <input type="email" name="email" class="form-control <?php echo (!empty($email_err)) ? 'is-invalid' : ''; ?>"
                value="<?php echo $row['email']; ?>">
                <span class="invalid-feedback"><?php echo $email_err; ?></span>
            </div>
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
                <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <a class="btn btn-link ml-2" href="index.php">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>