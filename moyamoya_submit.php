<?php
session_start();
require 'db.php';

// ログインチェック
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

// フォームからのデータ取得
$user_id = $_SESSION['user_id'];
$person_id = $_POST['person_id'];
$date = $_POST['date'];
$content = $_POST['content'];
$tag = $_POST['tag'];

// バリデーション（簡易）
if (empty($person_id) || empty($date) || empty($content)) {
  echo "未入力の項目があります。<a href='moyamoya_form.php'>戻る</a>";
  exit();
}

// 登録処理
$stmt = $pdo->prepare("
  INSERT INTO moyamoya_notes (user_id, person_id, date, content, tag) 
  VALUES (?, ?, ?, ?, ?)
");
$stmt->execute([$user_id, $person_id, $date, $content, $tag]);

// 完了後リダイレクト
header("Location: person_moyamoya_list.php?id=$person_id");
exit();
?>
