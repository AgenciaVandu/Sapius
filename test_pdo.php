<?php
try {
    $dsn = "mysql:host=162.214.126.54;dbname=wwsapi_testserver;charset=utf8mb4;port=3306";
    $pdo = new PDO($dsn, 'wwsapi_test', 'IqYeRkYnDCpg', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_TIMEOUT => 5
    ]);
    echo "CONNECTED TO DB SUCCESSFULLY!\n";
    
    // Check if the table is users or usuarios
    $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
    echo "TABLES: " . implode(', ', $tables) . "\n";
    
    // Find our test user
    $userTable = in_array('users', $tables) ? 'users' : (in_array('usuarios', $tables) ? 'usuarios' : null);
    if ($userTable) {
        $stmt = $pdo->prepare("SELECT id, username, email, is_blocked, strikes FROM {$userTable} WHERE username = ?");
        $stmt->execute(['marencocode']);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        echo "USER RECORD:\n";
        print_r($row);
    } else {
        echo "No users or usuarios table found!\n";
    }
} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
}
