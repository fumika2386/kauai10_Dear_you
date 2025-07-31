<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id']) || !isset($_GET['id']) || !isset($_GET['action'])) {
  header("Location: people_list.php");
  exit();
}

$user_id = $_SESSION['user_id'];
$id = $_GET['id'];
$action = $_GET['action'];

$shared = '';
if ($action === 'told') {
  $shared = 'told';
} elseif ($action === 'bragged_to_ai') {
  $shared = 'bragged_to_ai';
} else {
  header("Location: people_list.php");
  exit();
}

$stmt = $pdo->prepare("UPDATE thanks_notes SET shared = ? WHERE id = ? AND user_id = ?");
$stmt->execute([$shared, $id, $user_id]);

header("Location: " . $_SERVER['HTTP_REFERER']);
exit();
?>
