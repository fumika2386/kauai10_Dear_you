<link rel="stylesheet" href="style.css">

<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  $stmt = $pdo->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
  $stmt->execute([$name, $email, $password]);

  $_SESSION['user_id'] = $pdo->lastInsertId();
  $_SESSION['user_name'] = $name; // ★←ここ追加！

  header("Location: home.php");
  exit();
}
?>


<h2>新規登録</h2>
<form method="post">
  名前：<input type="text" name="name" required><br>
  メールアドレス：<input type="email" name="email" required><br>
  パスワード：<input type="password" name="password" required><br>
  <button type="submit">登録</button>
</form>
<a href="login.php">ログインはこちら</a>
