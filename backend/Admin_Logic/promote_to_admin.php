<?php
require_once __DIR__ . '/../bootstrap.php';

// Simple script to promote a user to admin

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $email = $_POST['email'];

        // Check if user exists
        $user = $entityManager->getRepository(\DB\Entities\User::class)->findOneBy(['email' => $email]);

        if ($user) {
            // Update role to admin
            $user->setRole('admin');
            $entityManager->flush();
            echo "User {$user->getUserName()} promoted to admin successfully!";
        } else {
            echo "No user found with that email.";
        }
    }

} catch (Exception $e) {
    echo "DB Error: " . $e->getMessage();
}
?>

<!-- Simple form to promote a user -->
<form method="post" action="">
    <label>User Email to Promote:</label>
    <input type="email" name="email" required>
    <button type="submit">Make Admin</button>
</form>
