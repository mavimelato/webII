<?php
session_start();
if (!isset($_SESSION['logado'])) {
       header("location: acesso.php");
}

include "conexao.php";

// Função para inserir um responsável
function inserirResponsavel($conn, $nome, $id)
{
       $sql = "INSERT INTO responsaveis (nome, id) VALUES ('$nome', $id)";
       if ($conn->query($sql) === TRUE) {
              echo "Responsável inserido com sucesso.";
       } else {
              echo "Erro ao inserir responsável: " . $conn->error;
       }
}

// Função para editar um responsável
function editarResponsavel($conn, $id, $nome)
{
       $sql = "UPDATE responsaveis SET nome = '$nome' WHERE id = $id";
       if ($conn->query($sql) === TRUE) {
              echo "Responsável atualizado com sucesso.";
       } else {
              echo "Erro ao atualizar responsável: " . $conn->error;
       }
}

// Função para excluir um responsável
function excluirResponsavel($conn, $id)
{
       $sql = "DELETE FROM responsaveis WHERE id = $id";
       if ($conn->query($sql) === TRUE) {
              echo "Responsável excluído com sucesso.";
       } else {
              echo "Erro ao excluir responsável: " . $conn->error;
       }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
       // Verifica a ação a ser executada (inserir, editar ou excluir)
       $acao = $_POST["acao"];

       if ($acao === "inserir") {
              $nome = $_POST["nome"];
              $id = $_POST["id"];
              inserirResponsavel($conn, $nome, $id);
       } elseif ($acao === "editar") {
              $id = $_POST["id"];
              $nome = $_POST["nome"];
              editarResponsavel($conn, $id, $nome);
       } elseif ($acao === "excluir") {
              $id = $_POST["id"];
              excluirResponsavel($conn, $id);
       }
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
                                          <a class="nav-link" href="listarespo.php">Responsáveis</a>
                                   </li>
                                   <li class="nav-item">
                                          <a class="nav-link" href="tarefas.php">Tarefas</a>
                            </ul>
                     </div>
              </div>
       </nav>

       <h2>Editar/Excluir Responsável</h2>
       <table>
              <tr>
                     <th>ID</th>
                     <th>Nome</th>
                     <th>Ações</th>
              </tr>
              <?php
              // Consulta os responsáveis
              $sql = "SELECT * FROM responsaveis";
              $result = $conn->query($sql);

              if ($result->num_rows > 0) {
                     while ($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["nome"] . "</td>";
                            echo "<td>";
                            echo "<form method='post' action='" . $_SERVER["PHP_SELF"] . "'>";
                            echo "<input type='hidden' name='acao' value='editar'>";
                            echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                            echo "<input type='text' name='nome' value='" . $row["nome"] . "' required>";
                            echo "<input type='submit' value='Editar'>";
                            echo "</form>";
                            echo "<form method='post' action='" . $_SERVER["PHP_SELF"] . "'>";
                            echo "<input type='hidden' name='acao' value='excluir'>";
                            echo "<input type='hidden' name='id' value='" . $row["id"] . "'>";
                            echo "<input type='submit' value='Excluir'>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                     }
              } else {
                     echo "<tr><td colspan='3'>Nenhum responsável encontrado.</td></tr>";
              }
              ?>
       </table>
       </body>

</html>