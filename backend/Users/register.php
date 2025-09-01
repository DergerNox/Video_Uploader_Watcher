<form method="post" action="register.php">
    <label>Username:</label>
    <input type="text" name="username" required><br>
    <label>Email:</label>
    <input type="email" name="email" required><br>
    <label>Password:</label>
    <input type="password" name="password" required><br>
    <button type="submit">Register</button>
</form>
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $dsn = "mysql:host=localhost;dbname=myDB_PHP;charset=utf8";
    $user = "Derger";
    $pass = "B@kugan8";

    try {
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("INSERT INTO RegisteredUsers (UserName, email, password, reg_date) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$username, $email, $hashedPassword]);

        echo "Registration successful!";

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>