<link rel="stylesheet" href="style.css">

<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
  header("Location: people_list.php");
  exit();
}

$stmt = $pdo->prepare("SELECT * FROM important_people WHERE id = ? AND user_id = ?");
$stmt->execute([$_GET['id'], $_SESSION['user_id']]);
$person = $stmt->fetch();

if (!$person) {
  echo "対象が見つかりません";
  exit();
}
?>

<h2>大切な人の情報を編集</h2>
<form action="people_update.php" method="post">
  <input type="hidden" name="id" value="<?= $person['id'] ?>">
  名前：<input type="text" name="name" value="<?= htmlspecialchars($person['name']) ?>" required><br>
  関係性：<input type="text" name="relationship" value="<?= htmlspecialchars($person['relationship']) ?>"><br>
  <button type="submit">更新する</button>
</form>
<a href="people_list.php">戻る</a>
