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
require_once __DIR__ . '/../bootstrap.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Check if email already exists
        $existingUser = $entityManager->getRepository(\DB\Entities\User::class)->findOneBy(['email' => $email]);
        if ($existingUser) {
            echo "Email already registered!";
            exit;
        }

        $user = new \DB\Entities\User();
        $user->setUserName($username);
        $user->setEmail($email);
        $user->setPassword($hashedPassword);
        $user->setRegDate(new \DateTime());
        $user->setRole('user');

        $entityManager->persist($user);
        $entityManager->flush();

        echo "Registration successful!";

    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
header("Location: ../index.php?message=registered");
exit;
?>
