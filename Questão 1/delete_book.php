<?php
include "database.php";

if (!empty($_POST['id'])) {
    $id = $_POST['id'];

    $stmt = $db->prepare("DELETE FROM livros WHERE id = ?");
    $stmt->execute([$id]);
}

header("Location: index.php");
exit;
?>
