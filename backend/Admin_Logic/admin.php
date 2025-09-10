<?php
require_once __DIR__ . '/../bootstrap.php';

session_start();

// Only allow admin users
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access denied. Admins only.");
}

try {
    // Promote to admin
    if (isset($_POST['promote_user_id'])) {
        $promoteId = (int)$_POST['promote_user_id'];
        $userToPromote = $entityManager->find(\DB\Entities\User::class, $promoteId);
        if ($userToPromote) {
            $userToPromote->setRole('admin');
            $entityManager->flush();
            $successMessage = "User ID $promoteId promoted to admin successfully!";
        }
    }

    // Delete user
    if (isset($_POST['delete_user_id'])) {
        $delId = (int)$_POST['delete_user_id'];
        $userToDelete = $entityManager->find(\DB\Entities\User::class, $delId);
        if ($userToDelete) {
            $entityManager->remove($userToDelete);
            $entityManager->flush();
            $successMessage = "User ID $delId deleted successfully!";
        }
    }

    // Delete video
    if (isset($_POST['delete_video_id'])) {
        $delVid = (int)$_POST['delete_video_id'];
        $videoToDelete = $entityManager->find(\DB\Entities\Video::class, $delVid);
        if ($videoToDelete) {
            $entityManager->remove($videoToDelete);
            $entityManager->flush();
            $successMessage = "Video ID $delVid deleted successfully!";
        }
    }

    // Update user info (inline editing)
    if (isset($_POST['edit_user_id'])) {
        $id = (int)$_POST['edit_user_id'];
        $userToEdit = $entityManager->find(\DB\Entities\User::class, $id);
        if ($userToEdit) {
            $userToEdit->setUserName($_POST['UserName']);
            $userToEdit->setEmail($_POST['email']);
            $entityManager->flush();
            $successMessage = "User ID $id updated successfully!";
        }
    }

    // Update video info (inline editing)
    if (isset($_POST['edit_video_id'])) {
        $id = (int)$_POST['edit_video_id'];
        $videoToEdit = $entityManager->find(\DB\Entities\Video::class, $id);
        if ($videoToEdit) {
            $videoToEdit->setTitle($_POST['title']);
            $videoToEdit->setDescription($_POST['description']);
            $entityManager->flush();
            $successMessage = "Video ID $id updated successfully!";
        }
    }

    // Fetch data
    $users = $entityManager->getRepository(\DB\Entities\User::class)->findAll();
    $videos = $entityManager->getRepository(\DB\Entities\Video::class)->findAll();

} catch (Exception $e) {
    die("DB Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Page</title>
    <style>
        table { border-collapse: collapse; margin-bottom: 30px; }
        th, td { border: 1px solid #666; padding: 8px 12px; }
        th { background: #ddd; }
        .success { color: green; margin-bottom: 15px; }
        form { display: inline; margin: 0; }
        input[type="text"], input[type="email"] { width: 90%; }
    </style>
</head>
<body>
<h1>Admin Panel</h1>

<?php if (!empty($successMessage)): ?>
    <p class="success"><?= htmlspecialchars($successMessage) ?></p>
<?php endif; ?>

<h2>Registered Users</h2>
<table>
    <tr>
        <?php if (!empty($users)): ?>
            <?php foreach (array_keys($users[0]) as $col): ?>
                <th><?= htmlspecialchars($col) ?></th>
            <?php endforeach; ?>
            <th>Actions</th>
        <?php endif; ?>
    </tr>
    <?php foreach ($users as $row): ?>
        <tr>
            <form method="post">
                <input type="hidden" name="edit_user_id" value="<?= $row->getId() ?>">
                <td><?= $row->getId() ?></td>
                <td><input type="text" name="UserName" value="<?= htmlspecialchars($row->getUserName()) ?>"></td>
                <td><input type="email" name="email" value="<?= htmlspecialchars($row->getEmail()) ?>"></td>
                <td>****</td>
                <td><?= htmlspecialchars($row->getRegDate()->format('Y-m-d H:i:s')) ?></td>
                <td><?= htmlspecialchars($row->getRole()) ?></td>
                <td>
                    <button type="submit">Save</button>
                </td>
            </form>
            <td>
                <?php if ($row->getRole() !== 'admin'): ?>
                    <form method="post">
                        <input type="hidden" name="promote_user_id" value="<?= $row->getId() ?>">
                        <button type="submit">Make Admin</button>
                    </form>
                <?php endif; ?>
                <form method="post" onsubmit="return confirm('Delete this user?');">
                    <input type="hidden" name="delete_user_id" value="<?= $row->getId() ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>

<h2>Videos</h2>
<table>
    <tr>
        <?php if (!empty($videos)): ?>
            <?php foreach (array_keys($videos[0]) as $col): ?>
                <th><?= htmlspecialchars($col) ?></th>
            <?php endforeach; ?>
            <th>Actions</th>
        <?php endif; ?>
    </tr>
    <?php foreach ($videos as $row): ?>
        <tr>
            <form method="post">
                <input type="hidden" name="edit_video_id" value="<?= $row->getId() ?>">
                <td><?= $row->getId() ?></td>
                <td><input type="text" name="title" value="<?= htmlspecialchars($row->getTitle()) ?>"></td>
                <td><input type="text" name="description" value="<?= htmlspecialchars($row->getDescription() ?? '') ?>"></td>
                <td><?= htmlspecialchars($row->getFilePath()) ?></td>
                <td><?= htmlspecialchars($row->getUploadDate()->format('Y-m-d H:i:s')) ?></td>
                <td><?= htmlspecialchars($row->getUser()->getId()) ?></td>
                <td>
                    <button type="submit">Save</button>
                </td>
            </form>
            <td>
                <form method="post" onsubmit="return confirm('Delete this video?');">
                    <input type="hidden" name="delete_video_id" value="<?= $row->getId() ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
