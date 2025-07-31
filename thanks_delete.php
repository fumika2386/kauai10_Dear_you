<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id'])) {
  header("Location: people_list.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM thanks_notes WHERE id = ? AND user_id = ?");
$stmt->execute([$id, $user_id]);

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>
