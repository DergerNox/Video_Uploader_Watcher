<!DOCTYPE html>
<html>
<head>
    <title>User Registration & Login</title>
    <style>
        .form-container {
            display: none;
            margin-top: 20px;
            border: 1px solid #ccc;
            padding: 15px;
            width: 300px;
        }
    </style>
</head>
<body>

<h1>Welcome!</h1>

<!-- Buttons -->
<button id="registerBtn">User Registration</button>
<button id="loginBtn">User Login</button>

<!-- Registration Form -->
<div id="registerForm" class="form-container">
    <form method="post" action="User_Handeling/register.php">
        <label>Username:</label>
        <input type="text" name="username" required><br>
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Register</button>
    </form>
</div>

<!-- Login Form -->
<div id="loginForm" class="form-container">
    <form method="post" action="User_Handeling/login.php">
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Password:</label>
        <input type="password" name="password" required><br>
        <button type="submit">Login</button>
    </form>
</div>

<script>
    // Show/hide registration form
    document.getElementById("registerBtn").addEventListener("click", function() {
        const regForm = document.getElementById("registerForm");
        const loginForm = document.getElementById("loginForm");
        regForm.style.display = regForm.style.display === "none" ? "block" : "none";
        loginForm.style.display = "none"; // hide login if open
    });

    // Show/hide login form
    document.getElementById("loginBtn").addEventListener("click", function() {
        const loginForm = document.getElementById("loginForm");
        const regForm = document.getElementById("registerForm");
        loginForm.style.display = loginForm.style.display === "none" ? "block" : "none";
        regForm.style.display = "none"; // hide registration if open
    });
</script>

</body>
</html>
