<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>SmartGruh Login</title>

    <link rel="stylesheet"
          href="../assets/style.css">

</head>

<body>

<div class="container">

    <h1>SmartGruh Login</h1>

    <form action="../actions/login.php"
          method="POST">

        <input type="email"
               name="email"
               placeholder="Enter Email"
               required>

        <input type="password"
               name="password"
               placeholder="Enter Password"
               required>

        <button type="submit">
            Login
        </button>

    </form>

    <p>
        Don't have account?
        <a href="signup.php">
            Signup
        </a>
    </p>

</div>

</body>
</html>