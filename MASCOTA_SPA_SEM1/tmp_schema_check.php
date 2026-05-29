<?php
require 'config/config.php';
try {
    $pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB.';charset=utf8mb4', DB_USER, DB_PASS);
    $tables = ['citas','mascotas','clientes','usuarios','groomers','servicios'];
    foreach ($tables as $t) {
        echo "TABLE $t:\n";
        $stmt = $pdo->query('SHOW COLUMNS FROM ' . $t);
        foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $c) {
            echo $c['Field'] . ' ' . $c['Type'] . ' ' . ($c['Null'] ?? '') . ' ' . ($c['Key'] ?? '') . ' ' . ($c['Extra'] ?? '') . "\n";
        }
        echo "\n";
    }
} catch (Exception $e) {
    echo 'ERR ' . $e->getMessage();
}
