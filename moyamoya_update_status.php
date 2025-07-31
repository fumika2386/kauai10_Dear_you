<link rel="stylesheet" href="style.css">

<?php
session_start();
require 'db.php';

// ログインチェック
if (!isset($_SESSION['user_id']) || !isset($_GET['id']) || !isset($_GET['action'])) {
  header("Location: moyamoya_list.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$id = $_GET['id'];
$action = $_GET['action'];

// 対応する状態に変換
$resolved = '';
if ($action === 'talked') {
  $resolved = 'talked';
} elseif ($action === 'not_a_big_deal') {
  $resolved = 'not_a_big_deal';
} else {
  // 無効な操作
  header("Location: moyamoya_list.php");
  exit();
}

// 該当モヤモヤが自分のものかチェックして更新
$stmt = $pdo->prepare("UPDATE moyamoya_notes SET resolved = ? 
                       WHERE id = ? AND user_id = ?");
$stmt->execute([$resolved, $id, $user_id]);

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>
