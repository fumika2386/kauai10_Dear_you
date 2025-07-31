<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
  header("Location: people_list.php");
  exit();
}

$stmt = $pdo->prepare("DELETE FROM important_people WHERE id = ? AND user_id = ?");
$stmt->execute([$_GET['id'], $_SESSION['user_id']]);

header("Location: people_list.php");
exit();
?>
