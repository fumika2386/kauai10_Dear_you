<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_POST['id'])) {
  header("Location: people_list.php");
  exit();
}

$stmt = $pdo->prepare("UPDATE important_people SET name = ?, relationship = ? 
                       WHERE id = ? AND user_id = ?");
$stmt->execute([
  $_POST['name'],
  $_POST['relationship'],
  $_POST['id'],
  $_SESSION['user_id']
]);

header("Location: people_list.php");
exit();
?>
