<?php

$pdo = new PDO('mysql:host=localhost;port=3306;dbname=user_info', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$errors = [];
$id = '';
$username = '';
$email = '';
$password = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (!$username) {
        $errors[] = "Please provide a username";
    }
    if (!$email) {
        $errors[] = "Please provide an email";
    }
    if (!$password) {
        $errors[] = "Please provide a password";
    }
    if (!$errors) {
        $statement = $pdo->prepare('INSERT INTO user (id, username, email, password) VALUES (:id, :username, :email, :password)');
        $statement->bindValue(':id', $id);
        $statement->bindValue(':username', $username);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':password', $password);
        $statement->execute();
        header('Location: login.php');
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
<h2>Registration</h2>
<br>
<form action="login.php" method="post">
    <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-2 col-form-label">Username</label>
        <div class="col-sm-10">
            <input type="text" name="username" class="form-control" id="inputEmail3">
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputEmail3" class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
            <input type="email" name="email" class="form-control" id="inputEmail3">
        </div>
    </div>
    <div class="row mb-3">
        <label for="inputPassword3" class="col-sm-2 col-form-label">Password</label>
        <div class="col-sm-10">
            <input type="password" name="password" class="form-control" id="inputPassword3">
        </div>
    </div>
    <br>
    <button type="submit" class="btn btn-success">Sign in</button>
    <br><br>
    <p>Already a user?
        <a href="login.php" class="btn btn-outline-success btn-sm">Log In</a>
    </p>
</form>
</body>
</html>
