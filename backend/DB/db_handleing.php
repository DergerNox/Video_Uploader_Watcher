<?php
$entityManager = require_once __DIR__ . '/../bootstrap.php';

function createDB(): void
{
    // Database creation is handled outside ORM
    echo "Database creation should be done manually or via CLI<br>";
}

function createTableRegisteredUsers()
{
    global $entityManager;

    $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($entityManager);
    $classes = [
        $entityManager->getClassMetadata(\DB\Entities\User::class),
    ];

    try {
        $schemaTool->updateSchema($classes, true);
        echo "RegisteredUsers table created/updated successfully<br>";
    } catch (Exception $e) {
        echo "Error creating RegisteredUsers table: " . $e->getMessage() . "<br>";
    }
}

function createTableVideos()
{
    global $entityManager;

    $schemaTool = new \Doctrine\ORM\Tools\SchemaTool($entityManager);
    $classes = [
        $entityManager->getClassMetadata(\DB\Entities\Video::class),
    ];

    try {
        $schemaTool->updateSchema($classes, true);
        echo "Videos table created/updated successfully<br>";
    } catch (Exception $e) {
        echo "Error creating Videos table: " . $e->getMessage() . "<br>";
    }
}

function checkDB(): void
{
    global $entityManager;

    $conn = $entityManager->getConnection();
    $sql = "SELECT * FROM Videos LIMIT 1";

    try {
        $stmt = $conn->executeQuery($sql);

        echo "<h2>Columns in Videos</h2><ul>";

        $columnCount = $stmt->columnCount();
        for ($i = 0; $i < $columnCount; $i++) {
            $meta = $stmt->getColumnMeta($i);
            echo "<li>" . htmlspecialchars($meta['name']) . "</li>";
        }

        echo "</ul>";
    } catch (Exception $e) {
        echo "DB Error: " . $e->getMessage();
    }
}
?>
