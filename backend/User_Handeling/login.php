<?php
require_once __DIR__ . '/../bootstrap.php';

header('Content-Type: application/json');

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Parse JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        echo json_encode(['success' => false, 'message' => 'Invalid JSON input']);
        exit;
    }

    $email = $input['email'] ?? '';
    $password = $input['password'] ?? '';

    if (empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'Email and password are required']);
        exit;
    }

    try {
        $user = $entityManager->getRepository(\DB\Entities\User::class)->findOneBy(['email' => $email]);

        if ($user && password_verify($password, $user->getPassword())) {
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['role'] = $user->getRole() ?: 'user';
            echo json_encode(['success' => true, 'message' => 'Login successful', 'user_id' => $user->getId(), 'role' => $user->getRole()]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Invalid email or password']);
        }

    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
