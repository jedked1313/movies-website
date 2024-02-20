<?php
// Initialize the session
session_start();

// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: login.php");
    exit;
}
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$movie_name = $movie_img = $movie_dir = "";
$movie_name_err = $movie_img_err = $movie_dir_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Validate movie name
    if(empty(trim($_POST["movie_name"]))){
        $movie_name_err = "Please enter a movie name.";
    }else{
        // Prepare a select statement
        $sql = "SELECT movie_num FROM movies where movie_name = :movie_name";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":movie_name",$param_movie_name, PDO::PARAM_STR);

            // Set parameters
            $param_movie_name = trim($_POST["movie_name"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $movie_name_err = "This movie name is already taken.";
                } else{
                    $movie_name = trim($_POST["movie_name"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            unset($stmt);
        }
    }

    // Validate movie Image
    if(empty(trim($_POST["movie_img"]))){
        $movie_img_err = "Please enter a movie Image.";
    }else{
        // Prepare a select statement
        $sql = "SELECT movie_num FROM movies where movie_img = :movie_img";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":movie_img",$param_movie_img, PDO::PARAM_STR);

            // Set parameters
            $param_movie_img = trim($_POST["movie_img"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $movie_img_err = "This movie name is already taken.";
                } else{
                    $movie_img = trim($_POST["movie_img"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            unset($stmt);
        }
    }

    // Validate movie Direction
    if(empty(trim($_POST["movie_dir"]))){
        $movie_dir_err = "Please enter a movie Image.";
    }else{
        // Prepare a select statement
        $sql = "SELECT movie_num FROM movies where movie_dir = :movie_dir";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":movie_dir",$param_movie_dir, PDO::PARAM_STR);

            // Set parameters
            $param_movie_dir = trim($_POST["movie_dir"]);

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $movie_dir_err = "This movie name is already taken.";
                } else{
                    $movie_dir = trim($_POST["movie_dir"]);
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }
            // Close statement
            unset($stmt);
        }
    }
    // Check input errors before inserting in database
    if(empty($movie_name_err) && empty($movie_img_err) && empty($movie_dir_err)){
    
        // Prepare an insert statement
        $sql = "INSERT INTO movies (movie_name, movie_img ,movie_dir) VALUES (:movie_name, :movie_img ,:movie_dir)";

        if($stmt = $pdo->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":movie_name" , $param_movie_name, PDO::PARAM_STR);
            $stmt->bindParam(":movie_img" , $param_movie_img, PDO::PARAM_STR);
            $stmt->bindParam(":movie_dir" , $param_movie_dir, PDO::PARAM_STR);

            // Set parameters
            $param_movie_name = $movie_name;
            $param_movie_img = "pages/images/" . $movie_img;
            $param_movie_dir = "pages/videos/" . $movie_dir;

            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: movies_list.php");
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
    <link rel="stylesheet" type="text/css" href="css/bootstrap.css">
    <title>Add Movie</title>
    <style>
        body {font:14px sans-serif;}
        .wrapper{width : 360px ; padding :20px;margin: 0 auto;}
    </style>
</head>
<body>
<div class="container">
    <div class="wrapper">
        <h1>Add a movie</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
        <div class="form-group">
            <label>Movie Name</label>
            <input type="text" name="movie_name" class="form-control <?php echo (!empty($movie_name_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $movie_name; ?>">
            <span class="invalid-feedback"><?php echo $movie_name_err; ?></span>
        </div>
        <div class="form-group">
            <label>Movie Image</label>
            <input type="file" name="movie_img" class="form-control <?php echo (!empty($movie_img_err)) ? 'is-invalid' : ''; ?>" value="<?php echo "pages//"; ?>">
            <span class="invalid-feedback"><?php echo $movie_img_err; ?></span>
        </div>
        <div class="form-group">
            <label>Movie Direction</label>
            <input type="file" name="movie_dir" class="form-control <?php echo (!empty($movie_dir_err)) ? 'is-invalid' : ''; ?>" value="<?php echo "pages//"; ?>">
            <span class="invalid-feedback"><?php echo $movie_dir_err; ?></span>
        </div>
        <input type="submit" class="btn btn-primary" value="Add" style="margin:15px 0 0">
        </div>
    </form>
    </div>
</div>
</body>
</html>