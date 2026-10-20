<?php

$host = "127.0.0.1";
$dbname = "tuition_lms";
$username = "tharumal";
$password = "0771856629";
$charset = "utf8mb4";

$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (PDOException $e) {
    // Log the actual error privately.
    error_log("Database connection failed: " . $e->getMessage());

    // Do not expose credentials or internal database errors.
    http_response_code(500);
    exit("A database connection error occurred.");
}
?>