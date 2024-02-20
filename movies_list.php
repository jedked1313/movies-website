<?php

require_once "config.php";
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Movies List</title>
        <link rel="stylesheet" href="css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
        <style>
            body{ font:14px sans-serif;}
            .wrapper {width :360px; padding : 20px}
        </style>
    </head>
    <body class="container">
        <h1 style="margin:50px 0 20px">Movies List</h1>
        <table class="table">
            <tr>
            <th></th>
            <th>Movie Name</th>
            <th>Movie Poster</th>
            </tr>
            <?php
                $stmt = $pdo->query("SELECT * FROM movies");
                while ($row = $stmt->fetch()){ ?>
                <tr>
                    <td><a href="delete_movie.php?movie_num=<?php echo $row['movie_num'] ?>">Delete</a></td>
                    <td><?php echo $row['movie_name']; ?></td>
                    <td><img src="<?php echo $row['movie_img']; ?>" alt="Movie Img" width="250" height="300"></td>
                </tr>
            <?php
                }
            ?>
        </table>
    </body>
</html>