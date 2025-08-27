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
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // sql to create table
        $sql = "CREATE TABLE IF NOT EXISTS  RegisteredUsers (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            UserName VARCHAR(30) NOT NULL,
            email VARCHAR(50),
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";

        // use exec() because no results are returned
        $conn->exec($sql);
        echo "Table MyGuests created successfully";
    } 
    catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
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
        // set the PDO error mode to exception
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // sql to create table
        $sql = "CREATE TABLE IF NOT EXISTS Videos (
            id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(100) NOT NULL,
            description TEXT,
            file_path VARCHAR(255) NOT NULL,
            upload_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
            )";

        // use exec() because no results are returned
        $conn->exec($sql);
        echo "Table Videos created successfully";
    } catch (PDOException $e) {
        echo $sql . "<br>" . $e->getMessage();
    }

    $conn = null;
}
?>