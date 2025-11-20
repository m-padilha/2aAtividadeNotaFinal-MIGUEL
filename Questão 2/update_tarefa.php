<?php
include 'database.php';

if (!isset($_POST['action'])) {
    http_response_code(400);
    echo "Erro: nenhuma ação especificada.";
    exit;
}

$action = $_POST['action'];

if ($action === "edit") {

    if (!isset($_POST['id'], $_POST['descricao'], $_POST['vencimento'])) {
        http_response_code(400);
        echo "Erro: dados incompletos para edição.";
        exit;
    }

    $id = $_POST['id'];
    $descricao = $_POST['descricao'];
    $vencimento = $_POST['vencimento'];

    $stmt = $db->prepare("UPDATE tarefas SET descricao = ?, vencimento = ? WHERE id = ?");
    $stmt->execute([$descricao, $vencimento, $id]);

    echo "OK";
    exit;
}

if ($action === "complete") {

    if (!isset($_POST['id'])) {
        http_response_code(400);
        echo "Erro: ID não enviado.";
        exit;
    }

    $id = $_POST['id'];

    $stmt = $db->prepare("UPDATE tarefas SET concluida = 1 WHERE id = ?");
    $stmt->execute([$id]);

    header("Location: index.php");
    exit;
}

http_response_code(400);
echo "Erro: ação inválida.";
?>
