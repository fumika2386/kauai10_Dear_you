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

// ありがとう記録取得
$stmt = $pdo->prepare("
  SELECT * FROM thanks_notes 
  WHERE user_id = ? AND person_id = ? 
  ORDER BY date DESC
");
$stmt->execute([$user_id, $person_id]);
$notes = $stmt->fetchAll();
?>

<h2>❤️ <?= htmlspecialchars($person['name']) ?> さんへのありがとう記録</h2>
<p>関係性：<?= htmlspecialchars($person['relationship']) ?></p>

<a href="thanks_form.php">＋ 新しくありがとうを記録する</a><br>
<a href="people_list.php">← 大切な人一覧に戻る</a>

<hr>

<?php if (empty($notes)): ?>
  <p>まだありがとう記録はありません。</p>
<?php else: ?>
  <?php foreach ($notes as $note): ?>
    <div style="border:1px solid #ccc; padding:10px; margin:10px;">
      <strong><?= htmlspecialchars($note['date']) ?></strong><br>
      <?= nl2br(htmlspecialchars($note['content'])) ?><br>
      状態：
      <?php
        switch ($note['shared']) {
          case 'told':
            echo ' 伝えられた';
            break;
          case 'bragged_to_ai':
            echo ' AIに惚気た';
            break;
          default:
            echo ' 未送信';
        }
      ?>
      <br>

      <?php if ($note['shared'] === 'not_shared'): ?>
        <a href="thanks_update_status.php?id=<?= $note['id'] ?>&action=told">✅ 伝えられた</a>　
      <?php endif; ?>
      
      <a href="thanks_delete.php?id=<?= $note['id'] ?>" onclick="return confirm('削除しますか？');"> 削除</a>
    </div>
  <?php endforeach; ?>
<?php endif; ?>
