<link rel="stylesheet" href="style.css">

<?php
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$name = $_SESSION['user_name']; // ここで取得！

?>

<h2><?= htmlspecialchars($name) ?>さん、ようこそ！</h2>

<ul>
  <li><a href="people_list.php">👥 大切な人一覧</a></li>
  <li><a href="moyamoya_form.php"> モヤモヤを記録する</a></li>
  <li><a href="thanks_form.php"> ありがとうを記録する</a></li>
</ul>
<a href="logout.php">ログアウト</a>
