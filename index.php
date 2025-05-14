<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

require_once 'db.php';

// Удаление записи
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: index.php");
    exit;
}

// Редактирование записи
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_id'])) {
    $stmt = $pdo->prepare("UPDATE users SET name=?, phone=?, email=?, birthdate=?, login=? WHERE id=?");
    $stmt->execute([
        $_POST['name'],
        $_POST['phone'],
        $_POST['email'],
        $_POST['birthdate'],
        $_POST['login'],
        $_POST['edit_id']
    ]);
    header("Location: index.php");
    exit;
}

$users = $pdo->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Админ-панель</title>
    <link rel="stylesheet" href="styles.css">
    <style>
        table {
            border-collapse: collapse;
            width: 95%;
            margin: 30px auto;
            font-size: 15px;
            background-color: #fdf6fd;
        }
        th {
            background-color: #e1bee7;
            color: #4a148c;
            padding: 10px;
            border: 1px solid #8e24aa;
            white-space: nowrap;
        }
        td {
            padding: 8px;
            border: 1px solid #ba68c8;
            vertical-align: middle;
            text-align: center;
        }
        input[type="text"], input[type="email"], input[type="date"] {
            width: 140px;
            padding: 4px;
            font-size: 14px;
            border: 1px solid #ba68c8;
            border-radius: 4px;
            background-color: #f8eaf6;
            color: #4a148c;
        }
        button {
            background-color: #6a1b9a;
            color: white;
            border: none;
            padding: 6px 10px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
        }
        button:hover {
            background-color: #4a148c;
        }
        a.delete {
            color: #d32f2f;
            text-decoration: none;
            font-size: 18px;
        }
        a.logout {
            display: block;
            text-align: center;
            margin-top: 15px;
            font-weight: bold;
            color: #6a1b9a;
        }
    </style>
</head>
<body>

  <div class="header-bar">
  <h2>Админ-панель</h2>
  <a href="logout.php" class="logout-link">Выйти</a>
  </div>

    <table>
        <tr>
            <th>ID</th><th>Имя</th><th>Телефон</th><th>Email</th><th>Дата рождения</th><th>Логин</th><th>Действия</th>
        </tr>

        <?php foreach ($users as $user): ?>
            <tr>
                <td><?= $user['id'] ?></td>
                <td>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="edit_id" value="<?= $user['id'] ?>">
                        <input type="text" name="name" value="<?= htmlspecialchars($user['name']) ?>">
                </td>
                <td>
                        <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>">
                </td>
                <td>
                        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>">
                </td>
                <td>
                        <input type="date" name="birthdate" value="<?= $user['birthdate'] ?>">
                </td>
                <td>
                        <input type="text" name="login" value="<?= htmlspecialchars($user['login']) ?>">
                </td>
                <td>
                        <button type="submit" title="Сохранить">💾</button>
                        <a class="delete" href="?delete=<?= $user['id'] ?>" onclick="return confirm('Удалить запись?')">🗑</a>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

</body>
</html>
