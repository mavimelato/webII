<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="estilo/styles.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Prazos</title>
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
                            <a class="nav-link" href="tarefas.php">Tarefas</a>
                    </ul>
                </div>
            </div>
        </nav>
        <h1>Acompanhamento de Prazos</h1>
        

        <?php
        session_start();
        if (!isset($_SESSION['logado'])) {
            header("location: acesso.php");
        }

        include "conexao.php";

        // Consulta as tarefas com prazos vencidos
        $today = date("Y-m-d");
        $sql = "SELECT * FROM tarefas WHERE data_fim < '$today'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<br><h2>Tarefas com Prazos Vencidos:</h2>";
            echo "<ul>";

            // Exibe as tarefas vencidas
            while ($row = $result->fetch_assoc()) {
                echo "<li><strong>" . $row["nome"] . "</strong> (Projeto ID: " . $row["projeto_id"] . ")</li>";
            }

            echo "</ul>";
        } else {
            echo "<p>Nenhuma tarefa com prazo vencido encontrada.</p>";
        }

        // Consulta as tarefas próximas ao prazo de término
        $nextWeek = date("Y-m-d", strtotime("+3 week"));
        $sql = "SELECT * FROM tarefas WHERE data_fim BETWEEN '$today' AND '$nextWeek'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<br><h2>Tarefas Próximas ao Prazo de Término:</h2>";
            echo "<ul>";

            // Exibe as tarefas próximas ao prazo de término
            while ($row = $result->fetch_assoc()) {
                echo "<li><strong>" . $row["nome"] . "</strong> (Projeto ID: " . $row["projeto_id"] . ")</li>";
            }

            echo "</ul>";
        } else {
            echo "<p>Nenhuma tarefa próxima ao prazo de término encontrada.</p>";
        }


        // Consulta os projetos em andamento e próximos ao prazo de término
        $sql = "SELECT * FROM projetos WHERE data_fim BETWEEN '$today' AND DATE_ADD('$today', INTERVAL 1 MONTH)";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            echo "<h2>Projetos em Andamento e Próximos ao Prazo de Término:</h2>";
            echo "<ul>";

            // Exibe os projetos em andamento e próximos ao prazo de término
            while ($row = $result->fetch_assoc()) {
                echo "<li><strong>" . $row["nome"] . "</strong> (Data de Término: " . $row["data_fim"] . ")</li>";
            }

            echo "</ul>";
        } else {
            echo "<p>Nenhum projeto em andamento ou próximo ao prazo de término encontrado.</p>";
        }



        // Fecha a conexão com o banco de dados
        $conn->close();
        ?>
</body>

</html>