<link rel="stylesheet" href="style.css">

<?php
session_start();
if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}
?>

<h2>大切な人を登録</h2>
<form action="people_store.php" method="post">
  名前：<input type="text" name="name" required><br>
  関係性（例：恋人、母、友人など）：<input type="text" name="relationship"><br>
  <button type="submit">登録する</button>
</form>
<a href="people_list.php">戻る</a>
