<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <form action="check.php" method="post">
        <h1>Login</h1>
        <!-- SQL-Injection: 123' OR 1=1#-->
        <input type="text" id="username" name="username" value="" placeholder="Username" required><br>
        <input type="text" id="password" name="password" value="" placeholder="Password" required><br>
        <input type="submit" name="login" value="Login">
        <p><a href="register.php"><br>Don't have an account?</a></p>
    </form> 
</body>

</html>
