<link rel="stylesheet" href="style.css">

<?php
session_start();
require 'db.php';

// ログインチェック
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

// 自分が登録した大切な人一覧を取得
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT * FROM important_people WHERE user_id = ?");
$stmt->execute([$user_id]);
$people = $stmt->fetchAll();
?>

<h2>モヤモヤ記録</h2>

<form action="moyamoya_submit.php" method="post">
  <label>誰に対してのモヤモヤ？</label><br>
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

  <label>モヤモヤしたこと：</label><br>
  <textarea name="content" rows="5" cols="40" required></textarea><br><br>

  <label>感情タグ：</label><br>
  <select name="tag">
    <option value="寂しい">寂しい</option>
    <option value="怒り">怒り</option>
    <option value="不安">不安</option>
    <option value="疲れた">疲れた</option>
    <option value="がっかり">がっかり</option>
    <option value="その他">その他</option>
  </select><br><br>

  <button type="submit">記録する</button>
</form>

<a href="people_list.php">← 大切な人一覧に戻る</a>
