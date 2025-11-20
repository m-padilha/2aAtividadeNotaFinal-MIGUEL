<?php
include 'database.php';

$id = $_POST['id'];

$stmt = $db->prepare("DELETE FROM tarefas WHERE id = ?");
$stmt->execute([$id]);

header('Location: index.php');
exit;
?>
