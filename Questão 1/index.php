<?php include "database.php"; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Questão 1</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #0d1117;
            color: #c9d1d9;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif;
        }

        header {
            background-color: black;
            padding: 25px 20px;
            border-bottom: 1px solid #30363d;
            text-align: center;
        }

        header h1 {
            font-size: 22px;
            font-weight: 600;
            line-height: 1.4;
            color: #c9d1d9;
        }

        main {
            padding: 25px;
        }

        h2 {
            margin-top: 20px;
            color: #c9d1d9;
            border-bottom: 1px solid #30363d;
            padding-bottom: 8px;
        }

        input, button {
            padding: 10px;
            margin-top: 6px;
            border-radius: 6px;
            border: 1px solid #30363d;
            background-color: #161b22;
            color: #c9d1d9;
            width: 280px;
        }

        input:focus {
            outline: none;
            border-color: #58a6ff;
            box-shadow: 0 0 2px #58a6ff;
        }

        button {
            width: auto;
            padding: 8px 14px;
            cursor: pointer;
            background-color: #21262d;
            border: 1px solid #30363d;
        }

        button:hover {
            background-color: #30363d;
        }

        table {
            width: 650px;
            margin-top: 20px;
            border-collapse: collapse;
            background-color: #161b22;
            border: 1px solid #30363d;
            border-radius: 6px;
            overflow: hidden;
        }

        th, td {
            border-bottom: 1px solid #30363d;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #21262d;
            color: #c9d1d9;
        }

        tr:hover {
            background-color: #21262d;
        }

        td.action-cell {
            text-align: center;
            vertical-align: middle;
        }



        .delete-btn {
            background-color: #da3633;
            border-color: #f85149;
            color: white;
            margin: 0;
            padding: 8px 14px;
        }

        .delete-btn:hover {
            background-color: #b62324;
        }
    </style>
</head>
<body>

<header>
    <h1>
        DESENV. WEB EM HTML5, CSS, JAVASCRIPT E PHP<br>
        2ª Atividade de Nota Final (NF)
    </h1>
</header>

<main>
    <h2>Cadastro de Livros</h2>

    <form action="add_book.php" method="POST">
        <label>Título:</label><br>
        <input type="text" name="titulo" required><br><br>

        <label>Autor:</label><br>
        <input type="text" name="autor" required><br><br>

        <label>Ano de Publicação:</label><br>
        <input type="number" name="ano" min="0" required><br><br>

        <button type="submit">Adicionar Livro</button>
    </form>

    <h2>Lista de Livros</h2>

    <table>
        <tr>
            <th>ID</th>
            <th>Título</th>
            <th>Autor</th>
            <th>Ano</th>
            <th>Ação</th>
        </tr>

        <?php
            $stmt = $db->query("SELECT * FROM livros");
            $livros = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($livros as $livro) {
                echo "<tr>
                        <td>{$livro['id']}</td>
                        <td>{$livro['titulo']}</td>
                        <td>{$livro['autor']}</td>
                        <td>{$livro['ano']}</td>
                        <td class='action-cell'>
                            <form action='delete_book.php' method='POST'>
                                <input type='hidden' name='id' value='{$livro['id']}'>
                                <button class='delete-btn' type='submit'>Excluir</button>
                            </form>
                        </td>
                    </tr>";
            }
        ?>
    </table>
</main>

</body>
</html>
