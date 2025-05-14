<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$host = 'sql102.infinityfree.com';
$db   = 'if0_38713386_user';
$user = 'if0_38713386';
$pass = 'yulia89153'; // твой новый MySQL пароль
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (PDOException $e) {
    die("Ошибка подключения к базе: " . $e->getMessage());
}
?>
