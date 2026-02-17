<?php
// Simple database connection test
$host = '162.214.126.54';
$port = '3306';
$dbname = 'wwsapi_testserver';
$username = 'wwsapi_test';
$password = 'IqYeRkYnDCpg';

echo "Testing database connection...\n";
echo "Host: $host:$port\n";
echo "Database: $dbname\n\n";

$start = microtime(true);

try {
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_TIMEOUT => 10, // 10 second timeout
    ];

    $pdo = new PDO($dsn, $username, $password, $options);

    $elapsed = microtime(true) - $start;
    echo "✓ Connection successful!\n";
    echo "Time taken: " . round($elapsed, 2) . " seconds\n\n";

    // Test a simple query
    $queryStart = microtime(true);
    $stmt = $pdo->query("SELECT 1 as test");
    $result = $stmt->fetch();
    $queryElapsed = microtime(true) - $queryStart;

    echo "✓ Query test successful!\n";
    echo "Query time: " . round($queryElapsed, 2) . " seconds\n";


}
catch (PDOException $e) {
    $elapsed = microtime(true) - $start;
    echo "✗ Connection failed!\n";
    echo "Error: " . $e->getMessage() . "\n";
    echo "Time taken: " . round($elapsed, 2) . " seconds\n";
    exit(1);
}
