<?php include 'database.php'; ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questão 2</title>
</head>
    <meta charset="UTF-8">
    <title>Gerenciador de Tarefas</title>

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
        h1, h2 {
            color: #c9d1d9;
            font-weight: 600;
        }
        input, button {
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #30363d;
            background: #161b22;
            color: #c9d1d9;
        }
        input:focus { border-color: #58a6ff; outline: none; }
        button { cursor: pointer; }
        button:hover { background: #21262d; }

        .container {
            padding: 20px;
            display: flex;
            justify-content: space-between;
        }
        .box-tarefas { width: 70%; }

        .tarefa, #pomodoro {
            background: #21262d;
            border: 1px solid #30363d;
            border-radius: 6px;
            margin-bottom: 10px;
            padding: 10px;
        }
        .tarefa.concluida { text-decoration: line-through; color: #8b949e; }

        #modalEditar {
            display:none; 
            position:fixed; 
            top:0; 
            left:0; 
            width:100%; 
            height:100%;
            background:rgba(0,0,0,0.6);
            align-items:center; 
            justify-content:center;
        }

        #modalEditar .box {
            background: #161b22;
            padding: 20px;
            width: 300px;
            border-radius: 8px;
            border: 1px solid #30363d;
        }

        #pomodoro {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 300px;
            width: 300px;
            gap: 20px;
        }

        #timer {
            font-size: 40px;
            font-weight: bold;
        }

        #notification {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background: #238636;
            border: 1px solid #2ea043;
            color: white;
            padding: 12px 18px;
            border-radius: 6px;
            font-size: 14px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.4s ease;
        }
        #notification.show { opacity: 1; pointer-events: auto; }
    </style>
</head>
<body>
<header>
    <h1>
        DESENV. WEB EM HTML5, CSS, JAVASCRIPT E PHP<br>
        2ª Atividade de Nota Final (NF)
    </h1>
</header>
<div class="container">
<div class="box-tarefas">
<h1>Gerenciador de Tarefas</h1>

<form action="add_tarefa.php" method="POST">
    <input type="text" name="descricao" placeholder="Descrição da tarefa" required>
    <input type="date" name="vencimento">
    <button type="submit">Adicionar</button>
</form>

<hr>

<h2>Tarefas Pendentes</h2>
<?php
$pendentes = $db->query("SELECT * FROM tarefas WHERE concluida = 0 ORDER BY vencimento ASC");
foreach ($pendentes as $t):
?>
    <div class="tarefa">
        <strong><?= htmlspecialchars($t['descricao']); ?></strong><br>
        <span style="color:#8b949e">Vencimento: <?= $t['vencimento']; ?></span><br><br>

        <form action="update_tarefa.php" method="POST" style="display:inline">
            <input type="hidden" name="id" value="<?= $t['id']; ?>">
            <input type="hidden" name="action" value="complete">
            <button style="color:#3fb950">Concluir</button>
        </form>

        <button onclick="abrirModal(<?= $t['id'] ?>, '<?= htmlspecialchars($t['descricao']) ?>', '<?= $t['vencimento'] ?>')">
            Editar
        </button>

        <form action="delete_tarefa.php" method="POST" style="display:inline">
            <input type="hidden" name="id" value="<?= $t['id']; ?>">
            <button style="color:#f85149">Excluir</button>
        </form>
    </div>
<?php endforeach; ?>

<hr>

<h2>Tarefas Concluídas</h2>
<?php
$concluidas = $db->query("SELECT * FROM tarefas WHERE concluida = 1 ORDER BY vencimento ASC");
foreach ($concluidas as $t):
?>
    <div class="tarefa concluida">
        <strong><?= htmlspecialchars($t['descricao']); ?></strong><br>
        <span style="color:#8b949e">Vencimento: <?= $t['vencimento']; ?></span><br><br>

        <button onclick="abrirModal(<?= $t['id'] ?>, '<?= htmlspecialchars($t['descricao']) ?>', '<?= $t['vencimento'] ?>')">
            Editar
        </button>

        <form action="delete_tarefa.php" method="POST" style="display:inline">
            <input type="hidden" name="id" value="<?= $t['id']; ?>">
            <button style="color:#f85149">Excluir</button>
        </form>
    </div>
<?php endforeach; ?>

<div id="modalEditar">
    <div class="box">
        <h2>Editar Tarefa</h2>

        <input type="hidden" id="edit_id">

        <label>Descrição:</label><br>
        <input type="text" id="edit_descricao" style="width:100%"><br><br>

        <label>Data de vencimento:</label><br>
        <input type="date" id="edit_vencimento" style="width:100%"><br><br>

        <button onclick="salvarEdicao()" style="color:#58a6ff">Salvar</button>
        <button onclick="fecharModal()" style="color:#f85149">Cancelar</button>
    </div>
</div>
</div>

<div id="pomodoro">
    <h2>Contador Pomodoro</h2>
    <div id="timer">25:00</div>

    <div id="pomodoro-botoes">
        <button style="color:#3fb950" onclick="startTimer()">Começar</button>
        <button style="color:#f85149" onclick="stopTimer()">Parar</button>
        <button onclick="resetTimer()">Resetar</button>
    </div>
</div>


<div id="notification">Tempo finalizado!</div>
</div>

<script>
function abrirModal(id, descricao, vencimento) {
    document.getElementById("modalEditar").style.display = "flex";
    document.getElementById("edit_id").value = id;
    document.getElementById("edit_descricao").value = descricao;
    document.getElementById("edit_vencimento").value = vencimento;
}

function fecharModal() {
    document.getElementById("modalEditar").style.display = "none";
}

function salvarEdicao() {
    const id = document.getElementById("edit_id").value;
    const descricao = document.getElementById("edit_descricao").value;
    const vencimento = document.getElementById("edit_vencimento").value;

    const formData = new FormData();
    formData.append("id", id);
    formData.append("descricao", descricao);
    formData.append("vencimento", vencimento);
    formData.append("action", "edit");

    fetch("update_tarefa.php", {
        method: "POST",
        body: formData
    }).then(res => {
        if (res.ok) location.reload();
    });
}

function showNotification() {
    const box = document.getElementById("notification");
    box.classList.add("show");

    setTimeout(() => {
        box.classList.remove("show");
    }, 4000);
}

let timer;
let totalSeconds = 25 * 60;

function updateDisplay() {
    const min = String(Math.floor(totalSeconds / 60)).padStart(2, '0');
    const sec = String(totalSeconds % 60).padStart(2, '0');
    document.getElementById("timer").textContent = `${min}:${sec}`;
}

function startTimer() {
    if (timer) return;

    timer = setInterval(() => {
        if (totalSeconds > 0) {
            totalSeconds--;
            updateDisplay();
        } else {
            stopTimer();
            showNotification();
        }
    }, 1000);
}

function stopTimer() {
    clearInterval(timer);
    timer = null;
}

function resetTimer() {
    stopTimer();
    totalSeconds = 25 * 60;
    updateDisplay();
}

updateDisplay();
</script>

</body>
</html>
