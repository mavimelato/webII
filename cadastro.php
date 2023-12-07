<?php
session_start();
include "conexao.php";


// Função para limpar os dados de entrada
function limparDados($dados)
{
    $dados = trim($dados);
    $dados = stripslashes($dados);
    $dados = htmlspecialchars($dados);
    return $dados;
}

// Variáveis para armazenar mensagens de erro
$erroCadastro = $erroLogin = "";

// Processamento do formulário de cadastro
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["cadastrar"])) {
    // Obtenha os dados do formulário
    $login = limparDados($_POST["login"]);
    $senha = limparDados($_POST["senha"]);

    // Insere os dados na tabela de usuários
    $sql = "INSERT INTO usuarios (login, senha) VALUES ('$login', '$senha')";
    if ($conn->query($sql) === true) {
        echo "Usuário cadastrado com sucesso!";
        $_SESSION["logado"] = true;
        header("location: projetos.php");
    } else {
        $erroCadastro = "Erro ao cadastrar";
    }


    // Fecha a conexão com o banco de dados
    $conn->close();
}

// Processamento do formulário de login
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["btlogin"])) {
    // Obtenha os dados do formulário
    $login = limparDados($_POST["login"]);
    $senha = limparDados($_POST["senha"]);

    // Cria a conexão com o banco de dados
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Verifica se ocorreu algum erro na conexão
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Consulta o usuário no banco de dados
    $sql = "SELECT * FROM usuarios WHERE login = '$login' AND senha='$senha'";
    $result = $conn->query($sql);

    if ($result) {
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            echo "Usuário logado com sucesso!";
            $_SESSION["logado"] = true;
            header("location: projetos.php");
        } else {
            $erroLogin = "Usuário ou senha incorretos.";
        }

    } else {
        $erroLogin = "Erro ao logar";
    }

    // Fecha a conexão com o banco de dados
    $conn->close();
}

?>


<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="estilo/styles.css">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>Cadastro e Login</title>
    <script>
        function exibirErroCadastro(mensagem) {
            var erroCadastro = document.getElementById("erroCadastro");
            alert(mensagem);
        }

        function exibirErroLogin(mensagem) {
            var erroLogin = document.getElementById("erroLogin");
            alert(mensagem);
        }
    </script>
</head>

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
                        <a class="nav-link" href="projetos.php">Projetos</a>
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
                        <h2>Cadastro</h2>
                    </div>
                    <form id="Login">
                        <div class="form-group">
                            <input type="text" class="form-control" id="inputEmail" name="login" placeholder="Usuário" required><br>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control" id="inputPassword" name="senha"
                                placeholder="Senha" required><br>
                        </div>
                        <input type="submit" value="Cadastrar" name="cadastrar" class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
        </div>
        <span id="erroLogin" style="color: red;">
            <?php echo $erroLogin; ?>
        </span>
        <script>
            <?php
            if ($erroCadastro == "Erro ao cadastrar") {
                echo "exibirErroCadastro('$erroCadastro');";
            }

            if ($erroLogin == "Erro ao logar") {
                echo "exibirErroLogin('$erroLogin');";
            }

            if ($erroLogin == "Usuário ou senha incorretos.") {
                echo "exibirErroLogin('$erroLogin');";
            }

            ?>
        </script>
    </body>

</html>