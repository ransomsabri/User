<?php
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=user_info', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$errors = [];
$username = '';
$passwordAttempt = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $passwordAttempt = $_POST['passwordAttempt'];

    if (!$username) {
        $errors[] = "Please provide a username";
    }
    if (!$passwordAttempt) {
        $errors[] = "Please provide a password";
    }
    if (!$errors) {
        $statement = $pdo->prepare('SELECT username, password FROM user WHERE username = :username');
        $statement->bindValue(':username', $username);
        $statement->execute();
        $users = $statement->fetch(PDO::FETCH_ASSOC);
        $hash = password_hash($users['password'],
            PASSWORD_DEFAULT);
        if($users==false){echo '<script>alert("Invalid username or password")</script>';}
        $valid_password = password_verify($passwordAttempt, $hash);
        if($valid_password){
            session_start();
            $_SESSION ['username'] = $users['username'];
            echo '<script>window.location.replace("index.php")</script>';
        }else {echo '<script>alert("Invalid username or password")</script>';}
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Backend Task</title>
</head>
<body>
<h2>Log In</h2>
<br>
<form action="login.php" method="post">
    <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-2 col-form-label">Username</label>
        <div class="col-sm-10">
            <input type="text" name="username" class="form-control" id="inputEmail3">
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-10">
            <input type="password" name="passwordAttempt" class="form-control" id="inputPassword3">
        </div>
    </div>
    <br>
    <button type="submit" class="btn btn-success">Log In</button>
    <br><br>
    <p>Don't Have an Account?
        <a href="Registration.php" class="btn btn-outline-success btn-sm">Sign In</a></p>
</form>
</body>
</html>