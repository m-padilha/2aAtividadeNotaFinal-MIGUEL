<?php
include "database.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $autor = $_POST['autor'];
    $ano = $_POST['ano'];

    $stmt = $db->prepare("INSERT INTO livros (titulo, autor, ano) VALUES (?, ?, ?)");
    $stmt->execute([$titulo, $autor, $ano]);
}

header("Location: index.php");
exit;
?>
