<?php
require_once __DIR__ . '/../bootstrap.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Parse JSON input
    $input = json_decode(file_get_contents('php://input'), true);

    if (!$input) {
        echo json_encode(['success' => false, 'message' => 'Invalid JSON input']);
        exit;
    }

    $username = $input['username'] ?? '';
    $email = $input['email'] ?? '';
    $password = $input['password'] ?? '';

    if (empty($username) || empty($email) || empty($password)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required']);
        exit;
    }

    // Hash password for security
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Check if email already exists
        $existingUser = $entityManager->getRepository(\DB\Entities\User::class)->findOneBy(['email' => $email]);
        if ($existingUser) {
            echo json_encode(['success' => false, 'message' => 'Email already registered']);
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

        echo json_encode(['success' => true, 'message' => 'Registration successful']);

    } catch (Exception $e) {
        echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
}
?>
