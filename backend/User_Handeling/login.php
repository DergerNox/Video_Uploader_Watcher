<form method="post" action="login.php">
    <label>Email:</label>
    <input type="email" name="email" required><br>
    <label>Password:</label>
    <input type="password" name="password" required><br>
    <button type="submit">Login</button>
</form>
<?php
require_once __DIR__ . '/../bootstrap.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    try {
        $user = $entityManager->getRepository(\DB\Entities\User::class)->findOneBy(['email' => $email]);

        if ($user && password_verify($password, $user->getPassword())) {
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['role'] = $user->getRole() ?: 'user';
            echo "Login successful!";
        } else {
            echo "Invalid email or password.";
        }

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
