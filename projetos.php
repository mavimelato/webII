<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="estilo/styles.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Cadastro de Projetos</title>
</head>
    <script>
        function confirmarExclusao(id) {
            if (confirm("Tem certeza que deseja excluir este projeto?")) {
                window.location.href = "?excluir=" + id;
            }
        }

        function exibirErro() {
            alert("Erro ao apagar, pois já há tarefa atribuída para esse projeto.");
        }
    </script>
</head>

<body>
    <?php
    session_start();
    if (!isset($_SESSION['logado'])) {
        header("location: acesso.php");
    }

    include "conexao.php";

    // Função para excluir um projeto
    if (isset($_GET['excluir'])) {
        $id = $_GET['excluir'];

        try {
            $sql = "DELETE FROM projetos WHERE id = '$id'";
            $conn->query($sql);
            echo "Projeto excluído com sucesso.";
        } catch (Exception $e) {
            echo "Erro ao apagar, pois já há tarefa atribuída para esse projeto. ";
            echo "<script>exibirErro();</script>"; // Chama a função JavaScript para exibir o alerta de erro
        }
    }

    // Função para inserir um projeto
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nome = $_POST["nome"];
        $descricao = $_POST["descricao"];
        $data_inicio = $_POST["data_inicio"];
        $data_fim = $_POST["data_fim"];

        $sql = "INSERT INTO projetos (nome, descricao, data_inicio, data_fim) VALUES ('$nome', '$descricao', '$data_inicio', '$data_fim')";

        if ($conn->query($sql) === TRUE) {
            echo "Projeto inserido com sucesso.";
        } else {
            echo "Erro ao inserir projeto: " . $conn->error;
        }
    }

    // Função para atualizar um projeto
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_POST["id"];
        $nome = $_POST["nome"];
        $descricao = $_POST["descricao"];
        $data_inicio = $_POST["data_inicio"];
        $data_fim = $_POST["data_fim"];

        $sql = "UPDATE projetos SET nome = '$nome', descricao = '$descricao', data_inicio = '$data_inicio', data_fim = '$data_fim' WHERE id = '$id'";

        if ($conn->query($sql) === TRUE) {
            echo "Projeto atualizado com sucesso.";
        } else {
            echo "Erro ao atualizar projeto: " . $conn->error;
        }
    }

    // Consulta os projetos cadastrados
    $sql = "SELECT * FROM projetos";
    $result = $conn->query($sql);
    ?>


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

        <body id="LoginForm">
            <div class="container">
                <div class="login-form">
                    <div class="main-div">
                        <div class="panel">
                            <h2>Cadastro de Projetos</h2>
                        </div>
                        <form id="Login">
                            <div class="form-group">
                                <input type="text" class="form-control" id="inputEmail" name="nome" placeholder="Nome do Projeto" required><br>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="inputPassword" name="descricao" placeholder="Descrição do Projeto" required><br>
                            </div>
                            <div class="form-group">
                                <input type="date" class="form-control" id="inputPassword" name="data_inicio" placeholder="Data de Início" required><br>
                            </div>
                            <div class="form-group">
                                <input type="date" class="form-control" id="inputPassword" name="data_fim" placeholder="Data de Término" required><br>
                            </div>
                            <div class="form-group">
                                <input type="text" class="form-control" id="inputPassword" name="responsavel" placeholder="Responsável do Projeto" required><br>
                            </div>
                            <input type="submit" value="Cadastrar" name="btlogin" class="btn btn-primary">
                        </form>
                    </div>
                </div>
            </div>
            </div>
            <script>
                // Função para preencher o formulário de edição com os dados do projeto selecionado
                function editarProjeto(id, nome, descricao, data_inicio, data_fim) {
                    document.getElementById('id').value = id;
                    document.getElementById('nome').value = nome;
                    document.getElementById('descricao').value = descricao;
                    document.getElementById('data_inicio').value = data_inicio;
                    document.getElementById('data_fim').value = data_fim;
                    document.querySelector('input[name="id"]').value = id;
                }
            </script>
        </body>

</html>