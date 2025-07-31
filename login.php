<link rel="stylesheet" href="style.css">

<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = $_POST['email'];
  $password = $_POST['password'];

  $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
  $stmt->execute([$email]);
  $user = $stmt->fetch();

  if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_name'] = $user['name']; 

    header("Location: home.php");
    exit();
  } else {
    $error = "メールアドレスまたはパスワードが間違っています";
  }
}
?>

<h2>ログイン</h2>
<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
<form method="post">
  メールアドレス：<input type="email" name="email" required><br>
  パスワード：<input type="password" name="password" required><br>
  <button type="submit">ログイン</button>
</form>
<a href="register.php">新規登録はこちら</a>
