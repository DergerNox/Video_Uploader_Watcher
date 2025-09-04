<?php
session_start();

// Only allow admin users
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    die("Access denied. Admins only.");
}

$dsn = "mysql:host=localhost;dbname=myDB_PHP;charset=utf8";
$user = "Derger";
$pass = "B@kugan8";

try {
    $pdo = new PDO($dsn, $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Promote to admin
    if (isset($_POST['promote_user_id'])) {
        $promoteId = (int)$_POST['promote_user_id'];
        $stmt = $pdo->prepare("UPDATE RegisteredUsers SET role='admin' WHERE id=?");
        $stmt->execute([$promoteId]);
        $successMessage = "User ID $promoteId promoted to admin successfully!";
    }

    // Delete user
    if (isset($_POST['delete_user_id'])) {
        $delId = (int)$_POST['delete_user_id'];
        $stmt = $pdo->prepare("DELETE FROM RegisteredUsers WHERE id=?");
        $stmt->execute([$delId]);
        $successMessage = "User ID $delId deleted successfully!";
    }

    // Delete video
    if (isset($_POST['delete_video_id'])) {
        $delVid = (int)$_POST['delete_video_id'];
        $stmt = $pdo->prepare("DELETE FROM Videos WHERE id=?");
        $stmt->execute([$delVid]);
        $successMessage = "Video ID $delVid deleted successfully!";
    }

    // Update user info (inline editing)
    if (isset($_POST['edit_user_id'])) {
        $id = (int)$_POST['edit_user_id'];
        $username = $_POST['UserName'];
        $email = $_POST['email'];
        $stmt = $pdo->prepare("UPDATE RegisteredUsers SET UserName=?, email=? WHERE id=?");
        $stmt->execute([$username, $email, $id]);
        $successMessage = "User ID $id updated successfully!";
    }

    // Update video info (inline editing)
    if (isset($_POST['edit_video_id'])) {
        $id = (int)$_POST['edit_video_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $stmt = $pdo->prepare("UPDATE Videos SET title=?, description=? WHERE id=?");
        $stmt->execute([$title, $description, $id]);
        $successMessage = "Video ID $id updated successfully!";
    }

    // Fetch data
    $users = $pdo->query("SELECT * FROM RegisteredUsers")->fetchAll(PDO::FETCH_ASSOC);
    $videos = $pdo->query("SELECT * FROM Videos")->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
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
                <input type="hidden" name="edit_user_id" value="<?= $row['id'] ?>">
                <td><?= $row['id'] ?></td>
                <td><input type="text" name="UserName" value="<?= htmlspecialchars($row['UserName']) ?>"></td>
                <td><input type="email" name="email" value="<?= htmlspecialchars($row['email']) ?>"></td>
                <td><?= htmlspecialchars($row['password']) ?></td>
                <td><?= htmlspecialchars($row['reg_date']) ?></td>
                <td><?= htmlspecialchars($row['role']) ?></td>
                <td>
                    <button type="submit">Save</button>
                </td>
            </form>
            <td>
                <?php if ($row['role'] !== 'admin'): ?>
                    <form method="post">
                        <input type="hidden" name="promote_user_id" value="<?= $row['id'] ?>">
                        <button type="submit">Make Admin</button>
                    </form>
                <?php endif; ?>
                <form method="post" onsubmit="return confirm('Delete this user?');">
                    <input type="hidden" name="delete_user_id" value="<?= $row['id'] ?>">
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
                <input type="hidden" name="edit_video_id" value="<?= $row['id'] ?>">
                <td><?= $row['id'] ?></td>
                <td><input type="text" name="title" value="<?= htmlspecialchars($row['title']) ?>"></td>
                <td><input type="text" name="description" value="<?= htmlspecialchars($row['description']) ?>"></td>
                <td><?= htmlspecialchars($row['file_path']) ?></td>
                <td><?= htmlspecialchars($row['upload_date']) ?></td>
                <td><?= htmlspecialchars($row['UserID']) ?></td>
                <td>
                    <button type="submit">Save</button>
                </td>
            </form>
            <td>
                <form method="post" onsubmit="return confirm('Delete this video?');">
                    <input type="hidden" name="delete_video_id" value="<?= $row['id'] ?>">
                    <button type="submit">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach; ?>
</table>
</body>
</html>
