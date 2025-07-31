<link rel="stylesheet" href="style.css">

<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM important_people WHERE user_id = ?");
$stmt->execute([$user_id]);
$people = $stmt->fetchAll();
?>

<h2>大切にしている人一覧</h2>

<?php foreach ($people as $person): ?>
  <div style="border:1px solid #ccc; padding:10px; margin:10px;">
    <strong><?= htmlspecialchars($person['name']) ?></strong><br>
    関係性：<?= htmlspecialchars($person['relationship']) ?><br>
    <a href="person_moyamoya_list.php?id=<?= $person['id'] ?>">モヤモヤ記録を見る</a><br>
    <a href="person_thanks_list.php?id=<?= $person['id'] ?>">ありがとう記録を見る</a><br>
    <a href="people_edit.php?id=<?= $person['id'] ?>">編集</a>　
    <a href="people_delete.php?id=<?= $person['id'] ?>" onclick="return confirm('削除しますか？')">削除</a>
  </div>
<?php endforeach; ?>


<?php if (count($people) < 3): ?>
  <a href="people_add.php">＋ 大切な人を追加する</a>
<?php else: ?>
  <p>※登録は3人までです。</p>
<?php endif; ?>

<a href="home.php">ホームに戻る</a>
