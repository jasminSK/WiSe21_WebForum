<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Register</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <script type = "text/javascript">  
        alert ("IMPORTANT:\nThis website is for SQL injection purposes only!\nDon't use real credentials!");  
    </script>  
</head>

<body>
    <form action="check.php" method="post">
        <h1>Register</h1>
        <input type="text" id="username" name="username" value="" placeholder="Username" required><br>
        <input type="password" id="password" name="password" value="" placeholder="Password" required><br>
        <input type="submit" name="register" value="Register">
        <p><a href="index.php"><br>Already have an account?</a></p>
    </form>
</body>

</html>
