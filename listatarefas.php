<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="estilo/styles.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Tarefas</title>
</head>

<body>
<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <div class="container">
                    <a class="navbar-brand" href="#">
                        <img src="estilo/projeto.png" alt="Projetos" width="45" height="45">
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="acesso.php">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="listaprojetos.php">Projetos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="prazos.php">Prazos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="responsaveis.php">Responsáveis</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="listatarefas.php">Tarefas</a>
                    </ul>
                </div>
            </div>
        </nav>

    <?php
    session_start();
    if (!isset($_SESSION['logado'])) {
        header("location: acesso.php");
    }

    include "conexao.php";

    // Verifica se o formulário foi enviado
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Obtém os dados do formulário
        $projeto_id = $_POST["projeto_id"];
        $nome = $_POST["nome"];
        $descricao = $_POST["descricao"];
        $data_inicio = $_POST["data_inicio"];
        $data_fim = $_POST["data_fim"];
        $responsavel = $_POST["responsavel"];

        // Insere os dados no banco de dados
        $sql = "INSERT INTO tarefas (projeto_id, nome, descricao, data_inicio, data_fim, responsavel)
                VALUES ('$projeto_id', '$nome', '$descricao', '$data_inicio', '$data_fim', '$responsavel')";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Tarefa criada com sucesso!</p>";
        } else {
            echo "Erro ao criar a tarefa: " . $conn->error;
        }
    }

    // Exclusão da tarefa
    if (isset($_GET["excluir"])) {
        $id = $_GET["excluir"];

        $sql = "DELETE FROM tarefas WHERE id = $id";

        if ($conn->query($sql) === TRUE) {
            echo "<p>Tarefa excluída com sucesso!</p>";
        } else {
            echo "Erro ao excluir a tarefa: " . $conn->error;
        }
    }
    // Consulta as tarefas
    $sql = "SELECT * FROM tarefas";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<table>
                <tr>
                    <tsh>ID</th>
                    <th>Projeto ID</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th>Data de Início</th>
                    <th>Data de Término</th>
                    <th>Responsável</th>
                    <th>Ações</th>
                </tr>";

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>" . $row["id"] . "</td>
                    <td>" . $row["projeto_id"] . "</td>
                    <td>" . $row["nome"] . "</td>
                    <td>" . $row["descricao"] . "</td>
                    <td>" . $row["data_inicio"] . "</td>
                    <td>" . $row["data_fim"] . "</td>
                    <td>" . $row["responsavel"] . "</td>
                    <td>
                        <a href='editar_tarefa.php?id=" . $row["id"] . "'>Editar</a>
                        <a href='" . $_SERVER["PHP_SELF"] . "?excluir=" . $row["id"] . "'>Excluir</a>
                    </td>
                </tr>";
        }

        echo "</table>";
    } else {
        echo "Não existem tarefas cadastradas.";
    }

    $conn->close();
    ?>