<?php

$db = new PDO('sqlite:tarefas.db');

$db->exec("
    CREATE TABLE IF NOT EXISTS tarefas (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        descricao TEXT NOT NULL,
        vencimento DATE,
        concluida INTEGER DEFAULT 0
    )
");
?>
