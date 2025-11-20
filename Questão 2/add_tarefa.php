<?php
include 'database.php';

$descricao = $_POST['descricao'];
$vencimento = $_POST['vencimento'] ?? null;

$stmt = $db->prepare("INSERT INTO tarefas (descricao, vencimento) VALUES (?, ?)");
$stmt->execute([$descricao, $vencimento]);

header('Location: index.php');
exit;
?>
