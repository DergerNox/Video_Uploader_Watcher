<form method="post" action="login.php">
    <label>Email:</label>
    <input type="email" name="email" required><br>
    <label>Password:</label>
    <input type="password" name="password" required><br>
    <button type="submit">Login</button>
</form>
<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $dsn = "mysql:host=localhost;dbname=myDB_PHP;charset=utf8";
    $user = "Derger";
    $pass = "B@kugan8";

    try {
        $pdo = new PDO($dsn, $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt = $pdo->prepare("SELECT id, password FROM RegisteredUsers WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            echo "Login successful!";
        } else {
            echo "Invalid email or password.";
        }

    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
