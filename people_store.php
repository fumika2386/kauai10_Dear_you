<link rel="stylesheet" href="style.css">

<?php

session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$name = $_POST['name'];
$relationship = $_POST['relationship'];

// 3人まで制限チェック
$stmt = $pdo->prepare("SELECT COUNT(*) FROM important_people WHERE user_id = ?");
$stmt->execute([$user_id]);
$count = $stmt->fetchColumn();

if ($count >= 3) {
  echo "登録できるのは最大3人までです。<br><a href='people_list.php'>戻る</a>";
  exit();
}

// 登録処理
$stmt = $pdo->prepare("INSERT INTO important_people (user_id, name, relationship) VALUES (?, ?, ?)");
$stmt->execute([$user_id, $name, $relationship]);

header("Location: people_list.php");
exit();
?>
