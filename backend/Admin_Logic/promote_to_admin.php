<?php
// Simple script to promote a user to admin
$dsn = "mysql:host=localhost;dbname=myDB_PHP;charset=utf8";
$user = "Derger";
$pass = "B@kugan8";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];

        // Check if user exists
        $stmt = $pdo->prepare("SELECT * FROM RegisteredUsers WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            // Update role to admin
            $update = $pdo->prepare("UPDATE RegisteredUsers SET role='admin' WHERE email = ?");
            $update->execute([$email]);
            echo "User {$user['UserName']} promoted to admin successfully!";
        } else {
            echo "No user found with that email.";
        }
    }

} catch (PDOException $e) {
    echo "DB Error: " . $e->getMessage();
}
?>

<!-- Simple form to promote a user -->
<form method="post" action="">
    <label>User Email to Promote:</label>
    <input type="email" name="email" required>
    <button type="submit">Make Admin</button>
</form>
