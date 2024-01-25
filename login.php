<?php
    session_start();
    if (isset($_SESSION["user"])) {
        header("Location: index.php");
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>

<video id="background-video" autoplay loop muted poster="Video/Background.mp4">
    <source src="video/Background.mp4" type="video/mp4">
</video>

<body>
    <div class="header">
        <div class="description">
            <?=date("l, d F Y") ?>
        </div>

        <div class="description">
            <span id="clock">Time: <?php echo date("H:i:s"); ?></span>
        </div>

        <script>
            function updateClock() {
                const clockElement = document.getElementById('clock');
                const now = new Date();
                const hours = String(now.getHours()).padStart(2, '0');
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');
                const timeString = 'Time: ' + hours + ':' + minutes + ':' + seconds;
                clockElement.textContent = timeString;
            }
            setInterval(updateClock, 1000);
        </script>
    </div>
    
    <br>

    <div class="container">
        <?php
            if (isset($_SESSION["user"])) {
                header("Location: index.php");
                exit;
            }       

            if (isset($_POST["login"])) {
                $email = $_POST["email"];
                $password = $_POST["password"];
                require_once "database.php";
        
                // Gunakan prepared statement
                $sql = "SELECT * FROM users WHERE email = ?";
                $stmt = mysqli_stmt_init($conn);
        
                if (mysqli_stmt_prepare($stmt, $sql)) {
                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    $user = mysqli_fetch_assoc($result);
                    
                    if ($user) {
                        if (password_verify($password, $user["password"])) {
                            $_SESSION["user"] = $user;
                            header("Location: index.php");
                            exit;
                        } else {
                            echo "<div class='alert alert-danger'>Password does not match</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger'>Email does not match</div>";
                    }
                }
            }
        ?>

        <h1>Login Account</h1><br>
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Email" name="email" class="form-control">
            </div>
            <div class="form-group">
                <input type="password" placeholder="Password" name="password" class="form-control">
            </div>
            <div class="form-btn">
                <input type="submit" value="Login" name="login" class="btn btn-primary">
            </div>
        </form>
        <div><p>Not registered yet <a href="registration.php">Register Here</a></p></div>
    </div>
</body>
</html>