<link rel="stylesheet" href="style.css">

<?php

session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
  header("Location: people_list.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$note_id = $_GET['id'];

// モヤモヤ記録を取得
$stmt = $pdo->prepare("SELECT * FROM moyamoya_notes WHERE id = ? AND user_id = ?");
$stmt->execute([$note_id, $user_id]);
$note = $stmt->fetch();

if (!$note) {
  echo "記録が見つかりません。";
  exit();
}
?>

<h2>AIに相談する</h2>
<p>以下の内容を <strong>ChatGPT</strong> にコピー＆ペーストして相談してみよう。</p>

<textarea readonly rows="6" id="promptText" style="width:100%; padding:10px;">
<?= htmlspecialchars($note['content']) ?> をどう伝えたらいいか迷っています。相手を傷つけず、自分の気持ちを素直に伝えるにはどうしたらいいでしょうか？
</textarea><br><br>

<button onclick="copyText()">📋 コピーする</button>

<a href="https://chat.openai.com/" target="_blank" style="margin-left:20px;">
▶ ChatGPTで相談する（新しいタブで開く）
</a>

<script>
function copyText() {
  const textarea = document.getElementById('promptText');
  textarea.select();
  document.execCommand('copy');
  alert("相談内容をコピーしました！");
}
</script>

<br><br>
<a href="javascript:history.back()">← 戻る</a>
