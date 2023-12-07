<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="estilo/styles.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <title>Lista de projetos</title>
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

    <h2>Projetos Cadastrados</h2>
    <table>
        <tr>
            <th>Nome</th>
            <th>Descrição</th>
            <th>Data de Início</th>
            <th>Data de Término</th>
            <th>Ações</th>
        </tr>
        <?php
        // Exibe os projetos cadastrados na tabela
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $id = $row['id'];
                $nome = $row['nome'];
                $descricao = $row['descricao'];
                $data_inicio = $row['data_inicio'];
                $data_fim = $row['data_fim'];
        ?>
                <tr>
                    <td><?php echo $nome; ?></td>
                    <td><?php echo $descricao; ?></td>
                    <td><?php echo $data_inicio; ?></td>
                    <td><?php echo $data_fim; ?></td>
                    <td>
                        <a href="#" onclick="confirmarExclusao('<?php echo $id; ?>')">Excluir</a>
                        <a href="#" onclick="editarProjeto('<?php echo $id; ?>', '<?php echo $nome; ?>', '<?php echo $descricao; ?>', '<?php echo $data_inicio; ?>', '<?php echo $data_fim; ?>')">Editar</a>
                    </td>
                </tr>
        <?php
            }
        } else {
            echo "<tr><td colspan='5'>Nenhum projeto cadastrado.</td></tr>";
        }
        ?>
    </table>