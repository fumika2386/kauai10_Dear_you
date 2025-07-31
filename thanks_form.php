<link rel="stylesheet" href="style.css">

<?php
session_start();
require 'db.php';

// ログイン確認
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

// 大切な人一覧を取得
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM important_people WHERE user_id = ?");
$stmt->execute([$user_id]);
$people = $stmt->fetchAll();
?>

<h2> ありがとうを記録する</h2>

<form action="thanks_submit.php" method="post">
  <label>誰に対してのありがとう？</label><br>
  <select name="person_id" required>
    <option value="">選択してください</option>
    <?php foreach ($people as $person): ?>
      <option value="<?= $person['id'] ?>">
        <?= htmlspecialchars($person['name']) ?>（<?= htmlspecialchars($person['relationship']) ?>）
      </option>
    <?php endforeach; ?>
  </select><br><br>

  <label>日付：</label>
  <input type="date" name="date" value="<?= date('Y-m-d') ?>"><br><br>

  <label>ありがとうの内容：</label><br>
  <textarea name="content" rows="5" cols="40" required></textarea><br><br>

  <button type="submit">記録する</button>
</form>

<a href="home.php">← ホームに戻る</a>
