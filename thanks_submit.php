<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$person_id = $_POST['person_id'];
$date = $_POST['date'];
$content = $_POST['content'];

// 入力チェック
if (empty($person_id) || empty($date) || empty($content)) {
  echo "未入力の項目があります。<a href='thanks_form.php'>戻る</a>";
  exit();
}

// 登録処理
$stmt = $pdo->prepare("
  INSERT INTO thanks_notes (user_id, person_id, date, content)
  VALUES (?, ?, ?, ?)
");
$stmt->execute([$user_id, $person_id, $date, $content]);

header("Location: person_thanks_list.php?id=$person_id");
exit();
?>
