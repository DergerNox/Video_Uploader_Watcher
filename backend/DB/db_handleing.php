<?php
function createDB(): void
{
    // Create database
    $servername = "localhost";
    $username = "Derger";
    $password = "B@kugan8";
    try {
        $conn = new PDO("mysql:host=$servername", $username, $password);
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = "CREATE DATABASE IF NOT EXISTS myDB_PHP";
        // use exec() because no results are returned
        $conn->exec($sql);
        echo "Database created successfully<br>";
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
}
function createTableRegisteredUsers()
{
    $servername = "localhost";
    $username = "Derger";
    $password = "B@kugan8";
    $dbname = "myDB_PHP";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 1. Create table if it doesn't exist
        $sql = "CREATE TABLE IF NOT EXISTS RegisteredUsers (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            UserName VARCHAR(30) NOT NULL,
            email VARCHAR(50) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        $conn->exec($sql);
        echo "Table RegisteredUsers created successfully<br>";

        // 2. Optionally check for missing columns (if table existed)
        $columns = ['UserName','email','password','reg_date'];
        foreach ($columns as $col) {
            $stmt = $conn->query("SHOW COLUMNS FROM RegisteredUsers LIKE '$col'");
            if ($stmt->rowCount() == 0) {
                // Add missing column
                switch ($col) {
                    case 'UserName':
                        $conn->exec("ALTER TABLE RegisteredUsers ADD COLUMN UserName VARCHAR(30) NOT NULL");
                        break;
                    case 'email':
                        $conn->exec("ALTER TABLE RegisteredUsers ADD COLUMN email VARCHAR(50) NOT NULL UNIQUE");
                        break;
                    case 'password':
                        $conn->exec("ALTER TABLE RegisteredUsers ADD COLUMN password VARCHAR(255) NOT NULL");
                        break;
                    case 'reg_date':
                        $conn->exec("ALTER TABLE RegisteredUsers ADD COLUMN reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP");
                        break;
                }
                echo "Added missing column $col<br>";
            }
        }

    } catch (PDOException $e) {
        echo "DB Error: " . $e->getMessage();
    }

    $conn = null;
}

function createTableVideos()
{
    $servername = "localhost";
    $username = "Derger";
    $password = "B@kugan8";
    $dbname = "myDB_PHP";

    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // 1. Create the Videos table if it doesn't exist
        $sql = "CREATE TABLE IF NOT EXISTS Videos (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(100) NOT NULL,
            description TEXT,
            file_path VARCHAR(255) NOT NULL,
            upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )";
        $conn->exec($sql);
        echo "Table Videos created successfully<br>";

        // 2. Add UserID column if it doesn't exist
        $stmt = $conn->query("SHOW COLUMNS FROM Videos LIKE 'UserID'");
        if ($stmt->rowCount() == 0) {
            $conn->exec("ALTER TABLE Videos ADD COLUMN UserID INT(6) UNSIGNED");
            echo "Column UserID added successfully<br>";
        }

        // 3. Add foreign key if it doesn't exist
        $stmt = $conn->query("
            SELECT CONSTRAINT_NAME
            FROM information_schema.TABLE_CONSTRAINTS
            WHERE TABLE_SCHEMA = '$dbname'
              AND TABLE_NAME = 'Videos'
              AND CONSTRAINT_TYPE = 'FOREIGN KEY'
              AND CONSTRAINT_NAME = 'fk_user'
        ");
        if ($stmt->rowCount() == 0) {
            $conn->exec("ALTER TABLE Videos 
                         ADD CONSTRAINT fk_user FOREIGN KEY (UserID) REFERENCES RegisteredUsers(id)");
            echo "Foreign key fk_user added successfully<br>";
        }

    } catch (PDOException $e) {
        echo "DB Error: " . $e->getMessage();
    }

    $conn = null;
}
function checkDB(): void
{
    $dsn = "mysql:host=localhost;dbname=myDB_PHP;charset=utf8";
    $user = "Derger";
    $pass = "B@kugan8";

    try {
        $pdo = new PDO($dsn, $user, $pass);
        $stmt = $pdo->query("SELECT * FROM Videos LIMIT 1");

        echo "<h2>Columns in Videos</h2><ul>";

        $columnCount = $stmt->columnCount();
        for ($i = 0; $i < $columnCount; $i++) {
            $meta = $stmt->getColumnMeta($i);
            echo "<li>" . htmlspecialchars($meta['name']) . "</li>";
        }

        echo "</ul>";
    } catch (PDOException $e) {
        echo "DB Error: " . $e->getMessage();
    }
}
?>