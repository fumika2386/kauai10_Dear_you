<link rel="stylesheet" href="style.css">

<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
  header("Location: people_list.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$person_id = $_GET['id'];

// 対象の大切な人の情報取得
$stmt = $pdo->prepare("SELECT * FROM important_people WHERE id = ? AND user_id = ?");
$stmt->execute([$person_id, $user_id]);
$person = $stmt->fetch();
if (!$person) {
  echo "対象が見つかりません";
  exit();
}

// モヤモヤ記録取得
$stmt = $pdo->prepare("SELECT * FROM moyamoya_notes WHERE user_id = ? AND person_id = ? ORDER BY date DESC");
$stmt->execute([$user_id, $person_id]);
$moyamoya = $stmt->fetchAll();

// ありがとう記録取得
$stmt = $pdo->prepare("SELECT * FROM thanks_notes WHERE user_id = ? AND person_id = ? ORDER BY date DESC");
$stmt->execute([$user_id, $person_id]);
$thanks = $stmt->fetchAll();
?>

<h2><?= htmlspecialchars($person['name']) ?> さんとの記録</h2>
<p>関係性：<?= htmlspecialchars($person['relationship']) ?></p>

<h3>モヤモヤ一覧</h3>
<?php if (empty($moyamoya)): ?>
  <p>モヤモヤ記録はまだありません。</p>
<?php else: ?>
  <?php foreach ($moyamoya as $m): ?>
    <div style="margin-bottom: 10px;">
      <?= $m['date'] ?>：<?= nl2br(htmlspecialchars($m['content'])) ?>
    </div>
  <?php endforeach; ?>
<?php endif; ?>

<h3>ありがとう一覧</h3>
<?php if (empty($thanks)): ?>
  <p>ありがとう記録はまだありません。</p>
<?php else: ?>
  <?php foreach ($thanks as $t): ?>
    <div style="margin-bottom: 10px;">
      <?= $t['date'] ?>：<?= nl2br(htmlspecialchars($t['content'])) ?>
    </div>
  <?php endforeach; ?>
<?php endif; ?>

<a href="people_list.php">← 大切な人一覧へ戻る</a>
