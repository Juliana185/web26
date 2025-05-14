<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

$admin_login = 'admin';
$admin_password = 'admin123';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $input_login = $_POST['login'] ?? '';
    $input_password = $_POST['password'] ?? '';

    if ($input_login === $admin_login && $input_password === $admin_password) {
        $_SESSION['admin_logged_in'] = true;

        // JS-редирект вместо header()
        echo "<script>location.href='index.php';</script>";
        exit;
    } else {
        $error = 'Неверный логин или пароль.';
    }
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Вход администратора</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
  <form method="post" class="credentials-box">
  <h2>Вход администратора</h2>

  <div class="login-row">
      <div class="login-fields">
          <label for="login">Логин:</label>
          <input type="text" id="login" name="login" required>

          <label for="password">Пароль:</label>
          <input type="password" id="password" name="password" required>

          <button class="login-button" type="submit">Войти</button>
      </div>
      <div class="login-hint">
          <strong>Тестовые данные:</strong><br>
          Логин: <code>admin</code><br>
          Пароль: <code>admin123</code>
      </div>
    </div>
  </form>

</body>
</html>
