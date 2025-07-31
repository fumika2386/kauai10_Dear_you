<link rel="stylesheet" href="style.css">

<?php
session_start();
require 'db.php';

// ログイン・GETチェック
if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
  header("Location: people_list.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$person_id = $_GET['id'];

// 大切な人の情報取得
$stmt = $pdo->prepare("SELECT * FROM important_people WHERE id = ? AND user_id = ?");
$stmt->execute([$person_id, $user_id]);
$person = $stmt->fetch();

if (!$person) {
  echo "対象が見つかりません。";
  exit();
}

// モヤモヤ記録取得
$stmt = $pdo->prepare("
  SELECT * FROM moyamoya_notes 
  WHERE user_id = ? AND person_id = ? 
  ORDER BY date DESC
");
$stmt->execute([$user_id, $person_id]);
$notes = $stmt->fetchAll();
?>

<h2>💭 <?= htmlspecialchars($person['name']) ?> さんへのモヤモヤ記録</h2>
<p>関係性：<?= htmlspecialchars($person['relationship']) ?></p>

<a href="moyamoya_form.php">＋ 新しくモヤモヤを記録する</a><br>
<a href="people_list.php">← 大切な人一覧に戻る</a>

<hr>

<?php if (empty($notes)): ?>
  <p>まだモヤモヤ記録はありません。</p>
<?php else: ?>
  <?php foreach ($notes as $note): ?>
    <div style="border:1px solid #ccc; padding:10px; margin:10px;">
      <strong><?= htmlspecialchars($note['date']) ?></strong><br>
      <?= nl2br(htmlspecialchars($note['content'])) ?><br>
      感情タグ：<?= htmlspecialchars($note['tag']) ?><br>
      状態：
      <?php
        switch ($note['resolved']) {
          case 'talked':
            echo ' 話し合えた';
            break;
          case 'not_a_big_deal':
            echo ' 大したことじゃなかった';
            break;
          default:
            echo ' 未処理';
        }
      ?>
      <br>

      <?php if ($note['resolved'] === 'not_yet'): ?>
        <a href="moyamoya_update_status.php?id=<?= $note['id'] ?>&action=talked">✅ 話し合えた</a>　
        <a href="moyamoya_update_status.php?id=<?= $note['id'] ?>&action=not_a_big_deal">✅ 時間が経つと大したことじゃなかった</a>　
      <?php endif; ?>
      
      <a href="moyamoya_delete.php?id=<?= $note['id'] ?>" onclick="return confirm('削除してもよいですか？');"> 削除</a>　
      <a href="ai_consult.php?id=<?= $note['id'] ?>"> AIに相談</a>
    </div>
  <?php endforeach; ?>
<?php endif; ?>
